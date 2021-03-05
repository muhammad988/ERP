<?php

namespace App\Model\ControlPanel\Hr;

use App\Model\Hr\User;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\ControlPanel\Hr\Nationality
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nationality whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $users_count
 */
class Nationality extends Model {

    protected $fillable = ['name_en', 'name_ar','stored_by'];


    public function users(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class);
    }

}
