<?php

//echo \common\models\Persian::get_last_day_of_month(12, 1403);
//echo  \common\models\Persian::get_prev_month_array();
////$date=(explode(" ",$date));
////print_r ($date);
//exit(); 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\City;
use common\models\VatYear;

?>
<!--<h1>سیستم در حال تست است نترسید :</h1>-->
<style>
    @media print { @page {size: auto !important} .no_print{display: none;} }

    td.mid {
        padding: 0;
        font-size: 11px;
    }
    body{
        direction:rtl;
    }
    td{
        font-size: 13px;
    }
    .mid{
        text-align:center;
    }
    table{
        margin-top:1%;
    }
    .big_row td {
        font-size: 13px;
        padding: 6px;
        font-weight: bold !important;
    }
    td {
        font-family: "Times New Roman", Times, serif;
    }
    .w-equal-30{
        width:30%;
    }
    .w-equal-15{
        width:15%;
    }
    .w-equal-10{
        width:10%;
    } 
    .w-equal-25{
        width:27.1%;
    }

    *{
        font-family: 'B nazanin' !important;  
    }
    .col-lg-12 {
        min-height: 710px;
    }
    .col-6.col-mh {
        margin-top: 70px;
    }
    .sign-row td{
        padding: 10px !important;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<body>
    <?php
    if ($_GET['invoice']) {

        $invoice_data = \common\models\InvoiceType::findONe($_GET['invoice']);
    }

   

    ?>

    <?php
    $ad_table = common\models\Ad::find()->where(['id' => $_GET['id']])->one();
    $ad_table->print_count++;
    $ad_table->save();


    $date_p = explode("/",\common\models\Persian::convert_date_to_fa($ad_table->date_publish));
    
    

    $vat_percent =  VatYear::vatfinder($ad_table);
    //echo $ad_table->discount_price."*";

    for ($ij = 1; $ij <= 3; $ij++) {


        if ($ij > 1)
            $show_benfit = true;
        ?>

        <div class="user-form container">

            <div class="row">
                <div class="col-6" style="visibility: hidden;">
                    <img src="../../backend/web/uploads/3.jpg" class="float-right" style="height: 61px;">
                    <div class="float-right"><p style="text-decoration: ">روزنامه اجتماعی, فرهنگی,  اقتصادی<span style="font-weight:bold;"> سازمان آگهی ها </span></p></div>
                </div>
                <div class="col-6 col-mh" style="text-align: left;<?php if ($ij == 1) echo "    margin-top: 100px; "; ?>"> 
                    <?php
                    //if ($ad_table->custom_id)
                    //   $ad_table->id = $ad_table->custom_id;
                    //echo "<div class='no_print'>".  "شماره سریال: " . $ad_table->id . "</div><br>";
                    echo "تاریخ: " . \common\models\Persian::convert_date_to_fa($ad_table->date);

                    if ($show_benfit) {

                        // $ad_table->in_amount = $ad_table->in_amount -  $ad_table->benefit_price;
                    }
                    ?>
                </div>
                <div class="col-lg-12">

                    <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
                        <tbody>
                            <tr >
                                <td colspan="12" class="mid">مشخصات فروشنده</td>
                            </tr>
                            <tr>
                                <td class="w-equal-30" colspan="2">نام شخص حقیقی / حقوقی: شرکت همشهری</td>
                                <td class="w-equal-30" colspan="4">شماره اقتصادی: 10101377066</td>
                                <td class="w-equal-30" colspan="4">شماره ثبت / شماره ملی: 10101377066</td>
                            </tr>
                            <tr>

                                <td colspan="1" class="w-equal-15">نشانی: استان: تهران</td>
                                <td colspan="1" >شهرستان: تهران</td>

                                <td colspan="4" class="w-equal-30">کد پستی: 1966645956</td>
                                <td colspan="4" class="w-equal-30">شهر: تهران</td>
                            </tr>
                            <tr>
                                <td colspan="4">نشانی:  


                                    <?php
                                    if ($invoice_data->address) {
                                        echo $invoice_data->address;
                                    } else {
                                        echo 'خیابان ولیعصر نرسیده به پارک وی کوچه تورج پلاک ۱۴';
                                    }
                                    ?>

                                </td>
                                <?php if($ad_table->code_kargah){ ?>
                                    <td colspan="2">کد کارگاهی: <?php echo $ad_table->code_kargah; ?></td>
                                <?php } ?>
                                <td colspan="6">


                                    <?php
                                    if ($invoice_data->phone_number) {
                                        echo $invoice_data->phone_number;
                                    } else {
                                        echo 'شماره تلفن :23023000 / نمابر: 23023297';
                                    }
                                    ?>


                                </td>

                            </tr>
                            <tr>
                                <td colspan="12" class="mid">مشخصات خریدار</td>
                            </tr>
                            <tr>

                                <?php $customer_table = \common\models\Customer::find()->where(['id' => $ad_table->customer_id])->one();
                                ?>
                                <td colspan="2" class="w-equal-30">نام شخص حقیقی یا حقوقی: <?php echo $customer_table->name; ?></td>
                                <td colspan="4" class="w-equal-30">شماره اقتصادی: <?php echo $customer_table->economical_code; ?></td>
                                <td colspan="4" class="w-equal-30" >شماره ثبت / شماره ملی: <?php echo $customer_table->social_code; ?></td>

                            </tr>
                            <tr>
                                <td colspan="1" class="w-equal-15">استان: <?php echo $customer_table->s->name; ?></td>
                                <td colspan="1">شهرستان: <?php echo $customer_table->country; ?></td>
                                <td colspan="4"  class="w-equal-30">کد پستی: <?php echo $customer_table->postal_code; ?></td>
                                <td colspan="4"  class="w-equal-30">شهر: <?php echo $customer_table->c->name; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">نشانی: <?php echo $customer_table->addres; ?></td>
                               
                                <td colspan="6">شماره تلفن: <?php echo $customer_table->phone; ?></td>

                            </tr>
                            <tr>
                                <td colspan="12" class="mid">مشخصات کالا یا خدمات مورد معامله</td>
                            </tr>
                            <tr> 
                                <?php $box_table = common\models\Box::find()->where(['id' => $ad_table->box_id])->one(); ?>
                                <td colspan="2" >


                                    <?php
                                    if ($invoice_data->pages) {
                                        echo $invoice_data->pages . ":";
                                    } else {
                                        echo "صفحه:";
                                    }



                                    if ($box_table->name_print) {
                                        echo $box_table->name_print;
                                    } else {
                                        echo $box_table->name;
                                    }
                                    echo " " . $ad_table->inner_page_info;
                                    ?></td>
                                <td colspan="4" >تعداد نوبت: <?php echo $ad_table->pub_qty . " نوبت"; ?></td>
                                <td colspan="2" class="">تاریخ چاپ: <?php echo \common\models\Persian::convert_date_to_fa($ad_table->date_publish);
                                if($ad_table->date_publish2){
                                    echo "-";
                                    echo \common\models\Persian::convert_date_to_fa($ad_table->date_publish2); 
                                }
                                ?></td>
                                <td colspan="2" class="">واحد اندازه گیری:  <?php
                                    if ($invoice_data) {
                                        echo $invoice_data->andazegiri;
                                    } else {
                                        echo 'کادر';
                                    }
                                    ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="1" cellpadding="1" cellspacing="1" style="width:100%; margin-top:-.5px;">
                        <tbody>
                            <tr>
                                <td class="mid" style="width: 2% !important;" >ردیف</td>
                                <td  class="mid " style="width: 30.3%;">شرح کالا یا خدمات</td>
                                <td class="mid" style="width: 5.6%;"><?php
                                    if ($invoice_data) {
                                        echo $invoice_data->number_of_card_title;
                                    } else {
                                        echo 'تعداد <br>(کادر)';
                                    }
                                    ?></td>
                                <td class="mid" style="width: 7%;">مبلغ واحد <br> (ریال)</td>
                                <td class="mid" >مبلغ کل (ریال)</td>
                                <td  class="mid" >مبلغ تخفیف(ریال)</td>
                                <?php if ($show_benfit) { ?> <td  class="mid" >مبلغ کارمزد (ریال)</td> <?php } ?>
                                <td class="mid">مبلغ کل پس از تخفیف<br> <?php
                                    if ($show_benfit) {
                                        echo " و کارمزد";
                                    }
                                    ?>(ریال)</td> 
                                <td class="mid">جمع مالیات و عوارض<br> (ریال)</td> 
                                <td class="mid mid " style="width:9%;">جمع مبلغ کل بعلاوه جمع مالیات و عوارض(ریال)</td>
                            </tr>
                            <?php 
                            $i = 2;
                            ?>
                            <tr>
                                <td colspan="1" class="mid">1</td>
                                <td ><?php echo $ad_table->title; if($ad_table->date_publish2){  echo "- نوبت اول"; } ?></td>
                                <td class="mid"><?php if($ad_table->date_publish2){ echo $ad_table->box_qty/2;}else{ echo $ad_table->box_qty; }  ?></td>
                                <td class="mid"><?php echo number_format($ad_table->box_price); ?></td>
                                <td class="mid"><?php if($ad_table->date_publish2){ echo number_format($ad_table->total_price/2, 0);}else{ echo number_format($ad_table->total_price, 0); }   ?></td>
                                <td class="mid">&nbsp;</td>
                                <?php if ($show_benfit) { ?> <td  class="mid benefit" ></td> <?php } ?>
                                <td class="mid">

                                    
                                    
                                    <?php
                                    $benfit = ($show_benfit) ? $ad_table->in_amount - $ad_table->benefit_price : $ad_table->in_amount;
                                    if($ad_table->date_publish2) {
                                        
                                        echo number_format($benfit/2, 0); 

                                    }else{
                                        echo number_format($benfit, 0); 

                                    } ?>
                                </td>
                                <td class="mid ccc4">

                                    <?php
                                    //VAT ::

                                    $vat_pric = 0;
                                    if ($ad_table->vat  ) {

                                        
                                        $vat_pric = $ad_table->in_amount * $vat_percent;
                                        echo number_format((int) $vat_pric);
                                    } else {
                                        echo "0";
                                    }  
                                    $final_pp  = ($show_benfit) ? $ad_table->in_amount - $ad_table->benefit_price + $vat_pric : $ad_table->in_amount + $vat_pric;

                                    ?>

                                </td>
                                <td class="mid"><?php
                                if($ad_table->date_publish2) {
                                    echo number_format($final_pp/2, 0);
                                }else{
                                    echo number_format($final_pp, 0);
                                } ?></td>
                                
                            </tr>

                            <?php if($ad_table->date_publish2){
                                $i = 3;
                                ?>


                                <tr>
                                <td colspan="1" class="mid">2</td>
                                <td ><?php echo $ad_table->title; if($ad_table->date_publish2){  echo "- نوبت دوم"; } ?></td>
                                <td class="mid"><?php  if($ad_table->date_publish2){ echo $ad_table->box_qty/2;}else{ echo $ad_table->box_qty; } ?></td>
                                <td class="mid"><?php echo number_format($ad_table->box_price); ?></td>
                                <td class="mid"><?php if($ad_table->date_publish2){ echo number_format($ad_table->total_price/2, 0);}else{ echo number_format($ad_table->total_price, 0); }   ?></td>
                                <td class="mid">&nbsp;</td>
                                <?php if ($show_benfit) { ?> <td  class="mid benefit" ></td> <?php } ?>
                                <td class="mid">

                                    
                                    
                                    <?php
                                    $benfit = ($show_benfit) ? $ad_table->in_amount - $ad_table->benefit_price : $ad_table->in_amount;
                                    if($ad_table->date_publish2) {
                                        
                                        echo number_format($benfit/2, 0); 

                                    }else{
                                        echo number_format($benfit, 0); 

                                    } ?>
                                </td>
                                <td class="mid ccc4">

                                    <?php
                                    //VAT ::

                                    $vat_pric = 0;
                                    if ($ad_table->vat  ) {

                                        
                                        $vat_pric = $ad_table->in_amount * $vat_percent;
                                        echo number_format((int) $vat_pric);
                                    } else {
                                        echo "0";
                                    }

                                    $final_pp  = ($show_benfit) ? $ad_table->in_amount - $ad_table->benefit_price + $vat_pric : $ad_table->in_amount + $vat_pric;
                                    ?>

                                </td>
                                <td class="mid"><?php
                                if($ad_table->date_publish2) {
                                    echo number_format($final_pp/2, 0);
                                }else{
                                    echo number_format($final_pp, 0);
                                } ?></td>
                            </tr>

                            <?php } ?>



                            <?php if($ad_table->fix_discount){
                               
                                ?>


                                <tr>
                                <td colspan="1" class="mid"><?= $i ?></td>
                                <td >تخفیف ثابت ریالی</td>
                                <td class="mid"></td>
                                <td class="mid"></td>
                                <td class="mid"></td>
                                <td class="mid"><?= number_format($ad_table->fix_discount) ?></td>
                                <?php if ($show_benfit) { ?> <td  class="mid benefit" ></td> <?php } ?>
                                <td class="mid">
                                </td>
                                <td class="mid ccc4">

                                    

                                </td>
                                <td class="mid"></td>
                            </tr>

                            <?php } ?>


                            <tr>
                                <?php
                                $remian = $ad_table->total_price;
                                
                                $ahd_table = common\models\AdHasDiscount::find()->where(['ad_id' => $ad_table->id])->innerJoinWith('discount')->orderBy(['discount_item.type' => SORT_ASC, 'discount_item.id' => SORT_ASC])->all();

                                //echo count($ahd_table);
                                $c = 2;
                                if ($show_benfit)
                                    $c = 3;
                                ?>
                                <?php if ($ahd_table) {
                                    ?>
                                    <?php
                                    foreach ($ahd_table as $a) {

                                        if ((!$show_benfit and $a->discount->type == 1) or ($ad_table->naghdi_etebari == 4 and $a->discount->type == 1))
                                            continue;
                                        ?>
                                        <td colspan="1" class="mid"><?php echo $i; ?></td>

                                        <td ><?php
                                            echo $a->discount->name . " ";
                                            if ($a->discount->type == 1) {
                                                echo $a->discount_rate . " %";
                                            }
                                            ?></td>
                                        <td class="mid">&nbsp;</td>
                                        <td class="mid">&nbsp;</td>
                                        <td class="mid">&nbsp;</td>

                                        <?php if ($a->discount->type == 1) { ?>
                                            <td class="mid hhh"></td>
                                            <?php if ($show_benfit) { ?> <td  class="mid ben" ><?php echo number_format(($a->discount_rate / 100) * $ad_table->in_amount,0); ?></td> <?php } ?>
                                        <?php } else { ?>
                                            <td class="mid ggg"><?php
                                                if ($ad_table->pelekani) {

                                                    $pelekani_discount = ($a->discount_rate / 100) * $remian;
                                                    //echo ;
                                                    echo number_format($pelekani_discount);
                                                    $remian -= $pelekani_discount;
                                                } else {

                                                    echo number_format($a->discount_price);
                                                }
                                                ?></td>
                                            <?php if ($show_benfit) { ?> <td  class="mid" ></td> <?php } ?>
                                        <?php } ?>


                                        <td class="mid">&nbsp;</td>
                                        <td class="mid">&nbsp;</td>
                                        <td class="mid">&nbsp;</td>
                                    </tr>
                                    <?php
                                    $c++;
                                    $i++;
                                }
                            }
                            ?>

                            <?php if ($show_benfit and 2 > 3) { ?>
                                <tr>
                                    <td colspan="1" class="mid"><?= $i ?></td>
                                    <td >کارمزد</td>
                                    <td class="mid"></td>
                                    <td class="mid"></td>
                                    <td class="mid"></td>
                                    <td class="mid"></td>
                                    <td class="mid benefit"><?php echo number_format($ad_table->benefit_price,0); ?></td>
                                    <td class="mid"></td>
                                    <td class="mid"></td>
                                    <td class="mid"></td>
                                </tr>

                            <?php } ?>


                            <?php
                            if ($i < 7) {

                                for (; $i < 7; $i++) {
                                    ?>


                                    <tr>
                                        <td colspan="1" class="mid"><?= $i ?></td>
                                        <td ></td>
                                        <td class="mid"></td>
                                        <td class="mid"></td>
                                        <td class="mid"></td>
                                        <td class="mid"></td>
                                        <td class="mid"></td>
                                        <td class="mid"></td>
                                        <td class="mid"></td>
                                        <?php if ($show_benfit) { ?> <td class="mid"></td> <?php } ?>
                                    </tr>


                                    <?php
                                }
                            }
                            ?>


                            <tr class="big_row">
                                <td colspan="4" class="mid">&nbsp;جمع کل</td>
                                <td class="mid ccc1" ><?php echo number_format((int) $ad_table->total_price); ?></td>
                                <td class="mid ccc2"><?php echo number_format($ad_table->total_price - $ad_table->in_amount); ?></td>
                                <?php if ($show_benfit) { ?> <td  class="mid ben" ><?php echo number_format($ad_table->benefit_price,0); ?></td> <?php } ?>

                                <td class="mid ccc3"><?php echo number_format(($show_benfit) ? $ad_table->in_amount - $ad_table->benefit_price : $ad_table->in_amount); ?></td>
                                <td class="mid ccc4">

                                    <?php
                                    //VAT ::

                                    $vat_pric = 0;
                                    if ($ad_table->vat) {
                                        $vat_pric = $ad_table->in_amount * $vat_percent;
                                        echo number_format((int) $vat_pric);
                                    } else {
                                        echo "0";
                                    }
                                    ?>

                                </td>
                                <?php $sum = number_format(($show_benfit) ? $ad_table->in_amount - $ad_table->benefit_price + $vat_pric : $ad_table->in_amount + ($vat_pric)); ?>
                                <td  colspan="1" class="mid"><?php echo $sum; ?></td>

                            </tr>
                            <tr>

                                <td colspan="2">شرایط و نحوه فروش  <input type="checkbox" disabled="" name="" <?php
                                    if ($ad_table->naghdi_etebari == 1) {
                                        echo "checked";
                                    }
                                    ?> value=""> نقدی
                                    <input type="checkbox" name="" value="" disabled="" <?php
                                    if ($ad_table->naghdi_etebari == 2) {
                                        echo "checked";
                                    }
                                    ?> > غیر نقدی</td>
                                <td colspan="8" class="mid"><?php
                                    if ($data->vat ) {

                                        

                                        $vat_pric = $data->in_amount * $vat_percent;
                                    }


                                    echo common\models\Ad::convert_number(str_replace(",", "", $sum)) . " ریال"
                                    ?></td>

                            </tr>
                            <tr>
                                <td colspan="2" >توضیحات: <?= $ad_table->info ?></td>
                                <td colspan="8" class="mid">

                                    <?php
                                    if ($invoice_data) {
                                        echo $invoice_data->account_number;
                                    } else {
                                        echo 'لطفا مبلغ در وجه شرکت همشهری به شماره حساب 82181030003831 بانک سامان شعبه جام جم صادر گردد.';
                                    }
                                    ?>

                                </td>

                            </tr>
                            <tr class="sign-row">
                                <td colspan="2" class="mid">مهر و امضا فروشنده</td>
                                <td colspan="1" class="mid">کد شناسه: <?php echo $ad_table->user->code_kargozar; ?></td>
                                <td colspan="2" class="mid">مهر و امضا خریدار</td>
                                <td colspan="5" class="mid">
                                    <?php
                                    if ($invoice_data) {
                                        echo $invoice_data->shaba;
                                    } else {
                                        echo 'شماره شبا 400560082181003000383001';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>





                </div>

            </div>


        </div>

    </body>
    <div style="text-align: right; margin-right: 10%;"> 
        <?php
        if ($_GET['type'] == 1) {
            echo "فاکتور مشتری";
        }
        if ($_GET['type'] == 2) {
            echo "فاکتور کارگزار";
        }
        if ($_GET['type'] == 3) {
            echo "فاکتور حساب داری";
        }
        ?>
    </div>

<?php } ?>
<script>
    alert('فاکتور شماره <?= $ad_table->custom_id ?> در حال چاپ شدن است از داشتن کاغذ مطمئن شوید ٫ همین طور خدا اسراف کاران را دوست ندارد/این فاکتور برای بار <?= $ad_table->print_count ?> ام است که چاپ می شود/لطفا  شماره حساب و شماره صفحه را کنترل کنید..');
    // window.print();
</script>
<?php exit(); ?>