<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = $model->studid;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->studid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->studid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete the records of this student?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
        
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'picture',
                'value'=>$model->picture,
                'format'=>['image',
                           ['width'=>'60','height'=>'60']
                          ]
            ],
            'studid',
            'lname',
            'fname',
            'oname',
            'progid',
            'currentlevel',
            'admissionlevel',
            'sex',
            'phone',
            'email:email',
            'pobox',
            'admdate',
            'birthdate',
            'gradgroup',
            'semsdone',
            'totalgp',
            'totalcredit',
            'cgpa',
            'certclass',
           // 'picture',
        ],
    //     'brandLabel' => Html::img($asset->baseUrl . '/logo.png'),
    ]) ?>

</div>
