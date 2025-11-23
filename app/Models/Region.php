<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $fillable = [
        'nom_region',
        'description_region',
        'population',
        'superficie',
        'localisation',

    ];

    protected $casts = [
        "population" => "integer",
        "superficie" => "double"
    ];
}
