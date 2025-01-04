<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'resseler_id') ?>

    <?= $form->field($model, 'box_id') ?>

    <?php // echo $form->field($model, 'box_price') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'in_amount') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'date_publish') ?>

    <?php // echo $form->field($model, 'box_qty') ?>

    <?php // echo $form->field($model, 'pub_qty') ?>

    <?php // echo $form->field($model, 'date_old_ad') ?>

    <?php // echo $form->field($model, 'number_page_oldad') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'discount_rate') ?>

    <?php // echo $form->field($model, 'inc_rate') ?>

    <?php // echo $form->field($model, 'discount_price') ?>

    <?php // echo $form->field($model, 'prev_credit') ?>

    <?php // echo $form->field($model, 'price_credit') ?>

    <?php // echo $form->field($model, 'price_after_discount') ?>

    <?php // echo $form->field($model, 'avl_credit') ?>

    <?php // echo $form->field($model, 'benefit_rate') ?>

    <?php // echo $form->field($model, 'benefit_price') ?>

    <?php // echo $form->field($model, 'total_price_after_discount') ?>

    <?php // echo $form->field($model, 'info') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
