<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delete User Group';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="User-groups">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Users', ['index'], ['class' => 'btn btn-success']) ?>
    </p>
    <h3>All users in a particular group will be deleted from the system. It means they cannot access the administration or student websites. This is a powerful function which must be used cautiously. If you do not want to delete all users in a group, kindly return to the User page and delete individual user records from the system. Thank you.
    </h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label'=>'DELETE ALL GROUP MEMBERS',
                'format'=>'raw',
                'attribute'=>'ugroup',
                'value'=>function($data){
                    return  Html::a($data['ugroup'], ['rmv', 'id' =>$data['ugroup']], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete all users in '.$data['ugroup'].' group?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ],
    ]); ?>

</div>
