<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Model\Project\Indicator
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $description
 * @property int|null $output_id
 * @property float|null $progress
 * @property bool|null $completed
 * @property string|null $completed_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property string|null $means_of_verification
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereCompletedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereMeansOfVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereOutputId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Project\Indicator whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Indicator extends Model
{
    //
}
