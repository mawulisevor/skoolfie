<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results Export';
echo json_decode($dataProvider);

$dataProvider->dataProvider;
?>
<div class="results-export">
    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'=>$searchModel,
        'layout'=> "{items}",
        'summary'=>'',
        'showPageSummary'=> true,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'Semester Results'],
        'showFooter'=>true,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
        'columns' => [
            ['class'=>'kartik\grid\SerialColumn'],
            [
                'attribute'=>'Index_No',
                'value'=> 'Index_No',

            ],
            'CA',
            
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>