<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BROADSHEET';
// $this->params['breadcrumbs'][] = $this->title;

$instProvider->pagination->pageParam = 'inst-page';
$instProvider->sort->sortParam = 'inst-sort';

$prognameProvider->pagination->pageParam = 'progname-page';
$prognameProvider->sort->sortParam = 'progname-sort';

$c1Provider->pagination->pageParam = 'c1-page';
$c1Provider->sort->sortParam = 'c1-sort';
$c2uProvider->pagination->pageParam = 'c2u-page';
$c2uProvider->sort->sortParam = 'c2u-sort';
$c2lProvider->pagination->pageParam = 'c2l-page';
$c2lProvider->sort->sortParam = 'c2l-sort';
$c3Provider->pagination->pageParam = 'c3-page';
$c3Provider->sort->sortParam = 'c3-sort';
$cpProvider->pagination->pageParam = 'cp-page';
$cpProvider->sort->sortParam = 'cp-sort';
?>


<?= Html::a('Print PDF', ['printbroadsheet' ,'id'=>$_GET['id']], ['class' => 'btn btn-success']) ?>

<div class="broadsheet">
    <div class="container" align="center">
        <div class="col-lg-7">
            <div class="row">
                <h1><?= $instProvider->getModels()['0']['inst_name']?></h1> 
            </div>
            <div class="row">
                <h3> <?= $prognameProvider->getModels()['0']['progname'] ?></h3>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <img src=<?= '"'.$instProvider->getModels()['0']['logo'].'"' ?>  alt="institution logo" height="120" width="110">
            </div>
        </div>
        
    </div>  
       
    
    <h4 align="center">COMPLETE RECORDS</h4>

    <?php 
        if($c1Provider->models){
            echo '<b>FIRST CLASS HONOURS </b>';
            echo GridView::widget([
                'dataProvider' => $c1Provider,
                'layout'=> "{items}",
                'emptyCell'=>'',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>' ',
                        'format'=>'raw',
                        'attribute'=>'Index_No',
                        'value'=>function($data){
                            return Html::a(Html::encode($data['Index_No']),['/gradebook/viewx','id'=>$data['Index_No']]);
                        },
                    ],
                    ['label'=>' ', 'value'=>'Name'],
                    ['label'=>'CR1', 'value'=>'CR1'],
                    ['label'=>'GPA1', 'value'=>'GPA1'],
                    ['label'=>'CR2', 'value'=>'CR2'],
                    ['label'=>'GPA2', 'value'=>'GPA2'],
                    ['label'=>'CR3', 'value'=>'CR3'],
                    ['label'=>'GPA3', 'value'=>'GPA3'],
                    ['label'=>'CR4', 'value'=>'CR4'],
                    ['label'=>'GPA4', 'value'=>'GPA4'],
                    ['label'=>'CR5', 'value'=>'CR5'],
                    ['label'=>'GPA5', 'value'=>'GPA5'],
                    ['label'=>'CR6', 'value'=>'CR6'],
                    ['label'=>'GPA6', 'value'=>'GPA6'],
                    ['label'=>'FGPA', 'value'=>'FGPA'],
                ],
            ]);
        
        } 

    ?>

    <?php 
        if($c2uProvider->models){
            echo '<b>SECOND CLASS HONOURS (UPPER DIVISION) </b>';
            echo GridView::widget([
                'dataProvider' => $c2uProvider,
                'layout'=> "{items}",
                'emptyCell'=>'',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>' ',
                        'format'=>'raw',
                        'attribute'=>'Index_No',
                        'value'=>function($data){
                            return Html::a(Html::encode($data['Index_No']),['/gradebook/viewx','id'=>$data['Index_No']]);
                        },
                    ],
                    ['label'=>' ', 'value'=>'Name'],
                    ['label'=>'CR1', 'value'=>'CR1'],
                    ['label'=>'GPA1', 'value'=>'GPA1'],
                    ['label'=>'CR2', 'value'=>'CR2'],
                    ['label'=>'GPA2', 'value'=>'GPA2'],
                    ['label'=>'CR3', 'value'=>'CR3'],
                    ['label'=>'GPA3', 'value'=>'GPA3'],
                    ['label'=>'CR4', 'value'=>'CR4'],
                    ['label'=>'GPA4', 'value'=>'GPA4'],
                    ['label'=>'CR5', 'value'=>'CR5'],
                    ['label'=>'GPA5', 'value'=>'GPA5'],
                    ['label'=>'CR6', 'value'=>'CR6'],
                    ['label'=>'GPA6', 'value'=>'GPA6'],
                    ['label'=>'FGPA', 'value'=>'FGPA'],
                ],
            ]);
        
        } 

    ?>

    <?php 
        if($c2lProvider->models){
            echo '<b>SECOND CLASS HONOURS (LOWER DIVISION) </b>';
            echo GridView::widget([
                'dataProvider' => $c2lProvider,
                'layout'=> "{items}",
                'emptyCell'=>'',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>' ',
                        'format'=>'raw',
                        'attribute'=>'Index_No',
                        'value'=>function($data){
                            return Html::a(Html::encode($data['Index_No']),['/gradebook/viewx','id'=>$data['Index_No']]);
                        },
                    ],
                    ['label'=>' ', 'value'=>'Name'],
                    ['label'=>'CR1', 'value'=>'CR1'],
                    ['label'=>'GPA1', 'value'=>'GPA1'],
                    ['label'=>'CR2', 'value'=>'CR2'],
                    ['label'=>'GPA2', 'value'=>'GPA2'],
                    ['label'=>'CR3', 'value'=>'CR3'],
                    ['label'=>'GPA3', 'value'=>'GPA3'],
                    ['label'=>'CR4', 'value'=>'CR4'],
                    ['label'=>'GPA4', 'value'=>'GPA4'],
                    ['label'=>'CR5', 'value'=>'CR5'],
                    ['label'=>'GPA5', 'value'=>'GPA5'],
                    ['label'=>'CR6', 'value'=>'CR6'],
                    ['label'=>'GPA6', 'value'=>'GPA6'],
                    ['label'=>'FGPA', 'value'=>'FGPA'],
                ],
            ]);
        
        } 

    ?>

    <?php 
        if($c3Provider->models){
            echo '<b>THIRD CLASS </b>';
            echo GridView::widget([
                'dataProvider' => $c3Provider,
                'layout'=> "{items}",
                'emptyCell'=>'',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>' ',
                        'format'=>'raw',
                        'attribute'=>'Index_No',
                        'value'=>function($data){
                            return Html::a(Html::encode($data['Index_No']),['/gradebook/viewx','id'=>$data['Index_No']]);
                        },
                    ],
                    ['label'=>' ', 'value'=>'Name'],
                    ['label'=>'CR1', 'value'=>'CR1'],
                    ['label'=>'GPA1', 'value'=>'GPA1'],
                    ['label'=>'CR2', 'value'=>'CR2'],
                    ['label'=>'GPA2', 'value'=>'GPA2'],
                    ['label'=>'CR3', 'value'=>'CR3'],
                    ['label'=>'GPA3', 'value'=>'GPA3'],
                    ['label'=>'CR4', 'value'=>'CR4'],
                    ['label'=>'GPA4', 'value'=>'GPA4'],
                    ['label'=>'CR5', 'value'=>'CR5'],
                    ['label'=>'GPA5', 'value'=>'GPA5'],
                    ['label'=>'CR6', 'value'=>'CR6'],
                    ['label'=>'GPA6', 'value'=>'GPA6'],
                    ['label'=>'FGPA', 'value'=>'FGPA'],
                ],
            ]);
        
        } 

    ?>

    <?php 
        if($cpProvider->models){
            echo '<b>SECOND CLASS HONOURS (UPPER DIVISION) </b>';
            echo GridView::widget([
                'dataProvider' => $cpProvider,
                'layout'=> "{items}",
                'emptyCell'=>'',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>' ',
                        'format'=>'raw',
                        'attribute'=>'Index_No',
                        'value'=>function($data){
                            return Html::a(Html::encode($data['Index_No']),['/gradebook/viewx','id'=>$data['Index_No']]);
                        },
                    ],
                    ['label'=>' ', 'value'=>'Name'],
                    ['label'=>'CR1', 'value'=>'CR1'],
                    ['label'=>'GPA1', 'value'=>'GPA1'],
                    ['label'=>'CR2', 'value'=>'CR2'],
                    ['label'=>'GPA2', 'value'=>'GPA2'],
                    ['label'=>'CR3', 'value'=>'CR3'],
                    ['label'=>'GPA3', 'value'=>'GPA3'],
                    ['label'=>'CR4', 'value'=>'CR4'],
                    ['label'=>'GPA4', 'value'=>'GPA4'],
                    ['label'=>'CR5', 'value'=>'CR5'],
                    ['label'=>'GPA5', 'value'=>'GPA5'],
                    ['label'=>'CR6', 'value'=>'CR6'],
                    ['label'=>'GPA6', 'value'=>'GPA6'],
                    ['label'=>'FGPA', 'value'=>'FGPA'],
                ],
            ]);
        
        } 

    ?>

    <h4 align="center">RECORDS WITH ISSUES</h4>
<?php 
        if($issuesProvider->models){
            echo '<b>WITH ISSUES </b>';
            echo GridView::widget([
                'dataProvider' => $issuesProvider,
                'layout'=> "{items}",
                'emptyCell'=>'',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>' ',
                        'format'=>'raw',
                        'attribute'=>'Index_No',
                        'value'=>function($data){
                            return Html::a(Html::encode($data['Index_No']),['/gradebook/viewx','id'=>$data['Index_No']]);
                        },
                    ],
                    ['label'=>' ', 'value'=>'Name'],
                    ['label'=>'CR1', 'value'=>'CR1'],
                    ['label'=>'GPA1', 'value'=>'GPA1'],
                    ['label'=>'CR2', 'value'=>'CR2'],
                    ['label'=>'GPA2', 'value'=>'GPA2'],
                    ['label'=>'CR3', 'value'=>'CR3'],
                    ['label'=>'GPA3', 'value'=>'GPA3'],
                    ['label'=>'CR4', 'value'=>'CR4'],
                    ['label'=>'GPA4', 'value'=>'GPA4'],
                    ['label'=>'CR5', 'value'=>'CR5'],
                    ['label'=>'GPA5', 'value'=>'GPA5'],
                    ['label'=>'CR6', 'value'=>'CR6'],
                    ['label'=>'GPA6', 'value'=>'GPA6'],
                    ['label'=>'FGPA', 'value'=>'FGPA'],
                ],
            ]);
        
        } 

    ?>
</div>
