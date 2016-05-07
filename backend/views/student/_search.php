<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'studid') ?>

    <?= $form->field($model, 'lname') ?>

    <?= $form->field($model, 'fname') ?>

    <?= $form->field($model, 'oname') ?>

    <?= $form->field($model, 'progid') ?>

    <?php // echo $form->field($model, 'currentlevel') ?>

    <?php // echo $form->field($model, 'admissionlevel') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'pobox') ?>

    <?php // echo $form->field($model, 'admdate') ?>

    <?php // echo $form->field($model, 'birthdate') ?>

    <?php // echo $form->field($model, 'gradgroup') ?>

    <?php // echo $form->field($model, 'semsdone') ?>

    <?php // echo $form->field($model, 'totalgp') ?>

    <?php // echo $form->field($model, 'totalcredit') ?>

    <?php // echo $form->field($model, 'cgpa') ?>

    <?php // echo $form->field($model, 'certclass') ?>

    <?php // echo $form->field($model, 'picture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
