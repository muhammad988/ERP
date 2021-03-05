<?php

namespace App\Model\ControlPanel\Hr;

use App\Model\Hr\User;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * App\Model\ControlPanel\Hr\TypeOfContract
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read Collection|User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOfContract whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $users_count
 */
class TypeOfContract extends Model
{
    protected $fillable = ['name_en', 'name_ar','stored_by'];
    
    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
