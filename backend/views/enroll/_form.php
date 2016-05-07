<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Course;
use backend\models\Academicyear;

/* @var $this yii\web\View */
/* @var $model backend\models\Enroll */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="enroll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'studid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'courseid')->dropDownList(
            ArrayHelper::map(Course::find()->all(),'courseid','coursename'),
            ['prompt'=>'Select Course']
        ) 
    ?>
    
    <?= $form->field($model, 'resit')->textInput()->label('0= Not resit, 1 = 1st resit, 2 = 2nd resit, ...')->input('number') ?>
    
    <?= $form->field($model, 'acyear')->dropDownList(
            ArrayHelper::map(Academicyear::find()->all(),'acyear','acyear'),
            ['prompt'=>'Select Academic Year']
        ) 
    ?>

    <?= $form->field($model, 'ca')->textInput() ?>

    <?= $form->field($model, 'exams')->textInput() ?>

    <?= $form->field($model, 'classroom')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
