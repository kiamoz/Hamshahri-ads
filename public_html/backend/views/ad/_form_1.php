

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container-scroller">

    <div class="container-fluid page-body-wrapper">

        <div class="main-panel">        
            <div class="content-wrapper">


                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <?php $form = ActiveForm::begin(); ?>

                            <?php
                           ?>
                            <div class="form-group">
                               
                            </div>
                           
                              <?php
                              //if ((Yii::$app->user->identity->lvl==3  or Yii::$app->user->identity->lvl==6 or Yii::$app->user->identity->lvl==2) or ($model->active_user_id==$user_id)){
                                ?>
   
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'error')->textInput() ?>                
                  <?= Html::submitButton('ارسال', ['class' => 'btn btn-danger'] ) ?>          
                            
    <?php ActiveForm::end(); ?>
<?php //} ?>
                            

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>






            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->

            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->



