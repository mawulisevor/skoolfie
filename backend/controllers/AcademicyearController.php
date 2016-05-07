<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Academicyear;
use backend\models\AcademicyearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * AcademicyearController implements the CRUD actions for Academicyear model.
 */
class AcademicyearController extends Controller
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
     * Lists all Academicyear models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new AcademicyearSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Displays a single Academicyear model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Creates a new Academicyear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Academicyear();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->acyear]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Updates an existing Academicyear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->acyear]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Deletes an existing Academicyear model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Finds the Academicyear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Academicyear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Academicyear::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
