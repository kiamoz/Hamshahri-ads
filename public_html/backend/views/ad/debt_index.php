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

$this->title = 'گزارشات';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $date = date('Y-m-d'); ?> 


<div class="ad-index">

    <h1><?php echo گزارشات; ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h3 style="text-align:right !important; display:block !important;">بدهی</h3>
    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php ?>
            <?php
            $ad_type = Ad::find()->where(['is not', 'ad_type', null])->andwhere(['between', 'date_publish', '2019-03-21', '2020-03-21'])->all();
            //print_r($ad_type);
            $t_shahr = 0;
            $t_dolati = 0;
            $t_nafti = 0;
            foreach ($ad_type as $n) {
                if ($n->pay_status != 1) {
                    if ($n->ad_type == 7)
                        $t_shahr += ($n->in_amount) - ($n->cash);
                    if ($n->ad_type == 1 or $n->ad_type == 11)
                        $t_dolati += ($n->in_amount) - ($n->cash);
                    if ($n->ad_type == 2 or $n->ad_type == 13)
                        $t_nafti += ($n->in_amount) - ($n->cash);
                }
            }
            ?>
            <thead>
                <tr>
                    <th>شهرداری</th>
                    <th>دولتی</th>
                    <th>نفتی</th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">

                    <td><?php echo number_format($t_shahr); ?></td>
                    <td><?php echo number_format($t_dolati); ?></td>
                    <td><?php echo number_format($t_nafti); ?></td>

                </tr>
            </tbody>
        </table>
    </div>








    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $ad_r = Ad::find()->where(['date_publish' => $date])->all();
            $r_khales = 0;
            $r_nakhales = 0;
            $r_benefit = 0;
            foreach ($ad_r as $r) {
                $r_khales += (($r->in_amount) - ($r->benefit_price));
                $r_nakhales += $r->in_amount;
                $r_benefit += $r->benefit_price;
            }
            ?>
            <thead>   
                <tr>  
                    <?php $today = \common\models\Persian::convert_date_to_fa($date); ?>
                    <th><?php echo 'درآمد خالص روزانه' . " " . '<div class="badge badge-info badge-pill">' . $today . '</div>' ?></th>
                    <th><?php echo 'درآمد نا خالص روزانه' . " " . '<div class="badge badge-info badge-pill">' . $today . '</div>' ?></th>
                    <th><?php echo 'کارمزد' . " " . '<div class="badge badge-info badge-pill">' . $today . '</div>' ?></th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">

                    <td><?php echo number_format($r_khales); ?></td>
                    <td><?php echo number_format($r_nakhales); ?></td>
                    <td><?php echo number_format($r_benefit); ?></td>

                </tr>
            </tbody>
        </table>
    </div>






    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $this_persin = \common\models\Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
//print_r($this_persin)  . " ";
            $current_days = $this_persin[2];
            $current_days = ltrim($current_days, '0');
            $date1 = \common\models\Persian::get_current_month();

            $addd = Ad::find()->where(['between', 'date_publish', $date1, $date])->all();

            $s_khales = 0;
            $s_nakhales = 0;
            $s_benefit = 0;
            foreach ($addd as $kh) {
                $s_khales += (($kh->in_amount) - ($kh->benefit_price));
                $s_nakhales += $kh->in_amount;
                $s_benefit += $kh->benefit_price;
            }
            ?>
            <thead>
                <tr>
                    <th>درآمد خالص ماه جاری تاکنون</th>
                    <th>درآمد نا خالص ماه جاری تاکنون</th>
                    <th> کارمزد ماه جاری تاکنون</th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">

                    <td><?php echo number_format($s_khales); ?></td>
                    <td><?php echo number_format($s_nakhales) . "<br>" . '<div class="badge badge-info badge-pill">' . $current_days . " روز" . '</div>'; ?></td>
                    <td><?php echo number_format($s_benefit); ?></td>

                </tr>
            </tbody>
        </table>
    </div>





    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $dateyear = \common\models\Persian::get_current_year();

            $ad_year = Ad::find()->where(['between', 'date_publish', $dateyear, $date])->all();

            $y_khales = 0;
            $y_nakhales = 0;
            $y_benefit = 0;
            foreach ($ad_year as $y) {
                $y_khales += (($y->in_amount) - ($y->benefit_price));
                $y_nakhales += $y->in_amount;
                $y_benefit += $y->benefit_price;
            }
            $this_persin = \common\models\Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
//print_r($this_persin)  . " ";
            $current_month = $this_persin[1];

            $current_month = ltrim($current_month, '0');
//echo $current_month."<br>";
            $average = $current_month * 30;
//echo 'total_days'.$average."<br>";
// echo 'khales'.$y_khales."<br>";
            $av = $y_khales / $average;
// echo 'averahe per day'.$av."<br>";
            ?>
            <thead>
                <tr>
                    <th>درآمد خالص تاکنون</th>
                    <th>درآمد نا خالص تاکنون</th>
                    <th> متوسط درآمد خالص روزانه</th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">

                    <td><?php echo number_format($y_khales); ?></td>
                    <td><?php echo number_format($y_nakhales); ?></td>
                    <td><?php echo number_format($av) . "<br>" . '<div class="badge badge-info badge-pill">' . $average . " روز" . '</div>'; ?></td>

                </tr>
            </tbody>
        </table>
    </div>







    <h3 style="text-align:right !important; display:block !important;">درآمد</h3>
    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $ad_income = Ad::find()->where(['is not', 'ad_type', null])->all();

            $income_shahr = 0;
            $income_dolati = 0;
            $income_naft = 0;
            $income_khososi = 0;
            $income_sum = 0;
            foreach ($ad_income as $in) {
                if ($in->cash == $in->in_amount or $in->pay_status == 1) {
                    if ($in->ad_type == 7)
                        $income_shahr += $in->in_amount;
                    if ($in->ad_type == 1 or $in->ad_type == 11)
                        $income_dolati += $in->in_amount;
                    if ($n->ad_type == 2 or $in->ad_type == 13)
                        $income_naft += $in->in_amount;
                    if ($n->ad_type == 10)
                        $income_khososi += $in->in_amount;
                }
            }
//            $dastgah = 0;
//            $useer = common\models\User::find()->where(['<>', 'city', 10511133])->all();
//
//            foreach ($useer as $u) {
//                $ad_dastgah = Ad::find()->where(['resseler_id' => $u->id])->all();
//                foreach ($ad_dastgah as $ad) {
//                    $dastgah += $ad_dastgah->in_amount;
//                }
//            }
            $income_sum = $income_khososi + $income_naft + $income_dolati + $income_shahr;
            ?>
            <thead>
                <tr>
                    <!--<th>مجموع سهم  استانها و شهرستانها</th>-->
                    <th>مجموع سهم شهرداری</th>
                    <th>مجموع سهم دولتی</th>
                    <th>مجموع سهم نفت</th>
                    <th>مجموع سهم خصوصی</th>
                    <th>مجموع سهم کل درآمد</th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">
                    <!--<td><?php echo number_format($dastgah); ?></td>-->
                    <td><?php echo number_format($income_shahr); ?></td>
                    <td><?php echo number_format($income_dolati); ?></td>
                    <td><?php echo number_format($income_naft); ?></td>
                    <td><?php echo number_format($income_khososi); ?></td>
                    <td><?php echo number_format($income_sum); ?></td>


                </tr>
            </tbody>
        </table>
    </div>








    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $ad_r = Ad::find()->where(['date_publish' => $date])->all();
            $r_khales = 0;
            $r_nakhales = 0;
            $r_benefit = 0;
            foreach ($ad_r as $r) {
                $r_khales += (($r->in_amount) - ($r->benefit_price));
                $r_nakhales += $r->in_amount;
                $r_benefit += $r->benefit_price;
            }


            $this_persin = common\models\Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
            //print_r($this_persin);
            $month = $this_persin[1];
            //echo $month . "***";
            $month = ltrim($month, '0');
            ?>

            <thead>
                <tr>
                    <?php for ($i = 1; $i <= $month; $i++) { ?>
                        <th>خالص <?php echo common\models\Persian::months[$i]; ?></th>
                    <?php } ?>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">
                    <?php for ($i = 1; $i <= $month; $i++) { ?>
                        <td><?= Ad::report($month); ?></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>






    <div class="card" style="margin-bottom:30px;">
        <table class="table mrg20T table-hover" id="result_list">
            <?php
            $ad_r = Ad::find()->where(['date_publish' => $date])->all();
            $r_khales = 0;
            $r_nakhales = 0;
            $r_benefit = 0;
            foreach ($ad_r as $r) {
                $r_khales += (($r->in_amount) - ($r->benefit_price));
                $r_nakhales += $r->in_amount;
                $r_benefit += $r->benefit_price;
            }
            ?>
            <thead>
                <tr>
                    <th>مجموع سهم استانها و شهرستانها </th>
                    <th>مجموع سهم شهرداری </th>
                    <th>مجموع سهم دولتی </th>
                    <th>مجموع سهم نفت </th>
                    <th>مجموع سهم پیام </th>
                    <th>مجموع سهم خصوصی </th>
                    <th>جمع کل درآمد </th>
                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">

                    <td><?= Ad::sahm(20); ?></td>
                    <td><?= Ad::sahm(7); ?></td>
                    <td><?= Ad::sahm(1, 11); ?></td>
                    <td><?= Ad::sahm(2, 13); ?></td>
                    <td><?= Ad::sahm(null, null, 480); ?></td>
                    <td><?= Ad::sahm(10); ?></td>
                    <td><?= Ad::sahm(20); ?></td>
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