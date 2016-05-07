<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use backend\models\Gradebook;
use backend\models\GradebookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use backend\controllers\SiteController;
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
    
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $searchModel = new GradebookSearch();
            //$searchModel = new GradebookQuery();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            //$dataProvider = new Gradebook();

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
     * Displays a single Gradebook model if you are a site-viewer
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM gradebook WHERE `Index_No`=:Index_No',
            [':Index_No'=> $id]) -> queryScalar();
            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No ',
                'params' => [':Index_No' => $id],
            ]);

            return $this->render('view', [
                'dataProvider' => $dataProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }
    
    /**
     * Displays a single Gradebook model if you are a site-viewer
     * @param string $id
     * @return mixed
     */
    public function actionViewx($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM gradebook WHERE `Index_No`=:Index_No',
            [':Index_No'=> $id]) -> queryScalar();
            /*$sem1Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Ac_Level=100 AND Semester = 1',
                'params' => [':Index_No' => $id],
            ]); */
            $instProvider = new SqlDataProvider([
                'sql' => 'SELECT `inst_name`, `logo` FROM institution WHERE `id`=1',
            ]);
            $sem1Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 1',
                'params' => [':Index_No' => $id],
            ]);
            $sem2Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 2',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem3Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 3',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem4Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 4',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem5Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 5',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem6Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 6',
                'params' => [':Index_No' => $id],
            ]);

            $studProvider = new SqlDataProvider([ 
                'sql' => 'SELECT `sex` as `sex`, `birthdate` as `birthdate`, `admdate` as `admdate`, `acprog`.`progname` as `acprog`, `certclass` as `certclass` FROM `student` JOIN `acprog` WHERE `student`.`progid` = `acprog`.`progid` AND `studid`=:Index_No',
                'params' => [':Index_No' => $id],
            ]);

            $cgpaProvider = new SqlDataProvider([
                'sql' =>'SELECT  ROUND(SUM(`GP`)/sum(`CR`), 2)  as `CGPA` FROM gradebook WHERE `Index_No`=:Index_No ',
                'params' => [':Index_No' => $id],
            ]);

            $gpa1Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=1',
                'params' => [':Index_No' => $id],
            ]);
            
            $gpa2Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=2',
                'params' => [':Index_No' => $id],
            ]);

            $gpa3Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=3',
                'params' => [':Index_No' => $id],
            ]);

            $gpa4Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=4',
                'params' => [':Index_No' => $id],
            ]);

            $gpa5Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=5',
                'params' => [':Index_No' => $id],
            ]);

            $gpa6Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=6',
                'params' => [':Index_No' => $id],
            ]);

            return $this->render('viewx', [
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
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    public function actionPrintviewx($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {      
            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM gradebook WHERE `Index_No`=:Index_No',
            [':Index_No'=> $id]) -> queryScalar();
            $instProvider = new SqlDataProvider([
                'sql' => 'SELECT `inst_name`, `logo` FROM institution WHERE `id`=1',
            ]);
            $sem1Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 1',
                'params' => [':Index_No' => $id],
            ]);
            $sem2Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 2',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem3Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 3',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem4Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 4',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem5Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 5',
                'params' => [':Index_No' => $id],
            ]);
            
            $sem6Provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No AND Semester = 6',
                'params' => [':Index_No' => $id],
            ]);

            $studProvider = new SqlDataProvider([ 
                'sql' => 'SELECT `sex` as `sex`, `birthdate` as `birthdate`, `admdate` as `admdate`, `acprog`.`progname` as `acprog`, `certclass` as `certclass` FROM `student` JOIN `acprog` WHERE `student`.`progid` = `acprog`.`progid` AND `studid`=:Index_No',
                'params' => [':Index_No' => $id],
            ]);

            $cgpaProvider = new SqlDataProvider([
                'sql' =>'SELECT  ROUND(SUM(`GP`)/sum(`CR`), 2)  as `CGPA` FROM gradebook WHERE `Index_No`=:Index_No ',
                'params' => [':Index_No' => $id],
            ]);

            $gpa1Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=1',
                'params' => [':Index_No' => $id],
            ]);
            
            $gpa2Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=2',
                'params' => [':Index_No' => $id],
            ]);

            $gpa3Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=3',
                'params' => [':Index_No' => $id],
            ]);

            $gpa4Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=4',
                'params' => [':Index_No' => $id],
            ]);

            $gpa5Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=5',
                'params' => [':Index_No' => $id],
            ]);

            $gpa6Provider = new SqlDataProvider([
                'sql' =>'SELECT sum(`CR`) AS `CRT`, sum(`GP`) AS `GPT`, ROUND(SUM(`GP`)/sum(`CR`), 2) as `GPA` FROM gradebook WHERE `Index_No`=:Index_No AND `Semester`=6',
                'params' => [':Index_No' => $id],
            ]);

            $mpdf=new mPDF();
            
            $mpdf->WriteHTML($this->renderPartial('viewx' ,
                [
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
                ]
            ));
            $mpdf->Output($id.'_Result.pdf', 'D');
            exit;
        }else 
        {
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    public function actionViewxx($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM gradebook WHERE `Index_No`=:Index_No',
            [':Index_No'=> $id]) -> queryScalar();

            $semProvider = new SqlDataProvider([
                'sql' => 'SELECT * FROM gradebook WHERE `Index_No`=:Index_No',
                'params' => [':Index_No' => $id],
            ]);
/*
            $studProvider = new SqlDataProvider([ 
                'sql' => 'SELECT `sex` as `sex`, `birthdate` as `birthdate`, `admdate` as `admdate`, `acprog`.`progname` as `acprog`, `certclass` as `certclass` FROM `student` JOIN `acprog` WHERE `student`.`progid` = `acprog`.`progid` AND `studid`=:Index_No',
                'params' => [':Index_No' => $id],
            ]);

            $cgpaProvider = new SqlDataProvider([
                'sql' =>'SELECT  ROUND(SUM(`GP`)/sum(`CR`), 2)  as `CGPA` FROM gradebook WHERE `Index_No`=:Index_No ',
                'params' => [':Index_No' => $id],
            ]);
*/

            return $this->render('viewxx', [
                'dataProvider' => $semProvider,
                //'cgpaProvider' => $cgpaProvider,
            ]);
        }else 
        {
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }
}
