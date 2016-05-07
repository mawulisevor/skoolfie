<?php

namespace backend\controllers;

use Yii;
use backend\models\Institution;
use backend\models\InstitutionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use yii\web\UploadedFile;

/**
 * InstitutionController implements the CRUD actions for Institution model.
 */
class InstitutionController extends Controller
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
     * Lists all Institution models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-admin'))
        {
            $searchModel = new InstitutionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Institution model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    /**
     * Creates a new Institution model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('develop'))
        {
            $model = new Institution();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Updates an existing Institution model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('site-admin'))
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if (UploadedFile::getInstance($model,'imageFile')){
                    $model->imageFile= UploadedFile::getInstance($model,'imageFile');
                    $instid = $model->id;
                    $imageName = 'logo.'.$model->imageFile->extension;
                        // Upload file
                    if ($model->validate())
                    {
                        $model->imageFile->saveAs('logo.'.$model->imageFile->extension);

                            // Save file path in database
                        $sql = "UPDATE institution SET `logo` = '$imageName' WHERE `id`='$instid'";
                        $query = Yii::$app->db->createCommand($sql)->execute();
                    }
                }                
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Deletes an existing Institution model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('develop'))
        {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Institution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Institution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Institution::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
