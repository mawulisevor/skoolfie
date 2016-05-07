<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Enroll;
use backend\models\EnrollSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * EnrollController implements the CRUD actions for Enroll model.
 */
class EnrollController extends Controller
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
     * Lists all Enroll models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new EnrollSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Displays a single Enroll model.
     * @param string $studid
     * @param string $courseid
     * @return mixed
     */
    public function actionView($studid, $courseid, $resit)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            return $this->render('view', [
            'model' => $this->findModel($studid, $courseid, $resit),
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Creates a new Enroll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Enroll();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
                return $this->redirect(['view', 'studid' => $model->studid, 'courseid' => $model->courseid, 'resit' => $model->resit]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }
 /**
     * Uploads a new Enroll model from CSV file.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
public function actionUpload()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Enroll();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file) //&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/enroll/' .$time. '.'.$model->file->baseName . '.'. $model->file->extension);
                        $model->file = 'csv/enroll/' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;
                        $handle = fopen($model->file, "r");
                        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                        {
                            $studid = $fileop[0];
                            $courseid = $fileop[1];
                            $resit = $fileop[2];
                            $ca = $fileop[3];
                            $exams = $fileop[4];
                            $acyear = $fileop[5];
                            $classroom = $fileop[6];
                            // print_r($fileop);exit();
                            $sql = "INSERT INTO enroll(studid, courseid, resit, ca, exams, acyear, classroom) VALUES ('$studid', '$courseid', '$resit', '$ca', '$exams', '$acyear', '$classroom')";
                            $query = Yii::$app->db->createCommand($sql)->execute();
                        }

                         if ($query) 
                         {
                            echo "data upload successfull";
                         }

                    }

                $model->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('upload', [
                    'model' => $model,
                ]);
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

/**
     * Uploads a new Enroll model from CSV file.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
public function actionUploadupdate()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Enroll();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file) //&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/enroll/update' .$time. '.'.$model->file->baseName . '.'. $model->file->extension);
                        $model->file = 'csv/enroll/update' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;
                         $handle = fopen($model->file, "r");
                         while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                         {
                            $studid = $fileop[0];
                            $courseid = $fileop[1];
                            $resit = $fileop[2];
                            $ca = $fileop[3];
                            $exams = $fileop[4];
                            $acyear = $fileop[5];
                            $classroom = $fileop[6];
                            // print_r($fileop);exit();
                            $sql = "UPDATE enroll SET studid='$studid', courseid='$courseid', resit='$resit', ca='$ca', exams='$exams', acyear='$acyear', classroom='$classroom' WHERE studid='$studid' and courseid='$courseid' and resit='$resit'";
                            $query = Yii::$app->db->createCommand($sql)->execute();
                         }
                         if ($query) 
                         {
                            echo "data upload successfull";
                         }
                    }
                $model->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('upload', [
                    'model' => $model,
                ]);
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }
     
    /**
     * Updates an existing Enroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $studid
     * @param string $courseid
     * @return mixed
     */
    public function actionUpdate($studid, $courseid, $resit)
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = $this->findModel($studid, $courseid, $resit);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'studid' => $model->studid, 'courseid' => $model->courseid, 'resit' => $model->resit]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Deletes an existing Enroll model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $studid
     * @param string $courseid
     * @return mixed
     */
    public function actionDelete($studid, $courseid, $resit)
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $this->findModel($studid, $courseid, $resit)->delete();
            return $this->redirect(['index']);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Finds the Enroll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $studid
     * @param string $courseid
     * @return Enroll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($studid, $courseid, $resit)
    {
        if (($model = Enroll::findOne(['studid' => $studid, 'courseid' => $courseid, 'resit'=> $resit])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
