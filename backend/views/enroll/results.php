<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;


/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results Export';
$dataProvider->models;
?>
<div class="results-export">
    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=> "{items}",
        'summary'=>'',
        'showPageSummary'=> true,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'Results Export: CSV Format'],
        'showFooter'=>true,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
        'columns' => [
            ['class'=>'kartik\grid\SerialColumn'],
            [
                'attribute'=>'Ac_Level',
                'width'=>'50px',
                'value'=> 'Ac_Level',
            ],
            [
                'attribute'=>'Year',
                'label'=>'Ac Year',
                //'width'=>'250px',
                'value'=>'Year',
            ],
            //'Name',
            //'Index_No',
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
