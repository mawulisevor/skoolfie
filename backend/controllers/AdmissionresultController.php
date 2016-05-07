<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Admissionresult;
use backend\models\AdmissionresultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AdmissionresultController implements the CRUD actions for Admissionresult model.
 */
class AdmissionresultController extends Controller
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
     * Lists all Admissionresult models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new AdmissionresultSearch();
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
     * Displays a single Admissionresult model.
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
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Creates a new Admissionresult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Admissionresult();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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
     * Uploads a new Admissionresult model from CSV file.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
public function actionUpload()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Admissionresult();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file)//&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/admissionresult/' .$time. '.'.$model->file->baseName . '.'.$model->file->extension);
                        $model->file = 'csv/admissionresult/' .$time. '.'.$model->file->baseName . '.'.$model->file->extension;

                        $handle = fopen($model->file, "r");
                        $csv_headings = fgetcsv($handle, 4096, ",")
                        $flag = true;
                        while (($fileop = fgetcsv($handle, 4096, ",")) !== false) 
                         {  
                            if ($flag) {
                                $flag = false;
                                continue;
                            }
                            $numcols = count($fileop);
                            $numcols1 = 7;
                            while ($numcols1 < $numcols) {
                                $studid = $fileop[0];
                                $cert = $fileop[1];
                                $institution = $fileop[2];
                                $certno = $fileop[3];
                                $indexno = $fileop[4];
                                $certclass = $fileop[5]; // certclass ... recurrent data begins after
                                // ENGLISH LANGUAGE MATHEMATICS INTEGRATED SCIENCE  SOCIAL STUDIES  PHYSICS CHEMISTRY   BIOLOGY ELECTIVE MATHEMATICS    GENERAL AGRICULTURE CROP HUSBANDRY  ANIMAL HUSBANDRY    fisheries
                                $subject = $csv_headings[$numcols1];
                                $grade = $fileop[$numcols1];
                                $numcols1 =$numcols1 +1;
                                // print_r($fileop);exit();
                                $sql = "INSERT INTO admissionresult(studid, cert, institution,certno,indexno,certclass,subject,grade) VALUES ('$studid', '$cert', '$institution', '$certno','$indexno','$certclass','$subject','$grade')";
                                $query = Yii::$app->db->createCommand($sql)->execute();
                            }
                            
                         }
                        /*
                        while (($fileop = fgetcsv($handle, 4096, ",")) !== false) 
                        {
                            $studid = $fileop[0];
                            $cert = $fileop[1];
                            $institution = $fileop[2];
                            $certno = $fileop[3];
                            $indexno = $fileop[4];
                            $certclass = $fileop[5];
                            $subject = $fileop[6];
                            $grade = $fileop[7];
                            // print_r($fileop);exit();
                         $sql = "INSERT INTO admissionresult(studid, cert, institution,certno,indexno,certclass,subject,grade) VALUES ('$studid', '$cert', '$institution', '$certno','$indexno','$certclass','$subject','$grade')";
                            $query = Yii::$app->db->createCommand($sql)->execute();
                         }
                         */

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
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }
 
    
    /**
     * Updates an existing Admissionresult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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
     * Deletes an existing Admissionresult model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Admissionresult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admissionresult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admissionresult::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
