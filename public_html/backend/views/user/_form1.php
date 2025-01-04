<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">
    <?= $form->field($model, 'name_and_fam')->textInput() ?>
    
    
 

    <?= $form->field($model, 'username')->textInput() ?>
   
  
    
        </div>
        <div class="col-lg-6">
    <?= $form->field($model, 'social_code')->textInput() ?>
   


     <?= $form->field($model, 'password')->textInput() ?>
    
    
    <?=
         $form->field($model, 'lvl')->widget(Select2::classname(), [
            'data' => \common\models\User::type_id_text,
            'options' => ['placeholder' => 'انتخاب کنید'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

    <?php
    $items=array();
    $items=['10'=>'فعال','0'=>'غیرفعال'];
    

    echo $form->field($model, 'status')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'']    // options
        );

   
?>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
