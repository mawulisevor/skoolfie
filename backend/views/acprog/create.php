<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Acprog */

$this->title = 'Create Program';
$this->params['breadcrumbs'][] = ['label' => 'Academic Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acprog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
