<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Model\Project\ProjectAccount
 *
 * @property-read \App\Model\Project\Project $project
 * @property-read \App\Model\Project\Project $project_from
 * @property-read \App\Model\Project\Project $project_to
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProjectAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProjectAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProjectAccount query()
 * @mixin \Eloquent
 */
class ProjectAccount extends Model
{
    //
    protected $guarded = [];

    public function project_from() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class,'transferred_from','id');
    }
    public function project_to() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function project() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
