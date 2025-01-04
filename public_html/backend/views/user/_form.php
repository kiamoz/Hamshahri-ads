

<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

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
                        <div class="card-body" style="margin-top:20px;">

                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'name_and_fam')->textInput() ?>
                            <div class="clearfix" style="margin-top:20px;"></div>
                            <?php echo $form->field($model, 'status_p')->radioList([1 => 'حاضر', 0 => 'غایب'], ['id' => 'radiopresent']); ?>
                            <div class="clearfix" style="margin-top:40px;"></div>  
                            
                            <?php if(Yii::$app->user->identity->lvl==1){
                            echo $form->field($model, 'sub_type')->radioList([1 => 'بله', 0 => 'خیر'], ['id' => 'radiodolati']); 
                            } ?>
                            <div class="clearfix" style="margin-bottom:20px;margin-top:20px;"></div>
                            <div class="clearfix"></div>
                            <?= $form->field($model, 'karmozd')->radioList([1 => 'بله', 0 => 'خیر'], ['id' => 'karmozd']); ?>
                            <div class="clearfix" style="margin-bottom:20px;"></div>
                            <?= $form->field($model, 'username')->textInput() ?>

                            
                            
                            
                    

                            <?= $form->field($model, 'social_code')->textInput() ?>



                            <?= $form->field($model, 'password')->textInput() ?>


                            <?=
                            $form->field($model, 'lvl')->widget(Select2::classname(), [
                                'data' => \common\models\User::type_id_text,
                                'options' => ['placeholder' => 'انتخاب کنید'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>

                            <?php
                            ?>
                            <?php
                            $items = array();
                            $items = ['10' => 'فعال', '0' => 'غیرفعال'];


                            echo $form->field($model, 'status')
                                    ->dropDownList(
                                            $items, // Flat array ('id'=>'label')
                                            ['prompt' => '']    // options
                            );
                            ?>

                            <?php
                            $model->level_id = json_decode($model->level_id);

                            if (in_array(16, (array) json_decode(Yii::$app->user->identity->level_id))) {
                                echo $form->field($model, 'level_id')->checkboxList(User::access_list);
                                ?> 

                                <?php
                            }
                            ?>      


                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-primary mr-2' : 'btn btn-primary mr-2']) ?>
                            </div>


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



<style>
    .form-group.field-karmozd label{
        display:block !important;
    }
</style>
