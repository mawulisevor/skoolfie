<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdmissionresultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admission Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admissionresult-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('New Admission Result', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Bulk Admission Results', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'studid',
            'cert',
            'institution',
            //'certno',
            //'indexno',
            // 'certclass',
            'subject',
            'grade',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
