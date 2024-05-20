<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBlaki extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb-laki-laki';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'UMUR';

    /**
     * Indicates if the model's primary key is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UMUR', 'N3SD', 'N2SD', 'N1SD', 'MEDIAN', 'P1SD', 'P2SD', 'P3SD',
    ];
}
