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
    protected $primaryKey = 'umur';

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
        'umur', '-3SD', '-2SD', '-1SD', 'median', '1SD', '2SD', '3SD',
    ];
}
