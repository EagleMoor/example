<?php
/**
 * Created by PhpStorm.
 * User: eaglemoor
 * Date: 24.08.16
 * Time: 0:10
 */

namespace common\components;


class ErrorHandler extends \yii\web\ErrorHandler
{
    public function convertExceptionToArray($exception)
    {
        $exp = parent::convertExceptionToArray($exception);

        if ($exception instanceof ValidateException) {
            $exp['errors'] = $exception->errors;
        }
        return $exp;
    }
}