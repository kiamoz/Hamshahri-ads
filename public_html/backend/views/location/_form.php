<?php
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\location */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="location-form">

    <?php $form = ActiveForm::begin(); ?>
 
    
    <?PHP 

$b  = \common\models\State::find()->all();
$date = array();
foreach( $b as $Category){
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
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price1')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'free_delivery_price')->textInput(['maxlength' => true]) ?>
    <?=
            $form->field($model, 'status')->checkbox(array('label' => ''))
            ->label('اضافه به لیست شهر خرید آنلاین');
    ?>
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
