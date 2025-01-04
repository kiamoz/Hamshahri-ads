<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="address-form ">


    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    

    <?PHP
    $b = \common\models\State::find()->all();
    $date = array();
    foreach ($b as $Category) {
        $data[$Category->id] = $Category->name;
    }

    echo $form->field($model, 'state_id')->widget(Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => 'یک استان انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    
    <?PHP
    $b = common\models\location::find()->all();
    $date = array();
    foreach ($b as $Category) {
        $data[$Category->id] = $Category->name;
    }

    echo $form->field($model, 'city_id')->widget(Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => 'یک شهر انتخاب کنید'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
