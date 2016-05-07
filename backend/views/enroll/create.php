<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Enroll */

$this->title = 'Create Enroll';
$this->params['breadcrumbs'][] = ['label' => 'Enrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enroll-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
