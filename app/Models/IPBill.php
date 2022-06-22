<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPBill extends Model
{
    use HasFactory;

    protected $table='ip_bills';

    protected $fillable=[
        'year',
        'bill_no',
        'ip_id',
        'pt_id',
        'total',
        'advance_paid',
        'discount',
        'sub_total',
        'paid',
        'due',
        'refund',
        'payment_method',
        'other_payment',
        'card_no',
        'card_type',
        'card_expiry',
        'user_id'
    ];

    public function billDetails()
    {
        return $this->hasMany(IPBillDetail::class, 'bill_id', 'id')
        ->select(['bill_id','category','department','fees_id', 'fees_type', 'cost', 'qty', 'total']);
    }

    public function patient()
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id')->select(['id','salutation','name','age','gender','uhid']);
    }

    public function admission()
    {
        return $this->belongsTo(IPAdmission::class, 'ip_id', 'id')->select(['id','ip_no','created_at','consultant']);
    }

    public function discharge()
    {
        return $this->belongsTo(IPDischarge::class, 'ip_id', 'ip_id')->select(['id','created_at']);
    }
}
