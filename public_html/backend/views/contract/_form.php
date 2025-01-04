<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Contract */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="contract-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'benefit_rate')->textInput() ?>

   

    <?= $form->field($model, 'contract_number')->textInput() ?>
     <?php
    $items = array();
    $items = ['1' => 'فعال', '0' => 'غیرفعال'];


    echo $form->field($model, 'status')
            ->dropDownList(
                    $items, // Flat array ('id'=>'label')
                    ['prompt' => '']    // options
    );
    ?>

    <div class="form-group">
        <?= Html::submitButton('ثبت', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
