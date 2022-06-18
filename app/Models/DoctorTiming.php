<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DoctorTiming
 *
 * @property int $doctor_id
 * @property string|null $day
 * @property string|null $start
 * @property string|null $end
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereStart($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Doctor $doctor
 */
class DoctorTiming extends Model
{
    use HasFactory;

    protected $table = 'doctor_timings';
    protected $fillable = [
        'doctor_id',
        'day',
        'start',
        'end'
    ];

    public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id', 'id');
    }
}
