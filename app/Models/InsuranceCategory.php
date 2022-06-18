<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InsuranceCategory
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory whereName($value)
 * @mixin \Eloquent
 */
class InsuranceCategory extends Model
{
    use HasFactory;
    protected $table='insurance_categories';
}
