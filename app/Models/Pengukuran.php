<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengukuran extends Model
{
    use HasFactory;

    protected $table = 'pengukuran'; // Nama tabel yang sesuai dengan tabel pengukuran di database

    protected $fillable = [ // Attribut yang dapat diisi
        'id_pasien',
        'umur',
        'tanggal_pengukuran',
        'berat_badan',
        'tinggi_badan',
        'status_gizi',
        'status_tinggi',
    ];

    // Relasi dengan model Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    // Relasi dengan model BBlaki
    public function bblaki()
    {
        return $this->belongsTo(BBlaki::class, 'umur', 'umur');
    }

    // Relasi dengan model BBperempuan
    public function bbperempuan()
    {
        return $this->belongsTo(BBperempuan::class, 'umur', 'umur');
    }
}
