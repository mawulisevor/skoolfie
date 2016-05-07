<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BIODATA EXPORT';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="Results-Search">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Students', ['student/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Assessment', ['enroll/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Gradebook', ['gradebook/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $bioProvider,
        'layout'=> "{items}",
        'summary'=>'',
        'showPageSummary'=> false,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>$_GET['id'].' BIODATA EXPORT'],
        'showFooter'=> false,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
    ]); ?>

</div>
