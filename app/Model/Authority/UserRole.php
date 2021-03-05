<?php

namespace App\Model\Authority;

use App\Model\Hr\User;
use App\Model\Project\Project;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\Authority\UserRole
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property int|null $project_id
 * @property bool|null $view
 * @property bool|null $add
 * @property bool|null $update
 * @property bool|null $disable
 * @property bool|null $delete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property-read \App\Model\Project\Project|null $project
 * @property-read \App\Model\Authority\Role $role
 * @property-read \App\Model\Hr\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereDisable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Authority\UserRole whereView($value)
 * @mixin \Eloquent
 */
class UserRole extends Model
{

    protected $fillable = ['project_id','user_id','role_id','view','add','update','disable','delete','stored_by'];
    protected $attributes = ['view' => false,'add' => false,'update' => false,'disable' => false,'delete' => false];
    protected $guarded = ['modified_by'];

    public function user (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function role (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
