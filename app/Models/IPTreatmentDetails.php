<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPTreatmentDetails extends Model
{

    use HasFactory;

    protected $table = 'ip_treatment_details';
    public $timestamps = false;

    protected $fillable=[
        'treatment_id',
        'ip_id',
        'pt_id',
        's_no',
        'fees_id',
        'department',
        'category',
        'fees_type',
        'test_type',
        'qty',
        'cost',
        'total'
    ];

    protected $casts = [
        'qty' => 'integer',
        'cost' => 'float',
        'total' => 'float'
    ];

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id');
    }

    public function treatment()
    {
        return $this->belongsTo(IPTreatment::class, 'treatment_id', 'id');
    }

    public function admission()
    {
        return $this->belongsTo(IPAdmission::class, 'ip_id', 'id');
    }
}
