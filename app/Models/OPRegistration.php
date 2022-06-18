<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OPRegistration.
 *
 * @property int                             $id
 * @property string|null                     $year
 * @property int|null                        $op_no
 * @property int|null                        $pt_id
 * @property string|null                     $name
 * @property string|null                     $age
 * @property string|null                     $gender
 * @property string|null                     $contact_no
 * @property int|null                        $doctor_id
 * @property string|null                     $height
 * @property string|null                     $weight
 * @property string|null                     $bsa
 * @property string|null                     $bp
 * @property string|null                     $pulse
 * @property string|null                     $status
 * @property string|null                     $visit_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereBp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereBsa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereOpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereVisitReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereYear($value)
 * @mixin \Eloquent
 */
class OPRegistration extends Model
{
    use HasFactory;
    protected $table = 'op_registrations';

    protected $fillable = [
        'year',
        'op_no',
        'pt_id',
        'name',
        'age',
        'gender',
        'contact_no',
        'doctor_id',
        'height',
        'weight',
        'bsa',
        'bp',
        'pulse',
        'status',
        'visit_reason',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class, 'op_id', 'id');
    }
}
