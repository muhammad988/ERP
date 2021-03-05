<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\Project\DetailedProposal
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $context
 * @property string|null $link_to_cluster_objectives
 * @property string|null $implementation_plan
 * @property string|null $overall_objective
 * @property string|null $monitoring_evaluation
 * @property string|null $reporting
 * @property string|null $gender_marker
 * @property string|null $accountability
 * @property float|null $overhead
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereAccountability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereGenderMarker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereImplementationPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereLinkToClusterObjectives($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereMonitoringEvaluation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereOverallObjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereOverhead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\DetailedProposal whereReporting($value)
 * @mixin \Eloquent
 */
class DetailedProposal extends Model
{
    protected $fillable = ['project_id','context','link_to_cluster_objectives','implementation_plan','overall_objective','monitoring_evaluation','reporting','gender_marker','accountability','overhead'];
    public $timestamps = false;
}
