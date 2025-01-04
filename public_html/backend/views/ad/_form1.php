<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $url = \yii\helpers\Url::to(['/site/list']);
    
    
    if($model->customer_id){
    $customer = \common\models\Customer::findOne($model->customer_id)->name;
    $model->date_publish = \common\models\Persian::convert_date_to_fa($model->date_publish);
    }
    

    echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
        'language' => 'en',
        'class' => 'select2',
        'initValueText' => $customer, // set the initial display text
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'please wait . . . '; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'createTag' => new JsExpression('function (params) {
    return {
      id: params.term,
      text: params.term,
      newOption: true
    }
  }'),
            'tags' => true,
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
    ]);
    ?>


    <?= $form->field($model, 'date_publish')->textInput(['maxlength' => true, 'class' => 'example1']) ?>
    
    <?=
    $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => common\models\Ad::type,
        'options' => ['placeholder' => 'انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'resseler_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'box_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'box_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'box_qty')->textInput() ?>

    <?= $form->field($model, 'pub_qty')->textInput() ?>

    <?= $form->field($model, 'date_old_ad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_page_oldad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inc_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prev_credit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_credit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_after_discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avl_credit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'benefit_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'benefit_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_price_after_discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    

    <?php ActiveForm::end(); ?>

</div>
