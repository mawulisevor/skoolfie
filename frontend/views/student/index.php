<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Student */
/* <?= Html::a('Change Password', ['up', 'id' => $model->studid], ['class' => 'btn btn-primary']) ?> */

$this->title = $model->studid;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?> </h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->studid], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'phone',
            'email:email',
            'pobox',
        ],
    ]) ?>

</div>
