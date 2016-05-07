<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\DataColumn;


/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results Slip';
// $this->params['breadcrumbs'][] = $this->title;
//$items=$dataProvider;
$dataProvider->models;
?>
<div class="results-slip">
    <p>
        <?= Html::a('Students', ['/student/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'=>$searchModel,
        'layout'=> "{items}",
        'summary'=>'',
        'showPageSummary'=> true,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'Student Name and index number'],
        'showFooter'=>true,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
        'columns' => [
            ['class'=>'kartik\grid\SerialColumn'],
            [
                'attribute'=>'Ac_Level',
                'width'=>'50px',
                'value'=> 'Ac_Level',
                /* 'CGPA: '.$gpa1Provider->getModels()['0']['GPA'],
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(Gradebook::find()->orderBy('Ac_Level')->asArray()->all(), 'id', 'Ac_Level'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    ],
                'filterInputOptions'=>['placeholder'=>'Any supplier'],
                */
                //'group'=>true, // enable grouping,
                //'groupedRow'=>true, // move grouped column to a single grouped row
                //'groupOddCssClass'=>'kv-grouped-row', // configure odd group cell css class
                //'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'attribute'=>'Year',
                'label'=>'Ac Year',
                //'width'=>'250px',
                'value'=>'Year',
                //'filterType'=>GridView::FILTER_SELECT2,
                //'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'),
                //'filterWidgetOptions'=>[
                //'pluginOptions'=>['allowClear'=>true],],
                //'filterInputOptions'=>['placeholder'=>'Any category'],
                //'group'=>true, // enable grouping
                //'subGroupOf'=>1, // supplier column index is the parent group
            ],
            //'Name',
            //'Index_No',
                        [
                'label'=>'Semester',
                'value'=> 'Semester'
            ],

            [
                'label'=>'Code',
                'value'=> 'Course_Code'
            ],
            [
                'label'=>'Title',
                'value'=> 'Course_Title'
            ],

            [
                'attribute'=>'CA',
                'label'=>'CA',
                'width'=>'150px',
                'hAlign'=>'right',
                //'format'=>['number', 1],
                //'pageSummary'=>true
            ],
            
            [
                'attribute'=>'Exam',
                'width'=>'150px',
                'hAlign'=>'right',
                //'format'=>['number', 0],
                //'pageSummary'=>true,
            ],
            
            [
            'attribute'=>'Total',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            //'pageSummary'=>true
            ],
            
            [
            'attribute'=>'GR',
            'label'=>'GR',
            'width'=>'150px',
            'hAlign'=>'right',
            ],
            
            [
            'label'=>'CR',
            'attribute'=>'CR',
            'width'=>'150px',
            'hAlign'=>'right',
            //'format'=>['number', 0],
            'pageSummary'=>true
            ],

            [
            'attribute'=>'GP',
            'label'=>'GP',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
