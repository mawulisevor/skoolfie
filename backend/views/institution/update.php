<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Institution */

$this->title = 'Update ' . ' ' . $model->inst_shortname;
$this->params['breadcrumbs'][] = ['label' => 'Institution Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
