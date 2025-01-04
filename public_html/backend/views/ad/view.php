<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Ad;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use common\models\AdMsg;
?>

<style>
    table tbody tr td{
        text-align: right;
        direction:rtl;
    }
    .card{
        padding:10px;
    }
    body{
        direction: ltr;
    }
</style>

<?php
$this->title = $model->title;
// echo $model->if_changed."*****";
$this->params['breadcrumbs'][] = ['label' => 'Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user_id = Yii::$app->user->identity->id;
?>
<div class="ad-view">

    <h1>عنوان آگهی: <?= Html::encode($this->title) ?></h1>
    <?php
    if ((Yii::$app->user->identity->lvl == 2 or Yii::$app->user->identity->lvl == 1 and $model->status == 1 or $model->status == 2)) {
        echo Html::a('ویرایش آگهی', Url::to(['ad/edit_ad', 'id' => $model->id,]), ['class' => 'btn btn-secondary']);
        
        
        
        
    }
    ?>
    <?php
    $find_ad = Ad::findOne($_GET['id']);
    $find_rej = \common\models\Reject::find()->where(['ad_id' => $_GET['id'], 'status' => 1])->one();
    if ((Yii::$app->user->identity->lvl == 2 and $find_ad->active_user_id = Yii::$app->user->identity->id and $find_ad->status == 2 and $find_rej))
        echo Html::a('رد برای کارگذار', Url::to(['reject/send', 'id' => $_GET['id']]), ['class' => 'btn btn-danger']);
    ?>
    <?php
    if ((Yii::$app->user->identity->lvl == 6 and $model->active_user_id = Yii::$app->user->identity->id and $model->status == 6))
        echo Html::a('رد برای کارگذار', Url::to(['reject/create', 'id' => $model->id,]), ['class' => 'btn btn-danger']);
    ?>
    <p>
        <?php
        //Html::a('کپی آگهی', ['ad/copy', 'id' => $model->id,  ], ['class' => 'btn btn-success']);
        $f = AdMsg::find()->where(['ad_id' => $model->id])->orderby(['id' => SORT_DESC])->One();
//print_r($f);

        if ($model->active_user_id == $user_id and $model->if_rejected == 1) {
            echo "<h3 style='display:inline;'>دلیل رد آگهی:</h3>" . "<h3 style='color:red;'>$f->msg </h3>";
        }
        ?>
        <?php
        if ((Yii::$app->user->identity->lvl == 22 and $model->active_user_id = Yii::$app->user->identity->id and $model->status == 22))
            echo Html::a('آپلود فایل رضوان ', Url::to(['rezvan/create', 'id' => $model->id,]), ['class' => 'btn btn-primary']);
        ?>
        <?php
        if ((Yii::$app->user->identity->lvl == 5 and $model->active_user_id = Yii::$app->user->identity->id and $model->status == 5))
            echo Html::a('آپلود عکس نمونه طراحی  ', Url::to(['design/create', 'id' => $model->id,]), ['class' => 'btn btn-primary']);
        ?>
        <?php
        if ($model->cancel_user_id != null) {

            $uu = User::find()->where(['id' => $model->cancel_user_id])->one();
            ?>
        <h3>کنسل شده توسط: <?= $uu->name_and_fam; ?></h3>

    <?php } ?>
    <?php
    if ($constt->constt == 1) {
        $currnet_task_chekc = Ad::status_tasks[$model->status];
        $countt = count(Ad::status_tasks[$model->status]['action_acc']);
    } elseif ($constt->constt == 2) {
        $currnet_task_chekc = Ad::status_tasks_mojoodi[$model->status];
        $countt = count(Ad::status_tasks_mojoodi[$model->status]['action_acc']);
    }

    $i = 0;
    $find_ad = Ad::findOne($_GET['id']);
    if ($find_ad->active_user_id == Yii::$app->user->identity->id and $find_ad->status < 9 and $find_ad->constt == 1) {
//echo $model->active_user_id."<br>".Yii::$app->user->identity->id."<br>".$model->constt;
        if (count(Ad::status_tasks[$model->status]['action_acc']) > 0) {
            ?>

            <input type="radio" id="doc_need" value="msg=1" name="cond">
            نیاز به آپلود مدارک دارد



            <input type="radio" id="msg_need" value="doc=1" name="cond">
            نیاز به توضیحات دارد
            <?php
        }
    }
    if (( $model->active_user_id == $user_id) and ( $model->status <= 8) and $model->constt == 2) {

        if (count(Ad::status_tasks_mojoodi[$model->status]['action_acc']) > 0) {
            ?>

            <input type="radio" id="doc_need" value="msg=1" name="cond">
            نیاز به آپلود مدارک دارد



            <input type="radio" id="msg_need" value="doc=1" name="cond">
            نیاز به توضیحات دارد
            <?php
        }
    }
    ?>
    <div style="clear: both"></div>
    <?php
    $user_id = Yii::$app->user->identity->id;
    //  echo $model->active_user_id;
    //echo $user_id;
    // echo  Yii::$app->user->identity->lvl;
    //  echo "<br>";
    //  echo $model->status;
//        $active= User::find()->where(['id'=>$model->active_user_id])->one();
//        if ($active)
//echo $model->status."<br>".$model->status_change;
    if ($model->status_change == 1) {
        echo Html::a('تایید آگهی و ارسال برای پذیرش', ['paz', 'ad_id' => $model->id], ['class' => 'btn btn-success']);
    }
    $adddd = Ad::findOne($_GET['id']);
//    if ((Yii::$app->user->identity->lvl == 1) or ( Yii::$app->user->identity->lvl == 2 and $model->status == 2)or ( $model->active_user_id == Yii::$app->user->identity->id and $model->status < 9 or $model->status == 22 )) {
//        if ($model->status_change != 1) {
    $th = Ad::findOne($_GET['id']);
    if (($th->active_user_id == Yii::$app->user->identity->id or Yii::$app->user->identity->lvl == 1) and Yii::$app->user->identity->lvl != 9) {
        $constt = Ad::findOne($_GET['id']);
        if ($constt->constt == 1) {
            $currnet_task_chekc = Ad::status_tasks[$model->status];
        } elseif ($constt->constt == 2) {
            $currnet_task_chekc = Ad::status_tasks_mojoodi[$model->status];
        }
        $i = 0;

        foreach ((array) $currnet_task_chekc['action_acc'] as $act) {
//                     echo "*";
            $next = $currnet_task_chekc['next_user'][$i];
            // echo $next;
            // echo Ad::status_next_user[$next]."*";
//            $n = Ad::status_next_user[$next];
            $n = '';
            //echo $currnet_task_chekc['acc_status'][$i]."*";
            //echo $currnet_task_chekc['next_user'][$i]."*";
            echo Html::a(Ad::action_text[$act] . " " . $n, ['verify', 'ad_id' => $model->id, 'next_user' => $currnet_task_chekc['next_user'][$i], 'acc_status' => $currnet_task_chekc['acc_status'][$i]], ['class' => 'btn btn-success']);
            $i++;
        }
//            }
//        }
    }
    $agahii = Ad::findOne($_GET['id']);
    if (( $agahii->active_user_id == Yii::$app->user->identity->id)) {

        //  print_r(\common\models\Ad::status_tasks[$model->status]); 

        if ($model->constt == 1) {
//            echo "1";

            $currnet_task_chekc = Ad::status_tasks[$model->status];
        } elseif ($model->constt == 2) {
//              echo $model->status."<br>";

            $currnet_task_chekc = Ad::status_tasks_mojoodi[$model->status];
//            print_r($currnet_task_chekc) ;
        }
        $i = 0;
        foreach ((array) $currnet_task_chekc['action_rej'] as $act1) {
            $next1 = $currnet_task_chekc['prev_user'][$i];
            // echo "next".$next1 . "<br>";
            // echo Ad::status_cancel_text[$next1] . "<br>";
            $c = Ad::status_cancel_text[$next1];
            // echo $currnet_task_chekc['rej_status'][$i] . "*<br>";
            //echo $currnet_task_chekc['prev_user'][$i] . "&<br>";
            // echo $act1."*"; 
//            echo $act1 . "*" . "<br>";
//            echo $next1 . "&" . "<br>";
//            if($ad->sarparast_first == 2 and $currnet_task_check==6 and $act1==6)
//            echo "<br>".$act1;

            if ($model->status != 3) {
                echo Html::a(Ad::action_text[$act1] . " " . $c, ['verify', 'ad_id' => $model->id, 'acc_status' => $currnet_task_chekc['rej_status'][$i], 'next_user' => $currnet_task_chekc['prev_user'][$i]], ['class' => 'btn btn-danger reject_btn']);
            } elseif ($model->status == 3 and $act1 == 2) {
//                echo "act2";
                echo Html::a(Ad::action_text[$act1] . " " . $c, ['verify', 'ad_id' => $model->id, 'acc_status' => $currnet_task_chekc['rej_status'][$i], 'next_user' => $currnet_task_chekc['prev_user'][$i]], ['class' => 'btn btn-danger reject_btn']);
            } elseif ($model->status == 3 and $act1 == 6 and $model->sarparast_first == 2) {
//                 echo "act6";
                echo Html::a(Ad::action_text[$act1] . " " . $c, ['verify', 'ad_id' => $model->id, 'acc_status' => $currnet_task_chekc['rej_status'][$i], 'next_user' => $currnet_task_chekc['prev_user'][$i]], ['class' => 'btn btn-danger reject_btn']);
            }
            $i++;
        }
    }

    if (( Yii::$app->user->identity->lvl == 3 )and ( $model->active_user_id == $user_id)) {
        echo Html::a('رد کامل', Url::to(['ad/cancelsarparast', 'id' => $model->id,]), ['class' => 'btn btn-danger']);
    }


    $user_id = Yii::$app->user->identity->id;
    if ((Yii::$app->user->identity->lvl == 9 or Yii::$app->user->identity->lvl == 1) and ( $model->status == 9)) {
        if ($model->constt == 1) {
            $currnet_task_chekc = Ad::status_tasks[$model->status];
        } elseif ($model->constt == 2) {
            $currnet_task_chekc = Ad::status_tasks_mojoodi[$model->status];
        }
        // echo status_tasks[$model->status]."<br>";
        // echo $model->status;
        $i = 0;
        foreach ((array) $currnet_task_chekc['action_acc'] as $act) {

            // echo Ad::status_next_user[$next];
            //echo $currnet_task_chekc['acc_status'][$i];

            echo Html::a('تایید مالی', ['verifymali', 'ad_id' => $model->id], ['class' => 'btn btn-success']);
            $i++;
        }
    }
    ?>

    <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>


    <?php
    
    if($model->pay_status == 1){
        echo Html::a('برگشت زدن آگهی پرداخت شده', Url::to(['ad/refund', 'id' => $model->id,]), ['class' => 'btn btn-secondary']);
        }
    
    
//        $h=$model->id;
//        echo $h;
//        exit();
//        $my_ad=Ad::findOne($model->id);
    //print_r(getErrors( $my_ad));
//        print_r ($my_ad->getErrors());
//       echo $my_ad;
//print_r(getErrors($task));
//        echo $my_ad;
//        exit();
//        echo "my_ad". $my_ad ."<br>";
    // $taskk=Task::find()->where(['id' =>$id])->one();
    //  echo "user_id". $user_id."<br>";
    // echo "active user". $model->active_user_id."<br>";
    $userr = User::find()->where(['id' => $model->active_user_id])->one();
//        echo $userr->lvl ."<br>";
//       echo $model->dabiri_id."<br>";
//        echo $model->status."<br>";
    if ((Yii::$app->user->identity->lvl == 1) or ( $model->active_user_id == $user_id)) {
        if ($model->status < 10) {
            ?>  

            <?php
        }
    }
    ?>
    <?php
    if ((Yii::$app->user->identity->lvl == 3 or Yii::$app->user->identity->lvl == 6) and ( $model->active_user_id == $user_id)) {
        ?>

        <?php
    }
    if ((Yii::$app->user->identity->lvl == 3 or Yii::$app->user->identity->lvl == 6) and ( $model->active_user_id == $user_id)) {
        ?>

        <?php ?>
    <?php } ?>

    <?php if ($model->active_user_id == $user_id or Yii::$app->user->identity->lvl == 2 or Yii::$app->user->identity->lvl == 1) {
        ?>
        <?= Html::a(' پروفایل مشتری', ['/customer/view', 'id' => $model->customer_id], ['class' => 'btn btn-info']) ?>

    <?php } ?>
    <?php if ((Yii::$app->user->identity->lvl == 9 ) and ( $model->status == 9)) {
        ?>


    <?php } ?>
    <?php $ad_status = Ad::findOne($_GET['id']); ?>
    <h2>وضعیت فعلی:<?= Ad::status_text[$ad_status->status] ?></h2>

    <?php
    if ($model->status == 6) {
        $add = Ad::findOne($_GET['id']);
//       print_r($add);
        $usss = User::findOne($add->active_user_id);

        echo "<h3>دبیری برای تایید: " . $usss->name_and_fam . "</h3>";
    }
    ?>



    <div class="card">
        <table class="table mrg20T table-hover" id="result_list">
            <?php $addd = common\models\Ad::find()->where(['id' => $model->id])->one(); ?>
            <?php $cc = common\models\Customer::find()->where(['id' => $model->customer_id])->one(); ?>
            <thead>
                <tr>
                    <th>کد کارگزار</th>
                    <th>نام کارگزار</th>
                    <th>نام شرکت</th>
                    <th>عنوان آگهی</th>
                    <?php if ($model->ad_type) { ?>
                        <th>نوع آگهی</th>
                    <?php } ?>
                    <th>تاریخ چاپ</th>
                    <th>شماره صفحه</th>

                    <th>درصد تخفیف</th>
                    <th>تخفیف های استفاده شده</th>
                    <th>نحوه پرداخت</th>
                    <th>نیاز به تایید مشتری دارد؟ </th>
                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_17">
                    <?php $fi = common\models\User::find()->where(['id' => $addd->resseler_id])->one(); ?>
                    <td><?php echo $fi->username; ?></td>
                    <td><?php echo $fi->name_and_fam; ?></td>
                    <td><?php echo $cc->name ?></td>
                    <td><?php echo $addd->title ?></td>
                    <?php if ($model->ad_type) { ?>
                        <td><?php echo Ad::ad_type[$model->ad_type]; ?></td>
                    <?php } ?>

                    <td><?php echo common\models\Persian::convert_date_to_fa($addd->date_publish); ?></td>
                    <?php $finddd = common\models\BoxMaket::find()->where(['id' => $addd->box_id])->one(); ?>
                    <td><?php echo $finddd->name; ?></td>

                    <td><?php if ($addd->discount_rate != null) echo $addd->discount_rate . "%" ?></td>
                    <td>
                        <?php
                        $find = \common\models\AdHasDiscount::find()->where(['ad_id' => $_GET['id']])->all();
                        foreach ($find as $f) {
                            $ff = common\models\DiscountItem::find()->where(['id' => $f->discount_id])->one();
                            ?>  <?php if ($ff) echo $ff->name . "<br>"; ?><?php
                        }
                        ?>
                    </td>
                    <td><?php echo Ad::pay_type[$model->naghdi_etebari]; ?></td>
                    <td>
                        <?php
                        if ($addd->customer_confirmation == 1) {
                            echo "بله";
                        } else {
                            echo "خیر";
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card" style="margin-top:50px;">
        <table class="table mrg20T table-hover" id="result_list" >




            <thead>

            </thead>


            <tbody>
                <tr> 
                    <td colspan="1" class="text-right" style="width:150px;">مبلغ تعرفه:</td> <td colspan="3" id="sum_discount"><?php echo number_format($model->total_price); ?></td>
                </tr>
                <tr>

                    <td>نام تخفیف استفاده شده</td>
                    <td class="text-center">درصد افزایش اعتبار</td>
                    <td>درصد تخفیف</td>
                    <td>قیمت(ریال)</td>

                </tr>
                <?php $ahd = common\models\AdHasDiscount::find()->where(['ad_id' => $model->id])->all(); ?>

                <?php foreach ($ahd as $aa) { ?> 

                    <tr id="discount-id_17">
                        <td><?= \common\models\DiscountItem::findOne($aa->discount_id)->name; ?></td>
                        <td><?php echo $aa->inc_rate ?></td>
                        <td><?php if ($aa->discount_rate != null) echo number_format((double) $aa->discount_rate, 2) ?></td>
                        <td><?php if ($aa->discount_price != null) echo number_format($aa->discount_price); ?></td>
                    </tr>
                <?php } ?>
                <tr> 


                    <td colspan="1" class="text-right" style="width:150px;"> تعداد کل کادر ها:</td> <td colspan="3" id="sum_discount"><?php echo $model->box_qty ?></td>

                </tr>
                <tr> <td colspan="1" class="text-right" style="width:150px;"> جمع تخفیف:</td><td id="sum_discount"><?php if ($model->discount_price > 0) echo number_format($model->discount_price, 2) ?></td></tr>
                <tr><td colspan="1" class="text-right" style="width:150px;">مبلغ مورد نیاز :</td><td colspan="3" id="sum_in"><?php if ($model->in_amount > 0) echo number_format($model->in_amount) ?></td></tr>
                <tr><td colspan="1" class="text-right" style="width:150px;">درصد افزایش اعتبار:</td><td colspan="3" id="sum_inc"><?php if ($model->inc_rate > 0) echo number_format($model->inc_rate) ?></td></tr>
                <tr><td colspan="1" class="text-right" style="width:150px;"> درصد کارمزد:</td><td colspan="3" id="benefit_rate"><?php if ($model->benefit_rate > 0) echo number_format($model->benefit_rate) ?></td></tr>
                <tr><td colspan="1" class="text-right" style="width:150px;"> مبلغ کارمزد:</td><td colspan="3" id="benefit_price"><?php if ($model->benefit_price > 0) echo number_format($model->benefit_price) ?></td></tr>
                <tr><td colspan="1" class="text-right" style="width:150px;">تاریخ ثبت:</td><td colspan="3"> <?php echo common\models\Persian::convert_date_to_fa($addd->date, true); ?></td></tr>
            </tbody></table>

    </div>







    <?php
    $c = Ad::find()->where(['id' => $data->model_id])->one();
    $str = $c->frame;
    $str2 = (explode(",", $str));
    ?>

    <style>
        .ad_frame td{
            width: 60px;
            height: 20px;
            border: 2px solid #000 !important;
        }
        .ad_frame {
            width: unset;
        }
    </style>

    <table class="table mrg20T table-hover border ad_frame " id="result_list" >
        <?php
        $str = $model->frame;
        $str2 = (explode(",", $str));
// print_r($str2);
// exit();
        for ($i = 0; $i < $str2[0]; $i++) {
            ?>
            <tr>
                <?php for ($j = 0; $j < $str2[1]; $j++) { ?>
                    <td class="border"></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
    <div class="card" style="margin-top:30px;">
        <table class="table mrg20T table-hover" id="result_list" style ="margin:30px 0;">

            <thead>
                <tr>
                    <th style="font-size: 20px !important; font-weight:bold;">آرم</th>

                    <th style="font-size: 20px !important; font-weight:bold;">صفحه اول</th>
                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_1717">
                    <td style="font-size: 15px !important;">
                        <?php
                        if ($model->logo == 1)
                            echo 'آرم دارد';
                        elseif ($model->logo == 0 or $model->logo == null or $model->logo == '') {
                            echo 'آرم ندارد';
                        }
                        ?>
                    </td>
                    <td style="font-size: 15px !important;">
                        <?php
                        if ($model->first_page == 1)
                            echo 'آگهی در صفحه اول است';
                        elseif ($model->first_page == 0 or $model->first_page == null or $model->first_page == '') {
                            echo 'آگهی در صفحه اول نیست';
                        }
                        ?>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    <div class="card" style="margin-top:30px;">
        <table class="table mrg20T table-hover" id="result_list" style ="margin:30px 0;">

            <thead>
                <tr>
                    <th style="font-size: 25px !important; font-weight:bold;">متن آگهی</th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_1717">
                    <td style="font-size: 25px !important;"><?php echo $model->info ?></td>

                </tr>
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-top:30px;">
        <table class="table mrg20T table-hover" id="result_list" style ="margin:30px 0;">

            <thead>
                <tr>
                    <th style="font-size: 25px !important; font-weight:bold;">توضیحات فنی</th>

                </tr>
            </thead>
            <tbody>
                <tr id="discount-id_1717">
                    <td style="font-size: 25px !important;"><?php echo $model->fani ?></td>

                </tr>
            </tbody>
        </table>
    </div>
    <style>
        #discount-id_1717 p{
            font-size: 23px !important;
        }
    </style>

    <!--    <h2 style=" float:right;">متن آگهی</h2>
        <p style="direction: rtl; text-align: justify; float:right;font-size: 25px;">
    <?php //echo strip_tags($model->info) ;         ?>
        </p>-->
    <div class="clearfix"></div>
    <div class="card" style="margin-top:30px;">
        <h2 style="float:right !important; text-align:right !important;">جدول وظایف</h2>
        <?php //  $id_ad=$model->id; echo $id_ad ;      ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'start_time',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data->start_time != '0000-00-00 00:00:00' and $data->start_time != null)
                            return common\models\Persian::convert_date_to_fa($data->start_time, true);
                    }
                ],
                [
                    'attribute' => 'end_time',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data->end_time != '0000-00-00 00:00:00')
                            return common\models\Persian::convert_date_to_fa($data->end_time, true);
                    }
                ],
                [
                    'header' => 'وضعیت',
                    'format' => 'raw',
                    'attribute' => 'status',
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'status',
                        'data' => \common\models\Task::status_task,
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'options' => [
                            'placeholder' => 'وضعیت آگهی',
                        ],
                    ]),
                    'value' => function ($data) {
                        return \common\models\Task::status_task[$data->status];
                    },
                ],
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $c = User::find()->where(['id' => $data->user_id])->one();
                        // $model_customer = Customer::find()->where(['name' => $customer_name])->one();
                        return $c->name_and_fam;
                    }
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => ' {view} ',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            if (Yii::$app->user->identity->lvl == 1) {
                                return Html::a('<i class="icon-user"></i>', Url::to(['task/update', 'id' => $model->id]), $options);
                            }
                        }
                    ]
                ],
//        
            ],
        ]);
        ?>
    </div>
    <div class="card" style="margin-top:30px;">
        <h3 style="text-align:right;">فایل های پیوست طراحی</h3>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider_1,
            'filterModel' => $searchModel_1,
            'columns' => [
                [
                    'attribute' => 'tarahi_id',
                    'format' => 'raw',
                    'value' => function ($da) {
                        $find = common\models\User::find()->where(['id' => $da->tarahi_id])->one();
                        return $find->name_and_fam;
                    }
                ],
                [
                    'attribute' => 'attach',
                    'format' => 'raw',
                    'value' => function ($da) {
                        // return "<a target='_blank' href='/backend/web/" . $da->attach . "'>دانلود فایل پیوست</a>";
                        //echo $da->attach;
                        // return  "<a target='_blank'  href='".Url::to(['design/view1','ad_id'=>$da->ad_id])."'>مشاهده فایلهای پیوست مشتری و طراحی</a>";

                        return " <a target='_blank'  href='" . Url::to(['design/view', 'ad_id' => $da->ad_id, 'file' => $da->attach]) . "'>مشاهده فایل پیوست</a>";
                    }
                ],
            ]
        ]);
        ?>
    </div>

    <?php //if(Yii::$app->user->identity->lvl==6 or Yii::$app->user->identity->lvl==2){  ?>
    <div class="card" style="margin-top:30px;">
        <h3 style="text-align:right;">فایل های پیوست رد</h3>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider_rej,
            'filterModel' => $searchModel_rej,
            'columns' => [
                [
                    'attribute' => 'dabiri_id',
                    'format' => 'raw',
                    'value' => function ($da) {
                        $find = common\models\User::find()->where(['id' => $da->dabiri_id])->one();
                        return $find->name_and_fam;
                    }
                ],
                [
                    'attribute' => 'gallery',
                    'format' => 'raw',
                    'value' => function ($da) {

                        return "<a target='_blank' href='https://hamshahriads.ir/backend/web/" . $da->gallery . "'>دانلود فایل پیوست</a>";
                    }
                ],
            ]
        ]);
        ?>
    </div>
    <?php // }  ?>
    <!--<h3 style="text-align:right;margin:5% 0 5% 0;">فایل های پیوست طراحی مشتری</h3>-->

    <?php
    GridView::widget([
        'dataProvider' => $dataProvider_1,
        'filterModel' => $searchModel_1,
        'columns' => [
            [
                'attribute' => 'attach',
                'format' => 'raw',
                'value' => function ($da) {
                    // return "<a target='_blank' href='/backend/web/" . $da->attach . "'>دانلود فایل پیوست</a>";
                    //echo $da->attach;
                    // return  "<a target='_blank'  href='".Url::to(['design/view1','ad_id'=>$da->ad_id])."'>مشاهده فایلهای پیوست مشتری و طراحی</a>";

                    return " <a target='_blank'  href='" . Url::to(['design/view11', 'ad_id' => $da->ad_id, 'file' => $da->attach]) . "'>مشاهده فایل پیوست</a>";
                }
            ],
        ]
    ]);
    ?>

    <div class="card" style="margin-top:30px;">
        <h3 style="float:right !important; text-align:right !important;">رضوان</h3>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider_rez,
            'filterModel' => $searchModel_rez,
            'columns' => [
                [
                    'attribute' => 'gallery',
                    'format' => 'raw',
                    'value' => function ($da) {

                        return "<a target='_blank' href='/backend/web/" . $da->gallery . "'>دانلود فایل پیوست</a>";
                    }
                ],
            ]
        ]);
        ?>
    </div>
    <div class="card" style="margin-top:30px;">
        <h2 style="float:right !important; text-align:right !important;">فایل های پیوست مشتری</h2>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider_doc,
            'filterModel' => $searchModel_doc,
            'columns' => [
                [
                    'attribute' => 'subject',
                    'format' => 'raw',
                    'value' => function ($data) {

                        return $data->subject;
                    }
                ],
                [
                    'attribute' => 'file',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data->file != null)
                        // echo $data->file;
                        //return " <a target='_blank'  href='".Url::to(['ad/pic', 'file'=> $data->file ])."'>مشاهده فایل پیوست</a>";
                        //return "<a target='_blank' href='/" . $data->file . "'>دانلود فایل پیوست</a>";
                            if (strpos($data->file, 'uploads/') !== false)
                                return "<a target='_blank' href='/backend/web/" . $data->file . "'>دانلود فایل پیوست</a>";
                            elseif (strpos($data->file, 'uploaded_document/') !== false)
                                return "<a target='_blank' href='/" . $data->file . "'>دانلود فایل پیوست</a>";
                    }
                ],
                [
                    'attribute' => 'file_doc',
                    'format' => 'raw',
                    'value' => function ($data) {
//                        if ($data->file != null)
                        // echo $data->file;
                        //return " <a target='_blank'  href='".Url::to(['ad/pic', 'file'=> $data->file ])."'>مشاهده فایل پیوست</a>";
                        //return "<a target='_blank' href='/" . $data->file . "'>دانلود فایل پیوست</a>";
//                            if (strpos($data->file, 'uploaded_document/') !== false)
                        return "<a target='_blank' href='/" . $data->file_doc . "'>دانلود فایل پیوست</a>";
                    }
                ],
//       
            ],
        ]);
        ?>
    </div>
    <div class="clearfix"></div>
    <?php
    $ad_id = $_GET['id'];

    echo "<a id=m-t target='_blank'  href='" . Url::to(['/design/view1', 'ad_id' => $ad_id]) . "'>مشاهده فایلهای پیوست مشتری و طراحی</a>";
    ?>
    <style>
        h2{
            margin-right:10px ;
        }
        #m-t{
            color:white;
            background-color: purple;
            padding:2% 1%;
            float:right;
            margin-bottom: 3%;
            margin-top: 3%;
            display:block;
            border-radius:5px;

        }
        #m-t:hover{

            background-color:darkviolet;

        }
    </style>
    <div class="clearfix"></div>
    <div class="card">
        <h2 style="float:right !important; text-align:right !important;">پیام های این آگهی</h2>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider_adm,
            'filterModel' => $searchModel_adm,
            'columns' => [
                [
                    'attribute' => 'msg',
                    'format' => 'raw',
                    'value' => function ($data) {

                        return $data->msg;
                    }
                ],
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $user_table = User::find()->where(['id' => $data->user_id])->one();
                        return Ad::view_level[$user_table->lvl];
                    }
                ],
            ],
        ]);
        ?>
        <?php ?>

    </div>

    <!--<h2 style="float:right;">فایل های پیوست مالی</h2>-->
    <?php
// echo 
    GridView::widget([
        'dataProvider' => $dataProvider_s,
        'filterModel' => $searchModel_s,
        'columns' => [
            [
                'attribute' => 'mali_attach',
                'format' => 'raw',
                'value' => function ($dataaa) {

                    return "<a target='_blank' href='/backend/web/" . $dataaa->mali_attach . "'>دانلود فایل پیوست</a>";
                }
            ],
            [
                'attribute' => 'mali_id',
                'format' => 'raw',
                'value' => function ($dataaa) {
                    $user_table1 = User::find()->where(['id' => $dataaa->mali_id])->one();
                    return $user_table1->name_and_fam;
                }
            ],
        ],
    ]);
    ?>
    <?php ?>
</div>
