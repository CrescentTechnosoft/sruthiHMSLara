<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class IPAdmission extends Model
{
    use HasFactory;
    //    use SoftDeletes;

    protected $table = 'ip_admissions';
    protected $fillable = [
        'year',
        'ip_no',
        'pt_id',
        'fees',
        'advance',
        'type',
        'diagnosis',
        'department',
        'consultant',
        'referrer',
        'rel_name',
        'rel_contact_no',
        'rel_type',
        'rel_address',
        'user_id',
        'ins_cat',
        'ins_name',
        'ins_id'
    ];
    protected $casts = [
        'cons' => 'integer',
        'ref' => 'integer'
    ];

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id');
    }

    public function ward()
    {
        return $this->hasOne(Ward::class, 'ip_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'consultant', 'id')->select(['id', 'name']);
    }

    public function treatments()
    {
        return $this->hasMany(IPTreatment::class, 'ip_id', 'id');
    }

    public function discharge()
    {
        return $this->hasOne(IPDischarge::class, 'ip_id', 'id');
    }

    public function billing()
    {
        return $this->hasOne(IPBill::class, 'ip_id', 'id');
    }

    public function getAdvances()
    {
        return $this->hasMany(Advance::class, 'ip_id', 'id')->sum('amount');
    }
}
