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
?>

<style>
    table.kv-grid-table.table.table-bordered.table-striped.kv-table-wrap tr td
</style>

<div class="ad-index">
    <?php // print_r($_GET['AdSearch']['status']) . "**"; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    $url = \yii\helpers\Url::to(['/ad/list']);
    $url2 = \yii\helpers\Url::to(['/ad/list2']);
    $gridColumns = [
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($data) {

                return $data->id;
            }
        ],
        [
            'attribute' => 'customer_id',
            'format' => 'raw',
            // 'data'=>array($searchModel->customer_id=>'sss'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'customer_id',
                'language' => 'fa',
                'initValueText' => common\models\Customer::findOne($searchModel->customer_id)->name,
                'options' => ['placeholder' => 'نام مشتری'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'لطفا صبر کنید . . . '; }"),
                    ],
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]),
            'value' => function ($data) {
                return $data->customer->name;
            },
        ],
        'title',
        [
            'attribute' => 'resseler_id',
            'format' => 'raw',
            // 'data'=>array($searchModel->customer_id=>'sss'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'resseler_id',
                'language' => 'fa',
                'initValueText' => common\models\User::findOne($searchModel->resseler_id)->name_and_fam,
                'options' => ['placeholder' => 'نام کارگذار'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'لطفا صبر کنید . . . '; }"),
                    ],
                    'ajax' => [
                        'url' => $url2,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]),
            'value' => function ($data) {
                $uuu = common\models\User::find()->where(['id' => $data->resseler_id])->one();
                return $uuu->name_and_fam;
            },
        ],
        [
            'attribute' => 'in_amount',
            'value' => function ($data) {

                return number_format((int) $data->in_amount);
            },
            'footer' => number_format((int) $dataProvider->query->sum('in_amount')),
        ],
        [
            'attribute' => 'benefit_price',
            'value' => function ($data) {

                return number_format((int) $data->benefit_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('benefit_price')),
        ],
        [
            'attribute' => 'benefit',
            'value' => function ($data) {

                return number_format((int) $data->benefit);
            },
            'footer' => number_format((int) $dataProvider->query->sum('benefit')),
        ],
        [
            'header' => 'وضعیت',
            'format' => 'raw',
            'attribute' => 'status',
            'contentOptions' => ['style' => 'background-color:' . \common\models\Ad::status_color[$model->status]],
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'status',
                'data' => \common\models\Ad::status_text,
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'options' => [
                    'placeholder' => 'وضعیت آگهی',
                ],
            ]),
            'value' => function ($data) {
                return \common\models\Ad::status_text[$data->status];
            },
        ],
        [
            'attribute' => 'date_publish',
            'format' => 'raw',
            'value' => function ($data) {

                //return $data->date_publish

                if ($data->date_publish != '0000-00-00 00:00:00' and $data->date_publish != null)
                    return common\models\Persian::convert_date_to_fa($data->date_publish);
            }
        ],
        [
            'attribute' => 'date',
            'format' => 'raw',
            'value' => function ($data) {

                if ($data->date != '0000-00-00')
                    return common\models\Persian::convert_date_to_fa($data->date);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}  {delete} {view} {maket}  {doc} {doc1} {doc2}',
            'buttons' => [
                'doc' => function ($url, $model, $key) {
//                    if (in_array(29, (array) json_decode(Yii::$app->user->identity->level_id))) {
                    if ($_GET['AdSearch']['status'] == 11) {

                        return Html::a('<i class="icon-doc"></i>', Url::to(['view1', 'id' => $model->id]), $options);
                    }
                },
                'doc1' => function ($url, $model, $key) {
//                    if (in_array(29, (array) json_decode(Yii::$app->user->identity->level_id))) {
                    if ($_GET['AdSearch']['status'] == 11) {

                        return Html::a('<i class="icon-doc"></i>', Url::to(['view1', 'id' => $model->id, 'type' => 2]), $options);
                    }
                },
                'doc2' => function ($url, $model, $key) {
//                    if (in_array(29, (array) json_decode(Yii::$app->user->identity->level_id))) {
                    if ($_GET['AdSearch']['status'] == 11) {

                        return Html::a('<i class="icon-doc"></i>', Url::to(['view1', 'id' => $model->id, 'type' => 2]), $options);
                    }
                },
                'maket' => function ($url, $model, $key) {
                    return Html::a('<i class="icon-calendar"></i>', Url::to(['maket/view', 'date_publish' => $model->date_publish, 'box_id' => $model->box_id]), $options);
                },
                'update' => function ($url, $model, $key) {
                    if (in_array(24, (array) json_decode(Yii::$app->user->identity->level_id))) {
                        return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
                    }
                },
                'view' => function ($url, $model, $key) {

                    return Html::a('<i class="icon-eye"></i>', Url::to(['view', 'id' => $model->id]), $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];
                    if (in_array(25, (array) json_decode(Yii::$app->user->identity->level_id))) {
                        // return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                }
            ],
        ],
    ];

// You can choose to render your own GridView separately
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($data) {
            if ($data->pay_status) {
                return ['class' => 'green'];
            }
        },
        'columns' => $gridColumns,
        'emptyCell' => '-',
        'showFooter' => true,
    ]);
    ?>
</div>
