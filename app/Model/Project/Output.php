<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class Output
 *
 * @package App\Model\Project
 * @property int $id
 * @property string|null $name_en
 * @property string|null $description
 * @property string|null $assumption
 * @property int|null $outcome_id
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Project\Activitie[] $activities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Project\Indicator[] $indicators
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereAssumption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereDirectCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereIndirectCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereOutcomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output wherePlannedProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output wherePrecentOfCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereTotalPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Output whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $activities_count
 * @property-read int|null $indicators_count
 */
class Output extends Model
{
    
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($output) {
            foreach($output->activities as $activity){
                $activity->delete();
            }
        });
        static::deleting(function($output) {
            foreach($output->indicators as $indicator){
                $indicator->delete();
            }
        });
    }
    
    /**
     * @return HasMany
     */
    public function activities () : HasMany
    {
        return $this->hasMany(Activitie::class)
            ->join ('users', 'activities.responsibility', '=', 'users.id')
            ->join ('activity_phases', 'activities.activity_phase_id', '=', 'activity_phases.id')
            ->select('activities.*', 'users.first_name_en', 'users.last_name_en', 'activity_phases.name_en as phase_name_en');
    }
    
    /**
     * @return HasMany
     */
    public function indicators () : HasMany
    {
        return $this->hasMany(Indicator::class);
    }

    
}
