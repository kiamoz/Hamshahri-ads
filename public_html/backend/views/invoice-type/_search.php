<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InvoiceType_serach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ad_type') ?>

    <?= $form->field($model, 'account_number') ?>

    <?= $form->field($model, 'number_of_card_title') ?>

    <?= $form->field($model, 'pages') ?>

    <?php // echo $form->field($model, 'andazegiri') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
