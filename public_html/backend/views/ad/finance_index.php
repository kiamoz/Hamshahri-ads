<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\Ad;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'آگهی';
$this->params['breadcrumbs'][] = $this->title;
?>

 <?php
//        $fid = common\models\Tagimage::find()->all();
//        foreach ($fid as $f) {
//            $ad = \common\models\Ad::find()->where(['id' => $f->ad_id])->one();
//            if (!$ad) {
//                \Yii::$app
//                        ->db
//                        ->createCommand()
//                        ->delete('tagimage', ['id' => $f->id])
//                        ->execute();
////       
//            }
//        }
        ?>

<div class="ad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    $url = \yii\helpers\Url::to(['/ad/list']);
    $url2 = \yii\helpers\Url::to(['/ad/list2']);

    $gridColumns = [
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
        [
            'header' => 'کد ملی',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->customer->social_code != 0)
                    return $data->customer->social_code;
                else
                    return 'ثبت نشده';
            }
        ],
        [
            'header' => 'آدرس',
            'format' => 'raw',
            'value' => function($data) {

                return $data->customer->addres;
            }
        ],
        [
            'header' => 'کد پستی',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->customer->postal_code != 0)
                    return $data->customer->postal_code;
                else
                    return "ثبت نشده";
            }
        ],
        [
            'header' => 'کد اقتصادی',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->customer->economical_code != 0)
                    return $data->customer->economical_code;
                else
                    return "ثبت نشده";
            }
        ],
        [
            'attribute' => 'serial',
            'format' => 'raw',
            'value' => function($data) {

                return $data->serial;
            }
        ],
        [
            'header' => 'مبلغ پس از تخفیف',
            'format' => 'raw',
            'value' => function($data) {
                $mt = $data->total_price - $data->discount_price;
                if ($mt != null)
                    return number_format($mt);
            }
        ],
        [
            'header' => 'جمع تخفیف و کارمزد',
            'format' => 'raw',
            'value' => function($data) {
                $bd = $data->benefit_price + $data->discount_price;
                if ($bd != null)
                    return number_format($bd);
            }
        ],
        [
            'attribute' => 'benefit_price',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->benefit_price)
                    if ($data->benefit_price)
                        return number_format($data->benefit_price);
            },
            'footer' => number_format(Ad::getTotal($dataProvider->models, 'benefit_price')) . "<br>" . number_format($dataProvider->query->sum('benefit_price')),
        ],
        [
            'attribute' => 'discount_price',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->discount_price)
                    return number_format($data->discount_price);
            },
            'footer' => number_format(Ad::getTotal($dataProvider->models, 'discount_price')) . "<br>" . number_format($dataProvider->query->sum('discount_price')),
        // 'footer' =>      $dataProvider->query->sum('discount_price'),
        ],
        
        // $this->datefarsi  = Persian::convert_date_to_fa($this->date);
//        'date_publish',
        [
            'attribute' => 'resseler_id',
        ],
        [
            'attribute' => 'date',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->date != '0000-00-00' and $data->date != null)
                    return common\models\Persian::convert_date_to_fa($data->date);
            }
        ],
//        'date',
        [
            'attribute' => 'title',
            'contentOptions' => ['style' => 'min-width:400px;'],
        ],
        [
            'attribute' => 'date1',
            'format' => 'raw',
            'filterInputOptions' => [
                'class' => 'form-control example1 first_date',
                'autocomplete' => "off",
                'data-name' => 'AdSearch[date2]',
            ],
            'value' => function($data) {
                return common\models\Persian::convert_date_to_fa($data->date_publish);
            },
            'contentOptions' => ['style' => 'min-width:300px; white-space: normal;'],
        ],
        // ['class' => 'yii\grid\ActionColumn'],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}  {delete} {view} ',
            'buttons' => [
               
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
                        return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                }
            ],
        ],
    ];

// Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            //ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_EXCEL_X => false,
            'CSV' => false,
            'HTML' => false,
            'PDF' => false,
        ],
        'showConfirmAlert' => FALSE,
        'messages' => [
            'confirmDownload' => '1',
            'downloadComplete' => 'تهیه فایل کامل شد پس از دیدن دانلود فایل میتوانید این پنجره را ببنید',
            'downloadProgress' => '2',
            'downloadProgress' => 'درحال آماده سازی جهت دانلود فایل لطفا این پنجره را نبندید',
            'allowPopups' => 'ss'
        ]
    ]);

// You can choose to render your own GridView separately
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => $gridColumns,
        'emptyCell' => '-',
    ]);
    ?>
</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#adsearch-date1").persianDatepicker({
 calendar:{
        persian: {
            leapYearMode: 'astronomical'
        }
    },
            initialValue: false,
            initialValueType: "persian",
            calendarType: "persian",
            format: 'YYYY/MM/DD',
            persianDigit: false,
              autoClose: true,
            // minDate: new persianDate().valueOf(),
        }
        );
    });

</script>