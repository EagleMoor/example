<?php
/**
 * Created by PhpStorm.
 * User: eaglemoor
 * Date: 24.08.16
 * Time: 0:12
 */

namespace common\components;


use yii\web\HttpException;

class ValidateException extends HttpException
{
    public $statusCode;
    public $errors = [];

    public function __construct($modelName = '', array $errors = [], $code = 0, \Exception $previous = null)
    {
        $err = &$this->errors;
        if (!empty($modelName)) {
            $this->errors[$modelName] = [];
            $err = &$this->errors[$modelName];
        }

        foreach ($errors as $name => $message) {
            $err[] = [
                'field' => $name,
                'message' => $message
            ];
        }

        parent::__construct(422, $modelName, $code, $previous);
    }

    public function getName()
    {
        if ($this->statusCode == 422) {
            return 'Data Validation Failed.';
        } else {
            return parent::getName();
        }
    }
}