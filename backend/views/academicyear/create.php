<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Academicyear */

$this->title = 'New Academic Year';
$this->params['breadcrumbs'][] = ['label' => 'School Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academicyear-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
