<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admissionresult */
/* @var $form ActiveForm */
//$this->title = 'Update Admissionresult: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admissionresults', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';
?>
<div class="admissionresult-upload">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput(['maxlength' => true]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admissionresult-upload -->
