<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use \mPDF;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use backend\controllers\SiteController;


/**
 * StudentController implements the CRUD actions for Student model.
 */
class GraduationController extends Controller
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
     * Displays a single Gradebook model if you are a site-viewer
     * @param string $id
     * @return mixed
     */

    public function actionBroad($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $createbroad = Yii::$app -> db -> createCommand('call broadsheet_pivot(:id)',
                [':id'=>$id,])->execute();
            /* $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM broad',[]) -> queryScalar();
                */
            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            return $this->render('broad', [
                'dataProvider' => $dataProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }

    public function actionBroadsheet($id,$pid)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $createbroad = Yii::$app -> db -> createCommand('call broadsheet_pivot(:id,:pid)',
                [':id'=>$id,':pid'=>$pid,])->execute();

            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM broad',[]) -> queryScalar();
            $instProvider = new SqlDataProvider([
                'sql' => 'SELECT `inst_name`, `logo` FROM institution WHERE `id`=1',
            ]);
            $progid = new SqlDataProvider([
                'sql' => 'SELECT DISTINCT `Progid` FROM broad',
            ]);
            $prognameProvider = new SqlDataProvider([
                'sql' => 'SELECT `progname` FROM acprog WHERE `progid`=:pid',
                'params' => [':pid' => $pid],
            ]);
            $c1Provider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=3.6 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $c2uProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=3.0 AND FGPA <=3.5 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $c2lProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=2.5 AND FGPA <=2.9 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $c3Provider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=2.0 AND FGPA <=2.4 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $cpProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=1.0 AND FGPA <=1.9 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $issuesProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA <1.0 OR TCR < 106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                    // FGPA <1.0 AND SUM(CR1 + CR2 + CR3 + CR4 + CR5 + CR6) < 106
                ],
            ]);

            return $this->render('broadsheet', [
                'instProvider' => $instProvider,
                'prognameProvider' => $prognameProvider,
                'c1Provider' => $c1Provider,
                'c2uProvider' => $c2uProvider,
                'c2lProvider' => $c2lProvider,
                'c3Provider' => $c3Provider,
                'cpProvider' => $cpProvider,
                'issuesProvider' => $issuesProvider,
                
            ]);
        }else 
        {
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }


    public function actionPrintbroadsheet($id)
    {
        if(Yii::$app->user->can('site-viewer'))
        {
            $createbroad = Yii::$app -> db -> createCommand('call broadsheet_pivot(:id)',
                [':id'=>$id,])->execute();

            $count = Yii::$app -> db -> createCommand('
                SELECT COUNT(*) FROM broad',[]) -> queryScalar();
            $instProvider = new SqlDataProvider([
                'sql' => 'SELECT `inst_name`, `logo` FROM institution WHERE `id`=1',
            ]);
            $c1Provider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=3.6 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $c2uProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=3.0 AND FGPA <=3.5 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $c2lProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=2.5 AND FGPA <=2.9 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $c3Provider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=2.0 AND FGPA <=2.4 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $cpProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA >=1.0 AND FGPA <=1.9 AND TCR >=106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                ],
            ]);

            $issuesProvider = new SqlDataProvider([
                'sql' => 'SELECT 
                        Index_No,
                        Name,
                        IF(CR1 IS NULL," ",CR1) AS CR1,
                        IF(GPA1 IS NULL," ",GPA1) AS GPA1,
                        IF(CR2 IS NULL," ",CR2) AS CR2,
                        IF(GPA2 IS NULL," ", GPA2) AS GPA2,
                        IF(CR3 IS NULL," ",CR3) AS CR3,
                        IF(GPA3 IS NULL," ",GPA3) AS GPA3,
                        IF(CR4 IS NULL," ",CR4) AS CR4,
                        IF(GPA4 IS NULL," ",GPA4) AS GPA4,
                        IF(CR5 IS NULL," ",CR5) AS CR5,
                        IF(GPA5 IS NULL," ",GPA5) AS GPA5,
                        IF(CR6 IS NULL," ",CR6) AS CR6,
                        IF(GPA6 IS NULL," ",GPA6) AS GPA6,
                        FGPA
                        FROM broad WHERE FGPA <1.0 AND TCR < 106 ORDER BY FGPA DESC',
                'pagination' => [
                    'pagesize' => -1,
                    // FGPA <1.0 AND SUM(CR1 + CR2 + CR3 + CR4 + CR5 + CR6) < 106
                ],
            ]);
            $mpdf=new mPDF();
            $mpdf->WriteHTML($this->renderPartial('broadsheet', 
                [
                    'instProvider' => $instProvider,
                    'c1Provider' => $c1Provider,
                    'c2uProvider' => $c2uProvider,
                    'c2lProvider' => $c2lProvider,
                    'c3Provider' => $c3Provider,
                    'cpProvider' => $cpProvider,
                    'issuesProvider' => $issuesProvider,
                ]
                ));
            $mpdf->Output('Broadsheet.pdf', 'D');
            exit;
        }else 
        {
            //throw new ForbiddenHttpException("Hold it!. You tried doing the wrong thing.");
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }
    }
}
