<?php

namespace App\Model\ControlPanel\Project;


use App\Model\Project\ProjectAccount;
use Illuminate\Database\Eloquent\Model;



/**
 * App\Model\ControlPanel\Project\ProjectDonorPayment
 *
 * @property int $id
 * @property int $project_id
 * @property int $donor_id
 * @property string|null $due_date
 * @property float|null $agreed_amount
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $storedby
 * @property string|null $modifiedby
 * @property int|null $payment_number_id
 * @property float|null $received_payment
 * @property string|null $payment_file
 * @property string|null $receiving_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Project\ProjectAccount[] $project_account
 * @property-read int|null $project_account_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereAgreedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereDonorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment wherePaymentFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment wherePaymentNumberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereReceivedPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereReceivingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereStoredby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\ProjectDonorPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectDonorPayment extends Model
{
    protected $guarded = [];
    public function project_account()
    {
        return $this->hasMany(ProjectAccount::class)->orderBy ('id');
    }
}
