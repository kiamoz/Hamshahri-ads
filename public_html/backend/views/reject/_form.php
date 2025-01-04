<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reject */
/* @var $form yii\widgets\ActiveForm */
?>
<link href="/backend/web/upload_js/jquery.dm-uploader.min.css" rel="stylesheet">

<div class="reject-form">

    <?php $form = ActiveForm::begin(); ?>
<script src="../../backend/web/images/ckeditor/ckeditor.js"></script>
    

   <div class="row">
                                <script type="text/html" id="files-template">
                                    <li class="media">
                                        <div class="media-body mb-1">
                                            <p class="mb-2">
                                                <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
                                            </p>
                                            <div class="progress mb-2">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                                                     role="progressbar"
                                                     style="width: 0%" 
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <hr class="mt-1 mb-1" />
                                        </div>
                                    </li>
                                    </script>



                                    <!-- Debug item template -->
                                    <script type="text/html" id="debug-template">
                                        <li class="list-group-item text-color"><strong></strong></li>
                                        </script>



                                        <!--                        </div>-->


                                        <div class="col-md-12 col-sm-12">



                                            <!-- Our markup, the important part here! -->
                                            <div id="drag-and-drop-zone-update" class="dm-uploader p-5">
                                                <h3 class="mb-5 mt-5 text-muted">فایل‌ها را بکشید و در اینجا رها کنید …</h3>



                                                <div class="btn btn-primary btn-block mb-5">
                                                    <span>مرورگر فایل را باز کنید</span>
                                                    <input type="file" title='Click to add Files' />
                                                </div>
                                            </div><!-- /uploader -->



                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    لیست
                                                </div>



                                                <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
                                                    <li class="text-muted text-center empty">هنوز فایلی آپلود نشده است</li>
                                                </ul>
                                            </div>
                                        </div>





                                        <br>
                                        <hr>
                                        <br>



                                        <div class="col-lg-6">
                                            <?= $form->field($model, 'gallery')->textarea(['rows' => 6, 'class' => 'nonex', 'id' => 'gallery_area_update']) ?>
                                            <div id="gallery-box-update">
                                               

                                                <?php
                                                $m = explode("\n", $model->gallery);

                                                $items_arr = array();
                                                foreach ($m as $imgx) {

                                                    $imgx = trim($imgx);
                                                    if ($imgx == "") {
                                                        continue;
                                                    }
                                                    ?>
                                                    <div  class="file-preview-frame file-preview-success " id="uploaded-1494563246882" data-fileindex="-1" data-template="image"><div class="kv-file-content">
                                                            <img src="<?php echo $imgx ?>" class="kv-preview-data file-preview-image"  style="width:auto;height:160px; ">

                                                            <?php
                                                            // print_r($imgx)  ."*****";
                                                            ?>
                                                        </div><div class="file-thumbnail-footer">



                                                            <div class="file-actions ">
                                                                <div class="file-footer-buttons">
                                                                    <button type="button" class="kv-file-remove btn btn-xs btn-default removex" title="<?= $imgx ?>"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                                                                </div></div></div></div>

                                                <?php } ?>



                                            </div>




                                        </div>
                                    </div>
    <div class="clearfix"></div>
      <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
    <div class="clearfix"></div>
    <div class="form-group">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
       <script>
            editor = CKEDITOR.replace('reject-text', {
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