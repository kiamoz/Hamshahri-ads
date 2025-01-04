<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BankBalance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-balance-form">

    <?php $form = ActiveForm::begin(); 
    
    
    $today = common\models\Persian::convert_date_to_fa(date("Y-m-d"));
    $model->date = $today;
    
    ?>

    <?= $form->field($model, 'cash')->textInput(['maxlength' => true,'class'=>'maskm']) ?>

    <?= $form->field($model, 'cheque')->textInput(['maxlength' => true,'class'=>'maskm']) ?>

    <?= $form->field($model, 'date')->textInput(['class'=>'dd-date']) ?>

    <div class="form-group">
        <?= Html::submitButton('ثبت', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
