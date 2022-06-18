<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    public function timings()
    {
        return $this->hasMany(DoctorTiming::class, 'doctor_id', 'id');
    }
}
