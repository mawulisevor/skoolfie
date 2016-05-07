<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Acprog */

$this->title = 'Update ' . ' ' . $model->progid . ' Academic Program';
$this->params['breadcrumbs'][] = ['label' => 'Acprogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->progid, 'url' => ['view', 'id' => $model->progid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acprog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
