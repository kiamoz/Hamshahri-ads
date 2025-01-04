<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
   $shipping_methods= ArrayHelper::map(\common\models\Product_shipping_method::find()->all(), 'id','name');
                                   
?>

<div class="order-form">

    <div class="col-md-3" style="float: right">
    <?php $form = ActiveForm::begin(); ?>

    <?php
    
    echo $form->field($model, 'status')->widget(Select2::classname(), [
    'data' => common\models\Order::status_text,
    'language' => 'de',
  
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
    
    ?>
          
        <?= $form->field($model, 'ship_code')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'payment_id')->radioList( common\models\Order::payment ) ?>
      <?= $form->field($model, 'shipping_method_id')->radioList( $shipping_methods ) ?>
        
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
                          
 
 
    
   
    
 
  
    

    

    <?php ActiveForm::end(); ?>

</div>
