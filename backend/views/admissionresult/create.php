<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Admissionresult */

$this->title = 'New admission result';
$this->params['breadcrumbs'][] = ['label' => 'Admission result', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admissionresult-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
