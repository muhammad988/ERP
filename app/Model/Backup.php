<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\Backup
 *
 * @property int $backupid
 * @property string|null $type
 * @property string|null $datavalue
 * @property string|null $datatype
 * @property int|null $userid
 * @property int|null $projectid
 * @property int|null $notificationid
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $projectname
 * @property int|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereBackupid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereDatatype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereDatavalue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereNotificationid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereProjectid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereProjectname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Backup whereUserid($value)
 * @mixin \Eloquent
 */
class Backup extends Model
{
    protected $primaryKey = 'backupid';
    public static $rulesConcept = array(
        'projectname' => 'required|unique:backups|min:2',
    );
    public static function validateConcept($data) {
    return Validator::make($data, static::$rulesConcept);
}
    public static function getBackup() {
        
        return  \App\Backup::get();
    }
}
