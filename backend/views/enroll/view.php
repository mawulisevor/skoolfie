<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Enroll */

$this->title = $model->studid;
$this->params['breadcrumbs'][] = ['label' => 'Enrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enroll-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'studid' => $model->studid, 'courseid' => $model->courseid, 'resit' => $model->resit], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'studid' => $model->studid, 'courseid' => $model->courseid, 'resit' => $model->resit], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'studid',
            'courseid',
            'resit',
            'ca',
            'exams',
            'acyear',
            'classroom',
        ],
    ]) ?>

</div>
