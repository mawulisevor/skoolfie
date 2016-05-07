<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Acprog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acprog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'progid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'progname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'awardedby')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
