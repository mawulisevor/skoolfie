<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Acprog;
use backend\models\Department;
/* @var $this yii\web\View */
/* @var $model backend\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'courseid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coursename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coursecredit')->textInput() ?>

    <?= $form->field($model, 'aclevel')->textInput() ?>

    <?= $form->field($model, 'semester')->textInput() ?>

    <?= $form->field($model, 'deptid')->dropDownList(
        ArrayHelper::map(Department::find()->all(),'deptid','deptname'),
        ['prompt'=>'Select Department']
        ) 
    ?>    

    <?= $form->field($model, 'progid')->dropDownList(
        ArrayHelper::map(Acprog::find()->all(),'progid','progid'),
        ['prompt'=>'Select Program']
        ) 
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
