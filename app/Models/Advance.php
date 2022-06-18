<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{

    use HasFactory;

    protected $fillable = [
        'ip_id',
        'pt_id',
        'advance_no',
        'amount',
        'pay_type',
        'other_pay_type',
        'card_no',
        'card_type',
        'card_expiry',
        'user_id',
    ];
    protected $casts = [
        'id' => 'integer',
        'ip_id' => 'integer'
    ];

    public function admission()
    {
        return $this->belongsTo(IPAdmission::class, 'ip_id', 'id')->select(['id','ip_no']);
    }

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id')->select(['id','salutation','name']);
    }

}
