<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BoxMaket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-maket-form">

    <?php $form = ActiveForm::begin(); ?>

 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_nafti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_sabti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_dolati')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
