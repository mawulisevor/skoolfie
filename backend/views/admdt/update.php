<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Admdt */

$this->title = 'Update Admission Results: ' . ' ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Admission Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->INDEX_NO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admission-results-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
