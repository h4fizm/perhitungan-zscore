<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'tanggal_lahir',
        'tempat_lahir',
        'nama_ortu',
        'email_ortu',
        'jenis_kelamin',
        'id_location',
        'tanggal_pengukuran',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'status_gizi',
        'status_tinggi',
        'kategori',
        'created_at',
        'updated_at'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location');
    }
}
