<?php

namespace App\Model\ControlPanel\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ControlPanel\Project\Category
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $stored_by
 * @property string|null $modified_by
 * @property int|null $budget_category_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereBudgetCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereStoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ControlPanel\Project\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'budget_category_id',
        'stored_by',
    ];
    protected $guarded = [
        'modified_by',
    ];
//    protected $table = 'categoryoptions';
//    protected $primaryKey = 'categoryoptionid';
//    public static $rules = array(
//        'nameen' => 'required|min:3|max:50|unique:categories',
//    );
//    public static function validate($data) {
//        return Validator::make($data, static::$rules);
//    }

}
