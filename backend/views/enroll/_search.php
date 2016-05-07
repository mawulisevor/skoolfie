<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EnrollSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="enroll-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'studid') ?>

    <?= $form->field($model, 'courseid') ?>
    <?= $form->field($model, 'resit') ?>

    <?= $form->field($model, 'ca') ?>

    <?= $form->field($model, 'exams') ?>

    <?= $form->field($model, 'acyear') ?>

    <?php // echo $form->field($model, 'classroom') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
