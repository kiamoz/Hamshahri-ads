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




    $ad_q = Ad::find();
    foreach ((array) Yii::$app->request->queryParams['AdSearch'] as $key => $param) {

        $ad_q->andFilterWhere([$key => $param]);
    }

    $ad_q1 = clone $ad_q;
    $ad_q2 = clone $ad_q;
    $ad_q3 = clone $ad_q;
    $ad_q4 = clone $ad_q;
    $ad_q5 = clone $ad_q;
    $ad_q6 = clone $ad_q;









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
                return "<a href='" . Url::to(['user/view', 'id' => $data->user->id]) . "'>" . $data->user->name_and_fam . " <i class='icon-share-alt'></i> <a>";
            },
        ],
        [
            'header' => 'هزینه آگهی',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(total_price) as sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->select('sum(total_price) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'تخفیفات مشتری',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(discount_price) as sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->select('sum(discount_price) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'مبلغ واریزی (ناخالص)',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(in_amount) as sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->select('sum(in_amount) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'کارمزد',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(benefit_price) as sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->select('sum(benefit_price) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'خالص',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(in_amount)-sum(benefit_price) as sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->select('sum(in_amount)-sum(benefit_price) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'واریزی کارگزار',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(cash) as sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->select('sum(cash) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'مانده نقدی',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id, 'naghdi_etebari' => 1])->select('sum(in_amount)-sum(cash) AS sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->andWhere(['naghdi_etebari' => 1])->select('sum(in_amount)-sum(cash) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'مانده اعتباری',
            'format' => 'raw',
            'value' => function($data) {
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id, 'naghdi_etebari' => 2])->select('sum(in_amount)-sum(cash) AS sum_remaind_1')->One()->sum_remaind_1);
            },
            'footer' => number_format($ad_q1->andWhere(['naghdi_etebari' => 2])->select('sum(in_amount)-sum(cash) AS sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'کارمزد   قابل پرداخت',
            'format' => 'raw',
            'value' => function($data) {
                //echo Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(benefit_price)-sum(benefit_paid) as sum_remaind_1')->createCommand()->getRawSql();
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['pay_status' => 1])->select('sum(benefit_price)-sum(benefit_paid) as sum_remaind_2')->One()->sum_remaind_2);
            },
            'footer' => number_format($ad_q5->andWhere(['pay_status' => 1])->select('sum(benefit_price)-sum(benefit_paid) as sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'کارمزد  مسدود نشده',
            'format' => 'raw',
            'value' => function($data) {
                //echo Ad::find()->where(['resseler_id' => $data->resseler_id])->select('sum(benefit_price)-sum(benefit_paid) as sum_remaind_1')->createCommand()->getRawSql();
                return number_format(Ad::find()->where(['resseler_id' => $data->resseler_id])->andWhere(['is', 'pay_status', null])->select('sum(benefit_price)-sum(benefit_paid) as sum_remaind_2')->One()->sum_remaind_2);
            },
            'footer' => number_format($ad_q5->andWhere(['is', 'pay_status', null])->select('sum(benefit_price)-sum(benefit_paid) as sum_remaind_1')->One()->sum_remaind_1),
        ],
        [
            'header' => 'فروردین',
            'format' => 'raw',
            'value' => function($data) {

                return (Ad::report(1, $data->resseler_id));
            },
            'footer' => Ad::report(1, Yii::$app->request->queryParams['AdSearch']),
        ],
        [
            'header' => 'اردیبهشت',
            'format' => 'raw',
            'value' => function($data) {
                return (Ad::report(2, $data->resseler_id));
            },
            'footer' => Ad::report(2, Yii::$app->request->queryParams['AdSearch']),
        ],
        [
            'header' => 'خرداد',
            'format' => 'raw',
            'value' => function($data) {
                return (Ad::report(3, $data->resseler_id));
            },
            'footer' => Ad::report(3, Yii::$app->request->queryParams['AdSearch']),
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
            $benefit += $ad->benefit_price - $ad->benefit_paid;
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