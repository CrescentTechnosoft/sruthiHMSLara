<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Test.
 *
 * @property string|null $category
 * @property string|null $name
 * @property string|null $field_category
 * @property string|null $field_name
 * @property string|null $method
 * @property string|null $sample
 * @property string|null $reference_range
 * @property string|null $comments
 * @property string|null $cost
 * @property string|null $out_cost
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereFieldCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereOutCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereReferenceRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereSample($value)
 * @mixin \Eloquent
 */
class Test_old extends Model
{
    use HasFactory;
    protected $table = 'tests';
    protected $fillable = [
        'category',
        'name',
        'fees',
    ];

    public function testDetails()
    {
        return $this->hasMany(TestDetails::class, 'test_id', 'id');
    }
}
