<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'AIMS Admin Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <h3>Roles for existing administration users can be upgraded or downgraded. The least role is 'site-viewer', next is 'site-clerk' and the highest is 'site-admin'. Please assign roles carefully to enhance security.</h3>
    <h3>Kindly remember that, a user must first be assigned a role = 20 as a user before they can log into AIMS administration website. This means that even if a user is assigned the role of 'site-admin' but not assigned a user role of 20, the user cannot access the administration website. </h3>
    <h3>Please do well not to allow students access to AIMS administration website.</h3>
    <p>
        <?= Html::a('Assign Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
            [
                'label'=>'User ID',
                'attribute'=>'user_id'
            ],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
