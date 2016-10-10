<?php
/**
 * Created by PhpStorm.
 * User: eaglemoor
 * Date: 23.08.16
 * Time: 23:21
 */

namespace common\components;


class Serializer extends \yii\rest\Serializer
{
    public function serializeModelErrors($model)
    {
        throw new ValidateException(null, $model->getFirstErrors());
    }
}