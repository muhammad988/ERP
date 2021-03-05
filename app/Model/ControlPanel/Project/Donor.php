<?php

namespace App\Model\ControlPanel\Project;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Donor
 *
 * @package App\Model\ControlPanel\Project
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property int|null $parent_id
 * @property string|null $modified_by
 * @method static Builder|Donor newModelQuery()
 * @method static Builder|Donor newQuery()
 * @method static Builder|Donor query()
 * @method static Builder|Donor whereCreatedAt($value)
 * @method static Builder|Donor whereId($value)
 * @method static Builder|Donor whereModifiedBy($value)
 * @method static Builder|Donor whereNameAr($value)
 * @method static Builder|Donor whereNameEn($value)
 * @method static Builder|Donor whereParentId($value)
 * @method static Builder|Donor whereStoredBy($value)
 * @method static Builder|Donor whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Donor extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
}
