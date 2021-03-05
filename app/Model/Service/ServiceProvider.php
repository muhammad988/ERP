<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Service\ServiceProvider
 *
 * @property int $id
 * @property string $name_en
 * @property int|null $methodid
 * @property string|null $namear
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereMethodid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereNamear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereStoredby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Service\ServiceProvider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Service\Service[] $services
 * @property-read int|null $services_count
 */
class ServiceProvider extends Model
{
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
