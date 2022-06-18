<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestCategory
 *
 * @property int $id
 * @property string|null $Category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|TestCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TestCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TestCategory withoutTrashed()
 * @mixin \Eloquent
 */
class TestCategory extends Model
{
    use HasFactory;
}
