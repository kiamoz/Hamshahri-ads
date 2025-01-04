
<?php
use yii\base\Model; 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = "ویرایش آگهی";
//$online=Yii::$app->user->identity->id;
//$user= common\models\User::find()->where(['id'=>$online])->one();
//echo "credit: ".$user->credit."<br>";
//echo "saghf: ".$user->saghf_etebar."<br>";
//$sum=$user->credit+$user->saghf_etebar;
//echo $sum;
$form = ActiveForm::begin();
?>
<script src="/backend/web/images/ckeditor/ckeditor.js"></script>

<style>
    td {
    border-color: gray !important;
/*   font-size:17px;*/
}
#iddd{
     font-family: "Times New Roman", Times, serif;
/*     font-size:17px;*/
     
}
    div#discount_list_all {
    width: 100%;
}

div#discount_list_all > div {
    float: right;
}
    div#loading_fade {
        width: 100%;

        position: absolute;
        background: rgba(255, 255, 255, 0.71);
        z-index: 99;
        left: 0;
        text-align: center;
        padding-right: 10%;
    } 

    div#loading_fade  i{
        position: absolute;
        top: 50%;
        z-index: 100;
        color:#fff;
        text-align:center;
        font-size:40px;
    }

    ٫loading_fade{
        display: none;
    }
    td {
        height: 20px;
        width: 60px;
    }
    td {
        border: solid;
    }

    table{
        margin-bottom: 10px;
    }
    #div_ad-num_full_page{
        display: none;
    }

</style>

<?php // $cccc= \common\models\CustomerDuration::find()->where(['customer_id'=>2997])->one();
//if($cccc){
//    echo "*". $cccc->date;
//}else{
//    echo "%";
//}
//$on=Yii::$app->user->identity->id;
//$user_table = common\models\User::find()->where(['id' => $on])->one();
//        $sum= $user_table->credit + $user_table->saghf_etebar;
//$str_credit=(string)$user_table->credit;
//        $str_credit= str_replace("-","",$str_credit);
//      echo "*".$str_credit."<br>";
//        $summ=5 + $str_credit;  
//     
//         echo  "*".$summ."<br>";
//            if($summ>70200000){
//                echo"******************";
//            }
//         exit();
?>
<div class="content-box pad25A" style="direction: rtl;">
    <div class="row">
        <div class="col-sm-3">
            <div class="dummy-logo">
                
            </div>
            <address class="invoice-address">
              
                <br>
                
                <br>

            </address>
        </div>
        <?php //echo Yii::$app->user->identity->id;?>
        <div class="col-sm-6 float-right text-right">
            <h4 class="invoice-title"></h4>
            <!--No. <b>#<?php //echo $model->id ?></b>-->
            <?php $user=Yii::$app->user->identity->id;?>
            <?= $form->field($model, 'user_id')->hiddenInput(['maxlength' => true, 'value' => $user])->label('') ?>
            <?= $form->field($model, 'ad_id')->hiddenInput(['maxlength' => true, 'value' => $model->id])->label('') ?>
            <div style=' border: 1px solid black; padding:5%; display:none;' name="edit" id="edit"><?php echo $_GET['id'];?></div>
            <div class="divider"></div>
            <div class="invoice-date mrg20B"><?php//echo \common\models\Persian::convert_date_to_fa(date("Y-m-d")) ?></div>
            
        </div>
    </div>

    <div class="divider"></div>

    <div class="row">
        <div class="col-md-4">
            <h2 class="invoice-client mrg10T"></h2>
            <?php 
            
            $list_arr__ = yii\helpers\ArrayHelper::map(\common\models\Customer::find()->where(['owner_id' => Yii::$app->user->identity->id])->all(), 'id', 'name');
            if($_GET['id']){
                
                $add= common\models\Ad::findOne($_GET['id'])   ;    
                
               // $use= common\models\CustomerDuration::find(['customer_id'=>$add->customer_id])->one();
                $user=common\models\Customer::findOne($add->customer_id);
//                print_r($user);
                $list_arr__[$add->customer_id]=$user->name;
                //echo "*".$user->name."<br>";
                $model->customer_id = $add->customer_id;
//                echo "*".$model->customer_id;
            }
            ?>
            <div class="clearfix"></div>
          <?php  ?>
        <?= $form->field($model, 'tejari')->radioList( [1=>'تجاری',0=>'غیر تجاری'] ,['id'=>'customerstatus']);?>
            <br>
            <?=
            $form->field($model, 'customer_id')->widget(Select2::classname(), [
                'data' => $list_arr__,
                 'initValueText' => $user->name,
                'options' => ['placeholder' => 'انتخاب کنید'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <br>
            <div class="clearfix"></div>
            <!--
                        <address class="invoice-address">
                            آدرس مشتری
                            <br>
                            021-2138721
                            <br>
            
                        </address>-->
        </div>



        <div class="col-md-8">
            <h2 class="invoice-client mrg10T"></h2>
            <div class="col-md-4">
                <br>
                <div style="margin-top:"></div>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'value' => $model->title]) ?>
            </div>

            <!-- <ul class="reset-ul">
 
                 <li><b>وضعیت:</b> <span class="bs-label label-warning">آگهی معلق</span></li>
 
 
             </ul>-->
            <div class="col-md-4">

 <div style="margin-top"></div>
 <br>
 <?php
 
        if($model->date_publish)
        $model->date_publish =  \common\models\Persian::convert_date_to_fa($model->date_publish);
       
  
        echo   $form->field($model, 'date_publish')->textInput(['maxlength' => true, 'autocomplete' => 'off'])
       
     
        ?>
 
 
 
               

            </div>

        </div>
        <div class="clearfix"></div>
         <div class="col-md-12">
 <textarea name="Ad[info]" id="editor1" ><?= $model->info ?></textarea>

         </div>
            </div>
        <?php if(!$_GET['id']){ ?>
        <br>
        <div class="clearfix"> </div>   

<br>
        <div  id="discount_list" ></div>
        <div class="clearfix"> </div>
        
       
       
       
       
       
       
       
         <div class="clearfix" style="margin-bottom:80px;"> </div>
        <div class="col-md-2">
            <?php $model->box_id = 1; ?>
            <?=
            $form->field($model, 'box_id')->widget(Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\common\models\Box::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'انتخاب کنید'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        
        
        
        
        <div class="col-md-2">
            <?php
            echo $form->field($model, 'ad_in_page')->widget(Select2::classname(), [
                'data' => common\models\Ad::data_ad_in_page,
                'language' => 'de',
                'options' => ['placeholder' => 'انتخاب کنید...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>

        <div class="col-md-2" id="div_ad-num_full_page">
            <?= $form->field($model, 'num_full_page')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-1">
              <p style="margin-right: 37%;
    font-weight: bold;
    font-size: 22px;
    margin-top: 43%;">+</p>
        </div>
        <div class="col-md-2">
           
            <?= $form->field($model, 'box_qty')->textInput() ?>

        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'pub_qty')->textInput(['maxlength' => true]) ?>

        </div>
<div class="clearfix" style=""></div>
       <?php $discount=array(); $a_h_d= common\models\AdHasDiscount::find()->where(['ad_id'=>$_GET['id']])->all(); foreach($a_h_d as $a){array_push($discount,$a->discount_id);}?>
       <div id="discount_list_all" style="margin-bottom: 80px; margin-top:40px;">;
           <?php $discount_item=common\models\DiscountItem::find()->all();
           foreach($discount_item as $d){?>
           <div id="18" style="width:8%; margin-bottom:40px; margin-left: 8%;">
               
               <div id="iddd" value="<?php echo $d->id ;?>"><?php echo $d->name ;?><br><span class="bs-label label-success "><?php echo $d->discount ;?>%</span>
               </div>
               <label><input type="radio" name="ad-discount_1<?= $d->id  ?>" value="1" id="yes" data-id="<?php echo $d->id ;?>" <?php if(in_array($d->id,$discount)) {echo "checked";}?>> بله</label>
           <label><input type="radio" name="ad-discount_1<?= $d->id  ?>" value="2" > خیر</label>
           
       </div>
       <?php } ?>
       </div>
       
       <div style="margin-bottom:20px;"></div>
       
        <div class="col-md-1">
            <a>
                <button  id ="btn_cal"  class="glyph-icon tooltip-button demo-icon icon-plus" style='padding:20%; float:left;'>
                </button>
            </a>


        </div>
<?php $id=$_GET['id'];// echo $id;
         $ad_table= common\models\Ad::find()->where(['id'=>$id])->one(); 
        ?>
       <?php  $doc_table= common\models\Document::find()->where(['ad_id'=>$ad_table->copy_ad_id])->one();// echo $doc_table->file;
      
       if($ad_table->copy_ad_id){
       ?>
       <?php
               
            echo "<img style='max-width:50%;' src='/" . $doc_table->file . "' >";

               
               ?>
       <?php } ?>
        <div class="clearfix"></div>

        <div class="clearfix"> </div>





    <table class="table mrg20T table-hover" id="result_list">


        <div id="loading_fade">

            <div class="remove-border glyph-icon demo-icon tooltip-button icon-spin-3 icon-spin" title="" data-original-title="icon-spin-3"></div>
        </div>

        <thead>
            <tr>

                <th>نام تخفیف استفاده شده</th>
                <th class="text-center">درصد افزایش اعتبار</th>
                <th>درصد تخفیف</th>
                <th>قیمت(ریال)</th>
            </tr>
        </thead>

        <tbody class="cart-list-inner" id="result_list">

            <?php
            $ahd = common\models\AdHasDiscount::find()->where(['ad_id' => $model->id])->all();
            $m_ad = common\models\Ad::findOne($model->id);
//           print_r($m_ad);
           $m_ad1 = common\models\Ad::find()->where(['id'=>$model->id])->one();
           //echo "*****************************************".$m_ad1->customer_id;
           $c_t= \common\models\Customer::find()->where(['id'=>$m_ad1->customer_id])->one();
           
            ?>
            <?php if ($m_ad->in_amount != null) { ?>
         <?php if(!empty($ahd)) { ?>
        <?php foreach ($ahd as $aa) { ?> 



                        <tr id="discount-id_17">
                            <td><?= \common\models\DiscountItem::findOne($aa->discount_id)->name; ?></td>
                            <td><?php echo $aa->inc_rate ?></td>
                            <td><?php echo $aa->discount_rate ?></td>
                            <td><?php echo $aa->discount_price ?></td>
                        </tr>
        <?php
               }
             }
          
         ?><?php if(empty($ahd)){ ?>
             <tr >
                 <td> بدون تخفیف </td><td> 0 </td><td> 0 </td><td> 0 </td>
             </tr>
             <?php } ?>
                <tr><td colspan="3" class="text-left"> تعرفه افزایش/کاهش:</td><td colspan="3" id="takhfif"><?php echo $sign. $c_t->takhfif."%" ?></td></tr>
                <tr> 
                    <td colspan="3" class="text-left"> تعداد کل کادر ها:</td>
                    <td id="sum_discount"><?php echo $m_ad->box_qty ?></td></tr>
                
                <tr> <td colspan="3" class="text-left"> جمع تخفیف:</td><td id="sum_discount"><?php echo $m_ad->discount_price ?></td></tr>
                <tr><td colspan="3" class="text-left">مبلغ مورد نیاز :</td><td colspan="3" id="sum_in"><?php echo $m_ad->in_amount ?></td></tr>
                <tr><td colspan="3" class="text-left">درصد افزایش اعتبار:</td><td colspan="3" id="sum_inc"><?php echo $m_ad->inc_rate ?></td></tr>
                <tr><td colspan="3" class="text-left"> درصد کارمزد:</td><td colspan="3" id="benefit_rate"><?php echo $m_ad->benefit_rate ?></td></tr>
                <tr><td colspan="3" class="text-left"> مبلغ کارمزد:</td><td colspan="3" id="benefit_price"><?php echo $m_ad->benefit_price ?></td></tr>
<?php if($c_t->temp_p_n==1) $sign="-";elseif($c_t->temp_p_n==2)$sign="+";?>
             

            <?php } ?>
        </tbody>

    </table>



    <div style="" id="table_e_v" >


    </div>
        <?php } ?>
        <div class="clearfix"></div>
     <textarea name="Ad[fani]" id="editor1" class="form-group"><?= $model->fani ?></textarea>
    <div style="margin-top: 5%;" id ="new_ad">

       
           <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<!--            <a  >
                <button  id ="new_ad"   class="btn btn-alt btn-hover btn-success">
                    <span>ویرایش</span>
                    <i class="glyph-icon icon-check"></i>
                </button>
            </a>-->
</div>
</div>



<script>

//
// selected_discount_all = [];
//   
//    
//$('#discount_list_all input[type=radio]').change(function () {
////var all=1;
//
// $('#discount_list_all input:radio:checked').each(function () {
// if ($(this).attr('value') == 1) {
//     console.log('yes');
// //console.log($(this).attr('data-id'));
// 
// selected_discount_all.push($(this).attr('data-id'));
//}
//
//});
//
//
//console.log(selected_discount_all);
// var form_data = new FormData();
//  
//
//         form_data.append("selected_discount_all", (selected_discount_all));
//       
//         var all = {};
//         all['selected_discount_all'] = selected_discount_all;
//        
//         $.ajax({
//             url: "https://hamshahriads.ir/site/cal_data" ,
//             data: selected_discount_all,
//             datatype: "json",
//             type: "POST",
//             success: function (data) {
//                 //clickJStoPHPResponse(data);
//             }
//         });
//  });

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
</script>