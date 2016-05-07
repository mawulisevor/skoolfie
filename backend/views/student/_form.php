<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Acprog;

/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'studid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'progid')->dropDownList(
        ArrayHelper::map(Acprog::find()->all(),'progid','progid'),
        ['prompt'=>'Select Program']
        ) 
    ?>

    <?= $form->field($model, 'currentlevel')->textInput() ?>

    <?= $form->field($model, 'admissionlevel')->textInput() ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pobox')->label('Postal Address') ?>
    
    <?= $form->field($model, 'admdate')->input('date') ?>
    
    <?= $form->field($model, 'birthdate')->input('date') ?>

    <?= $form->field($model, 'gradgroup')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'semsdone')->textInput() ?>

    <?= $form->field($model, 'totalgp')->textInput() ?>

    <?= $form->field($model, 'totalcredit')->textInput() ?>

    <?= $form->field($model, 'cgpa')->textInput() ?>

    <?= $form->field($model, 'certclass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
