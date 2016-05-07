<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Admdt */

$this->title = 'Add Results';
$this->params['breadcrumbs'][] = ['label' => 'Admission Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-results-add">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
