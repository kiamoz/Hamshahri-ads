<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'آگهی';
$this->params['breadcrumbs'][] = $this->title;



echo Html::beginForm(['ad/statusmali'], 'post');
?>
<input type="hidden" name="pager" value="<?= $_GET['page'] ?>" />
<?php
echo Html::submitButton('وصول شده', ['class' => 'btn btn-success',]);


echo GridView::widget([
    'dataProvider' => $dataProvider_r,
    'filterModel' => $searchModel_r,
    'columns' => [
        ['class' => 'yii\grid\CheckboxColumn',],
        'id',
        [
            'attribute' => 'user_id',
            'format' => 'raw',
            'value' => function($data) {
                $user_table = \common\models\User::find()->where(['id' => $data->user_id])->one();
                return $user_table->name_and_fam;
            }
        ],
        [
            'attribute' => 'benefit',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->benefit != null)
                    return number_format($data->benefit);
            }
        ],
              //  'benefit',
        [
            'attribute' => 'status',
            'format' => 'raw',
            'attribute' => 'status',
            'filter' => Select2::widget([
                'model' => $searchModel_r,
                'attribute' => 'status',
                'data' => \common\models\Ad::status_request,
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'options' => [
                    'placeholder' => 'وضعیت درخواست',
                ],
            ]),
            'value' => function($data) {
                return \common\models\Ad::status_request[$data->status];
            },
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => ' {view} {update}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="icon-eye"></i>', Url::to(['request/view', 'id' => $model->id]), $options);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="icon-pencil"></i>', Url::to(['request/update', 'id' => $model->id]), $options);
                },
            ]
        ],
//        
    ],
]);
?>       

