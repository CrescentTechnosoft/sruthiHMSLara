<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IPLabResult
 *
 * @property int|null $treatment_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereUserId($value)
 * @mixin \Eloquent
 */
class IPLabResult extends Model
{

    use HasFactory;

    protected $table = 'ip_lab_results';
    protected $fillable = [
        'treatment_id',
        'ip_id',
        'pt_id',
        'user_id'
    ];

}
