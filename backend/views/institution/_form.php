<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Institution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-form">
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'inst_shortname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inst_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inst_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inst_post_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inst_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inst_est_date')->textInput() ?>
    
    <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
