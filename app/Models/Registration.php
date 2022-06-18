<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{

    use HasFactory;

    //    use SoftDeletes;

    protected $table = 'registrations';
    protected $fillable = [
        'salutation',
        'uuid',
        'name',
        'age',
        'gender',
        'dob',
        'contact_no',
        'email_address',
        'address',
        'doctor_id',
        'user_id'
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (self $registration) {
            $registration->uuid = Str::uuid();
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
}
