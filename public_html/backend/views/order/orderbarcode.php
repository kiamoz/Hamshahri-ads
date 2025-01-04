<?php

use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Order;
use common\models\Product;
use common\models\Price;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

$site_base = dirname(dirname(dirname(dirname(__FILE__))));
?>
<style>
    .container {
        width: 100% !important;
    }
</style>
<div class="panel">
<div class=" panel-body">
<div class="order-form oredr_barcode_hide col-lg-8" >
    <div>
        <div style=" width: 100%">
            <div class="area-title bdr">
            </div>
            <div class="table-area" style="border: 1px solid #abb;direction: rtl;">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" style="width: 100%">
                        <thead>

                            <tr class="c-head">
                                <th style="padding: 5px;border: 1px solid #abb;font-size: 12px;font-family: tahoma;width: 10%;">تصویر </th>
                                <th style="padding: 5px;border: 1px solid #abb;font-size: 12px;font-family: tahoma;width: 30%;">نام محصول</th>
                                <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">تعداد</th>
                                <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">قیمت</th>
                                <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">مجموع</th>
                                <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">حذف</th>
                            </tr>
                        </thead>
                        <?php echo Order::get_cart_items_html_backend($usr_id); ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class=" col-lg-4">
    <div class="user_name_order">
        <?php
        $url = \yii\helpers\Url::to(['/product/userlist']);


        echo Select2::widget([
            'id' => 'user_name_order',
            'name' => 'user_name',
            'initValueText' => '', // set the initial display text
            'options' => ['placeholder' => 'جستجو اطلاعات کاربر'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'منتظر باشید . . . '; }"),
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
        ]);
        ?> 
        <br>
        <div class="alert_box"></div>
        <input class="gender mrs" name="gender" value="1" type="radio" checked=""><span>خانم</span>
        <input class="gender mr" name="gender" value="0" type="radio"><span>آقای</span>
        
        <input type="text" class="new_user_name" placeholder="نام و نام خانوادگی  ">
        <br>
        <input type="text" class="new_user_phone" placeholder="شماره همراه  ">
        <br>
        <input type="text" class="new_user_address" placeholder="آدرس  ">
        <br>
        <input type="text" class="new_user_email" placeholder="آدرس ایمیل  ">
        <br>
        <button class="new_form_btn btn btn-xs btn-danger"> فرم جدید</button>
        <button class="new_user_btn btn btn-xs btn-info">ثبت نام </button>

        <a id="user_history" href="" target="_blank">
            <button class="btn btn-primary btn-xs user_hist">تاریخچه مشتری</button>
        </a>
        
    </div>
    <div>
        <br>
        <label class="p_avl">موجودی : </label> <span class="avl_box"></span>
        <input type="text" class="tx_bar" name="product_id" autofocus placeholder="جستجوی بارکد">
        
        <div class="col-md-12 image_box">
            <img src="no_image.PNG" class="img_append" width="300">
        </div>

        

        <div class="col-md-6">
            <fieldset>
                <legend>  نحوه تسویه </legend>
                <input type="radio" name="tasvie" value="0"> نقدی<br>
                <input type="radio" name="tasvie" value="1" checked="check"> کارت خوان<br>
                <input type="radio" name="tasvie" value="2"> کارت به کارت<br>
                <input type="radio" name="tasvie" value="3"> کارت خوان سیار<br>
                <input type="radio" name="tasvie" value="4"> امانی<br>

            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend> نوع خرید : </legend>
                <input type="radio" name="forosh"  value="0" checked="check"> حضوری<br>
                <input type="radio" name="forosh"  value="1"> ارسال<br>

            </fieldset>
        </div>
        <div class="col-md-12 off_box">
            <fieldset>
                <legend> تخفیف </legend>
                <div class="input-group">
                    <input value="0" type="radio" name="takhfif">درصد
                    <input value="1" type="radio" name="takhfif">عددی
                    <input type="text" class="form-control" value="" name="num">
                    
                </div>
                

            </fieldset>
        </div>
        <div class="col-md-12 button_box">
            <br>
            <div class="msg_box"></div>
            <br><br>
            <a>
                <button class="submit_order btn btn-danger">ثبت خرید </button>
            </a>   
            <button id="reload_me" class="btn btn-danger">رفرش کن </button>
            <a class="print_f2" target="_blank" href=""> 
                <button class="print btn btn-info xx">چاپ فاکتور  <i class="glyph-icon icon-print"></i></button>
            </a>
            <br><br>
        </div>
    </div>
</div>
</div></div>