<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class OpLabResult extends Model
{
    use HasFactory;
//    use SoftDeletes;
    protected $table = 'op_lab_results';

    protected $fillable = [
        'bill_id',
        'user_id',
        'deleted_at',
    ];
}
