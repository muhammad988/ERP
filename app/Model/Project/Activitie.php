<?php

namespace App\Model\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 * App\Model\Project\Activitie
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $output_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $note
 * @property int|null $status_id
 * @property int|null $responsibility
 * @property float|null $direct_cost
 * @property float|null $planned_progress
 * @property float|null $days
 * @property float|null $precent_of_cost
 * @property float|null $total_percentage
 * @property float|null $indirect_cost
 * @property int|null $activity_phase_id
 * @property float|null $duration
 * @method static Builder|Activitie newModelQuery()
 * @method static Builder|Activitie newQuery()
 * @method static Builder|Activitie query()
 * @method static Builder|Activitie whereActivityPhaseId($value)
 * @method static Builder|Activitie whereCreatedAt($value)
 * @method static Builder|Activitie whereDays($value)
 * @method static Builder|Activitie whereDescription($value)
 * @method static Builder|Activitie whereDirectCost($value)
 * @method static Builder|Activitie whereDuration($value)
 * @method static Builder|Activitie whereEndDate($value)
 * @method static Builder|Activitie whereId($value)
 * @method static Builder|Activitie whereIndirectCost($value)
 * @method static Builder|Activitie whereModifiedBy($value)
 * @method static Builder|Activitie whereNameEn($value)
 * @method static Builder|Activitie whereNote($value)
 * @method static Builder|Activitie whereOutputId($value)
 * @method static Builder|Activitie wherePlannedProgress($value)
 * @method static Builder|Activitie wherePrecentOfCost($value)
 * @method static Builder|Activitie whereResponsibility($value)
 * @method static Builder|Activitie whereStartDate($value)
 * @method static Builder|Activitie whereStatusId($value)
 * @method static Builder|Activitie whereStoredBy($value)
 * @method static Builder|Activitie whereTotalPercentage($value)
 * @method static Builder|Activitie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activitie extends Model
{
    //
}
