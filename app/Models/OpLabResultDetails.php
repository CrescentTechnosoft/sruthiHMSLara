<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpLabResultDetails extends Model
{

    use HasFactory;

    protected $table = 'op_lab_result_details';
    protected $casts = [
        'test_id' => 'integer',
        'id' => 'integer',
        'is_selected' => 'boolean',
        'is_group' => 'boolean'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'field_id', 'id');
    }

}
