<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_location',
        'latitude',
        'longitude',
        'radius',
        'value', 
        'created_at',// Tambahkan atribut value
    ];
}
