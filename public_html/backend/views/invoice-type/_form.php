<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InvoiceType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ad_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shaba')->textInput(['maxlength' => true]) ?>





    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_of_card_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pages')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'andazegiri')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
