<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

   
    <h3> Your registration will only be successful if you provide the correct index number, email address, phone number, first name, last name, and date of birth that the academic office has in its records. Please check with the academic office if you encounter any problems. </h3>
    <p>Please fill out the following fields to register:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput()->hint('Please enter your index number')->label('Student ID') ?>

                <?= $form->field($model, 'email')->input('email')->label('Email Address') ?>

                <?= $form->field($model, 'phone')->input('phone')->label('Phone No.')->hint('Example: 0208355088') ?>

                <?= $form->field($model, 'pobox')->label('Postal Address') ?>
            
                <?= $form->field($model, 'fname') ->label('First Name') ?>
            
                <?= $form->field($model, 'lname') ->label('Last Name / Surname / Family Name') ?>
                
                <?= $form->field($model, 'birthdate')->input('date')->label('Date of Birth')->hint('Date Format: Year-Month-Day. Example: 1900-12-31') ?>
                
                <?= $form->field($model, 'ugroup')->input('date')->label('Admission Year')->hint('Example: 2010/2011') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
