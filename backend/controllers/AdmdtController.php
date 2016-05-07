<?php
// Not preferred; 

namespace backend\controllers;

use Yii;
use backend\models\Admdt;
use backend\models\AdmdtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AdmdtController implements the CRUD actions for Admdt model.
 */
class AdmdtController extends Controller
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
     * Lists all Admdt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdmdtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admdt model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admdt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admdt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->INDEX_NO]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Uploads a new Admdt model from CSV file.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionUpload()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Admdt();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file)//&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/admresults/' .$time. '.'.$model->file->baseName . '.'.$model->file->extension);
                        $model->file = 'csv/admresults/' .$time. '.'.$model->file->baseName . '.'.$model->file->extension;

                         $handle = fopen($model->file, "r");
                         while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                         {
                             $INDEX_NO = $fileop[0];
                             $NAME = $fileop[1];
                             $ENTRANCE_CERT = $fileop[2];
                             $AWARDING_INSTITUTION = $fileop[3];
                             $CERTIFICATE_NO = $fileop[4];
                             $QUALIFICATION_INDEX_NO = $fileop[5];
                             $CLASS = $fileop[6];
                             $ENGLISH_LANGUAGE = $fileop[7];
                             $MATHEMATICS = $fileop[8];
                             $INTEGRATED_SCIENCE = $fileop[9];
                             $SOCIAL_STUDIES = $fileop[10];
                             $PHYSICS = $fileop[11];
                             $CHEMISTRY = $fileop[12];
                             $BIOLOGY = $fileop[13];
                             $ELECTIVE_MATHEMATICS = $fileop[14];
                             $GENERAL_AGRICULTURE = $fileop[15];
                             $CROP_HUSBANDRY = $fileop[16];
                             $ANIMAL_HUSBANDRY = $fileop[17];

                         $sql = "INSERT INTO admdt(INDEX_NO, NAME, ENTRANCE_CERT, AWARDING_INSTITUTION, CERTIFICATE_NO, 
                                QUALIFICATION_INDEX_NO, CLASS, ENGLISH_LANGUAGE, MATHEMATICS, INTEGRATED_SCIENCE, SOCIAL_STUDIES,
                                PHYSICS, CHEMISTRY, BIOLOGY, ELECTIVE_MATHEMATICS, GENERAL_AGRICULTURE, CROP_HUSBANDRY, ANIMAL_HUSBANDRY) 
                            VALUES ('$INDEX_NO', '$NAME', '$ENTRANCE_CERT', '$AWARDING_INSTITUTION', '$CERTIFICATE_NO','$QUALIFICATION_INDEX_NO',
                                    '$CLASS','$ENGLISH_LANGUAGE','$MATHEMATICS','$INTEGRATED_SCIENCE', '$SOCIAL_STUDIES', '$PHYSICS', '$CHEMISTRY', 
                                    '$BIOLOGY', '$ELECTIVE_MATHEMATICS', '$GENERAL_AGRICULTURE', '$CROP_HUSBANDRY', '$ANIMAL_HUSBANDRY')";
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
     * Updates an existing Admdt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->INDEX_NO]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admdt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admdt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admdt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admdt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
