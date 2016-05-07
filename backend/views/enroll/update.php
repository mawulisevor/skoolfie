<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Enroll */

$this->title = 'Update Enroll: ' . ' ' . $model->studid;
$this->params['breadcrumbs'][] = ['label' => 'Enrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->studid, 'url' => ['view', 'studid' => $model->studid, 'courseid' => $model->courseid, 'resit' => $model->resit]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="enroll-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
