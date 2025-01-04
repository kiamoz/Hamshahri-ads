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
            'header' => 'کد مشتری',
            'value' => function ($data) {

                return $data->customer->id;
            }
        ],
        [
            'header' => 'نوع',
            'value' => function ($data) {

                return common\models\Customer::customer_type[$data->customer->type];
            }
        ],
        [
            'header' => 'باطله',
            'value' => function ($data) {

                if ($data->status == -10)
                    return 'باطله';
            }
        ],
        'custom_id',
        [
            'header' => 'تاریخ صدور فاکتور',
            'format' => 'raw',
            'value' => function ($data) {
                return common\models\Persian::convert_date_to_fa($data->date);
            },
        ],
        [
            'header' => 'کد کارگزار',
            'format' => 'raw',
            'value' => function ($data) {

                return $data->user->code_kargozar;
            }
        ],
        [
            'header' => 'نام کارگزار',
            'format' => 'raw',
            'value' => function ($data) {

                return $data->user->name_and_fam;
            }
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
            'attribute' => 'ad_type',
            'value' => function ($data) {


                return \common\models\AdType::findOne($data->ad_type)->name; //\common\models\Ad::pay_type[$data->type_id] . $v;
            }
        ],
        [
            'attribute' => 'customer_id',
            'format' => 'raw',
            // 'data'=>array($searchModel->customer_id=>'sss'),
            'value' => function ($data) {
                //return $data->customer->name;
                return \common\models\Post::limitword($data->customer->name, 10);
                return "<a href='" . Url::to(['customer/view', 'id' => $data->customer->id]) . "'>" . \common\models\Post::limitword($data->customer->name, 10) . "<a>";
            },
        ],
        [
            'header' => 'کد اقتصادی',
            'value' => function ($data) {
                return $data->customer->economical_code;
            }
        ],
        [
            'header' => 'شناسه ملی ',
            'value' => function ($data) {
                return $data->customer->social_code;
            }
        ],
        [
            'header' => 'استان',
            'value' => function ($data) {
                return $data->customer->s->name;
            }
        ],
        [
            'header' => 'شهر',
            'value' => function ($data) {
                return $data->customer->city0->name;
            }
        ],
                [
            'header' => 'کد پستی',
            'value' => function ($data) {
                return $data->customer->postal_code;
            }
        ],
        [
            'header' => 'شهرستان',
            'value' => function ($data) {
                // return $data->customer->s->name;
            }
        ],
        
        [
            'header' => 'آدرس',
            'value' => function ($data) {
                return $data->customer->addres;
            }
        ],
        [
            'header' => 'تلفن',
            'value' => function ($data) {
                return $data->customer->phone;
            }
        ],
        [
            'header' => ' صفحه',
            'value' => function ($data) {
                return $data->box->name;
            }
        ],
        [
            'header' => ' نوبت',
            'value' => function ($data) {
                return $data->pub_qty;
            }
        ],
        [
            'header' => 'تاریخ انتشار آگهی',
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
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->title;
                return "<a href='" . Url::to(['ad/view', 'id' => $data->id]) . "'>" . $data->title . "<a>";
            }
        ],
        [
            'attribute' => 'شرح تخفیف ۱ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->limit(1)->One()->discount->name);
            },
        ],
        [
            'attribute' => 'شرح تخفیف ۲ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->limit(1)->offset(1)->One()->discount->name);
            },
        ],
        [
            'attribute' => 'شرح تخفیف ۳ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->limit(1)->offset(2)->One()->discount->name);
            },
        ],
        [
            'attribute' => 'شرح تخفیف ۴ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is', 'is_benefit', null])->limit(1)->offset(3)->One()->discount->name);
            },
        ],
        [
            'attribute' => 'شرح کارمزد ۱ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is_benefit' => 1])->limit(1)->One()->discount->name);
            },
        ],
        [
            'attribute' => 'شرح کارمزد ۲ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is_benefit' => 1])->limit(1)->offset(1)->One()->discount->name);
            },
        ],
        [
            'attribute' => 'شرح کارمزد ۳ ',
            'format' => 'raw',
            'value' => function ($data) {

                return (\common\models\AdHasDiscount::find()->where(['ad_id' => $data->id])->andWhere(['is_benefit' => 1])->limit(1)->offset(2)->One()->discount->name);
            },
        ],
        [
            'header' => 'تعداد کادر',
            'value' => function ($data) {
                return $data->box_qty;
            }
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
            'header' => 'مبلغ کل',
            'attribute' => 'total_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->total_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('total_price')),
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
            'footer' => number_format((int) $dataProvider->query->sum('CASE WHEN vat = 1 THEN (in_amount*.1+in_amount) ELSE in_amount END')),
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
            'header' => 'تخفیفات',
            'attribute' => 'discount_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->total_price - $data->in_amount);
            },
            'footer' => number_format((int) $dataProvider->query->sum('ad.total_price')-$dataProvider->query->sum('ad.in_amount')),
        ],
        [
            'header' => 'هزنیه طراحی'
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
            'header' => 'جمع کارمزد ها',
            'attribute' => 'benefit_price',
            'format' => 'raw',
            'value' => function ($data) {


                return number_format((int) $data->benefit_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('benefit_price')),
        ],
        [
            'header' => 'رقم نهایی (خالص)',
            'format' => 'raw',
            'value' => function ($data) {



                return number_format((int) $data->in_amount - $data->benefit_price);
            },
            'footer' => number_format((int) $dataProvider->query->sum('in_amount - benefit_price')),
        ],
        [
            'header' => 'توضیحات'
        ],
        [
            'header' => 'نوع تسویه',
            'format' => 'raw',
            'value' => function ($data) {



                return \common\models\Ad::pay_type[$data->naghdi_etebari];
            }
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
