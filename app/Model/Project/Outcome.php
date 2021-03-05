<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class Outcome
 *
 * @package App\Model\Project
 * @property int $id
 * @property string|null $name_en
 * @property string|null $description
 * @property int|null $project_id
 * @property float|null $progress
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $duration
 * @property float|null $direct_cost
 * @property float|null $planned_progress
 * @property float|null $days
 * @property float|null $precent_of_cost
 * @property float|null $total_percentage
 * @property float|null $indirect_cost
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Project\Output[] $outputs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereDirectCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereIndirectCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome wherePlannedProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome wherePrecentOfCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereTotalPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Outcome whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $outputs_count
 */
class Outcome extends Model
{
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function($outcome) {
            foreach ($outcome->outputs()->get() as $post) {
                $post->delete();
            }
        });
    }
    /**
     * @return HasMany
     */
    public function outputs () : HasMany
    {
        return $this->hasMany(Output::class);
    }
    

}
