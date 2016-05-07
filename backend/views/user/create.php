<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Create Admin User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3>Please do not use this interface to create or add normal users like students. Students should register through the main AIMS website. Thank you.</h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
