<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\data\ArrayDataProvider;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results Export';
$results = json_encode($dataProvider);

$provider = new ArrayDataProvider([
    'allModels' => $dataProvider,
    'pagination' => [
        'pageSize' => -1,
    ],
    'key' => 'Index_No',
    'sort' => [
        'attributes' => ['Index_No'],
    ],
]);

?>
<div class="results-export">
    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('New Export', ['/result/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $provider,
        //'filterModel'=>$searchModel,
        'layout'=> "{items}",
        'summary'=>'',
        'showPageSummary'=> false,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'Semester Results'],
        'showFooter'=> false,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
    ]); ?>

</div>