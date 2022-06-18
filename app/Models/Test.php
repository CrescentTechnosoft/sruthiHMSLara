<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'method',
        'sample',
        'units',
        'reference_range',
        'comments',
        'parameters',
        'fees'
    ];
    
    protected $casts=[
        'id'=>'integer',
        'fees'=>'float',
        'cost'=>'float'
    ];
}
