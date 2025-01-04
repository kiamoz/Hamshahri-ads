<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pack_price')->textInput(['maxlength' => true]) ?>
    
    
    <?= $model->getAttributeLabel('real_ship_show'); ?><br>
    
   
  
    
    <label class="switch">
        
        <input type="checkbox" name="Company[real_ship_show]" <?php if( $model->real_ship_show){echo 'checked="1"'; } ?> />

            <span class="slider round"></span>
    </label>

   

    <?= $form->field($model, 'daily_discount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
