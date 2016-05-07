<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\AdminUser */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'New Admin Site User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-admin-site-user">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'new-admin-site-new']); ?>

                <?= $form->field($model, 'username')->textInput()->hint('Please enter your index number')->label('User Name') ?>

                <?= $form->field($model, 'email')->input('email')->label('Email Address') ?>
            
                <?= $form->field($model, 'fname') ->label('First Name') ?>
            
                <?= $form->field($model, 'lname') ->label('Last Name / Surname / Family Name') ?>
                
                <?= $form->field($model, 'birthdate')->input('date')->label('Date of Birth')->hint('Date Format: Year-Month-Day. Example: 1900-12-31') ?>
                
                <?= $form->field($model, 'ugroup')->textInput()->label('User Group')->hint('Example: site-viewer, site-clerk, site-admin,') ?>
                
                <?= $form->field($model, 'status')->input('number')->label('User Status')->hint('Note: 10 = enabled to login and 0 = user login disabled.') ?>

                <?= $form->field($model, 'role')->input('number')->label('User Role')->hint('Note: 10 = normal user and 20 = admin site user.') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Create User', ['class' => 'btn btn-primary', 'name' => 'create-admin-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
