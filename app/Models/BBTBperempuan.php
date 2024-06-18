<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bbtbperempuan extends Model
{
    protected $table = 'bbtb-perempuan';

    protected $fillable = [
        'id',
        'TB',
        'N3SD',
        'N2SD',
        'N1SD',
        'MEDIAN',
        'P1SD',
        'P2SD',
        'P3SD',
    ];
}
