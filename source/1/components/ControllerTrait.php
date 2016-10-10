<?php
/**
 * Created by PhpStorm.
 * User: eaglemoor
 * Date: 21.08.16
 * Time: 23:28
 */

namespace common\components;


trait ControllerTrait
{
    protected function authExcept() {
        if ($this instanceof \yii\console\Controller) return false;
        return [];
    }

    /**
     * Добавление модуля авторизации
     *
     * ```php
     * $authExcept = false — отключить авторизацию
     * $authExcept = [] — включить авторизацию
     * $authExcept = ['auth'] — включить авторизацию везде, кроме actionAuth
     * ```
     *
     * @return mixed
     */
    public function behaviors() {
        $behaviors = parent::behaviors();

        $authExcept = $this->authExcept();

        if (false !== $authExcept) {
            $behaviors['authenticator'] = [
                'class' => \yii\filters\auth\CompositeAuth::className(),
                'authMethods' => [
                    \yii\filters\auth\HttpBearerAuth::className(),
                    \yii\filters\auth\QueryParamAuth::className(),
                ],
                'except' => $authExcept
            ];
        }

        return $behaviors;
    }

    /**
     * Поиск модели по id
     *
     * ```php
     * $modelClass = 'app\models\User';
     * ```
     *
     * @param $id
     * @param string $modelClass
     *
     * @return \yii\db\ActiveRecordInterface
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function findModel($id, $modelClass = null) {
        $findModelClass = $modelClass;

        if (null == $findModelClass) {
            $fields = \Yii::getObjectVars($this);

            if (!$findModelClass && isset($fields['modelClass']) && $fields['modelClass'])
                $findModelClass = $fields['modelClass'];
        }

        if (!$findModelClass) {
            throw new \yii\base\InvalidConfigException('Not set $modelClass');
        }

        $object = $findModelClass::findOne($id);
        if (!$object) {
            throw new \yii\web\NotFoundHttpException("Object not found: $id");
        } else {
            return $object;
        }
    }
}