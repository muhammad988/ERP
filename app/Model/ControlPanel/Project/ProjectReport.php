<?php

namespace App\Model\ControlPanel\Project;


use Illuminate\Database\Eloquent\Model;



/**
 * App\Model\ControlPanel\Project\ProjectReport
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $due_date
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property bool|null $received
 * @property int|null $email_counter
 * @property int|null $report_type_id
 * @property string|null $description
 * @property string|null $report_file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereEmailCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereReportFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereReportTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectReport extends Model
{
    protected $guarded = [];

}
