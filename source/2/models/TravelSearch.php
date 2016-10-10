<?php
/**
 * Created by PhpStorm.
 * User: eaglemoor
 * Date: 05/10/16
 * Time: 22:30
 */

namespace backend\models\search;


use common\models\Company;
use common\models\travel\Travel;
use common\models\Tt;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class TravelSearch extends Travel
{
    public function rules()
    {
        return [
            [['companyUid', 'userLogin', 'travelDate', 'status'], 'string']
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'companyUid',
            'userLogin'
        ]);
    }

    public function getStatusList()
    {
        return [
            Travel::STATUS_DELETED => 'Удален',
            Travel::STATUS_ACTIVE => 'Активен',
            Travel::STATUS_ACTIVE_TEMPLATE => 'Активен (шаблон)',
            Travel::STATUS_PROCESS => 'В обработке',
            Travel::STATUS_COMPLETE => 'Завершен успешно',
            Travel::STATUS_COMPLETE_OUT_RANGE => 'Завершен успешно, но не по адресу',
            Travel::STATUS_COMPLETE_FREE => 'Завершен успешно (свободный)',
            Travel::STATUS_UNFINISHED => 'Не выполнен',
        ];
    }

    public function getUsersList()
    {
        $query = User::find()
            ->select('login')
            ->andFilterWhere(['=', 'companyUid', $this->getAttribute('companyUid')]);

        return $query->createCommand()->queryColumn();
    }

    public function getCompanyList()
    {
        $c = Company::find()->all();

        return ArrayHelper::map($c, 'uid', 'name');
    }

    public function search($params)
    {
        $query = Travel::find()
            ->with(['tt', 'tt.company', 'user', 'implementation']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 200,
                'pageSizeLimit' => [1, 200]
            ]
        ]);

        $dataProvider->sort->attributes['status'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC]
        ];

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'status', $this->getAttribute('status')]);

        $query->andFilterWhere(['=', 'travelDate', $this->getAttribute('travelDate')]);

        if ($userLogin = $this->getAttribute('userLogin')) {
            $query->innerJoinWith('user')->andFilterWhere(['ilike',  User::tableName() . '.login', $userLogin]);
        }

        if ($companyUid = $this->getAttribute('companyUid')) {
            $query->innerJoinWith('tt')->andFilterWhere(['=', Tt::tableName() . '.companyUid', $companyUid]);
        }

//        $query->andFilterWhere(['ilike', 'term_id', $this->getAttribute('term_id')])
//            ->andFilterWhere(['uuid' => $this->getAttribute('uuid')]);
//
//        if ($dataTypes = $this->getAttribute('data_types')) {
//            $query->andWhere(['@>', 'data_types', new Expression("'{" . $dataTypes . "}'::text[]")]);
//        }
//
//        if ($useTypes = $this->getAttribute('use_types')) {
//            $query->andWhere(['@>', 'use_types', new Expression("'{" . $useTypes . "}'::text[]")]);
//        }
//
//        if ($typeName = $this->getAttribute('type.name')) {
//            $query->innerJoinWith('type')->andFilterWhere(['ilike', DeviceType::tableName() . '.name', $typeName]);
//        }
//
//        if ($carName = $this->getAttribute('car.name')) {
//            $query->innerJoinWith('car')->andFilterWhere(
//                ['ilike', 'CONCAT(' . Car::tableName() . '.car_brand_name, ' . Car::tableName() . '.car_model_name)', $carName]
//            );
//        }

        return $dataProvider;
    }
}