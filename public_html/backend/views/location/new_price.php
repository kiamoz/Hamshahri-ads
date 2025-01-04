<?php
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'ساخت قیمت برای مکان';
/* @var $this yii\web\View */
/* @var $model app\models\location */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="location-create">

    <h1><?= Html::encode($this->title) ?></h1>

   


<div class="location-form">

    <?php $form = ActiveForm::begin(); ?>
 
    
    <?PHP 

$b  = \common\models\location::find()->all();
$date = array();
foreach( $b as $Category){
    
     $state_name = common\models\State::find()
                    ->where('id='.$Category->state_id)->One()->name;
           
            $data[$Category->id] = '('.$state_name.'('.$Category->name;

} 

$b  = \common\models\shipping_method::find()->all();
$date = array();
foreach( $b as $Category){
    
    
           
            $data2[$Category->id] = $Category->name;

} 


echo $form->field($model, 'location_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['placeholder' => 'یک استان انتخاب کنید'],
    'pluginOptions' => [
    'allowClear' => true
    ],
    
]);
echo $form->field($model, 'shipping_id')->widget(Select2::classname(), [
    'data' => $data2,
    'options' => ['placeholder' => 'یک استان انتخاب کنید'],
    'pluginOptions' => [
    'allowClear' => true
    ],
    
]);


?>
    
  <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'extra_price')->textInput(['maxlength' => true]) ?>
   	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>