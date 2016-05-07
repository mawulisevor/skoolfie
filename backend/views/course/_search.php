<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'courseid') ?>

    <?= $form->field($model, 'coursename') ?>

    <?= $form->field($model, 'coursecredit') ?>

    <?= $form->field($model, 'aclevel') ?>

    <?= $form->field($model, 'semester') ?>

    <?php // echo $form->field($model, 'deptid') ?>

    <?php // echo $form->field($model, 'progid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
