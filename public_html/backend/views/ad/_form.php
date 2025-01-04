

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    #dataa{
        display:none;
    }
</style>



<link href="/backend/web/upload_js/jquery.dm-uploader.min.css" rel="stylesheet">
<div class="container-scroller">

    <div class="container-fluid page-body-wrapper">

        <div class="main-panel">        
            <div class="content-wrapper">


                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <?php $form = ActiveForm::begin(); ?>




                            <?= $form->field($model, 'resseler_id')->textInput([]) ?>
                            
                             
                            <?= $form->field($model, 'cash')->textInput([]) ?>
                            
                            <?= $form->field($model, 'customer_id')->textInput([]) ?>
                            
                             <?= $form->field($model, 'info')->textArea([]) ?>

                            <?= $form->field($model, 'custom_id')->textInput([]) ?>

                            <?= $form->field($model, 'inner_page_info')->textInput([]) ?>





                            <!-- File item template -->


                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ثبت', ['class' => $model->isNewRecord ? 'btn btn-primary mr-2' : 'btn btn-primary mr-2', 'id' => 'upfiles']) ?>
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




<script>
    editor = CKEDITOR.replace('ad-info', {
        extraPlugins: 'lineutils,widget,image2',
        fullPage: true,
        allowedContent: true,
        removeFormatAttributes: "",
        height: '200px',
        toolbar: [
            {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
            {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
            {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
            {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
            '/',
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
            '/',
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']},
            {name: 'others', items: ['-']},
            {name: 'about', items: ['About']}
        ]


                // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });
</script>