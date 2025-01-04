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
        [
            'header' => '  '
        ],
        [
            'header' => '  '
        ],
        [
            'header' => '  '
        ],
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'date',
            'format' => 'raw',
            'value' => function ($data) {


                return \common\models\Persian::convert_date_to_fa($data->date);
            }
        ],
        [
            //'attribute' => 'customer_id2',
            'header' => 'کد مشتری',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->customer->id;
            }
        ],
        [
            'header' => 'کد کارگزار',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->user->code_kargozar;
            }
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
            'attribute' => 'economical_code',
            'header' => 'کد اقتصادی',
            'value' => function ($data) {
                return $data->customer->economical_code;
            }
        ],
        [
            
            'attribute' => 'social_code',
            'header' => 'شناسه ملی ',
            'value' => function ($data) {
                return $data->customer->social_code;
            }
        ],
        [
            'header' => 'شهر',
            'value' => function ($data) {
                return $data->customer->city0->name;
            }
        ],
        [
            'attribute' => 'postal_code',
            'header' => 'کد پستی',
            'value' => function ($data) {
                return $data->customer->postal_code;
            }
        ],
        [
            
            'attribute' => 'addres',
            'header' => 'آدرس',
            'value' => function ($data) {
                return $data->customer->addres;
            }
        ],
        [
            
            'attribute' => 'phone',
            'header' => 'تلفن',
            'value' => function ($data) {
                return $data->customer->phone;
            }
        ],
        [
            'attribute' => 'box_id',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'data' => yii\helpers\ArrayHelper::map(\common\models\Box::find()->all(), 'id', 'name'),
                'attribute' => 'box_id',
                'options' => ['placeholder' => 'فیلتر'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]),
            'header' => ' صفحه',
            'value' => function ($data) {
                return $data->box->name;
            }
        ],
        [
            'attribute' => 'box_qty',
            'header' => 'تعداد کادر',
            'value' => function ($data) {
                return $data->box_qty;
            }
        ],
        [
            'attribute' => 'pub_qty',
            'header' => ' نوبت',
            'value' => function ($data) {
                return $data->pub_qty;
            }
        ],
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->title;
                return "<a href='" . Url::to(['ad/view', 'id' => $data->id]) . "'>" . $data->title . "<a>";
            }
        ],
        [
            'header' => 'تخفیفات',
            'format' => 'raw',
            'attribute' => 'disc___',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'disc___',
                'data' => yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->where(['discount_item.type' => 0])->andWhere(['>', 'discount_item.discount', 0])->all(), 'id', 'name'),
                'pluginOptions' => [
                    'multiple' => true,
                    'allowClear' => true
                ],
                'options' => [
                    'placeholder' => 'فیلتر کنید',
                ],
            ]),
            'value' => function ($data) {
                $ret = '';
                foreach (common\models\AdHasDiscount::find()->innerJoinWith('discount')->where(['ad_id' => $data->id, 'discount_item.type' => 0])->all() as $disc) {
                    $ret .= "/" . \common\models\DiscountItem::findOne($disc->discount_id)->name;
                }
                return $ret;
            },
        ],
        [
            'header' => 'کارمزد ها',
            'format' => 'raw',
            'attribute' => 'benefit___',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'benefit___',
                'data' => yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->where(['discount_item.type' => 1])->all(), 'id', 'name'),
                'pluginOptions' => [
                    'multiple' => true,
                    'allowClear' => true
                ],
                'options' => [
                    'placeholder' => 'فیلتر کنید',
                ],
            ]),
            'value' => function ($data) {
                $ret = '';
                foreach (common\models\AdHasDiscount::find()->innerJoinWith('discount')->where(['ad_id' => $data->id, 'discount_item.type' => 1])->all() as $disc) {
                    $ret .= "/" . \common\models\DiscountItem::findOne($disc->discount_id)->name;
                }
                return $ret;
            },
        ],
        [
            'header' => 'وضعیت',
            'format' => 'raw',
            'attribute' => 'status',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'status',
                'data' => \common\models\Ad::status_text,
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'options' => [
                    'placeholder' => 'وضعیت',
                ],
            ]),
            'value' => function ($data) {
                return \common\models\Ad::status_text[$data->status];
            },
        ],
        [
            'attribute' => 'd1',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->limit(1)->One()->discount_price);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'd2',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->offset(1)->limit(1)->One()->discount_price);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'd3',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->offset(2)->limit(1)->One()->discount_price);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'd4',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->offset(3)->limit(1)->One()->discount_price);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'b1',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id, 'is_benefit' => 1])->limit(1)->One()->discount_rate * .01 * $data->in_amount);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'b2',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id, 'is_benefit' => 1])->offset(1)->limit(1)->One()->discount_rate * .01 * $data->in_amount);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'b3',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id, 'is_benefit' => 1])->offset(2)->limit(1)->One()->discount_rate * .01 * $data->in_amount);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'attribute' => 'b4',
            'format' => 'raw',
            'value' => function ($data) {

                return number_format(\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id, 'is_benefit' => 1])->offset(3)->limit(1)->One()->discount_rate * .01 * $data->in_amount);
            },
        //'footer' => number_format((int) $dataProvider->query->sum('box_price')),
        ],
        [
            'header' => 'مبلغ واحد',
            'attribute' => 'box_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->box_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('box_price')),
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
            'header' => 'ناخالص',
            'attribute' => 'in_amount',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->in_amount);
            },
            'footer' => number_format((int) $dataProvider->query->sum('in_amount')),
        ],
        /* [
          'header' => 'مانده',
          'format' => 'raw',
          'value' => function($data) {


          return number_format((int) $data->in_amount - $data->cash);
          },
          'footer' => number_format((int) $dataProvider->query->sum('in_amount-cash')),
          ], */
                    
                    [
            'header' => 'VAT',
            'format' => 'raw',
            'value' => function ($data) {

                //return VatYear::vatfinder($data);

                if ($data->vat) {
                    $vat_pric = $data->in_amount * VatYear::vatfinder($data);
                }
                return number_format((int) $vat_pric);
            },
            'footer' => number_format((int) $dataProvider->query->sum('vat_price')),
        ],
                    [
            'header' => 'مبلغ قابل واریز  با احتساب ارزش افزوده',
            'format' => 'raw',
            'value' => function ($data) {


                if ($data->vat) {

                    $vat_pric = $data->in_amount *  VatYear::vatfinder($data);
                }

                return number_format((int) $data->in_amount + $vat_pric);
            },
            'footer' => number_format((int) $dataProvider->query->sum('CASE WHEN vat = 1 THEN (vat_price+in_amount) ELSE in_amount END')),
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

                    $vat_pric = $data->in_amount *  VatYear::vatfinder($data);
                }

                return number_format((int) $data->in_amount - $data->benefit_price + $vat_pric);
            },
            'footer' => number_format((int) $dataProvider->query->sum('CASE WHEN vat = 1 THEN vat_price+ (in_amount - benefit_price) ELSE (in_amount - benefit_price) END')),
        ],
                    
        [
            'attribute' => 'cash',
            //'header' => 'پرداختی تا این لحظه',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->cash);
            },
            'footer' => number_format((int) $dataProvider->query->sum('cash')),
        ],
        [
            'attribute' => 'pay_status',
            'format' => 'raw',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'data' => common\models\Ad::status_request,
                'attribute' => 'pay_status',
                'options' => ['placeholder' => 'فیلتر'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]),
            'value' => function ($data) {


                return common\models\Ad::status_request[$data->pay_status];
            }
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
        //'print_count',
        'custom_id',
        'id',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}  {doc} {delete} {view}',
            'buttons' => [
                'doc' => function ($url, $model, $key) {
                    if ($model->status == 11) {
                        $options = ['target' => '_blank'];

                        $a_1 .= " " . Html::a('<i class="fa fa-print" aria-hidden="true"></i>', Url::to(['ad/view1', 'id' => $model->id, 'invoice' => 1]), $options);

                        return $a_1;
                    }
                },
                'update' => function ($url, $model, $key) {
                    if (in_array(24, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-pencil"></i>', 'https://hamshahriads.ir/site/new_order?id=' . $model->id, $options);
                },
                'view' => function ($url, $model, $key) {
                    if (in_array(106, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-eye"></i>', Url::to(['view', 'id' => $model->id]), $options);
                },
                'delete' => function ($url, $model, $key) {

                    $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];
                    if (in_array(25, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                }
            ],
        ],
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
