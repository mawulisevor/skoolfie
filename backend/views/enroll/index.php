<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EnrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Enrollment';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enroll-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('New Enrollment/Result', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Results Batch', ['upload'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update Results Batch', ['uploadupdate'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Results Export', ['result/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showHeader' => true,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'OAC Student Assessment Results'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'studid',
            'courseid',
            'resit',
            'ca',
            'exams',
            'acyear',
            // 'classroom',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
