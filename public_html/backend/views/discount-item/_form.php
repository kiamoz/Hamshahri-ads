<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\DiscountItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'cat_id')->widget(Select2::classname(), [
        'data' => \common\models\DiscountItem::discount_table,
        'options' => ['placeholder' => 'انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>



    <?= $form->field($model, 'just_discount')->radioList([0 => 'خیر', 1 => 'بله']) ?>

    <?= $form->field($model, 'type')->radioList([0 => 'تخفیف', 1 => 'کارمزد']) ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
