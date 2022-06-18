<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    protected $table = 'prescriptions';

    protected $fillable = [
        'op_id',
        'opinion',
        'patient_info',
        'diagnosis',
        'complaints',
        'medicines',
        'investigations',
        'treatments',
    ];

    public function opReg()
    {
        return $this->belongsTo(OPRegistration::class, 'op_id', 'id');
    }
}
