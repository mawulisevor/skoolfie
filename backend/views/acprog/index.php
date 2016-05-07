<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AcprogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Academic Setup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acprog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Manage Users', ['user/index'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Institution Details', ['institution/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('New Academic Program', ['create'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Academic Years', ['academicyear/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Departments', ['department/index'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Courses', ['course/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Admission Details Export', ['admdt/index'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'Academic Programs'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'progid',
            [
                'label'=>'Program ID',
                'format'=>'raw',
                'attribute'=>'progid',
                'value'=>function($data){
                    return Html::a(Html::encode($data['progid']),['/student/grad','progid'=>$data['progid']]);
                },
            ],
            'progname',
            'awardedby',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
