<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AcademicyearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Academic Calendar';
?>
<div class="academicyear-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Academic Setup', ['acprog/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('New School Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'acyear',
            'description',
            'startdate',
            'enddate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
