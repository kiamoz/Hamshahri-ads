<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

   

   
    <?= $form->field($model, 'economical_code')->textInput() ?>
    <?= $form->field($model, 'social_code')->textInput() ?>

    <?= $form->field($model, 'addres')->textInput() ?>
    
    
    
    <?=
    $form->field($model, 'state')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(common\models\State::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'استان'],
        'pluginOptions' => [ 
            'allowClear' => true  
        ],
    ]);
    ?>
    
    <?=
    $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => common\models\Customer::customer_type,
        'options' => ['placeholder' => 'حقیقی حقوقی'],
        'pluginOptions' => [ 
            'allowClear' => true  
        ],
    ]);
    ?>
    
    
<?php 



$url = \yii\helpers\Url::to(['ad/list4']); ?>

   <?=
            $form->field($model, 'city')->widget(Select2::classname(), [
                'model' => $searchModel,
                'attribute' => 'city',
                'language' => 'fa',
                'data'=>[$model->city=>common\models\location::findOne($model->city)->name],
                'initValueText' => $current_customer,
                'options' => ['placeholder' => 'نام شهر'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'لطفا صبر کنید . . . '; }"),
                    ],
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term,id:$("#customerstatus input:checked").val()}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]);
            ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

   

    <div class="clearfix"></div>
    
 
    
    <div class="clearfix"></div>
    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
