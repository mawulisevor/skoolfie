<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admissionresult */
/* @var $form ActiveForm */
$this->title = 'Upload Admission Results';
$this->params['breadcrumbs'][] = ['label' => 'Admission Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';
?>
<div class="admission-results-upload">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput(['maxlength' => true]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admissionresult-upload -->
