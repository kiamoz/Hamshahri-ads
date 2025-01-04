<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">

        </div>
        <div class="mx-auto d-flex justify-content-center col-lg-10">
            
<?php
   Yii::$app->session->setFlash('success', 'آگهی حذف شد' . $_post['id']);

//echo $m ."<br>";
?>

</div>
    <div class="form-group">
      
    </div>

    <?php ActiveForm::end(); ?>

</div>
