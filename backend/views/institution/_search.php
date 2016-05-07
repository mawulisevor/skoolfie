<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\InstitutionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'inst_shortname') ?>

    <?= $form->field($model, 'inst_name') ?>

    <?= $form->field($model, 'inst_location') ?>

    <?= $form->field($model, 'inst_post_address') ?>

    <?php // echo $form->field($model, 'inst_email') ?>

    <?php // echo $form->field($model, 'inst_est_date') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
