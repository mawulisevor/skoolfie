<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Update password';
// $this->title = 'Update password: ' . ' ' . $model->id;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_up', [
        'model' => $model,
    ]) ?>

</div>
