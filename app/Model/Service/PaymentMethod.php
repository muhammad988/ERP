<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Service\PaymentMethod
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentMethod whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $services_count
 */
class PaymentMethod extends Model
{
    //
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
