<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Academicyear */

$this->title = 'Update' . ' ' . $model->acyear . ' Academic Year ';
$this->params['breadcrumbs'][] = ['label' => 'Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->acyear, 'url' => ['view', 'id' => $model->acyear]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="academicyear-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
