<?php

use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<style>
    .form-group.field-karmozd label{
        display:block !important;
    }
    .user-form{
        direction:rtl;
    }
</style>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">

        <?= $form->field($model, 'code_kargozar')->textInput() ?>
        <?= $form->field($model, 'social_code')->textInput() ?>
        <?= $form->field($model, 'code_eghtesadi')->textInput() ?>
        <?= $form->field($model, 'sh_gharardad')->textInput() ?>


        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'company_name')->textInput() ?>


        <?= $form->field($model, 'fax')->textInput() ?>






        <div class="clearfix"></div>
        <?php
//}
        ?>

    </div>
    <div class="col-lg-6">

        <?= $form->field($model, 'name_and_fam')->textInput() ?>
        <?= $form->field($model, 'phone_number')->textInput() ?>
        <?= $form->field($model, 'cell_number')->textInput() ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'address')->textInput() ?>
        <?= $form->field($model, 'addres_work')->textInput() ?>
        <?= $form->field($model, 'postal_code')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>


        <?= $form->field($model, 'benefit_override')->textInput() ?>




        <div class="clearfix"></div>
        <?php if (Yii::$app->user->identity->lvl == 1 or Yii::$app->user->identity->lvl == 9 or Yii::$app->user->identity->lvl == 2) { ?>


            <?= $form->field($model, 'prev_naghdi')->textInput() ?>



            <?= $form->field($model, 'prev_etebari')->textInput() ?>    

        <?php } ?>



        <div class="clearfix"></div>





        <div class="clearfix"></div>

        <?php
        //echo $model->tarikh_gharardad;
        if ($model->tarikh_gharardad != '0000-00-00' or $model->tarikh_gharardad != '00-00-0000')
            ;
        $tarikh = $model->tarikh_gharardad;
        ?>
        <?= $form->field($model, 'tarikh_gharardad')->textInput(['autocomplete' => 'off', 'value' => $tarikh]) ?>

        <?=
        $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => \common\models\User::data_status,
            'options' => ['placeholder' => 'انتخاب کنید'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?> 

        <?php if (Yii::$app->user->identity->lvl == 9) { ?>
            <?php
            $sum_benefit_price = 0;
            $ad_table = common\models\Ad::find()->where(['resseler_id' => $model->id])->andWhere(['is', 'pay_status', null])->all();
            foreach ($ad_table as $add) {
                $sum_benefit_price += $add->benefit_price;
            }
            ?>
            <br>
            <h4 style="margin-top: 
                30px;"><?php echo "مقدار کارمزد های وصول نشده: " . number_format($sum_benefit_price) ?></h4>

        <?php } ?>
        <?= $form->field($model, 'karmozd')->radioList([1 => 'بله', 0 => 'خیر'], ['id' => 'karmozd']); ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    jQuery(function ($) {


        $(document).ready(function () {
            document.getElementById("radioB input[type=radio]");
            if ($(this).val() == '0') {
                document.getElementById("user-saghf_etebar").style.display = 'none';
                document.getElementsByClassName("control-label")[0].style.display = 'none';
                console.log($(this).val());
            } else {
                document.getElementById("user-saghf_etebar").style.display = 'block';
                document.getElementsByClassName("control-label")[0].style.display = 'block';
            }
            $('#radioB input[type=radio]').change(function () {
                if ($(this).is(':checked') && $(this).val() == '1') {
                    document.getElementById("user-saghf_etebar").style.display = 'block';
                    document.getElementsByClassName("control-label")[0].style.display = 'block';
                    console.log($(this).val());
                } else if ($(this).is(':checked') && $(this).val() == '0') {
                    document.getElementById("user-saghf_etebar").style.display = 'none';
                    document.getElementsByClassName("control-label")[0].style.display = 'none';
                    console.log($(this).val());
                }

            });






            document.getElementById("naghdi input[type=radio]");
            if ($(this).val() == '0') {
                document.getElementById("user-saghf_etebar_naghdi").style.display = 'none';
                document.getElementsByClassName("control-label")[0].style.display = 'none';
                console.log($(this).val());
            } else {
                document.getElementById("user-saghf_etebar_naghdi").style.display = 'block';
                document.getElementsByClassName("control-label")[0].style.display = 'block';
            }
            $('#naghdi input[type=radio]').change(function () {
                if ($(this).is(':checked') && $(this).val() == '1') {
                    document.getElementById("user-saghf_etebar_naghdi").style.display = 'block';
                    document.getElementsByClassName("control-label")[0].style.display = 'block';
                    console.log($(this).val());
                } else if ($(this).is(':checked') && $(this).val() == '0') {
                    document.getElementById("user-saghf_etebar_naghdi").style.display = 'none';
                    document.getElementsByClassName("control-label")[0].style.display = 'none';
                    console.log($(this).val());
                }

            });
        });
    });




</script>
