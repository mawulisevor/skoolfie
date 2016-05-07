<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InstitutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institution Details';
$this->params['breadcrumbs'][] = 'Institution Details';
?>
<div class="institution-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => 1], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'inst_shortname',
            'inst_name',
            'inst_location',
            'inst_post_address',
            'inst_email:email',
            'inst_est_date',
        ],
    ]); ?>

</div>
