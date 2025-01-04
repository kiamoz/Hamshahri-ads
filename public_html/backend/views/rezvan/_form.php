<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Rezvan */
/* @var $form yii\widgets\ActiveForm */
?>
<link href="/backend/web/upload_js/jquery.dm-uploader.min.css" rel="stylesheet">
<div class="rezvan-form">

    <?php $form = ActiveForm::begin(); ?>

   

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

    <?php $form->field($model, 'gallery')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
         $(function () {
             
             if($('#drag-and-drop-zone').length > 0 ){
                 
             
             function remove_from_gallery(content) {
                    var gall = $('#gallery_area').val();
                    gall = gall.replace(content, '');
                    $('#gallery_area').val(gall);
                }
                 
             
              $( '.removex' ).click(function() {
  remove_from_gallery($(this).attr('title'));
  $(this).parent().parent().parent().parent().hide(); 
                });

 

             $('#drag-and-drop-zone').dmUploader({//
                 url: '<?= Url::to(['/product/uploadx']) ?>',
                 maxFileSize: 30000000, // 3 Megs 
                 onDragEnter: function () {
                     // Happens when dragging something over the DnD area
                     this.addClass('active');
                 },
                 onDragLeave: function () {
                     // Happens when dragging something OUT of the DnD area
                     this.removeClass('active');
                 },
                 onInit: function () {
                     // Plugin is ready to use
                     ui_add_log('Penguin initialized :)', 'info');
                 },
                 onComplete: function () {
                     // All files in the queue are processed (success or error)
                     ui_add_log('All pending tranfers finished');
                 },
                 onNewFile: function (id, file) {
                     // When a new file is added using the file selector or the DnD area
                     ui_add_log('New file added #' + id);
                     ui_multi_add_file(id, file);
                 },
                 onBeforeUpload: function (id) {
                     // about tho start uploading a file
                     ui_add_log('Starting the upload of #' + id);
                     ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                     ui_multi_update_file_progress(id, 0, '', true);
                 },
                 onUploadCanceled: function (id) {
                     // Happens when a file is directly canceled by the user.
                     ui_multi_update_file_status(id, 'warning', 'Canceled by User');
                     ui_multi_update_file_progress(id, 0, 'warning', false);
                 },
                 onUploadProgress: function (id, percent) {
                     // Updating file progress
                     ui_multi_update_file_progress(id, percent);
                 },
                 onUploadSuccess: function (id, data) {
                     
                     
                     var pathx ="/backend/web/"+data.path;
                $('#gallery_area').val($('#gallery_area').val()+"\n"+pathx);

 

                
                var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='"+pathx+"' class='kv-preview-data file-preview-image'  style='width:auto;height:160px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='"+pathx+"'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";
                
                 
                $('#gallery-box').append(strm);
                //alert(strm);

 

                $( '.removex' ).click(function() {
  remove_from_gallery($(this).attr('title'));
  $(this).parent().parent().parent().parent().hide();
                });
                     
                     
                     
                     console.log(data.path);
                     // A file was successfully uploaded
                     
                     
                     
                     ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
                     ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
                     ui_multi_update_file_status(id, 'success', 'Upload Complete');
                     ui_multi_update_file_progress(id, 100, 'success', false);
                 },
                 onUploadError: function (id, xhr, status, message) {
                     ui_multi_update_file_status(id, 'danger', message);
                     ui_multi_update_file_progress(id, 0, 'danger', false);
                 },
                 onFallbackMode: function () {
                     // When the browser doesn't support this plugin :(
                     ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
                 },
                 onFileSizeError: function (file) {
                     ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
                 }
             });
             
             }
         });

 

</script>
                        