<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Ad;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use common\models\AdMsg;
?>
<p>
    <?= Html::a('کادر جدید', ['create'], ['class' => 'btn btn-primary mr-2']) ?>
</p>
<?php
$gridColumns = [
    [
        'attribute' => 'id',
        'format' => 'raw',
        'value' => function ($data) {

            return $data->id;
        }
    ],
    [
        'header' => 'نام',
        'attribute' => 'name',
        'format' => 'raw',
        'value' => function ($data) {

            return $data->name;
        }
    ],
    [
        'header' => 'قیمت',
        'attribute' => 'price',
        'format' => 'raw',
        'value' => function ($data) {

            return number_format((int) $data->price);
        }
    ],
    [
        'header' => 'قیمت ثبتی',
        'attribute' => 'price_sabti',
        'format' => 'raw',
        'value' => function ($data) {

            return number_format((int) $data->price_sabti);
        }
    ],
    [
        'header' => 'قیمت دولتی',
        'attribute' => 'price_dolati',
        'format' => 'raw',
        'value' => function ($data) {

            return number_format((int) $data->price_dolati);
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}  {delete} {view} ',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                if (in_array(5, (array) json_decode(Yii::$app->user->identity->level_id)))
                    return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
            },
            'delete' => function ($url, $model, $key) {
                $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];
                if (in_array(6, (array) json_decode(Yii::$app->user->identity->level_id)))
                    return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
            }
        ],
    ],
];

// You can choose to render your own GridView separately
echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($data) {
        
    },
    'columns' => $gridColumns,
    'emptyCell' => '-',
]);
?>


?>