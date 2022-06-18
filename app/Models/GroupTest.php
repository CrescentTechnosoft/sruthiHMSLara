<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'fees',
        'test_fields'
    ];
    protected $casts = [
        'id' => 'integer',
        'fees' => 'float',
        'cost' => 'float',
        'test_fields' => 'array'
    ];

}
