<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{

    use HasFactory;

    protected $table = 'fees';
    protected $fillable = [
        'department',
        'category',
        'name',
        'op_cost',
        'ip_cost',
    ];
    protected $casts = [
        'id' => 'integer'
    ];

}
