<?php

namespace App\Model;

use App\Model\Hr\User;
use App\Model\Project\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Model\OrganisationUnit
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $uid
 * @property string|null $code
 * @property string|null $shortname
 * @property string|null $path
 * @property int|null $hierarchylevel
 * @property string|null $description
 * @property string|null $openingdate
 * @property string|null $closeddate
 * @property string|null $featuretype
 * @property string|null $coordinates
 * @property string|null $url
 * @property-read Collection|Project[] $projects
 * @property-read int|null $projects_count
 * @method static Builder|OrganisationUnit newModelQuery()
 * @method static Builder|OrganisationUnit newQuery()
 * @method static Builder|OrganisationUnit query()
 * @method static Builder|OrganisationUnit whereCloseddate($value)
 * @method static Builder|OrganisationUnit whereCode($value)
 * @method static Builder|OrganisationUnit whereCoordinates($value)
 * @method static Builder|OrganisationUnit whereCreatedAt($value)
 * @method static Builder|OrganisationUnit whereDescription($value)
 * @method static Builder|OrganisationUnit whereFeaturetype($value)
 * @method static Builder|OrganisationUnit whereHierarchylevel($value)
 * @method static Builder|OrganisationUnit whereId($value)
 * @method static Builder|OrganisationUnit whereModifiedBy($value)
 * @method static Builder|OrganisationUnit whereNameAr($value)
 * @method static Builder|OrganisationUnit whereNameEn($value)
 * @method static Builder|OrganisationUnit whereOpeningdate($value)
 * @method static Builder|OrganisationUnit whereParentId($value)
 * @method static Builder|OrganisationUnit wherePath($value)
 * @method static Builder|OrganisationUnit whereShortname($value)
 * @method static Builder|OrganisationUnit whereStoredBy($value)
 * @method static Builder|OrganisationUnit whereUid($value)
 * @method static Builder|OrganisationUnit whereUpdatedAt($value)
 * @method static Builder|OrganisationUnit whereUrl($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Hr\User[] $users
 * @property-read int|null $users_count
 */
class OrganisationUnit extends Model
{
    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }
}
