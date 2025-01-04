<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\AttGroup;
use common\models\UploadForm;
use common\models\Category;
use common\models\ProductCategory;
use common\models\ProductHasCategory;
use common\models\ProductHasAttGroup;
use kartik\file\FileInput;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;
use common\models\Price;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use faravaghi\jalaliDatePicker\jalaliDatePicker;
use kartik\time\TimePicker;

$_http = "http://";
?>
<link href="/backend/web/upload_js/jquery.dm-uploader.min.css" rel="stylesheet">

<script src="images/ckeditor/ckeditor.js"></script>
<style>
    .select2-results__option,.select2-selection__choice{
        text-align: right;
        direction: rtl;
    }
    #product-gallery{
        display: none;
    }
</style>

<div class="product-form panel">

    <?php
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])
    ?>

    <div class="col-lg-6 panel-body">

        <?PHP
        $b = ProductCategory::find()->all();
        $date2 = array();
        foreach ($b as $ProductCategory) {

            $ret = "";
            $daste = common\models\CategoryHasCategory::find()->where('category=' . $ProductCategory->id)->all();
//echo count($daste);
            foreach ($daste as $cats) {
                $ret .= \common\models\ProductCategory::findOne($cats->parent_category)->name . " ";
            }

            $data2[$ProductCategory->id] = $ProductCategory->name . "(" . $ret . ")";
        }

        if ($model->id) {

            $m = ProductHasCategory::find()
                    ->with('product')
                    ->where('product_id=' . $model->id)
                    ->all();
            $arr_select = array();
//echo count($m);
            foreach ($m as $list) {

                $arr_select[] = $list->product_category;
            }
        }



        echo Html::activeLabel($model, 'attrc');


        echo Select2::widget([
            'name' => 'Product[attrc]',
            'data' => $data2,
            'options' => ['placeholder' => 'دسته بندی', 'multiple' => true],
            'value' => $arr_select, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);



        echo Html::error($model, 'attrc');
        ?>

        <br>
        <hr>
        <br>
        <div class="col-md-6">
            <?= $form->field($model, 'img1')->fileInput(['id' => 'imgInp']) ?>
            <small>حذف تصویر : </small>
            <br>
            <label class="switch">

                <input type="checkbox" name="clearimg">

                <span class="slider round"></span>
            </label>
            <br>
            <?php if (strlen($model->image) > 2) { ?>
                <img id="imgInp_"  src="<?php echo $_http . $_SERVER['SERVER_NAME'] . '/backend/web/' . $model->image; ?>" alt="تصویر " width="200"/>

            <?php } else { ?>
                <img id="imgInp_" src="img/no_image.png" alt="تصویر اصلی" width="200"/>
            <?php } ?>
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'file')->fileInput(['id' => 'imgInp1']) ?>
            <small>حذف تصویر دوم : </small>
            <br>
            <label class="switch">

                <input type="checkbox" name="clearimg2">

                <span class="slider round"></span>
            </label>
            <br>
            <?php if (strlen($model->image_2) > 2) { ?>
                <img id="imgInp1_"  src="<?php echo $_http . $_SERVER['SERVER_NAME'] . '/backend/web/' . $model->image_2; ?>" alt="تصویر " width="200"/>

            <?php } else { ?>
                <img id="imgInp1_" src="img/no_image.png" alt="تصویر اصلی" width="200"/>
            <?php } ?>
        </div>



        <div class="clearfix"></div>


        <div class=" col-md-12">












            <!-- File item template -->
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
                    <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
                    </script>

                </div>


                <div class="col-md-12 col-sm-12">

                    <!-- Our markup, the important part here! -->
                    <div id="drag-and-drop-zone" class="dm-uploader p-5">
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

                <div class="col-lg-12">
                    <?= $form->field($model, 'gallery')->textarea(['rows' => 6, 'class' => 'nonex', 'id' => 'gallery_area']) ?>
                    <div id="gallery-box">




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
                                    <img src="<?= $imgx ?>" class="kv-preview-data file-preview-image"  style="width:auto;height:160px; ">
                                </div><div class="file-thumbnail-footer">

                                    <div class="file-actions ">
                                        <div class="file-footer-buttons">
                                            <button type="button" class="kv-file-remove btn btn-xs btn-default removex" title="<?= $imgx ?>"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                                        </div></div></div></div>

                        <?php } ?>

                    </div>



                </div>
            </div>


            <div class="col-lg-6 panel-body">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?=
                $form->field($model, 'company_id')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'انتخاب کنید'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                
                
                
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'visible')->radioList(array('1' => 'بله', 2 => 'خیر')); ?>



                <?= $form->field($model, 'english_name')->textInput(['maxlength' => true]) ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'length')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                
                
                <?=
                $form->field($model, 'producer_id')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['type_id'=>5])->all(), 'id', 'name_and_fam'),
                    'options' => ['placeholder' => 'انتخاب کنید'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                
                <?= $form->field($model, 'producer_value')->radioList(array('1' => 'ثابت', 2 => 'درصد')); ?>
                
               
                <?= $form->field($model, 'producer_rate')->textInput(['maxlength' => true]) ?>










                <?= $form->field($model, 'qty')->textInput(['maxlength' => true]) ?> 


                <?= $form->field($model, 'extera_info')->textInput(['maxlength' => true]) ?>
                <?PHP
                if ($model->id) {


                    $price->selling_rate = $model->pricef->selling_rate;
                    ?>

                <?php }
                ?>

                <div class="clearfix"> </div>

<?= $form->field($price, 'selling_rate')->textInput(['maxlength' => true]) ?>
                <?= $form->field($price, 'buying_rate')->textInput() ?>

                <div class="panel">
                    <div class="panel-body">
                        <h3 class="title-hero">
                            چکیده
                        </h3>

                        <textarea name="Product[summery]" id="editor1" ><?= $model->summery ?></textarea>

                    </div>
                </div>


                <div class="panel">
                    <div class="panel-body">
                        <h3 class="title-hero">
                            توضیحات
                        </h3>

                        <textarea name="Product[body]" id="editor2" ><?= $model->body ?></textarea>

                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <h3 class="title-hero">
                            فنی
                        </h3>

                        <textarea name="Product[fani]" id="editor3" ><?= $model->fani ?></textarea>

                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <h3 class="title-hero">
                            محتویات جعبه
                        </h3>

                        <textarea name="Product[box]" id="editor4" ><?= $model->box ?></textarea>

                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <h3 class="title-hero">
                            نقد
                        </h3>

                        <textarea name="Product[naghd]" id="editor5" ><?= $model->naghd ?></textarea>

                    </div>
                </div>










            </div>


            <div class="clearfix"></div>
            <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'ذخیره' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>



<?php ActiveForm::end(); ?>





        </div>


        <script>
            function readURL(input) {

                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function (e) {

                        $("#" + input.id + "_").attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp,#imgInp1").change(function () {

                readURL(this);
            });
        </script>
        <script>
            editor = CKEDITOR.replace('editor1', {
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



            editor.addCommand("mySimpleCommand", {
                exec: function (edt) {
                    // alert("X");


                    var start_element = edt.getSelection().getStartElement().getOuterHtml();
                    em = start_element.slice(0, 4);

                    if (em == "<img") {
                        editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
                    }

                }
            });







        </script>    
        <script>
            editor = CKEDITOR.replace('editor4', {
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



            editor.addCommand("mySimpleCommand", {
                exec: function (edt) {
                    // alert("X");


                    var start_element = edt.getSelection().getStartElement().getOuterHtml();
                    em = start_element.slice(0, 4);

                    if (em == "<img") {
                        editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
                    }

                }
            });







        </script>  
        <script>
            editor = CKEDITOR.replace('editor5', {
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



            editor.addCommand("mySimpleCommand", {
                exec: function (edt) {
                    // alert("X");


                    var start_element = edt.getSelection().getStartElement().getOuterHtml();
                    em = start_element.slice(0, 4);

                    if (em == "<img") {
                        editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
                    }

                }
            });







        </script>  
        <script>
            editor = CKEDITOR.replace('editor3', {
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



            editor.addCommand("mySimpleCommand", {
                exec: function (edt) {
                    // alert("X");


                    var start_element = edt.getSelection().getStartElement().getOuterHtml();
                    em = start_element.slice(0, 4);

                    if (em == "<img") {
                        editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
                    }

                }
            });







        </script>  
        <script type="text/javascript">

        </script>
        <script>
            editor = CKEDITOR.replace('editor2', {
                extraPlugins: 'lineutils,widget,image2',
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



            editor.addCommand("mySimpleCommand", {
                exec: function (edt) {
                    // alert("X");


                    var start_element = edt.getSelection().getStartElement().getOuterHtml();
                    em = start_element.slice(0, 4);

                    if (em == "<img") {
                        editor.insertHtml("&nbsp;<p style='text-align:center'>" + start_element + "</p>");
                    }

                }
            });




        </script> 