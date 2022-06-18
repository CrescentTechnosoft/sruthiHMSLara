<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{

    use HasFactory;

    protected $fillable = [
        'floor',
        'ward',
        'room',
        'bed',
        'rent',
        'ip_id',
        'pt_id',
        'name',
        'status'
    ];
    protected $casts = [
        'id' => 'integer',
        'rent' => 'float',
        'status'=>'boolean',
        'occupied'=>'boolean'
    ];

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id');
    }

    public function admission()
    {
        return $this->belongsTo(IPAdmission::class, 'ip_id', 'id');
    }
}
