<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\ProductCategory;

?> 
<div class="panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">

        <script src="images/ckeditor/ckeditor.js"></script>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

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
        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'menu_show')->radioList(array('1' => 'بله', '0' => 'خیر')); ?>


        <?= $form->field($model, 'order_show')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'description')->textarea(['id' => 'editor1']); ?>
        <?= $form->field($model, 'body')->textarea(['id' => 'editor2']); ?>
        <?= $form->field($model, 'before_product')->textarea(['id' => 'editor3']); ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?PHP
        $b = ProductCategory::find()->all();
        $date2 = array();
        foreach ($b as $ProductCategory) {


            $ret = "";
            $daste = common\models\CategoryHasCategory::find()->where('category=' . $ProductCategory->id)->all();
            foreach ($daste as $cats) {
                $ret .= \common\models\ProductCategory::findOne($cats->parent_category)->name . " ";
            }

            $data2[$ProductCategory->id] = $ProductCategory->name . "(" . $ret . ")";
        }

        if ($model->id) {


            $m = \common\models\CategoryHasCategory::find()
                    ->where('category=' . $model->id)
                    ->all();
            $arr_select = array();
            foreach ($m as $list) {

                $arr_select[] = $list->parent_category;
            }
        }


        echo Html::activeLabel($model, 'attrchc');


        echo Select2::widget([
            'name' => 'ProductCategory[attrchc]',
            'data' => $data2,
            'options' => ['placeholder' => 'دسته بندی مشترک', 'multiple' => true],
            'value' => $arr_select, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);



        echo Html::error($model, 'attrc');
        ?>
        <br>
        <?= $form->field($model, 'is_mother')->checkbox(); ?>

        <?= $form->field($model, 'file')->fileInput(['id' => 'imgInp']) ?>
        <?php if (strlen($model->img)) { ?>
            <img id="imgInp_"  src="<?= $model->img; ?>" alt="تصویر " width="200"/>
        <?php } else { ?>
            <img id="imgInp_" src="img/no_image.png" alt="تصویر " width="200"/>
        <?php } ?>



<?= $form->field($model, 'file2')->fileInput(['id' => 'imgInp']) ?>

        <?php if (strlen($model->img2)) { ?>
            <img id="imgInp_"  src="<?= $model->img2; ?>" alt="تصویر " width="200"/>
        <?php } else { ?>
            <img id="imgInp_" src="img/no_image.png" alt="تصویر " width="200"/>
        <?php } ?>


        <br>
        <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

            <?php ActiveForm::end(); ?>

    </div>
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

    $("#imgInp").change(function () {

        readURL(this);
    });
</script>


<script>

    var conf = {
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
    };
    editor = CKEDITOR.replace('editor1', conf);
    editor = CKEDITOR.replace('editor2', conf);
    editor = CKEDITOR.replace('editor3', conf);



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