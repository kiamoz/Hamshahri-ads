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

$this->title = 'گزارش اصلی';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $date = date('Y-m-d'); ?> 
<style>
    #discount-id_18{
        width:50px;
    }
    h2{
        text-align: right !important;
    }
    .card{
        overflow-x:scroll;
    }
    .card td{
        border-right: 1px solid gray;
    }
    .ww{
        min-width: 243px !important;
    }
</style>

<div class="ad-index">

    <h1>گزارش اصلی</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $res_id = $id ?>
    <?php
    $this_persin = common\models\Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
    //print_r($this_persin);
    $month = $this_persin[1];
    //echo $month . "***";
    $month = ltrim($month, '0');
    //echo $month . "***";
    ?>
    <?php
    ?>


    <?php
//    $addd = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['>', 'ad_type', 0])->all();
//    foreach ($addd as $ad) {
//        echo "id: " . $ad->id . " type: " . $ad->ad_type . " date: " . \common\models\Persian::convert_date_to_fa($ad->date_publish) . "<br>";
//    }
    ?>


    <?php
    $date = explode(' ', $date);
//            print_r($date);
    $ad = Ad::find()->select('id,date_publish,in_amount,ad_type, sum(in_amount) as sum_gr,sum(benefit_price) as sum_be,sum(discount_price) as sum_di');
//    $ad = $ad->andWhere(['resseler_id' => $res_id]);
    $ad = $ad->andwhere(['between', 'date_publish', '2021-03-21', '2022-03-21']);
    $ad = $ad->groupBy('date_publish,ad_type');

//   echo $ad->createCommand()->getRawSql();




    $ad = $ad->all();

// echo count($ad);


    $data = array();
    $ret = array();
    for ($i = 1; $i <= $month; $i++) {
        $data = [];
        $data2 = [];
        $ret = [];
//        echo "month: " . $month . " i: " . $i;
        $date = \common\models\Persian::get_current_month_report($i);
        //   echo $date[0] . "<br>";
        //   echo $date[1] . "<br>";
        foreach ($ad as $a) {
            //echo $a->id." ".$a->pay_status ."<br>";
            //continue;
            if ($a->date_publish > $date[0] and $a->date_publish < $date[1]) {

                $date_persian = \common\models\Persian::convert_date_to_fa($a->date_publish);

                $data[$date_persian]['sum'] += $a->sum_gr;
                $data[$date_persian]['benefit'] += $a->sum_be;
                $data[$date_persian]['discount'] += $a->sum_di;
                $data[$date_persian]['sum_unpure'] += ($a->sum_gr - $a->sum_be) - $a->sum_di;

//                $data2[$a->ad_type][\common\models\Persian::convert_date_to_fa($a->date_publish)] = $a->sum_gr;

                if (!$a->ad_type) {
                    $data2[$date_persian]['-1'] = $a->sum_gr;
                } else {
                    $data2[$date_persian][$a->ad_type] = $a->sum_gr;
                }

                $data2[$date_persian]['sum'] += $a->sum_gr;
//                 $data2[$a->ad_type]['date'] = [\common\models\Persian::convert_date_to_fa($a->date_publish)];
//                 $data2[$a->ad_type]['total'] = $a->sum_gr;
//            array_push($data, \common\models\Persian::convert_date_to_fa($a->date_publish),$a->ad_type,$a->sum_gr);
            }
        }
//        print_r($data);
//        echo "<br>";
//        print_r($data2);
//        echo "<br>";
        foreach ($data2 as $key => $val) {
//                            echo '<td>' . $key .$val['t']. '</td>';
        }
//                           echo "<br>";
        foreach ($data2 as $loop) {
//                            echo '<td>' . $loop . '</td>';
        }
        ?>
        <a data-toggle="collapse" href="#collapse-10<?= $i ?>" aria-expanded="true" aria-controls="collapse-10">
            <h2><?php echo common\models\Persian::months[$i]; ?></h2>
        </a>

        <div id="collapse-10<?= $i ?>" class="collapse " role="tabpanel" aria-labelledby="heading-10" data-parent="#accordion-4">

            <div class="card" style="margin-bottom:30px;">
                <table class="table mrg20T table-hover" id="result_list">

                    <tbody>

                        <tr id="discount-id_18">
                            <td>درآمد/تاریخ</td>
                            <?php
                            foreach ($data as $key => $val) {
                                echo '<td>' . $key . '</td>';
                            }
                            ?>

                        </tr>
                        <tr id="discount-id_18">
                            <td class="ww">مجموع درآمد پس از تخفیف  (نا خالص)</td>
                            <?php
                            foreach ($data as $loop) {
                                echo '<td>' . number_format($loop['sum']) . '</td>';
                            }
                            ?>
                        </tr>
                        <tr id="discount-id_18">
                            <td>کارمزد</td>
                            <?php
                            foreach ($data as $loop) {
                                echo '<td>' . number_format($loop['benefit']) . '</td>';
                            }
                            ?>
                        </tr>
                        <tr id="discount-id_18">
                            <td class="ww">درآمد پس ازکسر تخفیف و کارمزد(خالص)</td>
                            <?php
                            foreach ($data as $loop) {
                                echo '<td>' . number_format($loop['sum'] - $loop['benefit']) . '</td>';
                            }
                            ?> 
                        </tr>

                    </tbody>


                </table>
            </div>



            <div class="card" style="margin-bottom:30px;">
                <table class="table mrg20T table-hover" id="result_list">

                    <tbody>

                        <tr id="discount-id_18">
                            <td>درآمد/تاریخ</td>
                            <?php
                            foreach ($data as $key => $val) {
                                echo '<td>' . $key . '</td>';
                                $datee = $key;
                            }
                            ?>
                        </tr>



                        <?php foreach (\common\models\AdType::find()->all() as $avlue) { ?>


                            <tr id="discount-id_18">
                                <td><?= $avlue->name ?></td>


                                <?php
                                foreach ($data2 as $loop) {


                                    echo '<td>' . number_format($loop[$avlue->id]) . '</td>';
                                }
                                ?> 


                            </tr>

                        <?php } ?>
                        <tr id="discount-id_18">
                            <td>جمع</td>
                            <?php
                            foreach ($data2 as $loop) {


                                echo '<td>' . number_format($loop['sum']) . '</td>';
                            }
                            ?>

                        </tr>
                    </tbody>


                </table>
            </div>

        </div>

    <?php } ?>

    <!--//******************************************************-->



</div>


<script src="http://code.jquery.com/jquery-11.0.min.js"></script>
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