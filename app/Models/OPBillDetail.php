<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPBillDetail extends Model
{
    use HasFactory;
    protected $table = 'op_bill_details';
    
    protected $casts=[
        'fees'=>'float'
    ];
}
