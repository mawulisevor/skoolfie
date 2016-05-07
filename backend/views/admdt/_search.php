<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdmdtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admdt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'INDEX_NO') ?>

    <?= $form->field($model, 'NAME') ?>

    <?= $form->field($model, 'ENTRANCE_CERT') ?>

    <?= $form->field($model, 'AWARDING_INSTITUTION') ?>

    <?= $form->field($model, 'CERTIFICATE_NO') ?>

    <?php // echo $form->field($model, 'QUALIFICATION_INDEX_NO') ?>

    <?php // echo $form->field($model, 'CLASS') ?>

    <?php // echo $form->field($model, 'ENGLISH_LANGUAGE') ?>

    <?php // echo $form->field($model, 'MATHEMATICS') ?>

    <?php // echo $form->field($model, 'INTEGRATED_SCIENCE') ?>

    <?php // echo $form->field($model, 'SOCIAL_STUDIES') ?>

    <?php // echo $form->field($model, 'PHYSICS') ?>

    <?php // echo $form->field($model, 'CHEMISTRY') ?>

    <?php // echo $form->field($model, 'BIOLOGY') ?>

    <?php // echo $form->field($model, 'ELECTIVE_MATHEMATICS') ?>

    <?php // echo $form->field($model, 'GENERAL_AGRICULTURE') ?>

    <?php // echo $form->field($model, 'CROP_HUSBANDRY') ?>

    <?php // echo $form->field($model, 'ANIMAL_HUSBANDRY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
