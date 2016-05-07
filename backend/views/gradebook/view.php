<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results Slip';
// $this->params['breadcrumbs'][] = $this->title;
//$items=$dataProvider;
$dataProvider->models;
?>
<div class="results-slip">
    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=> "{items}",
        'summary'=>'',
        'showFooter'=>true,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            //'Name',
            //'Index_No',
            [
                'label'=>'Level',
                'value'=> 'Ac_Level'
            ],
            'Year',
            'Semester',
            [
                'label'=>'Code',
                'value'=> 'Course_Code'
            ],
            [
                'label'=>'Title',
                'value'=> 'Course_Title'
            ],

            [
                'label'=>'CA',
                'value'=> 'CA'
            ],
            
            'Exam',
            'Total',
            [
                'label'=>'CR',
                'value'=> 'CR'
            ],

            [
                'label'=>'GR',
                'value'=> 'GR'
            ],

            [
                'label'=>'GP',
                'value'=> 'GP'
            ],


            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
