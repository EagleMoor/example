<?php

namespace backend\controllers;

use backend\models\search\TravelSearch;
use common\models\Company;
use common\models\travel\Implementation;
use Yii;
use common\models\travel\Travel;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TravelController implements the CRUD actions for Travel model.
 */
class TravelController extends Controller
{
    /**
     * Lists all Travel models.
     * @return mixed
     */
    public function actionIndex($companyUid = null)
    {
        $searchModel = new TravelSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        $company = ($companyUid) ? Company::findOne($companyUid) : null;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'company' => $company,
        ]);
    }
}
