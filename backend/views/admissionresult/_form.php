<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admissionresult */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admissionresult-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'studid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cert')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'institution')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'certno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'certclass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
