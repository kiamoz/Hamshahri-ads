<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = "ثبت آگهی  جدید";
//$online=Yii::$app->user->identity->id;
//$user= common\models\User::find()->where(['id'=>$online])->one();
//echo "credit: ".$user->credit."<br>";
//echo "saghf: ".$user->saghf_etebar."<br>";
//$sum=$user->credit+$user->saghf_etebar;
//echo $sum;
$form = ActiveForm::begin();
?>
<?php //echo Yii::$app->user->identity->id;                                                                              ?>
<link href="/backend/web/upload_js/jquery.dm-uploader.min.css" rel="stylesheet">
<script src="../../backend/web/images/ckeditor/ckeditor.js"></script>
<style>

    .text-left{
        text-align: right !important;
    }
    div#ad_type label, div#ad_type input {
        display: unset !important;
    }






    @media print {




        .form-group label,.form-group,.invoice-date,.col-md-4 {

            font-size: 13px;
            margin-bottom: 0 !important;
        }



        .container {
            width: 300px;
        }
        td {
            height: 10px !important;
            padding: 1px 10px !important;
            text-align: right !important;
            font-size: 12px;
        }

        .clear_m,#page-container table#result_list,#page-container  #page-wrapper{
            margin: 0 !important;
            padding: 0 !important;
        }
        div#page-content {
            padding: 0;
            margin: 0 !important;
        }
        .divider {
            margin: 0;
        }
        div#menu,#footer,.hide-h{
            display: none;
        }

        table#result_list {
            margin-top: 350px !important;
        }

        .form-group.field-cash_discount {
            text-align: right;
            width: 100% !important;
        }


    }

    @font-face{font-family:'IRANYekan';src:url('/IRANSansWeb(FaNum)_Light.woff2') format("woff2");font-weight:700;font-style:normal}
    input{
        font-family:'IRANYekan';
    }
    #show_code{
        display:none !important;
    }
    div#page-container {
        direction: rtl;
    }
    input#ad-date_publish,input#ad-title{


    }
    span#select2-ad-customer_id-container ,span.select2-selection.select2-selection--single{

    }
    .div_preview{
        display: flex;
        direction: rtl;
        margin-top: 35px;
    }
    input#ad-mim {
        width: 150px;
        float:right;
    }
    input#ad-id_ad {
        width: 150px;
    }
    .field-ad-id_ad {
        float: right;
    }
    .p_up{
        padding-top: 8px;
        padding-right: 3px;
    }
    #ad-id_ad,#ad-cer_no{
        display:none;
    }
    div#loading_fade {
        width: 100%;

        position: absolute;
        background: rgba(255, 255, 255, 0.71);
        z-index: 99;
        left: 0;
        text-align: center;
        padding-right: 10%;
    } 

    div#loading_fade  i{
        position: absolute;
        top: 50%;
        z-index: 100;
        color:#fff;
        text-align:center;
        font-size:40px;
    }

    ٫loading_fade{
        display: none;
    }
    td {
        height: 20px;
        width: 60px;
    }
    td {
        border: solid;
    }

    table{
        margin-bottom: 10px;
    }
    #div_ad-num_full_page{
        display: none;
    }

    select#sel_2,span.select2.select2-container.select2-container--default.select2-container--below.select2-container--focus {
        width: 100% !important;
    }

    .div_preview{
        display: none;
    }

    .select2-container--default {
        width: 100% !important;
    }
    span#select2-sel_2-container {
        font-size: 20px;
    }
</style>

<?php
?>
<div class="content-box pad25A">
    <div class="row">
        <div class="col-sm-3 hide-h">
            <div class="dummy-logo">
                لوگوی شرکت
            </div>
            <address class="invoice-address">
                آدرس شرکت
                <br>
                ۰۲۱-۲۲۲-۲۲۲
                <br>

            </address>
        </div>
        <?php //echo Yii::$app->user->identity->id;   ?>
        <div class="col-sm-6 float-right text-right hide-h" >
            <h4 class="invoice-title">صورت حساب</h4>


            <?php
            $user = Yii::$app->user->identity->id;
            $sub_type = Yii::$app->user->identity->sub_type;
            ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['maxlength' => true, 'value' => $user, 'id' => 'user_online'])->label('') ?>
            <?= $form->field($model, 'ad_id')->hiddenInput(['maxlength' => true, 'value' => $model->id])->label('') ?>
            <?= $form->field($model, 'constt')->hiddenInput(['maxlength' => true, 'value' => $sub_type, 'id' => 'sub_type'])->label('') ?>



        </div> 
    </div>
    شماره فاکتور : <b ><?= $model->custom_id ?></b>
    <br>شماره  جهت پشتیبانی نرم افزار <b id="ad_ID"><?= $model->id ?></b>
    <div style=' border: 1px solid black; padding:5%; display:none;' name="edit" id="edit"><?php echo $_GET['id']; ?></div>
    <div class="divider"></div>
    <div class="invoice-date mrg20B"><?= \common\models\Persian::convert_date_to_fa(date("Y-m-d")) ?></div>
    <div class="divider"></div>
    <div class="row">
        <div>

            <div class="col-md-4"> 
                <?php
                $model->takhfif_tarhim_tasliyat = 0;
                ?>

                <?= $form->field($model, 'naghdi_etebari')->radioList(common\models\Ad::pay_type, ['id' => 'naghdi_etebari']); ?>


                <?php
                $a_h_d = common\models\AdHasDiscount::find()->where(['ad_id' => $model->id, 'is_benefit' => 1])->all();
                foreach ($a_h_d as $bnf) {

                    //echo $bnf->discount_id."<br>";
                    if ($bnf->discount_id == 122)
                        $model->takhfif_avalin_h_adi = 2;


                    if ($bnf->discount_id == 124)
                        $model->takhfif_avalin_h_adi = 3;


                    if ($bnf->discount_id == 126)
                        $model->cash_discount = 2;
                }



                $ad_id_disc = $_GET['id'];
                if (!$ad_id_disc)
                    $ad_id_disc = $model->id;


                $discount_1 = array();
                $discount_2 = array();
                $discount_3 = array();
                $data_disc_arr_2 = [];
                $discount = [];
                $a_h_d = common\models\AdHasDiscount::find()->where(['ad_id' => $ad_id_disc, 'is_benefit' => null])->all();

                $a_h_d_benefit = common\models\AdHasDiscount::find()->where(['ad_id' => $ad_id_disc, 'is_benefit' => 1])->all();
                
               // echo \common\models\DiscountItem::find()->where(['not like', 'name', '%'])->where(['>', 'discount', 0])->andWhere(['cat_id' => 1])->createCommand()->getRawSql();

                $data_disc_arr_ = yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->where(['like', 'name', '%'])->andWhere(['>', 'discount', 0])->andWhere(['cat_id' => 1])->orderBy(['id'=>SORT_DESC])->all(), 'id', 'name');

                $data_disc_arr_2 = yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->where(['>', 'discount', 0])->andWhere(['cat_id' => 2])->orderBy(['id'=>SORT_DESC])->all(), 'id', 'name');
                $data_disc_arr_3 = yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->andWhere(['type' => 1])->orderBy(['id'=>SORT_DESC])->all(), 'id', 'name');

                foreach ($a_h_d as $a) {
                    
                    //print_r($a);
                    //echo "<hr>";
                    
                    array_push($discount, $a->discount_id);

                    if ($a->discount_id == 121)
                        $model->takhfif_avalin_h_adi = 1;


                    if ($a->discount_id == 125)
                        $model->cash_discount = 1;



                    if ($a->discount_level == 2) {

                        if ($a->custom_name) {

                            array_push($discount_2, $a->custom_name);

                            array_push($data_disc_arr_2, [$a->custom_name => $a->custom_name]);
                        } else {
                            array_push($discount_2, $a->discount_id);
                        }
                    } else {
                        array_push($discount_1, $a->discount_id);
                    }
                }

                foreach ((array) $a_h_d_benefit as $a) {


                    array_push($discount_3, $a->discount_id);
                }


                //echo $model->takhfif_avalin_h_adi."*";
                ?>
                <div class="hide-h">
                    <?= $form->field($model, 'takhfif_avalin_h_adi')->radioList([1 => 'مشتری ۱۰٪', 2 => 'کارگزار ۱۰٪', 3 => 'هر دو پنج درصد', -1 => 'هیچ کدام'], ['id' => 'takhfif_avalin_h_adi']); ?>
                </div>
                <div class="hide-h">

                </div>
                

            </div>
            <div class="col-md-4"> 
                <div class="hide-h">
                    <?= $form->field($model, 'takhfif_tarhim_tasliyat')->radioList([1 => 'فعال', 0 => 'غیر فعال'], ['id' => 'takhfif_tarhim_tasliyat']); ?>
                </div>
                <?= $form->field($model, 'pelekani')->radioList([1 => 'بله', 0 => 'خیر'], ['id' => 'pelekani']); ?>

            </div>
            <div class="col-md-4 hide-h"> 
                <?php
                //echo $model->vat;
                ?>
                <?= $form->field($model, 'vat')->radioList([1 => 'بله', 0 => 'خیر'], ['id' => 'vat']); ?>
                <?= $form->field($model, 'first_page')->radioList([1 => 'آگهی در صفحه اول است', 0 => 'آگهی در صفحه اول نیست'], ['id' => 'first_page']); ?>
                <?=             $form->field($model, 'fix_discount')->textInput(['maxlength' => true, 'autocomplete' => 'off']);
 ?>
                <div class="field-ad-id_ad p_up" id="code_kargah"><label class="control-label" for="ad-fix_discount">کد کارگاهی</label></div> <?= $form->field($model, 'code_kargah')->textInput(['value' => $model->cer_no, 'autocomplete' => 'off'])->input('code_kargah', ['placeholder' => "کد کارگاهی را در صورت نیاز وارد کنید"])->label(false) ?>
                
            </div>
        </div>
    </div>
    <div class="row" style="">
        <div class="divider"></div>
        <div class="col-md-6"> 
            <style>
                .select2s{
                    width: 500px;
                }
                span.select2.select2-container.select2-container--krajee{
                    margin-top: 7px;
                }
                span.select2-selection.select2-selection--multiple , .select2-results__option{
                    text-align: right;
                    direction: rtl;
                }
                .select2-container .select2-search--inline{
                    float: right;
                    width: auto;
                }
                .select2-container--krajee .select2-selection--multiple .select2-selection__choice{
                    float: right;
                    margin: 5px 4px 0 6px;
                }

                .s2-to-tree li.select2-results__option.non-leaf.opened .expand-collapse:before {
                    content: "-" !important;
                }
            </style>
            <select id="sel_2" name="Ad[ad_type]" style="width:8em">
                <?php
                foreach (\common\models\AdType::find()->all() as $adt) {
                    ?>
                    <option value="<?= $adt->id ?>" data-pup="<?= $adt->parent_id ?>"



                            class="<?php
                            if ($adt->parent_id) {
                                echo "l2;";
                            } else {
                                echo "l1";
                            }
                            ?> <?php
                            if (common\models\AdType::find()->where(['parent_id' => $adt->id])->count()) {
                                echo 'non-leaf';
                            }
                            ?>"
                            <?php
                            if ($model->ad_type == $adt->id) {
                                echo "selected";
                                // $selected 
                            }
                            ?>


                            <?php
                            if ($adt->id == 12 and!$model->ad_type) {
                                echo "selected";
                            }
                            ?>

                            ><?= $adt->name ?></option>
                            <?php
                        }
                        ?>

            </select>



            <?php
//    echo $form->field($model, 'id_ad', [
//        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">میم/الف</span>{input}</div>',
//    ]);

            $model->cer_no = null;
            $model->id_ad = null;
            ?>

            <div class="field-ad-id_ad p_up" id="add">شناسه آگهی</div><?= $form->field($model, 'id_ad')->textInput(['value' => $model->id_ad, 'autocomplete' => 'off'])->input('id_ad')->label(false) ?><div class="field-ad-id_ad p_up" id="mimm">م/الف</div><?= $form->field($model, 'mim')->textInput(['value' => $model->mim, 'autocomplete' => 'off'])->input('id_ad')->label(false) ?>

            <div class="field-ad-id_ad p_up" id="certificate">شماره مجوز</div> <?= $form->field($model, 'cer_no')->textInput(['value' => $model->cer_no, 'autocomplete' => 'off'])->input('cer_no', ['placeholder' => "شماره مجوز"])->label(false) ?>


            <div class="clearfix"></div>
            <?php
            if (Yii::$app->user->identity->lvl == 2) {

                $list_arrr__ = yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['lvl' => 8])->all(), 'id', 'name_and_fam');
                //echo \common\models\CustomerDuration::find()->where(['kargozar_id' => Yii::$app->user->identity->id])->createCommand()->getRawSql();
                ?>



                <?=
                $form->field($model, 'resseler_id')->widget(Select2::classname(), [
                    'data' => $list_arrr__,
                    'options' => ['placeholder' => 'انتخاب کنید'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            }
            ?>

        </div>

        <div class="col-md-3" style="margin-bottom:0;">
            <div id="inc_khareji" style="">

                <br>

                <?= $form->field($model, 'fee_Increase')->radioList([0 => 'صفر', 10 => '10%', 30 => '30%', 50 => '50%', 100 => '100%',], ['id' => 'takhfif_avalin_h_adi']); ?>




            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-3">

            <?php
            $list_arr__ = yii\helpers\ArrayHelper::map(\common\models\Customer::find()->where(['owner_id' => Yii::$app->user->identity->id])->all(), 'id', 'name');
//echo \common\models\CustomerDuration::find()->where(['kargozar_id' => Yii::$app->user->identity->id])->createCommand()->getRawSql();

            if ($_GET['id']) {

                $add = common\models\Ad::find(['id' => $_GET['id']])->one();

                $user = common\models\Customer::findOne(['id' => $model->customer_id]);
                //echo $user->name;;
                $list_arr__[$model->customer_id] = $user->name;
            }
            ?>
            <?php
            if ($model->customer_id)
                $current_customer = common\models\Customer::findOne($model->customer_id)->name //  echo $model->customer_id."*";
                ?>  

            <?php $url = \yii\helpers\Url::to(['/ad/list3', 'id' => 0]); ?>
            <?=
            $form->field($model, 'customer_id')->widget(Select2::classname(), [
                'model' => $searchModel,
                'attribute' => 'customer_id',
                'language' => 'fa',
                'initValueText' => $current_customer,
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
                        'data' => new JsExpression('function(params) { return {q:params.term,id:$("#customerstatus input:checked").val()}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]);
            ?>


        </div>
        <div class="col-md-3">

            <div style=""></div>
            <?= $form->field($model, 'title')->textarea(['maxlength' => true, 'value' => $model->title, 'autocomplete' => 'off','rows'=>6]) ?>
        </div>
        <div class="col-md-3">

            <div style=""></div>
            <?php
            if ($model->date_publish)
                $model->date_publish = \common\models\Persian::convert_date_to_fa($model->date_publish);

            if ($model->date_publish2)
                $model->date_publish2 = \common\models\Persian::convert_date_to_fa($model->date_publish2);


            if ($model->date)
                $model->date = \common\models\Persian::convert_date_to_fa($model->date);

            echo $form->field($model, 'date_publish')->textInput(['maxlength' => true, 'autocomplete' => 'off']);
            ?><div class="hide-h" > <?php
            echo $form->field($model, 'date')->textInput(['maxlength' => true, 'autocomplete' => 'off']);
            echo $form->field($model, 'date_publish2')->textInput(['maxlength' => true, 'autocomplete' => 'off']);

            ?>
            </div>



        </div>

        <div class="col-md-3" >

            <div style="">

                <?php
                echo $form->field($model, 'contract_id')->widget(Select2::classname(), [
                    'data' => $arr,
                    'options' => ['placeholder' => ('یک قرارداد انتخاب کنید')],
                ]);
                ?>


            </div>

        </div>

        <?= $form->field($model, 'cash_discount')->radioList([1 => 'مشتری', 2 => 'کارگزار'], ['id' => 'cash_discount']); ?>

    </div>
    <div class="row">
        <div class="col-md-4" style="float:right;margin-right: 2px;margin-bottom: 24px;">
            <div  id="show_code" ></div>
        </div>
    </div>
    <div class="row">

        <!-- File item template -->
        <script type="text/html" id="files-template">
            <li class="media">
                <div class="media-body mb-1">
                    <p class="mb-2">
                        <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
                    </p>
                    <div class="progress mb-2">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                             role="progressbar"
                             style="width: 0%" 
                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <hr class="mt-1 mb-1" />
                </div>
            </li>
            </script>



            <!--                        </div>-->












            <?php // if (!$_GET['id']) {           ?>
            <div  id="discount_list" ></div>
            <div class="clearfix"> </div>



            <div class="clearfix clear_m" style="margin-bottom:80px;" > </div>
            <div class="col-md-2">
                <?php //$model->box_id = 1;           ?>
                <?php //echo $model->box_id."*";     ?>
                <?php
                $listt_box = yii\helpers\ArrayHelper::map(\common\models\Box::find()
                        //->where(['like','name','جدید'])
                        ->all(), 'id', 'name');
                if ($model->box_id) {
                    $boxx = \common\models\Box::findOne($model->box_id);
                    $listt_box[$model->box_id] = $boxx->name;
                }
                ?>
                <?=
                $form->field($model, 'box_id')->widget(Select2::classname(), [
                    'data' => $listt_box,
                    'options' => ['placeholder' => 'انتخاب کنید'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>


            <?php
            $listt_ad_in_page = \common\models\Ad::data_ad_in_page;

//echo $model->agahi_in_page."***";

            if ($model->agahi_in_page) {

                if ($model->agahi_in_page == 12) {

                    $model->ad_in_page = $model->agahi_in_page;
                    $listt_ad_in_page[$model->ad_in_page] = 'یک چهارم صفحه';
                    //echo "avl"." ".$model->ad_in_page ;
                } elseif ($model->agahi_in_page == 48) {

                    $model->ad_in_page = $model->agahi_in_page;
                    $listt_ad_in_page[$model->ad_in_page] = 'تمام صفحه';
                    //echo "sevom"." ".$model->ad_in_page ;
                } elseif ($model->agahi_in_page == 24) {

                    $model->ad_in_page = $model->agahi_in_page;
                    $listt_ad_in_page[$model->ad_in_page] = 'نیم صفحه';
                    // echo "dovom"." ".$model->ad_in_page ;
                }
            }

//                echo $listt_ad_in_page."**";
//                
            ?>
            <div class="col-md-2" style="display: none;">
                <?php
                echo $form->field($model, 'ad_in_page')->widget(Select2::classname(), [
                    'data' => $listt_ad_in_page,
                    'language' => 'de',
                    'options' => ['placeholder' => 'انتخاب کنید...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div> 

            <div class="col-md-2" id="div_ad-num_full_page">
                <?= $form->field($model, 'num_full_page')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-1">
                <p style="margin-right: 37%;
                   font-weight: bold;
                   font-size: 22px;
                   margin-top: 43%;">+</p>
            </div> 
            <div class="col-md-2"> 
                <?php
//$model->box_qty = 0;
//$model->pub_qty = 0;
                $u = \common\models\Ad::find()->where(['id' => $model->id])->one();
//echo $u->id;
                if ($u) {
                    //  echo $u->box_qty;
                    $boxx = $u->box_qty - $u->agahi_in_page;
                    $pubb = $u->pub_qty;
                } else {
                    // $boxx = '1';
                    $pubb = '';
                }
                if ($boxx == 0)
                    $boxx = null;
                ?> 
                <?= $form->field($model, 'box_qty')->textInput(['autocomplete' => 'off']) ?>

            </div>
            <div class="col-md-2">

                <?php
                $user = \common\models\Ad::find()->where(['id' => $model->id])->one();
//echo $user->pub_qty;
                ?>
                <?php //echo $model->pub_qty;    ?>
                <?= $form->field($model, 'pub_qty')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

            </div>
            <div class="hide-h">
                <div class="clearfix" style=""></div>
                <?php
//echo "disc"; print_r($data_disc_arr_);
//  echo "<hr>";
// print_r($discount_2);
// echo "<hr>";
//exit();
                ?><h3>تخفیف های پلکان اول</h3><?php
                echo Select2::widget([
                    'name' => 'ad-discount_1',
                    'id' => 'ad-discount_1',
                    'value' => $discount_1,
                    'data' => $data_disc_arr_,
                    'options' => ['multiple' => true, 'placeholder' => 'انتخاب یا ثبت کنید'],
                    'pluginOptions' => [
                        //'tags' => true,
                        'tokenSeparators' => [','],
                    //'maximumInputLength' => 10
                    ],
                ]);

                /// echo "<hr>";
                //print_r($data_disc_arr_2);
                //echo "<hr>";
                // print_r($discount_2);
                ?><h3>تخفیف های پلکان دوم</h3><?php
                echo Select2::widget([
                    'name' => 'ad-discount_2',
                    'id' => 'ad-discount_2',
                    'value' => $discount_2,
                    'data' => $data_disc_arr_2,
                    'options' => ['multiple' => true, 'placeholder' => 'انتخاب یا ثبت کنید'],
                    'pluginOptions' => [
                        // 'tags' => true,
                        'tokenSeparators' => [','],
                    //'maximumInputLength' => 10
                    ],
                ]);
                ?><h3>کارمزد های ویژه</h3><?php
                echo Select2::widget([
                    'name' => 'ad-discount_3',
                    'id' => 'ad-discount_3',
                    'value' => $discount_3,
                    'data' => $data_disc_arr_3,
                    'options' => ['multiple' => true, 'placeholder' => 'انتخاب یا ثبت کنید'],
                    'pluginOptions' => [
                        //'tags' => true,
                        'tokenSeparators' => [','],
                    //'maximumInputLength' => 10
                    ],
                ]);
                ?>



            </div>

            <div style="margin-bottom:80px;"></div>





            <div class="clearfix"></div>

            <div class="col-md-1 hide-h">
                <a>
                    <button  id ="btn_cal"  class="glyph-icon tooltip-button demo-icon icon-plus">
                    </button>
                </a>


            </div>
            <?php
            $id = $_GET['id']; // echo $id;
            $ad_table = common\models\Ad::find()->where(['id' => $id])->one();
            ?>
            <?php
            $doc_table = common\models\Document::find()->where(['ad_id' => $ad_table->copy_ad_id])->one(); // echo $doc_table->file;

            if ($ad_table->copy_ad_id) {
                ?>
                <?php
                echo "<img style='max-width:50%;' src='/" . $doc_table->file . "' >";
                ?>
            <?php } ?>
            <div class="clearfix"></div>

            <div class="clearfix"> </div>



        </div>

        <table class="table mrg20T table-hover" id="result_list">


            <div id="loading_fade">

                <div class="remove-border glyph-icon demo-icon tooltip-button icon-spin-3 icon-spin" title="" data-original-title="icon-spin-3"></div>
            </div>

            <thead>

            </thead>

            <tbody class="cart-list-inner" id="result_list">

                <?php
                $ahd = common\models\AdHasDiscount::find()->where(['ad_id' => $model->id, 'discount_level' => 1])->all();
                $discount_type2_ = common\models\AdHasDiscount::find()->where(['ad_id' => $model->id, 'discount_level' => 2])->all();
                $m_ad = common\models\Ad::findOne($model->id);
//           print_r($m_ad);
                $m_ad1 = common\models\Ad::find()->where(['id' => $model->id])->one();
//echo "*****************************************".$m_ad1->customer_id;
                $c_t = \common\models\Customer::find()->where(['id' => $m_ad1->customer_id])->one();
                ?>
                <?php if ($m_ad->in_amount != null) { ?>

                                                                                                                                                                                                                                        <!--    <tr><td colspan="3" class="">مبلغ تعرفه :</td><td colspan="3" id="sum_in"><?php echo $m_ad->total_price ?></td></tr>-->
                    <tr>

                        <td>نام تخفیف استفاده شده</td>
                        <td class="text-center">درصد افزایش اعتبار</td>
                        <td>درصد تخفیف</td>
                        <td>قیمت(ریال)</td>
                    </tr>

                    <?php if (!empty($ahd)) { ?>
                        <?php
                        foreach ($ahd as $aa) {

                            $sum_discount_1 += $aa->discount_price;
                            ?> 



                            <tr id="discount-id_17" >
                                <td><?= \common\models\DiscountItem::findOne($aa->discount_id)->name ?></td>
                                <td><?php echo $aa->inc_rate ?></td>
                                <td><?php echo $aa->discount_rate ?></td>
                                <td><?php echo $aa->discount_price ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?><?php if (empty($ahd)) { ?>
                        <tr >
                            <td> بدون تخفیف </td><td> 0 </td><td> 0 </td><td> 0 </td>
                        </tr>
                    <?php } ?>



                    <tr><td colspan="3" class="">هزینه آگهی پس از کسر تخفیف افزایش اعتبار:</td><td colspan="3" id="sum_inc"><?php echo $model->total_price - $sum_discount_1; ?></td></tr>


                    <?php if (!empty($discount_type2_)) { ?>
                        <?php
                        foreach ($discount_type2_ as $aa) {

                            $sum_discount_2 += $aa->discount_price;
                            $sum_discount_2_r += $aa->discount_rate;
                            ?> 



                            <tr id="discount-id_17" >
                                <td><?= \common\models\DiscountItem::findOne($aa->discount_id)->name . " " . $aa->custom_name; ?></td>
                                <td><?php echo $aa->inc_rate ?></td>
                                <td><?php echo $aa->discount_rate ?></td>
                                <td><?php echo $aa->discount_price ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                    <tr><td colspan="2" class="">جمع تخفیف درصدی:</td><td><?= $sum_discount_2_r ?></td><td colspan="" id="sum_inc"><?php echo $sum_discount_2; ?></td></tr>




                    <?php if ($c_t->temp_p_n == 1) $sign = "-";elseif ($c_t->temp_p_n == 2) $sign = "+"; ?>

                    <tr><td colspan="3" class=""> تعرفه افزایش/کاهش:</td><td colspan="3" id="takhfif"><?php echo $sign . $c_t->takhfif . "%" ?></td></tr>
                    <tr> 
                        <td colspan="3" class=""> تعداد کل کادر ها:</td>
                        <td id="sum_discount"><?php echo $m_ad->box_qty ?></td></tr>


                    <tr><td colspan="3" class="">درصد افزایش اعتبار:</td><td colspan="3" id="sum_inc"><?php echo $m_ad->inc_rate ?></td></tr>
                    <tr><td colspan="3" class=""> درصد کارمزد:</td><td colspan="3" id="benefit_rate"><?php echo $m_ad->benefit_rate ?></td></tr>
                    <tr><td colspan="3" class=""> مبلغ کارمزد:</td><td colspan="3" id="benefit_price"><?php echo $m_ad->benefit_price ?></td></tr>


                    <tr> <td colspan="3" class=""> جمع تخفیف:</td><td id="sum_discount"><?php echo $m_ad->discount_price ?></td></tr>
                    <tr><td colspan="3" class="">مبلغ مورد نیاز :</td><td colspan="3" id="sum_in"><?php echo $m_ad->in_amount ?></td></tr>

                <?php } ?>
            </tbody>

        </table>

        <a class="btn btn-success hide-h"  target="_blank" href="https://hamshahriads.ir/backend/web/index.php?r=ad%2Fview1&id=<?= $model->id ?>&invoice=1">پرینت</a>

        <div style="display: none;" id="table_e_v"  >


        </div>
        <?php // }                   ?>

        <div style="margin-top: 5%;">
            <!--                <button onclick="printInvoice()" class="btn btn-alt btn-hover btn-info">
                     <span>چاپ</span>
                     <i class="glyph-icon icon-print"></i>
                 </button>
 
                 <a  >
                     <button  id ="new_ad"   class="btn btn-alt btn-hover btn-success">
                         <span>ثبت آگهی</span>
                         <i class="glyph-icon icon-check"></i>
                     </button>
                 </a>-->
        </div>
    </div>

</div>

<script>

    //
    // selected_discount_all = [];
    //   
    //    
    //$('#discount_list_all input[type=radio]').change(function () {
    ////var all=1;
    //
    // $('#discount_list_all input:radio:checked').each(function () {
    // if ($(this).attr('value') == 1) {
    //     console.log('yes');
    // //console.log($(this).attr('data-id'));
    // 
    // selected_discount_all.push($(this).attr('data-id'));
    //}
    //
    //});
    //
    //
    //console.log(selected_discount_all);
    // var form_data = new FormData();
    //  
    //
    //         form_data.append("selected_discount_all", (selected_discount_all));
    //       
    //         var all = {};
    //         all['selected_discount_all'] = selected_discount_all;
    //        
    //         $.ajax({
    //             url: "https://hamshahriads.ir/site/cal_data" ,
    //             data: selected_discount_all,
    //             datatype: "json",
    //             type: "POST",
    //             success: function (data) {
    //                 //clickJStoPHPResponse(data);
    //             }
    //         });
    //  });

</script>
<script>
    editor = CKEDITOR.replace('editor1', {
        extraPlugins: 'lineutils,widget,image2',
        fullPage: true,
        allowedContent: true,
        removeFormatAttributes: "",
        height: '200px',
        toolbar: [
            {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
            {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
            {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
            {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
            '/',
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
            '/',
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']},
            {name: 'others', items: ['-']},
            {name: 'about', items: ['About']}
        ]


                // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });
</script>
