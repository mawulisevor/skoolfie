<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results Batch Search';
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
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label'=>'Year',
                'value'=>'Year',
                'attribute'=>'Year',
            ],
            [
                'label'=>'Level',
                'value'=>'Level',
                'attribute'=>'Level',
            ],
            [
                'label'=>'Semester',
                'format'=>'raw',
                'attribute'=>'Semester',
                'value'=>function($data){
                    return Html::a(Html::encode($data['Semester'],$data['Year'],$data['Level']),['results','Year'=>$data['Year'],'Level'=>$data['Level'],'Semester'=>$data['Semester']]);
                },
            ],
            //'gradgroup',
        ],
    ]); ?>

</div>
