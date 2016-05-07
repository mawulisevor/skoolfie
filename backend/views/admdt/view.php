<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Admdt */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Admission Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-results-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->INDEX_NO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->INDEX_NO], [
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
            'INDEX_NO',
            'NAME',
            'ENTRANCE_CERT',
            'AWARDING_INSTITUTION',
            'CERTIFICATE_NO',
            'QUALIFICATION_INDEX_NO',
            'CLASS',
            'ENGLISH_LANGUAGE',
            'MATHEMATICS',
            'INTEGRATED_SCIENCE',
            'SOCIAL_STUDIES',
            'PHYSICS',
            'CHEMISTRY',
            'BIOLOGY',
            'ELECTIVE_MATHEMATICS',
            'GENERAL_AGRICULTURE',
            'CROP_HUSBANDRY',
            'ANIMAL_HUSBANDRY',
        ],
    ]) ?>

</div>
