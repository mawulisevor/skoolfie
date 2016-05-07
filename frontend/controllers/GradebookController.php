<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use frontend\models\Gradebook;
use frontend\models\GradebookSearch;
use backend\models\Student;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use frontend\controllers\SiteController;
use \mPDF;


/**
 * GradebookController implements the CRUD actions for Gradebook model.
 */
class GradebookController extends Controller
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
     * Displays a single Gradebook model if you are a registered student
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity)
        { 
            $studid = Yii::$app->user->identity->username;
            if(Student::findOne($studid) !== null)
            // if(Yii::$app->user->identity->status === 10 & Student::findOne($studid) !== null)
            {
                // Show results of the student
                {
                    $count = Yii::$app -> db -> createCommand('
                    SELECT COUNT(*) FROM gradebook WHERE `Index_No`=:Index_No',
                        [':Index_No'=> $studid]) -> queryScalar();
                    $instProvider = new SqlDataProvider([
                        'sql' => 'SELECT `inst_name`,`logo` FROM `institution`',
                    ]);
                    $sem1Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 1',
                        'params' => [':Index_No' => $studid],
                    ]);
                    $sem2Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 2',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem3Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 3',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem4Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 4',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem5Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 5',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem6Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 6',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $studProvider = new SqlDataProvider([ 
                        'sql' => 'SELECT `sex` as `sex`, `birthdate` as `birthdate`, `admdate` as `admdate`, `acprog`.`progname` as `acprog`, `certclass` as `certclass` FROM `student` JOIN `acprog` WHERE `student`.`progid` = `acprog`.`progid` AND `studid`=:Index_No',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $cgpaProvider = new SqlDataProvider([
                        'sql' =>'SELECT  ROUND(SUM(`GP`)/sum(`CR`), 2)  as `CGPA` FROM gradebook WHERE `Index_No`=:Index_No ',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa1Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=1',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $gpa2Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=2',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa3Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=3',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa4Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=4',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa5Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=5',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa6Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=6',
                        'params' => [':Index_No' => $studid],
                    ]);
                }
                return $this->render('index', [
                    'instProvider' => $instProvider,
                    'sem1Provider' => $sem1Provider,
                    'sem2Provider' => $sem2Provider,
                    'sem3Provider' => $sem3Provider,
                    'sem4Provider' => $sem4Provider,
                    'sem5Provider' => $sem5Provider,
                    'sem6Provider' => $sem6Provider,
                    'studProvider' => $studProvider,
                    'cgpaProvider' => $cgpaProvider,
                    'gpa1Provider' => $gpa1Provider,
                    'gpa2Provider' => $gpa2Provider,
                    'gpa3Provider' => $gpa3Provider,
                    'gpa4Provider' => $gpa4Provider,
                    'gpa5Provider' => $gpa5Provider,
                    'gpa6Provider' => $gpa6Provider,
                ]);
            }else  
            {
                throw new ForbiddenHttpException("Hold it!. What you did was wrong. Check with the Academic Office to resolve any problem");
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }

    /**
     * Exports a single Gradebook model if you are a registered student as a PDF file
     * @param string $id
     * @return mixed
     */
    public function actionPdf()
    {
        if(Yii::$app->user->identity)
        { 
            $studid = Yii::$app->user->identity->username;
            if(Student::findOne($studid) !== null)
            // if(Yii::$app->user->identity->status === 10 & Student::findOne($studid) !== null)
            {
                // Show results of the student
                {
                    $count = Yii::$app -> db -> createCommand('
                    SELECT COUNT(*) FROM gradebook WHERE `Index_No`=:Index_No',
                        [':Index_No'=> $studid]) -> queryScalar();
                    $sem1Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 1',
                        'params' => [':Index_No' => $studid],
                    ]);
                    $sem2Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 2',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem3Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 3',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem4Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 4',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem5Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 5',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $sem6Provider = new SqlDataProvider([
                        'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 6',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $studProvider = new SqlDataProvider([ 
                        'sql' => 'SELECT `sex` as `sex`, `birthdate` as `birthdate`, `admdate` as `admdate`, `acprog`.`progname` as `acprog`, `certclass` as `certclass` FROM `student` JOIN `acprog` WHERE `student`.`progid` = `acprog`.`progid` AND `studid`=:Index_No',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $cgpaProvider = new SqlDataProvider([
                        'sql' =>'SELECT  ROUND(SUM(`GP`)/sum(`CR`), 2)  as `CGPA` FROM gradebook WHERE `Index_No`=:Index_No ',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa1Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=1',
                        'params' => [':Index_No' => $studid],
                    ]);
                    
                    $gpa2Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=2',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa3Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=3',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa4Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=4',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa5Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=5',
                        'params' => [':Index_No' => $studid],
                    ]);

                    $gpa6Provider = new SqlDataProvider([
                        'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=6',
                        'params' => [':Index_No' => $studid],
                    ]);
                }
            $mpdf=new mPDF();
            $mpdf->WriteHTML($this->renderPartial('index' ,
                [
                    'sem1Provider' => $sem1Provider,
                    'sem2Provider' => $sem2Provider,
                    'sem3Provider' => $sem3Provider,
                    'sem4Provider' => $sem4Provider,
                    'sem5Provider' => $sem5Provider,
                    'sem6Provider' => $sem6Provider,
                    'studProvider' => $studProvider,
                    'cgpaProvider' => $cgpaProvider,
                    'gpa1Provider' => $gpa1Provider,
                    'gpa2Provider' => $gpa2Provider,
                    'gpa3Provider' => $gpa3Provider,
                    'gpa4Provider' => $gpa4Provider,
                    'gpa5Provider' => $gpa5Provider,
                    'gpa6Provider' => $gpa6Provider,
                ]
            ));
            $mpdf->Output($studid.'_Result.pdf', 'D');
            exit;
            }else  
            {
                throw new ForbiddenHttpException("Hold it!. What you did was wrong. Check with the Academic Office to resolve any problem");
            }
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/login"));
        }
    }
}
