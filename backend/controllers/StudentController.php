<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use backend\models\Student;
use backend\models\StudentSearch;
//use backend\models\GradSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use backend\controllers\SiteController;


/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','view','create','update','upload','delete','uploadupdate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ], */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Display a list of students if you are a site-viewer
     * Lists all Student models.
     * @return mixed
     */
    
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new StudentSearch();
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
    

    /**
     * Displays distinct graduation groups from Student model if you are a site-viewer
     * @return mixed
     */
    
    public function actionGrad($progid)
    {
        if(Yii::$app->user->can('site-viewer'))
        {

            $prognameProvider = new SqlDataProvider([
                'sql' => 'SELECT `student`.`progid`, `student`.`gradgroup`, `acprog`.`progname` FROM (`student` join `acprog` on((`student`.`progid` = `acprog`.`progid`))) WHERE `student`.`progid`=:progid',
                'params' => [':progid' => $progid],
            ]);

            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT DISTINCT `student`.`gradgroup`, `student`.`progid` FROM `student` WHERE `student`.`progid`=:progid',
                'params' => [':progid' => $progid],
            ]);
    
            return $this->render('grad', [
                'dataProvider' => $dataProvider,
                'prognameProvider' => $prognameProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }   
    }

    /**
     * Displays Student biodata models for all students in a particular admission group if you are a site-viewer
     * @param string $id
     * @return mixed
     */
    public function actionExportbio($id,$pid)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            /*$createbroad = Yii::$app -> db -> createCommand('call broadsheet_pivot(:id)',
                [':id'=>$id,])->execute();
            */
            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM exportbio',[]) -> queryScalar();
            // Select * from student where progid='DIGA' and gradgroup='JUN2016'
            // 'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No ',
            //    'params' => [':Index_No' => $id],
            $bioProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                    @s:=@s+1 AS ID,
                    INDEX_NO,
                    SURNAME,
                    MIDDLE_NAME,
                    OTHERNAMES,
                    PROGRAMME_CODE,
                    LEVEL,
                    LEVEL_OF_ADMISSION,
                    GENDER,
                    TEL,
                    EMAIL,
                    DATE_OF_ADMISSION,
                    DATE_OF_BIRTH,
                    GRADUATION_GROUP
                    FROM exportbio, 
                    (Select @s:=0) as s
                    WHERE GRADUATION_GROUP=:id
                    AND PROGRAMME_CODE=:pid',
                'params' => [':id' => $id,':pid' => $pid],
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            return $this->render('exportbio', [
                'bioProvider' => $bioProvider,
            ]);
        }else 
        {
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }
    
    /**
     * Displays Student admission result models for all students in a particular admission group if you are a site-viewer
     * @param string $id
     * @return mixed
     */
    public function actionIfciaadmdt($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM admdt',[]) -> queryScalar();
            // Select * from admdt JOIN `student` ON ((`student`.`studid` = `admdt`.`INDEX_NO`)) WHERE student.progid='DIGA' and student.gradgroup='JUN2016'
            $admdtProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                    *
                    FROM admdt 
                    JOIN `student` ON ((`student`.`studid` = `admdt`.`INDEX_NO`))
                    WHERE `student`.`progid`="DIGA" and `student`.`gradgroup`=:id',
                'params' => [':id' => $id],
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            return $this->render('ifciaadmdt', [
                'admdtProvider' => $admdtProvider,
            ]);
        }else
        {
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Displays a single Student model if you are a site-viewer
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
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Creates a new Student model if you are a site-clerk
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
        {
            if(Yii::$app->user->can('site-clerk')){
                   $model = new Student();

                if ($model->load(Yii::$app->request->post()) && $model->save()) 
                    // The model has already been saved.
                {
                    // Insert audit data;
                    $tableid = 'student';
                    $pkey = $model->studid;
                    $actionby = Yii::$app->user->identity->username;
                    $action = 'INSERT';
                    $sql = "INSERT INTO `auditlog` (tableid,pkey,actionby,action) VALUES ('$tableid','$pkey','$actionby','$action')";
                    $query = Yii::$app->db->createCommand($sql)->execute();
                    // Update it with the picture filepath
                    if (UploadedFile::getInstance($model,'imageFile')){
                        $model->imageFile= UploadedFile::getInstance($model,'imageFile');
                        $studid = $model->studid;
                        $imageName = 'pictures/'.$model->studid.'.'.$model->imageFile->extension;
                            // Upload file
                        if ($model->validate())
                        {
                            $model->imageFile->saveAs('pictures/'.$studid.'.'.$model->imageFile->extension);
                                // Save file path in database
                            $sql = "UPDATE student SET `picture` = '$imageName' WHERE `studid`='$studid'";
                                    $query = Yii::$app->db->createCommand($sql)->execute();
                        }
                    }
                    // My custom ends         
                    return $this->redirect(['view', 'id' => $model->studid]);
                } else 
                {
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
     * Uploads a new Student model from CSV file if you are a site-clerk.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
public function actionUpload()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Student();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file)//&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/students/' .$time. '.'.$model->file->baseName . '.' . $model->file->extension);
                        $model->file = 'csv/students/' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;

                         $handle = fopen($model->file, "r");
                         while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                         {
                            $studid = $fileop[0];
                            $lname = $fileop[1];
                            $fname = $fileop[2];
                            $oname = $fileop[3];
                            $progid = $fileop[4];
                            $currentlevel = $fileop[5];
                            $admissionlevel = $fileop[6];
                            $sex = $fileop[7];
                            $phone = $fileop[8];
                            $email = $fileop[9];
                            $admdate = $fileop[10];
                            $birthdate = $fileop[11];
                            $gradgroup = $fileop[12];
                            $semsdone = $fileop[13];
                            $totalgp = $fileop[14];
                            $totalcredit = $fileop[15];
                            $cgpa = $fileop[16];
                            $certclass = $fileop[17];
                             
                            if ($fileop[18]){
                            $picture = $fileop[18];
                            }
                            // print_r($fileop);exit();
                         $sql = "INSERT INTO student(studid, lname, fname, oname, progid, currentlevel, admissionlevel, sex, phone, email, admdate, birthdate, gradgroup, semsdone, totalgp, totalcredit, cgpa, certclass) VALUES ('$studid', '$lname', '$fname', '$oname', '$progid', '$currentlevel', '$admissionlevel', '$sex', '$phone', '$email', '$admdate', '$birthdate', '$gradgroup', '$semsdone', '$totalgp', '$totalcredit', '$cgpa', '$certclass')";
                            $query = Yii::$app->db->createCommand($sql)->execute();
                         }

                         if ($query) 
                         {
                            echo "data upload successfull";
                         }

                    }

                $model->save();
                // Insert audit data;
                $tableid = 'student';
                $actionby = Yii::$app->user->identity->username;
                $pkey = 'csv/students/' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;
                $action = 'UPLOAD';
                $sql = "INSERT INTO `auditlog` (tableid,pkey,actionby,action) VALUES ('$tableid','$pkey','$actionby','$action')";
                $query = Yii::$app->db->createCommand($sql)->execute();
                // End audit data;
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
     * Uploads an update of an existing Student model from CSV file if you are a site-user.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
public function actionUploadupdate()
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = new Student();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ( $model->file)//&& $model->validate()
                    {
                        $time = time();
                        $model->file->saveAs('csv/students/update' .$time. '.'.$model->file->baseName . '.' . $model->file->extension);
                        $model->file = 'csv/students/update' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;
                         $handle = fopen($model->file, "r");
                         while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                         {
                            $studid = $fileop[0];
                            $lname = $fileop[1];
                            $fname = $fileop[2];
                            $oname = $fileop[3];
                            $progid = $fileop[4];
                            $currentlevel = $fileop[5];
                            $admissionlevel = $fileop[6];
                            $sex = $fileop[7];
                            $phone = $fileop[8];
                            $email = $fileop[9];
                            $admdate = $fileop[10];
                            $birthdate = $fileop[11];
                            $gradgroup = $fileop[12];
                            $semsdone = $fileop[13];
                            $totalgp = $fileop[14];
                            $totalcredit = $fileop[15];
                            $cgpa = $fileop[16];
                            $certclass = $fileop[17];
                             
                            if ($fileop[18]){
                            $picture = $fileop[18];
                            }
                            // $picture = $fileop[18];
                            // print_r($fileop);exit();
                         $sql = "UPDATE student SET studid='$studid', lname='$lname', fname='$fname', oname='$oname', progid='$progid', currentlevel='$currentlevel', admissionlevel='$admissionlevel', sex='$sex', phone='$phone', email='$email', admdate='$admdate', birthdate='$birthdate', gradgroup='$gradgroup', semsdone='$semsdone', totalgp='$totalgp', totalcredit='$totalcredit', cgpa='$cgpa', certclass='$certclass' WHERE studid='$studid'";
                            $query = Yii::$app->db->createCommand($sql)->execute();
                         }

                        if ($query) 
                        {
                            echo "data upload successfull";
                        }

                    }

                $model->save();
                // Insert audit data;
                $tableid = 'student';
                $actionby = Yii::$app->user->identity->username;
                $pkey = 'csv/students/update' .$time. '.'.$model->file->baseName . '.'. $model->file->extension;
                $action = 'UPDATE';
                $sql = "INSERT INTO `auditlog` (tableid,pkey,actionby,action) VALUES ('$tableid','$pkey','$actionby','$action')";
                $query = Yii::$app->db->createCommand($sql)->execute();
                // End audit data;
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
     * Updates an existing Student model. if you are a site-user
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('site-clerk'))
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                // Insert audit data;
                $tableid = 'student';
                $actionby = Yii::$app->user->identity->username;
                $pkey = $id;
                $action = 'UPDATE';
                $sql = "INSERT INTO `auditlog` (tableid,pkey,actionby,action) VALUES ('$tableid','$pkey','$actionby','$action')";
                $query = Yii::$app->db->createCommand($sql)->execute();
                // End audit data;
                // My custom
                if(UploadedFile::getInstance($model,'imageFile')){
                    $model->imageFile= UploadedFile::getInstance($model,'imageFile');
                    // $imageName = $model->studid; 
                    $studid = $model->studid;
                    $imageName = 'pictures/'.$model->studid.'.'.$model->imageFile->extension;
                        // Upload file
                    if ($model->validate())
                    {
                        $model->imageFile->saveAs('pictures/'.$studid.'.'.$model->imageFile->extension);
                            // Save file path in database
                        $sql = "UPDATE student SET `picture` = '$imageName' WHERE `studid`='$studid'";
                                $query = Yii::$app->db->createCommand($sql)->execute();
                    }
                }
                    //-------------------------	
                // My custom ends
                return $this->redirect(['view', 'id' => $model->studid]);
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
     * Deletes an existing Student model if you are a site-user.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('site-clerk')){
            $this->findModel($id)->delete();
            // Insert audit data;
            $tableid = 'student';
            $actionby = Yii::$app->user->identity->username;
            $pkey = $id;
            $action = 'DELETE';
            $sql = "INSERT INTO `auditlog` (tableid,pkey,actionby,action) VALUES ('$tableid','$pkey','$actionby','$action')";
            $query = Yii::$app->db->createCommand($sql)->execute();
            // End audit data;
            return $this->redirect(['index']);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested student does not exist.');
        }
    }
}
