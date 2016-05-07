<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Admissionresult */

$this->title = 'Update Admissionresult: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['/student/index']];
$this->params['breadcrumbs'][] = ['label' => 'Admissionresults', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admissionresult-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
