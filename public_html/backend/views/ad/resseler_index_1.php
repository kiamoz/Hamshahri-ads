<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\Ad;
use common\models\Persian;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'گزارشات';
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
    $url = \yii\helpers\Url::to(['/ad/listr']);



$dataProvider1 = clone $dataProvider;
$dataProvider2 = clone $dataProvider;
$dataProvider3 = clone $dataProvider;
$dataProvider4 = clone $dataProvider;
$dataProvider5 = clone $dataProvider;
$dataProvider6 = clone $dataProvider;




    $gridColumns = [
        [
            'attribute' => 'resseler_id',
            'format' => 'raw',
            // 'data'=>array($searchModel->customer_id=>'sss'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'resseler_id',
                'language' => 'fa',
                'initValueText' => common\models\User::findOne($searchModel->resseler_id)->name_and_fam,
                'options' => ['placeholder' => 'نام کارگزار'],
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
                return $data->user->name_and_fam;
            },
        ],
        [
            'header' => 'مانده پس از كسر 
صورت حساب سازماني',
            'format' => 'raw',
            'value' => function($data) {



                $ad_naghdi = Ad::find()->where(['resseler_id' => $data->resseler_id, 'naghdi_etebari' => 1])->all();
                $in_naghdi = 0;
                foreach ($ad_naghdi as $naghdi) {
                    $in_naghdi += $naghdi->in_amount;
                }
                return number_format($in_naghdi);
            },
            'footer' => number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'صورت حساب سازماني',
            'format' => 'raw',
            'value' => function($data) {
                $ad_etebari = Ad::find()->where(['resseler_id' => $data->resseler_id, 'naghdi_etebari' => 2])->all();
                $in_etebari = 0;
                foreach ($ad_etebari as $etebari) {
                    $in_etebari += $etebari->in_amount;
                }
                return number_format($in_etebari);
            },
            'footer' => number_format($dataProvider1->query->where([ 'naghdi_etebari' => 2])->sum('in_amount')) . "<br>" . number_format($dataProvider1->query->sum('in_amount')),
        ],
        [
            'header' => 'مانده با احتساب
صورت حساب سازماني',
            'format' => 'raw',
            'value' => function($data) {
                $ad_etebari_naghdi = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['is not', 'naghdi_etebari', null])->all();
                $in_both = 0;
                foreach ($ad_etebari_naghdi as $etebarii) {
                    $in_both += $etebarii->in_amount;
                }
                return number_format($in_both);
            },
            'footer' =>  "<br>" . number_format($dataProvider1->query->sum('in_amount')),
        ],
        [
            'header' => 'مانده طلب کارمزد',
            'format' => 'raw',
            'value' => function($data) {
                $ad_benefit = Ad::find()->where(['resseler_id' => $data->resseler_id])->all();
                $s = 0;
                foreach ($ad_benefit as $a_benefit) {
                    $s_benefit += $a_benefit->benefit_price;
                }
                return number_format($s_benefit);
            },
            'footer' =>   "<br>" . number_format($dataProvider->query->where(['>','id',0])->sum('benefit_price')),
        ],
        [
            'header' => 'آورده آگهی',
            'format' => 'raw',
            'value' => function($data) {
                $ad = Ad::find()->where(['resseler_id' => $data->resseler_id])->all();
                //return count($ad);
                $s = 0;
                foreach ($ad as $a) {
                   
                    $s += $a->in_amount;
                }
                return number_format($s);
            },
            'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'فروردین',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_farvardin = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-03-21', '2019-04-20'])->all();
//                $s_far = 0;
//                foreach ($ad_farvardin as $a) {
//                    $s_far += $a->in_amount;
//                }
                return (Ad::report(1, $data->resseler_id));
            },
            'footer' => Ad::report(1, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(1)[0], Persian::get_current_month_report(1)[1]])->sum('in_amount')),
        ],
        [
            'header' => 'اردیبهشت',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_or = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-04-21', '2019-05-21'])->all();
//                $s_or = 0;
//                foreach ($ad_or as $a) {
//                    $s_or += $a->in_amount;
//                }
                return (Ad::report(2, $data->resseler_id));
                $date = Persian::get_current_month_report($month);
            },
            'footer' => Ad::report(2, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(2)[0], Persian::get_current_month_report(2)[1]])->sum('in_amount')),
            
        ],
        [
            'header' => 'خرداد',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_khor = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-05-22', '2019-06-21'])->all();
//                $s_khor = 0;
//                foreach ($ad_khor as $a) {
//                    $s_khor += $a->in_amount;
//                }
                return (Ad::report(3, $data->resseler_id));
            },
           'footer' => Ad::report(3, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(3)[0], Persian::get_current_month_report(3)[1]])->sum('in_amount')),
        ],
        [
            'header' => 'تیر',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_tir = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-06-22', '2019-07-22'])->all();
//                $s_tir = 0;
//                foreach ($ad_tir as $a) {
//                    $s_tir += $a->in_amount;
//                }
                return (Ad::report(4, $data->resseler_id));
            },
            'footer' => Ad::report(4, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(4)[0], Persian::get_current_month_report(4)[1]])->sum('in_amount')),
        ],
        [
            'header' => 'مرداد',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_mor = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-07-23', '2019-08-22'])->all();
//                $s_mor = 0;
//                foreach ($ad_mor as $a) {
//                    $s_mor += $a->in_amount;
//                }
                return (Ad::report(5, $data->resseler_id));
            },
            'footer' => Ad::report(5, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(5)[0], Persian::get_current_month_report(5)[1]])->sum('in_amount')),
        ],
        [
            'header' => 'شهریور',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_shah = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-08-23', '2019-09-22'])->all();
//                $s_shah = 0;
//                foreach ($ad_shah as $a) {
//                    $s_shah += $a->in_amount;
//                }
                return (Ad::report(6, $data->resseler_id));
            },
            'footer' => Ad::report(6, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(6)[0], Persian::get_current_month_report(6)[1]])->sum('in_amount')),
        ],
        [
            'header' => 'مهر',
            'format' => 'raw',
            'value' => function($data) {
//                $ad_mehr = Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['between', 'date_publish', '2019-09-23', '2019-10-22'])->all();
//                $s_mehr = 0;
//                foreach ($ad_mehr as $a) {
//                    $s_mehr += $a->in_amount;
//                }
                return (Ad::report(7, $data->resseler_id));
            },
            'footer' => Ad::report(7, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(7)[0], Persian::get_current_month_report(7)[1]])->sum('in_amount')),
        ],
        [
            'header' => 'آبان',
            'format' => 'raw',
            'value' => function($data) {
//             
                return (Ad::report(8, $data->resseler_id));
            },
            'footer' => Ad::report(8, null, $dataProvider) . "<br>" . number_format($dataProvider->query->Where(['between', 'date_publish', Persian::get_current_month_report(8)[0], Persian::get_current_month_report(8)[1]])->sum('in_amount')),
        ],
                    
                    /*
        [
            'header' => 'اردیبهشت به فروردین',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(1, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(2, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        //'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'خرداد به ارديبهشت',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(2, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(3, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        //  'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'تير به خرداد',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(3, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(4, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        // 'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'مرداد به تير',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(4, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(5, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        // 'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'شهريور به مرداد',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(5, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(6, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        // 'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'مهر به شهريور',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(6, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(7, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        // 'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'آبان به مهر',
            'format' => 'raw',
            'value' => function($data) {
                $first = Ad::report(7, $data->resseler_id);
                if ($first > 0)
                    $result = (Ad::report(8, $data->resseler_id)) / ($first) - 1;
                else {
                    $result = 00.0;
                }
                return $result;
            },
        // 'footer' => number_format(Ad::getTotal($dataProvider->models, 'in_amount')) . "<br>" . number_format($dataProvider->query->sum('in_amount')),
        ],
        [
            'header' => 'مبلغ طرح تشویقی',
            'format' => 'raw',
            'value' => function($data) {

                //return number_format($s_aban);
            },
        ], */
        [
            'header' => 'مجموع واریزی',
            'format' => 'raw',
            'value' => function($data) {

                return Ad::sum(1, $data->resseler_id);
            },
            'footer' => number_format(Ad::getTotal($dataProvider->models, 'cash')) . "<br>" . number_format($dataProvider->query->sum('cash')),
        //  return number_format($s_aban);
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


    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $ad_etebari = Ad::find()->all();
            $in_amount = 0;
            $benefit = 0;
            $b = 0;
            foreach ($ad_etebari as $ad) {
                if (($ad->pay_status != 1 or $ad->cash < $ad->in_amount) and $ad->naghdi_etebari == 2) {
                    $b += ($ad->in_amount - $ad->cash);
                } elseif ($ad->pay_status != 1) {
                    $in_amount += ($ad->in_amount - $ad->cash);
                } elseif ($ad->pay_status == 1) {
                    $benefit += $ad->benefit_price;
                }
            }


//            foreach ($ad_naghdi as $cash) {
//                if ($cash->cash < $cash->in_amount or $cash->cash == null or $cash->cash == 0) {
//                    $in_amount += $cash->in_amount;
//                    $benefit += $cash->benefit_price;
//                }
//            }
            ?> 
            <tbody>
                <tr id="discount-id_17">

                    <td>بدهکاری سایر دستگاه ها</td>
                    <td><?php echo number_format($b); ?></td>
                </tr>
                <tr id="discount-id_17">
                    <td>بدهکار کارگزاران</td>
                    <td><?php echo number_format($in_amount); ?></td>
                </tr>
                <tr id="discount-id_17">
                    <td>بستانکار کارگزاران</td>
                    <td><?php echo number_format($benefit); ?></td>
                </tr>
                <tr id="discount-id_17">
                    <td>مانده کارگزاران </td>
                    <td><?php echo number_format($in_amount - $benefit); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
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