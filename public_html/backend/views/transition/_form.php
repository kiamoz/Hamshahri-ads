<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Transition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput(['class' => 'dd-date form-control', 'autocomplete' => 'off']) ?>
    <?= $form->field($model, 'payment_date')->textInput(['class' => 'dd-date form-control', 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'amount')->textInput(['class' => 'maskm form-control']) ?>


    <?=
    $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(common\models\User::find()->where(['type' => 8])->all(), 'id', function ($data) {
            return $data->name_and_fam . " " . $data->code_kargozar;
        }),
        'options' => ['placeholder' => 'کارگزار مشتری'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <?=
    $form->field($model, 'priority_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'انتخاب کنید', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>





    <?=
    $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => [11 => 'حواله',
            12 => 'چک', 13 => 'چک روز',
            100 => 'استفاده از کیف پول مشتری', 101 => 'استفاده از معادل ریالی تهاتر کارگزار', 15 => 'واریزی به حساب کارگزار', 5 => 'تغییر بدهی اعتباری',
            6 => 'تغییر بدهی نقدی',
            7 => 'تغییر مبلغ کیف پول', 8 => 'تغییر بدهی تهاتر',],
        'options' => ['placeholder' => 'انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'bank_id')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\common\models\Bank::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'انتخاب بانک در صورت وجود'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>



    <?= $form->field($model, 'is_eslahi')->radioList([0 => 'خیر', 1 => 'بله']) ?>






    <?= $form->field($model, 'branch')->textInput() ?>
    <?= $form->field($model, 'cheque_num')->textInput() ?>
    <?= $form->field($model, 'cheque_date')->textInput(['class' => 'dd-date form-control', 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'sanad')->textInput() ?>
    <?= $form->field($model, 'resid')->textInput() ?>


    <?= $form->field($model, 'extra_info')->textArea([]) ?>



    <div class="form-group">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
