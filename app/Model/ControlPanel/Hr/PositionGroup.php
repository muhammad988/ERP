<?php

namespace App\Model\ControlPanel\Hr;

use App\Model\Hr\User;
use Illuminate\Database\Eloquent\Model;


/**
 * Class PositionGroup
 *
 * @package App\Model\ControlPanel\Hr
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\PositionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\PositionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Hr\PositionGroup query()
 * @mixin \Eloquent
 */
class PositionGroup extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];

}
