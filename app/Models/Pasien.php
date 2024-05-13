<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien'; // Menetapkan nama tabel

    protected $fillable = ['nik', 'nama', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'id_location']; // Tambahkan 'jenis_kelamin' ke fillable

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location');
    }

    // Ubah nama metode menjadi jenisKelamin
    public function jenisKelamin()
    {
        return $this->attributes['jenis_kelamin']; // Kembalikan nilai langsung dari atribut 'jenis_kelamin'
    }
    public function pengukuran()
    {
        return $this->hasMany(Pengukuran::class, 'id_pasien', 'id');
    }

}
