<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">
        
        <?= $form->field($model, 'social_code')->textInput() ?>
        <?= $form->field($model, 'code_eghtesadi')->textInput() ?>
        <?= $form->field($model, 'sh_gharardad')->textInput() ?>
        <?= $form->field($model, 'tarikh_gharardad')->textInput(['class' => 'example1 form-control']) ?>
        
        <?= $form->field($model, 'password')->passwordInput() ?>
       
        <?= $form->field($model, 'company_name')->textInput() ?>
        
        
        <?= $form->field($model, 'fax')->textInput() ?>
       
        
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'code_kargozar')->textInput([]) ?>
        <?= $form->field($model, 'name_and_fam')->textInput() ?>
        <?= $form->field($model, 'phone_number')->textInput() ?>
         <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'address')->textInput() ?>
         <?= $form->field($model, 'postal_code')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        
        
        <?=
        $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => \common\models\User::data_status,
            'options' => ['placeholder' => 'انتخاب کنید'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
