<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        // Hitung nilai warna dan status berdasarkan kondisi yang telah ditentukan
        foreach ($locations as $location) {
            if ($location->value > 50) {
                $location->color = 'red';
                $location->status = 'TINGGI';
            } elseif ($location->value >= 10 && $location->value <= 50) {
                $location->color = 'yellow';
                $location->status = 'MENENGAH';
            } else {
                $location->color = 'green';
                $location->status = 'RENDAH';
            }

            // Simpan jumlah pasien berdasarkan nilai dari kolom 'value'
            $location->jumlah_pasien = $location->value;
        }

        return view('menu.pemetaan-lokasi', compact('locations'));
    }

    public function manajemen()
    {
        $locations = Location::all();

        // Hitung nilai warna dan status berdasarkan kondisi yang telah ditentukan
        foreach ($locations as $location) {
            if ($location->value > 50) {
                $location->color = 'red';
                $location->status = 'TINGGI';
            } elseif ($location->value >= 10 && $location->value <= 50) {
                $location->color = 'yellow';
                $location->status = 'MENENGAH';
            } else {
                $location->color = 'green';
                $location->status = 'RENDAH';
            }

            // Simpan jumlah pasien berdasarkan nilai dari kolom 'value'
            $location->jumlah_pasien = $location->value;
        }

        return view('menu.manajemen-lokasi', compact('locations'));
    }

    public function create()
    {
        return view('menu.tambah-lokasi');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'name_location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            // 'value' => 'required|integer',
        ]);

        // Jika 'value' tidak disertakan dalam request, atur nilainya menjadi 0
        if (!$request->has('value')) {
            $validatedData['value'] = 0;
        }

        // Buat lokasi baru berdasarkan data yang diterima
        Location::create($validatedData);

        // Redirect ke halaman manajemen lokasi setelah lokasi berhasil ditambahkan
        return redirect()->back()->with('success', 'Lokasi berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('menu.edit-lokasi', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            // 'value' => 'required|integer',
        ]);

        if (!$request->has('value')) {
            $validatedData['value'] = 0;
        }

        Location::where('id', $id)->update($validatedData);

        // Redirect ke halaman manajemen lokasi setelah lokasi berhasil ditambahkan
        return redirect()->back()->with('success', 'Lokasi berhasil diedit.');
    }
    
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('manajemen-lokasi')->with('success', 'Lokasi berhasil dihapus.');
    }

}
