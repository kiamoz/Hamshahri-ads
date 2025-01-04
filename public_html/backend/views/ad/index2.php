<?php

use common\models\VatYear;
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

//foreach(\common\models\Ad::find()->where(['pay_status'=>0])->all() as $f){
//    
//    
//    if($f->cash >= ($f->in_amount - $f->benefit_price) and $f->in_amount>0 ){
//        
//        echo $f->id."<br>";
//        $f->pay_status = 1;
//        $f->save();
//        
//    }
//    
//    
//}
?>

<style>
    tr.green, tr.green td {
        background-color: #63ff0047 !important;
    }



    tr.blue, tr.blue td {
        background-color: #63ff0047 !important;
        color: #FFF !important;
    }
    tr.red, tr.red td {
        background-color: #ff000047 !important;
        color : #FFF !important;
    }
    tr.red, tr.red td a{
        color : #FFF !important;
    }
    tr.blue, tr.blue td {
        background-color: #0088cc !important;
        color: #FFF;
    }
    tr.blue a {
        color: #FFF !important;
    }
</style>
<style>

    .wrapper1{
        position: fixed;
        top: 20px;
    }
    .wrapper1, .wrapper2{width: 100%; border: none 0px RED;
                         overflow-x: scroll; overflow-y:hidden;}
    .wrapper1{height: 20px;  }
    .div1 { height: 20px; }
    .div2 { 
        overflow: auto;}
    table.kv-grid-table.table.table-bordered.table-striped.kv-table-wrap {

    }
</style>




<div class="ad-index">



    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <?php
    $url = \yii\helpers\Url::to(['/ad/list']);
    $url2 = \yii\helpers\Url::to(['/ad/listr']);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'date1',
            'format' => 'raw',
            'filterInputOptions' => [
                'class' => 'form-control example1 first_date',
                'autocomplete' => "off",
                'data-name' => 'AdSearch[date2]',
            ],
            'value' => function ($data) {
                return common\models\Persian::convert_date_to_fa($data->date_publish);
            },
            'contentOptions' => ['style' => 'min-width:110px; white-space: normal;'],
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
                //return $data->customer->name;
                return \common\models\Post::limitword($data->customer->name, 10);
                return "<a href='" . Url::to(['customer/view', 'id' => $data->customer->id]) . "'>" . \common\models\Post::limitword($data->customer->name, 10) . "<a>";
            },
        ],
        [
            'attribute' => 'resseler_id',
            'format' => 'raw',
            // 'data'=>array($searchModel->customer_id=>'sss'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'resseler_id',
                'language' => 'fa',
                'initValueText' => common\models\User::findOne($searchModel->resseler_id)->name_and_fam,
                'options' => ['placeholder' => 'نام یا کد کارگذار'],
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
                return \common\models\Post::limitword($uuu->name_and_fam, 20);
                return "<a href='" . Url::to(['user/view', 'id' => $uuu->id]) . "'>" . \common\models\Post::limitword($uuu->name_and_fam, 20) . " " . $uuu->username . "<a>";
            },
        ],
        [
            'attribute' => 'ad_type',
            'format' => 'raw',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'data' => yii\helpers\ArrayHelper::map(\common\models\AdType::find()->all(), 'id', 'name'),
                'attribute' => 'ad_type',
                'options' => ['placeholder' => 'فیلتر'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]),
            'value' => function ($data) {


                return \common\models\AdType::findOne($data->ad_type)->name; //\common\models\Ad::pay_type[$data->type_id] . $v;
            }
        ],
        [
            'header' => 'کد کارگزار',
            'value' => function ($data) {
                return $data->user->code_kargozar;
            }
        ],
        [
            'header' => 'مبلغ کل',
            'attribute' => 'total_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->total_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('total_price')),
        ],
        [
            'header' => 'تخفیفات',
            'attribute' => 'discount_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->total_price - $data->in_amount);
            },
            'footer' => number_format((int) $dataProvider->query->sum('ad.total_price')-$dataProvider->query->sum('ad.in_amount')),
        ],
        [
            'header' => 'درآمد ناخالص',
            'attribute' => 'in_amount',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->in_amount);
            },
            'footer' => number_format((int) $dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'VAT',
            'format' => 'raw',
            'value' => function ($data) {

                if ($data->vat) {

                    $vat_pric = $data->in_amount *  VatYear::vatfinder($data);
                }
                return number_format((int) $vat_pric);
            },
            'footer' => number_format((int) $dataProvider->query->sum('CASE WHEN vat = 1 THEN in_amount*.1 ELSE 0 END')),
        ],
        [
            'header' => 'مبلغ قابل واریز  با احتساب ارزش افزوده',
            'format' => 'raw',
            'value' => function ($data) {


                if ($data->vat) {

                    $vat_pric = $data->in_amount * VatYear::vatfinder($data);
                }

                return number_format((int) $data->in_amount + $vat_pric);
            },
            'footer' => number_format((int) $dataProvider->query->sum('CASE WHEN vat = 1 THEN (in_amount*.1+in_amount) ELSE in_amount END')),
        ],
        [
            'header' => 'کارمزد',
            'attribute' => 'benefit_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->benefit_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('benefit_price')),
        ],
        [
            'header' => 'خالص-رقم نهایی',
            'format' => 'raw',
            'value' => function ($data) {


                if ($data->vat) {

                    $vat_pric = $data->in_amount * VatYear::vatfinder($data);
                }

                return number_format((int) $data->in_amount - $data->benefit_price + $vat_pric);
            },
            'footer' => number_format((int) $dataProvider->query->sum('CASE WHEN vat = 1 THEN (in_amount*.1)+ (in_amount - benefit_price) ELSE (in_amount - benefit_price) END')),
        ],
        [
            'attribute' => 'naghdi_etebari',
            'format' => 'raw',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'data' => [1 => 'نقدی', 2 => 'اعتباری', 3 => 'تهاتر', 4 => 'رایگان'],
                'attribute' => 'naghdi_etebari',
                'options' => ['placeholder' => 'فیلتر'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]),
            'value' => function ($data) {

                //if ($data->naghdi_etebari == 2 and!$data->pay_status) {
                //    $v = "<a href='" . Url::to(['add_credit_payment', 'id' => $data->id]) . "' ><i class='icon-money'></i> </a>";
                //}

                return \common\models\Ad::pay_type[$data->naghdi_etebari] . $v;
            }
        ],
        'custom_id',
    ];
    ?>
    <div class="wrapper1">
        <div class="div1">
        </div>
    </div>


    <div class="wrapper2">
        <div class="div2">
            <?php
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_EXCEL => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_CSV => false,
                //ExportMenu::FORMAT_EXCEL_X => false,
                ],
                'showConfirmAlert' => FALSE,
                'messages' => [
                    'confirmDownload' => '1',
                    'downloadComplete' => 'تهیه فایل کامل شد پس از دیدن دانلود فایل میتوانید این پنجره را ببنید',
                    'downloadProgress' => '2',
                    'downloadProgress' => 'درحال آماده سازی جهت دانلود فایل لطفا این پنجره را نبندید',
                    'allowPopups' => 'ss'
                ]
            ]) . "*";

// You can choose to render your own GridView separately
            echo \kartik\grid\GridView::widget([
                'rowOptions' => function ($model, $index, $widget, $grid) {

                    if ($model->status == -10) {
                        return ['class' => 'red'];
                    }
                },
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'emptyCell' => '-',
                'showFooter' => true,
            ]);
            ?>

        </div>
    </div>
</div>

<script>

    window.onload = function () {






        $(document).ready(function () {
            $(function () {
                console.log("X" + $(".div1").css('width'));
                $(".div1,.div2").css('width', $(".table.kv-grid-table").css('width'));



                $(".wrapper1").scroll(function () {
                    console.log($(".wrapper1").scrollLeft());
                    $(".wrapper2")
                            .scrollLeft($(".wrapper1").scrollLeft());
                });
                $(".wrapper2").scroll(function () {
                    $(".wrapper1")
                            .scrollLeft($(".wrapper2").scrollLeft());
                });
            });
        });

    };


</script>
