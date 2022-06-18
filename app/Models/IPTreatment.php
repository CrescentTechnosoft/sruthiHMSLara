<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPTreatment extends Model
{
    use HasFactory;

    protected $table = 'ip_treatments';
    protected $fillable = [
        'ip_id',
        'pt_id',
        'ref_no',
        'user_id'
    ];
    protected $casts = [
        'ip_id' => 'integer',
        'pt_id' => 'integer',
        'ref_no' => 'integer'
    ];

    public function admission()
    {
        return $this->belongsTo(IPAdmission::class, 'ip_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id')
            ->select(['id', 'salutation', 'name', 'age', 'gender', 'contact_no']);
    }

    public function treatments()
    {
        return $this->hasMany(IPTreatmentDetails::class, 'treatment_id', 'id');
    }

    public function result()
    {
        return $this->hasOne(IPLabResult::class, 'treatment_id', 'id');
    }
}
