<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Graduation-groups';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="Graduation-groups">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Students', ['index'], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Results', ['enroll/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Gradebook', ['gradebook/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'emptyCell'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'Index_No',
            'Name',
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
    ]); ?>

</div>
