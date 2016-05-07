<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdmdtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admission Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-results-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Results', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Bulk Results CSV', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=> "{items}",
        'summary'=>'',
        'showPageSummary'=> false,
        'pjax'=> true,
        'panel'=>['type'=>'primary', 'heading'=>'Admission Results Export'],
        'showFooter'=> false,
        'showHeader' => true,
        'showOnEmpty'=>false,
        'emptyCell'=>'-',
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
            
    ]); ?>

</div>
