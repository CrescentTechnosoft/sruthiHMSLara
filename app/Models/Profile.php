<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = [
        'name',
        'tests',
        'fees'
    ];
    protected $casts = [
        'id' => 'integer',
        'tests' => 'array'
    ];

}
