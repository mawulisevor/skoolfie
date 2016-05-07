<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Academicyear */

$this->title = $model->acyear;
$this->params['breadcrumbs'][] = ['label' => 'Academic years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academicyear-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->acyear], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->acyear], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'acyear',
            'description',
            'startdate',
            'enddate',
        ],
    ]) ?>

</div>
