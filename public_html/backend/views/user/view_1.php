<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\Ad;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'شناسه: ' . $model->id . ' نام کاربری: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
<div class="user-view">
    <?php //echo $model->id; ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>


        <?= Html::a('لیست تمام آگهی های این کارگزار', ['/ad/index1', 'AdSearch[resseler_id]' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('لیست تراکنش های مالی این کارگزار', ['/transition', 'Transitionsearch[user_id]' => $model->id], ['class' => 'btn btn-primary']) ?>



        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?php
    //echo Ad::find()->where(['resseler_id' => $model->id, 'pay_status' => 0, 'naghdi_etebari' => 1])->andWhere(['!=','status',-1])->createCommand()->getRawSql();
    ?>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name_and_fam',
            'username',
            'email:email',
            'cell_number',
            'phone_number',
            'address',
            'addres_work',
            'postal_code',
            'company_name',
            'social_code',
            'code_eghtesadi',
            'sh_gharardad',
            [
                'attribute' => 'wallet',
                'format' => 'raw',
                'value' => function ($data) {
                    //if ($data->wallet)
                    return number_format((int) $data->wallet);
                }
            ],
            [
                'attribute' => 'saghf_etebar',
                'format' => 'raw',
                'value' => function ($data) {
                    // if ($data->saghf_etebar)
                    return number_format($data->saghf_etebar);
                }
            ],
            [
                'attribute' => 'credit',
                'format' => 'raw',
                'value' => function ($data) {


                    //return Ad::find()->where(['resseler_id' => $data->id, 'pay_status' => 0,'naghdi_etebari'=>2])->count();
                    $sum_ = common\models\Transition::get_live_balance($data->id, 2);
                    
                    
                    
                    return number_format((int) ($sum_ * -1) + ($data->prev_etebari) + common\models\Transition::find()->where(['user_id'=>$data->id,'type'=>5])->sum('amount') ) . "<br> مانده زنده:" . number_format($sum_ * -1);
                    //if ($data->credit)
                    //return number_format($data->saghf_etebar - (-1 * $data->credit));
                }
            ],
            [
                'attribute' => 'saghf_etebar_naghdi',
                'format' => 'raw',
                'value' => function ($data) {
                    // if ($data->saghf_etebar_naghdi)
                    return number_format((int) $data->saghf_etebar_naghdi);
                }
            ],
            [
                'attribute' => 'credit_naghdi',
                'format' => 'raw',
                'value' => function ($data) {
                    //if ($data->credit_naghdi)


                    $sum_ = common\models\Transition::get_live_balance($data->id, 1);

                    $all_change = common\models\Transition::find()->where(['user_id'=>$data->id,'type'=>6])->sum('amount');
                    
                    return   "جمع تغییر مانده نقدی:".number_format($all_change). "<br> اول دوره :". number_format($data->prev_naghdi)."<br> مانده زنده:" . number_format($sum_ * -1)."<br>" . number_format((int) ($sum_ * -1) + ($data->prev_naghdi) +  common\models\Transition::find()->where(['user_id'=>$data->id,'type'=>6])->sum('amount') );;
                }
            ],
            [
                'attribute' => 'credit_tahator',
                'format' => 'raw',
                'value' => function ($data) {
                    //if ($data->credit_naghdi)
                    return number_format((int) $data->credit_tahator);
                }
            ],
            [
                'attribute' => 'prev_naghdi',
                'format' => 'raw',
                'value' => function ($data) {
                    // if ($data->prev_naghdi)
                    return number_format((int) $data->prev_naghdi);
                }
            ],
            [
                'attribute' => 'prev_etebari',
                'format' => 'raw',
                'value' => function ($data) {
                    // if ($data->prev_etebari)
                    return number_format((int) $data->prev_etebari);
                }
            ],
            [
                'label' => 'سرجمع',
                'format' => 'raw',
                'value' => function ($data) {
                    //if ($data->credit_naghdi)

                    $sum_ = 0;
                    foreach (Ad::find()->where(['resseler_id' => $data->id, 'pay_status' => 0])->all() as $ads_) {

                        $khales = 0;
                        if ($ads_->naghdi_etebari == 1)
                            $khales = ($ads_->in_amount - $ads_->benefit_price) - $ads_->cash;
                        elseif ($ads_->naghdi_etebari == 2)
                            $khales = ($ads_->in_amount) - $ads_->cash;

                        $sum_ += $khales;
                    }



                    return " مانده سر جمع زنده:" . number_format($sum_ * -1);
                }
            ],
        ],
    ])
    ?>


    <?php
    GridView::widget([
        'dataProvider' => $dataProvider_ad,
        'filterModel' => $searchModel_ad,
        'showFooter' => true,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    // $find = common\models\User::find()->where(['id' => $da->tarahi_id])->one();
                    $options = ['target' => '_blank'];
                    $a_1 .= " " . Html::a('<i class="fa fa-print" aria-hidden="true"></i>', Url::to(['ad/view1', 'id' => $model->id, 'invoice' => 0]), $options);

                    return $a_1 . "<hr><a href='" . Url::to(['ad/view', 'id' => $da->id]) . "'>" . $da->title . " <i class='icon-share-alt'></i> <a>";
                }
            ],
            [
                'attribute' => 'customer_id',
                'format' => 'raw',
                'value' => function ($da) {
                    $find = common\models\Customer::find()->where(['id' => $da->customer_id])->one();

                    return "<a href='" . Url::to(['customer/view', 'id' => $find->id]) . "'>" . $find->name . " <i class='icon-share-alt'></i> <a>";
                }
            ],
            [
                'attribute' => 'date_publish',
                'format' => 'raw',
                'value' => function ($da) {
                    if ($da->date_publish != '0000-00-00')
                        return common\models\Persian::convert_date_to_fa($da->date_publish);
                }
            ],
            'id',
            [
                'attribute' => 'box_price',
                'format' => 'raw',
                'value' => function ($da) {
                    if ($da->box_price)
                        return number_format($da->box_price);
                }
            ],
            [
                'attribute' => 'total_price',
                'format' => 'raw',
                'value' => function ($da) {
                    if ($da->total_price)
                        return number_format($da->total_price);
                }
            ],
            [
                'attribute' => 'discount_price',
                'format' => 'raw',
                'value' => function ($da) {
                    if ($da->discount_price)
                        return number_format($da->discount_price);
                },
                'footer' => number_format(Ad::getTotal($dataProvider_ad->models, 'discount_price')) . "<br>" . number_format($dataProvider_ad->query->sum('discount_price')),
            // 'footer' =>      $dataProvider->query->sum('discount_price'),
            ],
            [
                'attribute' => 'in_amount',
                'format' => 'raw',
                'value' => function ($da) {
                    if ($da->in_amount)
                        return number_format($da->in_amount);
                }
            ],
            [
                'attribute' => 'benefit_price',
                'format' => 'raw',
                'value' => function ($da) {
                    return $da->benefit_price ? number_format($da->benefit_price) : 'ثبت نشده';
                },
                'footer' => number_format(Ad::getTotal($dataProvider_ad->models, 'benefit_price')) . "<br>" . number_format($dataProvider_ad->query->sum('benefit_price')),
            ],
            [
                'header' => 'مبلغ نهایی(خالص)',
                'format' => 'raw',
                'value' => function ($da) {
                    //if ($da->discount_price)
                    return number_format($da->total_price - $da->discount_price - $da->benefit_price);
                },
            ],
        ]
    ]);
    ?>
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
    $ad = $ad->andWhere(['resseler_id' => $res_id]);
//$ad = $ad->andwhere(['between', 'date_publish', '2019-03-21', '2020-03-21']);
    $ad = $ad->groupBy('date_publish,ad_type');

//    echo $ad->createCommand()->getRawSql();





    $ad = $ad->all();

// echo count($ad);


    $data = array();
    $ret = array();
    for ($i = 1; $i >= $month; $i++) {
        $data = [];
        $data2 = [];
        $ret = [];
//        echo "month: " . $month . " i: " . $i;
        $date = \common\models\Persian::get_current_month_report($i);
//        echo $date[0] . "<br>";
//        echo $date[1] . "<br>";
        foreach ($ad as $a) {
            if ($a->date_publish > $date[0] and $a->date_publish < $date[1]) {

                $date_persian = \common\models\Persian::convert_date_to_fa($a->date_publish);

                $data[$date_persian]['sum'] += $a->sum_gr;
                $data[$date_persian]['benefit'] += $a->sum_be;
                $data[$date_persian]['discount'] += $a->sum_di;
                $data[$date_persian]['sum_unpure'] += ($a->sum_gr - $a->sum_be);

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

        <h2><?php echo common\models\Persian::months[$i]; ?></h2>
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
                        <td class="ww">درآمد پس ازکسر تخفیف و کارمزد</td>
                        <?php
                        foreach ($data as $loop) {
                            echo '<td>' . number_format($loop['sum_unpure']) . '</td>';
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



    <?php foreach (Ad::ad_type as $key => $avlue) { ?>


                        <tr id="discount-id_18">
                            <td><?= $avlue ?></td>


        <?php
        foreach ($data2 as $loop) {


            echo '<td>' . number_format($loop[$key]) . '</td>';
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

<?php } ?>

    <!--//******************************************************-->


</div>
