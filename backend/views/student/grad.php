<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Graduation Groups';

$dataProvider->pagination->pageParam = 'data-page';
$dataProvider->sort->sortParam = 'data-sort';

$prognameProvider->pagination->pageParam = 'progname-page';
$prognameProvider->sort->sortParam = 'progname-sort';


?>
<div class="Graduation-groups">
    <p>
        <?= Html::a('Students', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Gradebook', ['gradebook/index'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
    if($prognameProvider->models){
        echo '<h1>'. Html::encode($prognameProvider->getModels()['0']['progname']).'</h1>';
    }else{
        echo '<h1>No student records found for this program.</h1>';
    }
    if ($dataProvider->models) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label'=>'Graduations',
                    'format'=>'raw',
                    'attribute'=>'gradgroup',
                    'value'=>function($data){
                        return Html::a(Html::encode($data['gradgroup']),['/graduation/broadsheet','id'=>$data['gradgroup'],'pid'=>$data['progid']]);
                    },
                ],
                [
                    'label'=>'Export Biodata',
                    'format'=>'raw',
                    'attribute'=>'gradgroup',
                    'value'=>function($data){
                        return Html::a(Html::encode($data['gradgroup']),['exportbio','id'=>$data['gradgroup'],'pid'=>$data['progid']]);
                    },
                ],
                
            ],
        ]); 
    }else{
        echo '<h1>No student records found for this program.</h1>';
    }
?>

</div>
