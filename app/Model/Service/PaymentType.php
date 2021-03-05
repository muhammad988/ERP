<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Service\PaymentType
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\PaymentType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $services_count
 */
class PaymentType extends Model
{
    //
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
