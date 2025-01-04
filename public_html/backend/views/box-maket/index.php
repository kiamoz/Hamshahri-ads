<?php

use yii\helpers\Html;
use yii\grid\GridView;


use yii\widgets\DetailView;
use common\models\Ad;
use common\models\User;

use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use common\models\AdMsg;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BoxMaketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Box Makets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-maket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('ایجاد صفحه', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
$gridColumns = [
    [
        'attribute' => 'id',
        'format' => 'raw',
        'value' => function($data) {

            return $data->id;
        }
    ],
    
    [
        'header' => 'نام',
        'attribute' => 'name',
        'format' => 'raw',
        'value' => function($data) {

            return $data->name;
        }
    ],
    [
        'header' => 'قیمت',
        'attribute' => 'price',
        'format' => 'raw',
        'value' => function($data) {

            return number_format($data->price);
        }
    ],
    [
        'header' => 'قیمت ثبتی',
        'attribute' => 'price_sabti',
        'format' => 'raw',
        'value' => function($data) {

            return number_format($data->price_sabti);
        }
    ],
            
    [
        'header' => 'قیمت نفتی',
        'attribute' => 'price_nafti',
        'format' => 'raw',
        'value' => function($data) {

          return number_format($data->price_nafti);
        }
    ],
    [
        'header' => 'قیمت دولتی',
        'attribute' => 'price_dolati',
        'format' => 'raw',
        'value' => function($data) {

             return number_format($data->price_dolati);
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}  {delete} {view} {maket}',
        'buttons' => [
            'update' => function ($url, $model, $key) {

                return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
            },
            'delete' => function ($url, $model, $key) {
                $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];

                return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
            }
        ],
    ],
];



// You can choose to render your own GridView separately
echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider_b,
    'filterModel' => $searchModel_b,
    'rowOptions' => function ($data) {
        
    },
    'columns' => $gridColumns,
    'emptyCell' => '-',
]);
?>

</div>
