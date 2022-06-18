<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPDischarge extends Model
{
    use HasFactory;

    protected $table = 'ip_discharges';
    protected $fillable = [
        'ip_id',
        'pt_id',
        'history',
        'diagnosis',
        'investigations',
        'surgery',
        'treatment',
        'advice',
        'condition',
        'disease',
        'consultants',
        'death_date',
        'death_details',
        'hosp_course',
        'report',
        'pt_reaction',
        'pulse',
        'bp',
        'hb',
        'tc',
        'wbc',
        'poly',
        'lymp',
        'eos',
        'm',
        'b',
        'blood_sugar',
        'urea',
        'scr',
        'crit',
        'plat',
        'user_id',
        'admitted_at',
    ];

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id')
                ->select(['id','salutation','name','age','gender','contact_no','address']);
    }

    public function admission()
    {
        return $this->belongsTo(IPAdmission::class, 'ip_id', 'id')
        ->select(['ip_no','consultant','created_at']);
    }
}
