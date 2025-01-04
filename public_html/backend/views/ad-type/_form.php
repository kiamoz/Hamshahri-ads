<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\AdType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-type-form">

    <?php 
    
    $model->benefit_json = json_decode($model->benefit_json);
    $model->discount_json = json_decode($model->discount_json);
    
    
    $form = ActiveForm::begin(); ?>

    <?=
    
    
    
    $form->field($model, 'name')->textInput(['maxlength' => true]) ?>



    <?=
    $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\common\models\AdType::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    
    
    <?=
    $form->field($model, 'price_type')->widget(Select2::classname(), [
        'data' => [1=>'عادی',2=>'ثبتی',3=>'دولتی'],
        'options' => ['placeholder' => 'انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <?=
    $form->field($model, 'benefit_json')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->where(['type' => 1])->all(), 'id', 'name'),
        'options' => ['placeholder' => 'انتخاب کنید','multiple'=>true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    
     <?=
    $form->field($model, 'discount_json')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\common\models\DiscountItem::find()->where(['type' => 0])->andWhere(['>','discount',0])->all(), 'id', 'name'),
        'options' => ['placeholder' => 'انتخاب کنید','multiple'=>true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
