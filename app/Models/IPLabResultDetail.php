<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPLabResultDetail extends Model
{

    use HasFactory;

    protected $table = 'ip_lab_result_details';
    protected $casts = [
        'is_selected' => 'boolean',
        'is_group' => 'boolean'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'field_id', 'id');
    }

}
