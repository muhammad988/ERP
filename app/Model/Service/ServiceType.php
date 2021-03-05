<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Service\ServiceType
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $services_count
 */
class ServiceType extends Model
{
    //
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
