<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
?>
<style>
    img{
        max-width:200px;

    }
    .alert.alert-info {
        direction: rtl;
        text-align: justify;
    }
</style>
<div class="sitesetting-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body"> 
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'font_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label('تنظیم رنگ فونت'); ?>
        <?= $form->field($model, 'hover_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label(' تنظیم رنگ هاور '); ?>

        <?= $form->field($model, 'main_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label(' تنظیم رنگ اصلی '); ?>
        <?= $form->field($model, 'favv')->fileInput(['id' => 'file_id']) ?>
        <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->fav; ?>" >
        <br>
        <hr>
        <br>
        <?= $form->field($model, 'logoo')->fileInput(['id' => 'file_id2']) ?>
        <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->logo; ?>" >
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'is_load_all_categories')->radioList(array('1' => 'نمایش همه دسته بندیها', '0' => ' نمایش دسته بندیهای مرتبط  ')); ?>
        <?= $form->field($model, 'currency')->radioList(array('1' => 'تومان', '0' => 'ریال')); ?>



        <?= $form->field($model, 'sms_send')->radioList(array('1' => 'فعال', '0' => 'غیر فعال')); ?>
        <?= $form->field($model, 'sms_check_signup')->radioList(array('1' => 'فعال', '0' => 'غیر فعال')); ?>


        <?= $form->field($model, 'sms_user')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'sms_pass')->textInput(['maxlength' => true]) ?>

        <div class="alert alert-info">
            برای ثبت متون اس ام اس به صورت برنامه ریزی شده به جای نام شخص از @1 به جای شماره سفارش از @2 به جای ساعت آخرین آپدیت سفارش @3 به جای شماره پیگری پستی @4 به جای مبلغ  کل سفارش @5 و به جای هزینه ارسال @6 استفاده کنید 
            <br> <br>
            اگر هر یک از کادر های زیر خالی باشد در آن مرحله اس ام اسی ارسال نمی شود

        </div>
        <?= $form->field($model, 'sms_order_submit')->textInput(['maxlength' => true])->textarea() ?>
        <?= $form->field($model, 'sms_order_submit_offline')->textInput(['maxlength' => true])->textarea() ?>
        <?= $form->field($model, 'sms_order_paid')->textInput(['maxlength' => true])->textarea() ?>
        <?= $form->field($model, 'sms_order_sent')->textInput(['maxlength' => true])->textarea() ?>


        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'googleplus')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'aparat')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'credit_recommended')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'credit_recommender')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'tell')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'saat_kar')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'pagination')->textInput(['maxlength' => true])->label(' تنظیم تعداد پست محصولات در هر صفحه  '); ?>

        <?= $form->field($model, 'pagination_post')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'js_code')->textInput(['maxlength' => true])->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<script src="jscolor.js"></script>