<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

//use Illuminate\Database\Eloquent\SoftDeletes;

class OPBill extends Model
{
    use HasFactory;

    // use SoftDeletes;

    protected $table = 'op_bills';
    protected $fillable = [
        'year',
        'bill_no',
        'pt_id',
        'name',
        'age',
        'gender',
        'contact_no',
        'doctor_id',
        'total',
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
        'user_id',
    ];
    protected $casts = [
        'id' => 'integer',
        'pt_id' => 'integer',
        'doctor_id' => 'integer',
        'total' => 'float'
    ];

    public function billDetails(): HasMany
    {
        return $this->hasMany(OPBillDetail::class, 'bill_id', 'id');
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id')
        ->select(['id','salutation', 'name', 'age', 'gender', 'contact_no', 'address','uhid']);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'pt_id', 'id')
        ->select(['id','salutation', 'name', 'age', 'gender', 'contact_no', 'address','uhid']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function result()
    {
        return $this->hasOne(OpLabResult::class, 'bill_id', 'id');
    }
}
