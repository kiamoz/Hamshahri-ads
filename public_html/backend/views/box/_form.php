<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Box */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_print')->textInput(['maxlength' => true]) ?>
    
    
    
    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price_sabti')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'price_dolati')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'price99')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price_sabti99')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'price_dolati99')->textInput(['maxlength' => true]) ?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
