<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    

   

 
    <?= $form->field($model, 'model_id')->textInput() ?>
    <?php
    
    $user = common\models\User::findOne($model->user_id);

   
            ?>
   <?=
         $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' =>  \yii\helpers\ArrayHelper::map(common\models\User::find()->where(['lvl'=>$user->lvl])->all(), 'id', 'name_and_fam'),
            'options' => ['placeholder' => 'انتخاب کنید'],
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
