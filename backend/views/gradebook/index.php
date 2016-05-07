<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gradebook';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="gradebook-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Students', ['student/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Assessments', ['enroll/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'Name',
            'Index_No',
            'Year',
            'Ac_Level',
            'Semester',
            'Course_Code',
            'Course_Title',
            'CA',
            'Exam',
            'Total',
            'CR',
            'GR',
            'GP',
        ],
    ]); ?>

</div>
