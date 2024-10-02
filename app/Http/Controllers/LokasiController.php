<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Phpml\Clustering\KMeans;
use Phpml\Clustering\KMeans\Cluster;
use Phpml\Classification\DecisionTree;

class LokasiController extends Controller
{
    public function showChart()
    {
        // Mengambil data kelurahan dari database
        $locations = Location::all();

        // Menyiapkan array untuk menyimpan data persentase pasien dan ID lokasi
        $kelurahanNames = [];
        $kelurahanIds = [];
        $obesitasData = [];
        $stuntingData = [];
        $normalData = [];

        foreach ($locations as $location) {
            // Mengambil pasien unik berdasarkan NIK terbaru untuk setiap kelurahan
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Menghitung total pasien dan jumlah pasien per kategori
            $totalPasien = $uniquePatients->count();
            $totalNormal = $uniquePatients->where('kategori', 'Gizi baik')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Gizi kurang', 'Gizi buruk'])->count();
            $totalObesitas = $uniquePatients->whereIn('kategori', ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas'])->count();

            // Menghitung persentase berdasarkan kategori gizi
            $obesitasPercent = $totalPasien > 0 ? ($totalObesitas / $totalPasien) * 100 : 0;
            $stuntingPercent = $totalPasien > 0 ? ($totalStunting / $totalPasien) * 100 : 0;
            $normalPercent = $totalPasien > 0 ? ($totalNormal / $totalPasien) * 100 : 0;

            // Menyimpan data ke array
            $kelurahanNames[] = $location->name_location;
            $kelurahanIds[] = $location->id; // Menyimpan ID lokasi
            $obesitasData[] = $obesitasPercent;
            $stuntingData[] = $stuntingPercent;
            $normalData[] = $normalPercent;
        }

        // Passing data ke view
        return view('menu.grafik', compact('kelurahanNames', 'kelurahanIds', 'obesitasData', 'stuntingData', 'normalData'));
    }

    public function index() // Logika K-Means
    {
        $locations = Location::all();
        $stuntingLocations = [];
        $features = [];

        // Set to true to override the calculated values
        $overrideValues = true;

        // Override values for each location
        $overriddenValues = [
            [
                'totalNormal' => 1000,
                'totalStunting' => 500,
                'totalObesitas' => 300,
            ], // Baratajaya
            [
                'totalNormal' => 800,
                'totalStunting' => 70000,
                'totalObesitas' => 200,
            ], // Pucang Sewu
            [
                'totalNormal' => 1200,
                'totalStunting' => 400,
                'totalObesitas' => 60,
            ], // Kertajaya
            [
                'totalNormal' => 1500,
                'totalStunting' => 300,
                'totalObesitas' => 50,
            ], // Gubeng
            [
                'totalNormal' => 900,
                'totalStunting' => 60,
                'totalObesitas' => 400,
            ], // Airlangga
            [
                'totalNormal' => 110,
                'totalStunting' => 700,
                'totalObesitas' => 5000,
            ], // Mojo
        ];

        foreach ($locations as $index => $location) {
            // Get the unique patients with the latest data for each NIK in the location
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Calculate totals based on unique patients
            $totalPasien = $uniquePatients->count();

            if ($totalPasien === 0) {
                $totalNormal = 0;
                $totalStunting = 0;
                $totalObesitas = 0;
                $percentNormal = 0;
                $percentStunting = 0;
                $percentObesitas = 0;
            } else {
                $totalNormal = $uniquePatients->where('kategori', 'Gizi baik')->count();
                $totalStunting = $uniquePatients->whereIn('kategori', ['Gizi kurang', 'Gizi buruk'])->count();
                $totalObesitas = $uniquePatients->whereIn('kategori', ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas'])->count();

                // Override values if $overrideValues is true
                if ($overrideValues && isset($overriddenValues[$index])) {
                    $totalNormal = $overriddenValues[$index]['totalNormal'];
                    $totalStunting = $overriddenValues[$index]['totalStunting'];
                    $totalObesitas = $overriddenValues[$index]['totalObesitas'];
                    $totalPasien = $totalNormal + $totalStunting + $totalObesitas;

                    // Peringatan jika total stunting terlalu besar
                    if ($totalStunting > $totalPasien) {
                        return response()->json(['warning' => "Nilai stunting di lokasi {$location->name} tidak realistis."], 400);
                    }
                }

                // Assign other data to location object
                $location->jumlah_pasien = $totalPasien;
                $location->jumlah_stunting = $totalStunting;
                $location->jumlah_normal = $totalNormal;
                $location->jumlah_obesitas = $totalObesitas;

                // Calculate percentages
                $percentNormal = $totalPasien > 0 ? ($totalNormal / $totalPasien) * 100 : 0;
                $percentStunting = $totalPasien > 0 ? ($totalStunting / $totalPasien) * 100 : 0;
                $percentObesitas = $totalPasien > 0 ? ($totalObesitas / $totalPasien) * 100 : 0;

                // Add features for clustering
                $features[] = [$percentNormal, $percentStunting, $percentObesitas];
            }
        }

        // Perform K-means clustering
        $k = 5; // Number of clusters
        $maxIterations = 100;
        $seed = 42; // Fixed seed for reproducibility
        list($clusters, $centroids, $iterations) = $this->kMeansClustering($features, $k, $maxIterations, $seed);

        // Assign cluster values to locations
        foreach ($clusters as $clusterIndex => $clusterPoints) {
            $value = $this->mapClusterToValue($clusterIndex, $centroids);
            foreach ($clusterPoints as $locationIndex) {
                $location = Location::find($locationIndex + 1);
                $location->value = $value;
                $locations[$locationIndex]->value = $value;
            }
        }

        // Calculate silhouette score
        $silhouetteScore = $this->calculateSilhouetteScore($features, $clusters);

        // Prepare data for visualization
        $visualizationData = $this->prepareVisualizationData($features, $clusters);

        return view('menu.pemetaan-lokasi', compact('locations', 'centroids', 'iterations', 'silhouetteScore', 'visualizationData'));
    }


    private function kMeansClustering($features, $k, $maxIterations, $seed)
    {
        srand($seed);
        $centroids = [];

        // Inisialisasi centroid secara acak
        $randomIndexes = array_rand($features, $k);
        foreach ($randomIndexes as $index) {
            $centroids[] = $features[$index];
        }

        $clusters = [];
        for ($i = 0; $i < $maxIterations; $i++) {
            // Mengelompokkan data ke centroid terdekat
            $clusters = array_fill(0, $k, []);
            foreach ($features as $key => $feature) {
                $distances = [];
                foreach ($centroids as $centroid) {
                    $distances[] = sqrt(
                        pow($feature[0] - $centroid[0], 2) +
                            pow($feature[1] - $centroid[1], 2) +
                            pow($feature[2] - $centroid[2], 2)
                    );
                }
                $clusterIndex = array_search(min($distances), $distances);
                $clusters[$clusterIndex][] = $key;
            }

            // Menghitung ulang centroid
            $newCentroids = [];
            foreach ($clusters as $cluster) {
                $clusterSize = count($cluster);
                if ($clusterSize > 0) {
                    $sumNormal = $sumStunting = $sumObesitas = 0;
                    foreach ($cluster as $index) {
                        $sumNormal += $features[$index][0];
                        $sumStunting += $features[$index][1];
                        $sumObesitas += $features[$index][2];
                    }
                    $newCentroids[] = [
                        $sumNormal / $clusterSize,
                        $sumStunting / $clusterSize,
                        $sumObesitas / $clusterSize,
                    ];
                } else {
                    // Jika cluster kosong, gunakan centroid lama
                    $newCentroids[] = $centroids[array_rand($centroids)];
                }
            }

            // Cek konvergensi
            if ($newCentroids == $centroids) {
                break;
            }

            $centroids = $newCentroids;
        }

        return [$clusters, $centroids, $i];
    }

    private function mapClusterToValue($clusterIndex, $centroids)
    {
        $centroid = $centroids[$clusterIndex];
        $stuntingWeight = 0.4;
        $obesitasWeight = 0.4;
        $normalWeight = 0.2;
        
        $riskScore = $centroid[1] * $stuntingWeight + $centroid[2] * $obesitasWeight + (100 - $centroid[0]) * $normalWeight;
        
        if ($riskScore >= 40) return 1; // Very High Risk
        if ($riskScore >= 30) return 2; // High Risk
        if ($riskScore >= 20) return 3; // Medium Risk
        if ($riskScore >= 10) return 4; // Low Risk
        return 5; // Very Low Risk
    }

    public function tree() // Logika Decision Tree
    {
        $locations = Location::all();
        $trainingData = [];
        $trainingLabels = [];

        // Set to true to override the calculated values
        $overrideValues = true;

        // Override values for each location
        $overriddenValues = [
            [
                'totalNormal' => 1000,
                'totalStunting' => 500,
                'totalObesitas' => 300,
            ], // Baratajaya
            [
                'totalNormal' => 800,
                'totalStunting' => 70000,
                'totalObesitas' => 200,
            ], // Pucang Sewu
            [
                'totalNormal' => 1200,
                'totalStunting' => 400,
                'totalObesitas' => 60,
            ], // Kertajaya
            [
                'totalNormal' => 1500,
                'totalStunting' => 300,
                'totalObesitas' => 50,
            ], // Gubeng
            [
                'totalNormal' => 900,
                'totalStunting' => 60,
                'totalObesitas' => 400,
            ], // Airlangga
            [
                'totalNormal' => 110,
                'totalStunting' => 5000,
                'totalObesitas' => 700,
            ], // Mojo
        ];

        foreach ($locations as $index => $location) {
            // Get the unique patients with the latest data for each NIK in the location
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Calculate totals based on unique patients
            $totalPasien = $uniquePatients->count();
            $totalNormal = $uniquePatients->where('kategori', 'Gizi baik')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Gizi kurang', 'Gizi buruk'])->count();
            $totalObesitas = $uniquePatients->whereIn('kategori', ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas'])->count();

            // Override values if $overrideValues is true
            if ($overrideValues && isset($overriddenValues[$index])) {
                $totalNormal = $overriddenValues[$index]['totalNormal'];
                $totalStunting = $overriddenValues[$index]['totalStunting'];
                $totalObesitas = $overriddenValues[$index]['totalObesitas'];
                $totalPasien = $totalNormal + $totalStunting + $totalObesitas;
            }

            // Calculate percentages
            $percentNormal = $totalPasien > 0 ? ($totalNormal / $totalPasien) * 100 : 0;
            $percentStunting = $totalPasien > 0 ? ($totalStunting / $totalPasien) * 100 : 0;
            $percentObesitas = $totalPasien > 0 ? ($totalObesitas / $totalPasien) * 100 : 0;

            // Prepare training data
            $trainingData[] = [$percentNormal, $percentStunting, $percentObesitas];
            $trainingLabels[] = $this->determineRiskLevel($percentNormal, $percentStunting, $percentObesitas);

            // Assign other data to location object
            $location->jumlah_pasien = $totalPasien;
            $location->jumlah_stunting = $totalStunting;
            $location->jumlah_normal = $totalNormal;
            $location->jumlah_obesitas = $totalObesitas;
            $location->percent_normal = $percentNormal;
            $location->percent_stunting = $percentStunting;
            $location->percent_obesitas = $percentObesitas;
        }

        // Train the decision tree
        $classifier = new DecisionTree();
        $classifier->train($trainingData, $trainingLabels);

        // Classify each location using the trained model
        foreach ($locations as $index => $location) {
            $features = [$location->percent_normal, $location->percent_stunting, $location->percent_obesitas];
            $predictedRisk = $classifier->predict($features);
            $value = $this->riskLevelToValue($predictedRisk);

            $location = Location::find($index + 1);
            $location->value = $value;
            $locations[$index]->value = $value;
        }

        return view('menu.pemetaan-lokasi-tree', compact('locations'));
    }


    private function determineRiskLevel($percentNormal, $percentStunting, $percentObesitas)
    {
        if ($percentStunting > 30 || $percentObesitas > 30) {
            return 'High Risk';
        } elseif ($percentStunting > 15 || $percentObesitas > 15) {
            return 'Medium Risk';
        } else {
            return 'Low Risk';
        }
    }

    private function riskLevelToValue($riskLevel)
    {
        switch ($riskLevel) {
            case 'High Risk':
                return 1;
            case 'Medium Risk':
                return 2;
            case 'Low Risk':
                return 3;
            default:
                return 2; // Default to medium risk
        }
    }

    private function euclideanDistance($point1, $point2)
    {
        $sum = 0;
        for ($i = 0; $i < count($point1); $i++) {
            $sum += pow($point1[$i] - $point2[$i], 2);
        }
        return sqrt($sum);
    }

    private function calculateSilhouetteScore($data, $clusters)
    {
        // Implement silhouette score calculation
        // This is a simplified version and may not be entirely accurate
        $silhouettes = [];
        foreach ($clusters as $clusterIndex => $clusterPoints) {
            foreach ($clusterPoints as $pointIndex) {
                $a = $this->averageDistanceWithinCluster($data, $pointIndex, $clusterPoints);
                $b = $this->averageDistanceToNearestCluster($data, $pointIndex, $clusters, $clusterIndex);
                $silhouettes[] = ($b - $a) / max($a, $b);
            }
        }
        return array_sum($silhouettes) / count($silhouettes);
    }

    private function averageDistanceWithinCluster($data, $pointIndex, $clusterPoints)
    {
        $distances = [];
        foreach ($clusterPoints as $otherPointIndex) {
            if ($pointIndex !== $otherPointIndex) {
                $distances[] = $this->euclideanDistance($data[$pointIndex], $data[$otherPointIndex]);
            }
        }
        return array_sum($distances) / max(1, count($distances));
    }

    private function averageDistanceToNearestCluster($data, $pointIndex, $clusters, $currentClusterIndex)
    {
        $minAverageDistance = PHP_FLOAT_MAX;
        foreach ($clusters as $clusterIndex => $clusterPoints) {
            if ($clusterIndex !== $currentClusterIndex) {
                $distances = array_map(function ($otherPointIndex) use ($data, $pointIndex) {
                    return $this->euclideanDistance($data[$pointIndex], $data[$otherPointIndex]);
                }, $clusterPoints);
                $averageDistance = array_sum($distances) / max(1, count($distances));
                $minAverageDistance = min($minAverageDistance, $averageDistance);
            }
        }
        return $minAverageDistance;
    }

    private function prepareVisualizationData($features, $clusters)
    {
        // If features are 3D, we can use them directly
        // If they're higher dimensional, we might need to use dimensionality reduction techniques
        $data = [];
        foreach ($clusters as $clusterIndex => $clusterPoints) {
            foreach ($clusterPoints as $pointIndex) {
                $data[] = [
                    'x' => $features[$pointIndex][0],
                    'y' => $features[$pointIndex][1],
                    'z' => $features[$pointIndex][2] ?? 0, // Use 0 if third dimension doesn't exist
                    'cluster' => $clusterIndex
                ];
            }
        }
        return $data;
    }

    public function manajemen()
    {
        $locations = Location::all();
        $stuntingLocations = [];

        foreach ($locations as $location) {
            // Get the unique patients with the latest data for each NIK in the location
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Calculate totals based on unique patients
            $totalPasien = $uniquePatients->count();
            $totalNormal = $uniquePatients->where('kategori', 'Gizi baik')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Gizi kurang', 'Gizi buruk'])->count();
            $totalObesitas = $uniquePatients->whereIn('kategori', ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas'])->count();

            // Determine the value category based on the counts of patients
            $value = $this->calculateValue($totalNormal, $totalStunting, $totalObesitas);

            // Update location value in the database
            $location->update(['value' => $value]);

            // Assign other data to location object
            $location->jumlah_pasien = $totalPasien;
            $location->jumlah_stunting = $totalStunting;
            $location->jumlah_normal = $totalNormal;
            $location->jumlah_obesitas = $totalObesitas;
        }

        return view('menu.manajemen-lokasi', compact('locations'));
    }


    // New function to calculate the value based on counts of patients
    public static function calculateValue($totalNormal, $totalStunting, $totalObesitas)
    {
        if (($totalNormal > $totalStunting && $totalNormal > $totalObesitas) || $totalNormal + $totalObesitas + $totalStunting == 0) {
            return 3; // Low
        } elseif ($totalNormal == $totalStunting || $totalNormal == $totalObesitas) {
            return 2; // Medium
        } else {
            return 1; // High
        }
    }

    // New function to calculate the stunting severity based on counts of patients
    public static function calculateStuntingSeverity($totalNormal, $totalStunting)
    {
        if ($totalNormal > $totalStunting || $totalNormal + $totalStunting == 0) {
            return 3; // Low
        } else {
            return 1; // High
        }
    }

    // New function to send stunting warning email once based on latest condition
    public static function sendStuntingWarningEmailOnce($stuntingLocations, $forceSend)
    {
        $cacheKey = 'last_stunting_email_locations';
        $lastStuntingEmailLocations = Cache::get($cacheKey, []);

        // Check if the current stunting locations are different from the last cached locations
        if (array_diff($stuntingLocations, $lastStuntingEmailLocations) || array_diff($lastStuntingEmailLocations, $stuntingLocations) || $forceSend == "kirim") {
            $emailContentData = [
                'stuntingLocations' => $stuntingLocations,
            ];

            $uniqueEmails = array_merge(
                Pasien::distinct()->pluck('email_ortu')->toArray(), // Email orang tua
                User::distinct()->pluck('email')->toArray() // Email pengguna (admin, operator, user)
            );
            $additionalRecipients  = ['humamaziz03@gmail.com']; // Email tambahan
            $recipients = array_filter(array_merge($uniqueEmails, $additionalRecipients));

            Mail::send('emails.stunting_alert', $emailContentData, function ($message) use ($recipients) {
                $message->to($recipients)
                    ->subject('Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan');
            });

            // Update the last stunting email locations in cache
            Cache::put($cacheKey, $stuntingLocations, now()->addDay()); // Cache for 1 day
        }
    }

    public function testEmail()
    {
        // $cacheKey = 'last_stunting_email_locations';
        // $lastStuntingEmailLocations = Cache::get($cacheKey, []);

        // Check if the current stunting locations are different from the last cached locations
        if (1 == 1) {
            $emailContent = "Yth. Bapak/Ibu,\n\nKami ingin memberitahukan bahwa jumlah pasien dengan status stunting telah mencapai tingkat yang tinggi di beberapa kelurahan. Berikut adalah daftar kelurahan yang memiliki status stunting dan obesitas tinggi:\n\n" . "TESSS TOKKK" . "\n\nKami sangat mengkhawatirkan kondisi ini dan berharap dapat segera mengambil tindakan yang diperlukan untuk menanggulangi masalah stunting di wilayah ini.\n\nTerima kasih atas perhatian dan kerjasamanya.\n\nSalam,\nTim Kesehatan";

            // $additionalRecipients  = ['savage.kuosong@gmail.com', 'humamaziz03@gmail.com', 'justdella.24@gmail.com'];
            $uniqueEmails = array_merge(
                Pasien::distinct()->pluck('email_ortu')->toArray(), // Email orang tua
                User::distinct()->pluck('email')->toArray() // Email pengguna (admin, operator, user)
            );
            $additionalRecipients  = ['humamaziz03@gmail.com']; // Email tambahan
            $recipients = array_filter(array_merge($uniqueEmails, $additionalRecipients));

            // Mail::raw($emailContent, function ($message) use ($recipients) {
            //     $message->to($recipients)
            //         ->subject('TEST 2 - Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan');
            // });

            return response($recipients);

            // Update the last stunting email locations in cache
            // Cache::put($cacheKey, $stuntingLocations, now()->addDay()); // Cache for 1 day
        }
    }
}
