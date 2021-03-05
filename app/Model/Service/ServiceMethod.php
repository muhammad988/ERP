<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Service\ServiceMethod
 *
 * @property int $id
 * @property string $name_en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $namear
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereNamear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceMethod whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $services_count
 */
class ServiceMethod extends Model
{
    //
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
