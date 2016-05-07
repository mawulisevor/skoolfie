<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Student */

$this->title = 'My Settings: ' . ' ' . $model->studid;
?>
<div class="student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
