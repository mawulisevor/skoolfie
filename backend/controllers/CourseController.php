<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Course;
use backend\models\CourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new CourseSearch();
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
     * Displays a single Course model.
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
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
         $model = new Course();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->courseid]);
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
     * Uploads a new Course model from CSV file.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
public function actionUpload()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Course();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file) //&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/course/' .$time. '.'.$model->file->baseName . '.'. $model->file->extension);
                        $model->file = 'csv/course/' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;
                         $handle = fopen($model->file, "r");
                         while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                         {
                            $courseid = $fileop[0];
                            $coursename = $fileop[1];
                            $coursecredit = $fileop[2];
                            $aclevel = $fileop[3];
                            $semester = $fileop[4];
                            $deptid = $fileop[5];
                            $progid = $fileop[6];
                            // print_r($fileop);exit(); 
                            $sql = "INSERT INTO course(courseid, coursename, coursecredit, aclevel, semester, deptid, progid) VALUES ('$courseid', '$coursename', '$coursecredit', '$aclevel', '$semester', '$deptid', '$progid')";
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
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }
    
    
    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->courseid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
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
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
