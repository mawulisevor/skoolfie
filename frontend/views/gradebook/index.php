<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'STATEMENT OF RESULTS';
// $this->params['breadcrumbs'][] = $this->title;
//$items=$dataProvider;
// $dataProvider->models;

$sem1Provider->pagination->pageParam = 'sem1-page';
$sem1Provider->sort->sortParam = 'sem1-sort';

$sem2Provider->pagination->pageParam = 'sem2-page';
$sem2Provider->sort->sortParam = 'sem2-sort';

$sem3Provider->pagination->pageParam = 'sem3-page';
$sem3Provider->sort->sortParam = 'sem3-sort';

$sem4Provider->pagination->pageParam = 'sem4-page';
$sem4Provider->sort->sortParam = 'sem4-sort';

$sem5Provider->pagination->pageParam = 'sem5-page';
$sem5Provider->sort->sortParam = 'sem5-sort';

$sem6Provider->pagination->pageParam = 'sem6-page';
$sem6Provider->sort->sortParam = 'sem6-sort';

$instProvider->pagination->pageParam = 'inst-page';
$instProvider->sort->sortParam = 'inst-sort';

$studid = Yii::$app->user->identity->username;
?>

<?= Html::a('PDF', ['pdf' ,'id'=>$studid], ['class' => 'btn btn-success']) ?>

<div class="results-slip">
    <div class="container" align="center">
        <div class="col-lg-7">
            <div class="row">
                <h3><?= $instProvider->getModels()['0']['inst_name']?></h3> 
            </div>
            <div class="row">
                <h5>ACADEMIC OFFICE</h5>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <img src=<?= '"'.$instProvider->getModels()['0']['logo'].'"' ?>  alt="institution logo" height="120" width="110">
            </div>
        </div>
        
    </div>  
       
    
    <h5 align="center"><?= Html::encode($this->title) ?></h5>
    
    <table height="80" width="100%" border="0" padding="0" align="center">
            <tr>
                <th> <?= 'Name: ' ?> </th>
                <td> <?= $sem1Provider->getModels()['0']['Name']?> </td>
                <th> <?= 'Index No: ' ?> </th>
                <td> <?= $sem1Provider->getModels()['0']['Index_No']?> </td>
                
            </tr>
            <tr>
                <th> <?= 'Sex: ' ?> </th>
                <td> <?= $studProvider->getModels()['0']['sex']?> </td>
                <th> <?= 'Date of Birth: ' ?> </th>
                <td> <?= $studProvider->getModels()['0']['birthdate']?> </td>
            </tr>

            <tr>
                <th> <?= 'Program: ' ?> </th>
                <td> <?= $studProvider->getModels()['0']['acprog']?> </td>
                <th> <?= 'Date of Admission: ' ?> </th>
                <td> <?= $studProvider->getModels()['0']['admdate']?> </td>
            </tr>
            <tr>
                <th> <?= 'CGPA: ' ?> </th>
                <td> <?= $cgpaProvider->getModels()['0']['CGPA']?> </td>
                <th> <?= 'Class: ' ?> </th>
                <td> <?= $studProvider->getModels()['0']['certclass']?> </td>
            </tr>
    </table>

    <?php 
        if($sem1Provider->models){
            echo 'LEVEL '. $sem1Provider->getModels()['0']['Ac_Level'].
                    ', YEAR: '. $sem1Provider->getModels()['0']['Year']. 
                    ', SEMESTER: ' . $sem1Provider->getModels()['0']['Semester'].
                 ' ';
            echo GridView::widget([
            'dataProvider' => $sem1Provider,
            'layout'=> "{items}",
            'summary'=>'',
            'tableOptions' =>['class' => 'table table-condensed table-hover'],
            'showFooter'=>true,
            'showHeader' => true,
            'headerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'footerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'showOnEmpty'=>false,
            'emptyCell'=>'',
            'columns' => [
                [
                    'label'=>'CODE',
                    'value'=> 'Course_Code',
                    'headerOptions' => ['width' => '90'],
                    'footer'=> 'CGPA: '.$gpa1Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'TITLE',
                    'value'=> 'Course_Title',
                    'headerOptions' => ['width' => '300'],
                    'footer'=> 'GPA: '. $gpa1Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'CA',
                    'value'=> 'CA',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'EXAM',
                    'value'=> 'Exam',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'TOTAL',
                    'value'=> 'Total',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'CR',
                    'value'=> 'CR',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa1Provider->getModels()['0']['CRT'],
                ],

                [
                    'label'=>'GR',
                    'value'=> 'GR',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'GP',
                    'value'=> 'GP',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa1Provider->getModels()['0']['GPT'],
                ],
            ],
        ]);
        } 

    ?>

    <?php 
        if($sem2Provider->models){
            echo 'LEVEL '. $sem2Provider->getModels()['0']['Ac_Level'].
                    ', YEAR: '. $sem2Provider->getModels()['0']['Year']. 
                    ', SEMESTER: ' . $sem2Provider->getModels()['0']['Semester'].
                 ' ';
            echo GridView::widget([
            'dataProvider' => $sem2Provider,
            'layout'=> "{items}",
            'summary'=>'',
            'tableOptions' =>['class' => 'table table-condensed table-hover'],
            'showFooter'=>true,
            'showHeader' => true,
            'headerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'footerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'showOnEmpty'=>false,
            'emptyCell'=>'',
            'columns' => [
                [
                    'label'=>'CODE',
                    'value'=> 'Course_Code',
                    'headerOptions' => ['width' => '90'],
                    'footer'=> 'CGPA: '. round(
                        ($gpa1Provider->getModels()['0']['GPT'] + $gpa2Provider->getModels()['0']['GPT']) / 
                        ($gpa1Provider->getModels()['0']['CRT'] + $gpa2Provider->getModels()['0']['CRT']),2),
                ],

                [
                    'label'=>'TITLE',
                    'value'=> 'Course_Title',
                    'headerOptions' => ['width' => '300'],
                    'footer'=> 'GPA: '. $gpa2Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'CA',
                    'value'=> 'CA',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'EXAM',
                    'value'=> 'Exam',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'TOTAL',
                    'value'=> 'Total',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'CR',
                    'value'=> 'CR',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa2Provider->getModels()['0']['CRT'],
                ],

                [
                    'label'=>'GR',
                    'value'=> 'GR',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'GP',
                    'value'=> 'GP',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa2Provider->getModels()['0']['GPT'],
                ],
            ],
        ]);
        } 
    ?>
    
    
    <?php 
        if($sem3Provider->models){
            echo 'LEVEL ' . $sem3Provider->getModels()['0']['Ac_Level'].
                    ', YEAR: ' . $sem3Provider->getModels()['0']['Year']. 
                    ', SEMESTER: ' . ($sem3Provider->getModels()['0']['Semester']-2).
                 ' ';
            echo GridView::widget([
            'dataProvider' => $sem3Provider,
            'layout'=> "{items}",
            'summary'=>'',
            'tableOptions' =>['class' => 'table table-condensed table-hover'],
            'showFooter'=>true,
            'showHeader' => true,
            'headerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'footerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'showOnEmpty'=>false,
            'emptyCell'=>'',
            'columns' => [
                [
                    'label'=>'CODE',
                    'value'=> 'Course_Code',
                    'headerOptions' => ['width' => '90'],
                    'footer'=> 'CGPA: '. round(
                        ($gpa1Provider->getModels()['0']['GPT'] + $gpa2Provider->getModels()['0']['GPT'] + $gpa3Provider->getModels()['0']['GPT']) / 
                        ($gpa1Provider->getModels()['0']['CRT'] + $gpa2Provider->getModels()['0']['CRT'] + $gpa3Provider->getModels()['0']['CRT']),2),
                ],

                [
                    'label'=>'TITLE',
                    'value'=> 'Course_Title',
                    'headerOptions' => ['width' => '300'],
                    'footer'=> 'GPA: '. $gpa3Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'CA',
                    'value'=> 'CA',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'EXAM',
                    'value'=> 'Exam',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'TOTAL',
                    'value'=> 'Total',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'CR',
                    'value'=> 'CR',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa3Provider->getModels()['0']['CRT'],
                ],

                [
                    'label'=>'GR',
                    'value'=> 'GR',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'GP',
                    'value'=> 'GP',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa3Provider->getModels()['0']['GPT'],
                ],
            ],
        ]);
        } 
    ?>

    <?php 
        if($sem4Provider->models){
            echo 'LEVEL ' . $sem4Provider->getModels()['0']['Ac_Level'].
                    ', YEAR: ' . $sem4Provider->getModels()['0']['Year']. 
                    ', SEMESTER: ' . ($sem4Provider->getModels()['0']['Semester']-2).
                 ' ';
            echo GridView::widget([
            'dataProvider' => $sem4Provider,
            'layout'=> "{items}",
            'summary'=>'',
            'showFooter'=>true,
            'tableOptions' =>['class' => 'table table-condensed table-hover'],
            'showHeader' => true,
            'headerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'footerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'showOnEmpty'=>false,
            'emptyCell'=>'',
            'columns' => [
                [
                    'label'=>'CODE',
                    'value'=> 'Course_Code',
                    'headerOptions' => ['width' => '90'],
                    'footer'=> 'CGPA: '. round(
                        ($gpa1Provider->getModels()['0']['GPT'] + 
                            $gpa2Provider->getModels()['0']['GPT'] + 
                            $gpa3Provider->getModels()['0']['GPT'] +
                            $gpa4Provider->getModels()['0']['GPT']) / 
                        ($gpa1Provider->getModels()['0']['CRT'] + 
                            $gpa2Provider->getModels()['0']['CRT'] + 
                            $gpa3Provider->getModels()['0']['CRT'] +
                            $gpa4Provider->getModels()['0']['CRT']),2),
                ],

                [
                    'label'=>'TITLE',
                    'value'=> 'Course_Title',
                    'headerOptions' => ['width' => '300'],
                    'footer'=> 'GPA: '. $gpa4Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'CA',
                    'value'=> 'CA',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'EXAM',
                    'value'=> 'Exam',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'TOTAL',
                    'value'=> 'Total',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'CR',
                    'value'=> 'CR',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa4Provider->getModels()['0']['CRT'],
                ],

                [
                    'label'=>'GR',
                    'value'=> 'GR',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'GP',
                    'value'=> 'GP',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa4Provider->getModels()['0']['GPT'],
                ],
            ],
        ]);
        } 
    ?>
    
    
    <?php 
        if($sem5Provider->models){
            echo 'LEVEL ' . $sem5Provider->getModels()['0']['Ac_Level'].
                    ', YEAR: ' . $sem5Provider->getModels()['0']['Year']. 
                    ', SEMESTER: ' . ($sem5Provider->getModels()['0']['Semester']-4).
                 ' ';
            echo GridView::widget([
            'dataProvider' => $sem5Provider,
            'layout'=> "{items}",
            'summary'=>'',
            'showFooter'=>true,
            'showHeader' => true,
            'tableOptions' =>['class' => 'table table-condensed table-hover'],
            'headerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'footerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'showOnEmpty'=>false,
            'emptyCell'=>'',
            'columns' => [
                [
                    'label'=>'CODE',
                    'value'=> 'Course_Code',
                    'headerOptions' => ['width' => '90'],
                    'footer'=> 'CGPA: '. round(
                        ($gpa1Provider->getModels()['0']['GPT'] + 
                            $gpa2Provider->getModels()['0']['GPT'] + 
                            $gpa3Provider->getModels()['0']['GPT'] +
                            $gpa4Provider->getModels()['0']['GPT'] +
                            $gpa5Provider->getModels()['0']['GPT']) / 
                        ($gpa1Provider->getModels()['0']['CRT'] + 
                            $gpa2Provider->getModels()['0']['CRT'] + 
                            $gpa3Provider->getModels()['0']['CRT'] +
                            $gpa4Provider->getModels()['0']['CRT'] +
                            $gpa5Provider->getModels()['0']['CRT']),2),
                ],

                [
                    'label'=>'TITLE',
                    'value'=> 'Course_Title',
                    'headerOptions' => ['width' => '300'],
                    'footer'=> 'GPA: '. $gpa5Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'CA',
                    'value'=> 'CA',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'EXAM',
                    'value'=> 'Exam',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'TOTAL',
                    'value'=> 'Total',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'CR',
                    'value'=> 'CR',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa5Provider->getModels()['0']['CRT'],
                ],

                [
                    'label'=>'GR',
                    'value'=> 'GR',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'GP',
                    'value'=> 'GP',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa5Provider->getModels()['0']['GPT'],
                ],
            ],
        ]);
        } 
    ?>
    
    
    <?php 
        if($sem6Provider->models){
            echo 'LEVEL ' . $sem6Provider->getModels()['0']['Ac_Level'].
                    ', YEAR: ' . $sem6Provider->getModels()['0']['Year']. 
                    ', SEMESTER: ' . ($sem6Provider->getModels()['0']['Semester']-4).
                 ' ';
            echo GridView::widget([
            'dataProvider' => $sem6Provider,
            'layout'=> "{items}",
            'summary'=>'',
            'showFooter'=>true,
            'showHeader' => true,
            'showOnEmpty'=>false,
            'headerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'footerRowOptions'=>['class' => 'tfoot','style'=>'background-color:#999;color:black; font:bold'],
            'tableOptions' =>['class' => 'table table-condensed table-hover'],
            'emptyCell'=>'',
            'columns' => [
                [
                    'label'=>'CODE',
                    'value'=> 'Course_Code',
                    'headerOptions' => ['width' => '90'],
                    'footer'=> 'CGPA: '. round(
                        ($gpa1Provider->getModels()['0']['GPT'] + 
                            $gpa2Provider->getModels()['0']['GPT'] + 
                            $gpa3Provider->getModels()['0']['GPT'] +
                            $gpa4Provider->getModels()['0']['GPT'] +
                            $gpa5Provider->getModels()['0']['GPT'] +
                            $gpa6Provider->getModels()['0']['GPT']) / 
                        ($gpa1Provider->getModels()['0']['CRT'] + 
                            $gpa2Provider->getModels()['0']['CRT'] + 
                            $gpa3Provider->getModels()['0']['CRT'] +
                            $gpa4Provider->getModels()['0']['CRT'] +
                            $gpa5Provider->getModels()['0']['CRT'] +
                            $gpa6Provider->getModels()['0']['CRT']),2),
                ],

                [
                    'label'=>'TITLE',
                    'value'=> 'Course_Title',
                    'headerOptions' => ['width' => '300'],
                    'footer'=> 'GPA: '. $gpa6Provider->getModels()['0']['GPA'],
                ],

                [
                    'label'=>'CA',
                    'value'=> 'CA',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'EXAM',
                    'value'=> 'Exam',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'TOTAL',
                    'value'=> 'Total',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'CR',
                    'value'=> 'CR',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa6Provider->getModels()['0']['CRT'],
                ],

                [
                    'label'=>'GR',
                    'value'=> 'GR',
                    'headerOptions' => ['width' => '30'],
                ],

                [
                    'label'=>'GP',
                    'value'=> 'GP',
                    'headerOptions' => ['width' => '30'],
                    'footer'=>$gpa6Provider->getModels()['0']['GPT'],
                ],
            ],
        ]);
        } 
    ?>
    <p>This is only a statement of results; not an official transcript. Please request official transcripts from the academic office.</p>
    
</div>
