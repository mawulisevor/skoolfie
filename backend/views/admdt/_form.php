<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Student;

/* @var $this yii\web\View */
/* @var $model backend\models\Admdt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admdt-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'INDEX_NO')->dropDownList(
            ArrayHelper::map(Student::find()->all(),'studid','studid'),
            ['prompt'=>'Select INDEX_NO']
        ) 
    ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ENTRANCE_CERT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AWARDING_INSTITUTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERTIFICATE_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUALIFICATION_INDEX_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CLASS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ENGLISH_LANGUAGE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MATHEMATICS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INTEGRATED_SCIENCE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SOCIAL_STUDIES')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PHYSICS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CHEMISTRY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BIOLOGY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ELECTIVE_MATHEMATICS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GENERAL_AGRICULTURE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CROP_HUSBANDRY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ANIMAL_HUSBANDRY')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
