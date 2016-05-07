<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results-Search';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="Results-Search">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Students', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Gradebook', ['gradebook/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label'=>'Graduation Group',
                'format'=>'raw',
                'attribute'=>'gradgroup',
                'value'=>function($data){
                    return Html::a(Html::encode($data['gradgroup']),['/graduation/broadsheet','id'=>$data['gradgroup']]);
                },
            ],
            //'gradgroup',
        ],
    ]); ?>

</div>
