<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('New Student', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload New Students', ['upload'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Students Update', ['uploadupdate'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Biodata Export', ['dipadmgroups'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Assessments', ['enroll/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Gradebook', ['gradebook/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Admission Results', ['/admdt/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showHeader' => true,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'OAC Students'],
        //'showFooter'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'studid',
            [
                'label'=>'Index_No',
                'format'=>'raw',
                'attribute'=>'studid',
                'value'=>function($data){
                    return Html::a(Html::encode($data['studid']),['/gradebook/viewx','id'=>$data['studid']]);
                },
            ],
            'lname',
            'fname',
            'oname',
            'progid',
            //'currentlevel',
            //'admissionlevel',
            'sex',
            'phone',
            'email:email',
            // 'admdate',
            // 'birthdate',
            'gradgroup',
            // 'semsdone',
            // 'totalgp',
            // 'totalcredit',
            // 'cgpa',
            // 'certclass',
            // 'picture',
                [   
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Action', 
                    'headerOptions' => ['width' => '80'],
                    'template' => '{view} {update} {delete}{link}',
                ],
        ],
    ]); ?>

</div>
