<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Institution */

$this->title = $model->inst_shortname. ' '.'Details';
$this->params['breadcrumbs'][] = 'Institution Details';
$this->params['breadcrumbs'][] = $model->inst_shortname;
?>
<div class="institution-view">

    <h1><?= $model->inst_shortname ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'inst_shortname',
            'inst_name',
            'inst_location',
            'inst_post_address',
            'inst_email:email',
            'inst_est_date',
            [
            'attribute'=>'logo',
            'value'=>$model->logo,
            'format'=>['image',
                       ['width'=>'60','height'=>'60']
                      ]
            ],
        ],
    ]) ?>

</div>
