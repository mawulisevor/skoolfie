<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <h4> To enable user to log into AIMS admin website, set role = 20.
        To prevent user from logging into AIMS admin website, set role = 10. <br />
        To prevent a student from viewing results, set status = 0.
        To enable a student to view results, set status = 10. <br />
    </h4>
    <p>
        <?= Html::a('Create New Admin User', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete User Group', ['usergp'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('AIMS Admin Roles', ['auth-assignment/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Username',
                'format'=>'raw',
                'attribute'=>'username',
            ],

            //'fname',
            'lname',
            'birthdate',
            'role',
            'status',
            [
                'label'=>'User Group',
                'attribute'=>'ugroup'
            ],
            //'ugroup',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
