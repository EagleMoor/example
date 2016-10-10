<?php
/**
 * Created by PhpStorm.
 * User: eaglemoor
 * Date: 26.08.16
 * Time: 0:20
 */

namespace common\components;


use Ramsey\Uuid\Uuid;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class UuidBehavior extends AttributeBehavior
{
    public $attributes = [
        ActiveRecord::EVENT_BEFORE_VALIDATE => 'uid'
    ];

    public function getValue($event)
    {
        if (empty($event->sender->uid)) {
            return (string) Uuid::uuid4();
        } else {
            return $event->sender->uid;
        }
    }
}