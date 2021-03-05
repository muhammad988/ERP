<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\Project\ProposalBeneficiary
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $description
 * @property int|null $project_id
 * @property float|null $men
 * @property float|null $women
 * @property float|null $girls
 * @property float|null $boys
 * @property int|null $organisation_unit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $project_beneficiary_type_id
 * @property-read \App\Model\Project\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereMen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereOrganisationUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereProjectBeneficiaryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\ProposalBeneficiary whereWomen($value)
 * @mixin \Eloquent
 */
class ProposalBeneficiary extends Model
{
    protected $table='project_beneficiaries';
    protected $fillable = ['men','women','girls','boys','project_id','project_beneficiary_type_id','organisation_unit_id','stored_by','modified_by'];
    public function project() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
//    public function project_beneficiary_type() : \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(ProjectBeneficiaryType::class);
//    }
}
