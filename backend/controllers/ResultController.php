<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use backend\models\Result;
use backend\models\ResultsForm;
use backend\models\ResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use backend\controllers\SiteController;


/**
 * ResultsController implements the CRUD actions for results database view.
 */
class ResultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

       /**
     * Displays all results for a particular year, level and semester if you are a site-viewer
     * @param string $id
     * @return mixed
     */

    public function actionResults($Year,$Level,$Semester)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
                $createbroad = Yii::$app -> db -> createCommand(
                    'call result_pivot(:Year, :Level, :Semester)')
                    ->bindValue(':Year', $Year)
                    ->bindValue(':Level', $Level)
                    ->bindValue(':Semester', $Semester)
                    ->queryAll();

                return $this->render('results', [
                    'dataProvider' => $createbroad,
                ]);
        }else 
        {
            throw new ForbiddenHttpException("No records found");
        }
    }

        public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new ResultSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }
        
    }
}
