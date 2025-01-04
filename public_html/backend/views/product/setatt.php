<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ProductAttGroupHasAtt;
use common\models\Att;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\ProductHasAttValue;
use common\models\AttValue;
use kartik\select2\Select2;
use common\models\AttSetHasAttGroup;
use common\models\ProductAttValue;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Setatt';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setatt-index">

    
    
    <?PHP
    
    $listval = "";

    
        //echo $list->att_set_id;
        
       
        foreach ($attlist as $list){
           //echo $list->att_group_id."<hr>";
     $list_att_gr = ProductAttGroupHasAtt::find()
     ->where('att_group_id='.$list->att_group_id)
     ->all();
     foreach($list_att_gr as $att){
    
        $attibuteList = Att::find()
     ->where('id='.$att->att_id)
     ->all(); 
        
      
        //$listval .= $attbiute->id."|";
        ?>
    
        <?PHP
        foreach($attibuteList as $attbiute){
            
         // echo $attbiute->id."<br>";
          
          $rm = ProductAttValue::find()
                ->where('product_id='.$id." AND att_id=".$attbiute->id) //AND attValue.id=1
                ->all();
        $val = array();
        $valprice =array();
        $value_id =array();
       
        //$attrC = count($rm); // check it out  more important 
      // echo  $attrC."<=count<br>";
        $i=0;
        foreach($rm as $ziizii){
            $val[$i] = $ziizii->value;
            $valprice[$i] = $ziizii->price; 
            $value_id[$i] = $ziizii->id; 
            $i++;
        } 
        //print_r($val);
        // end zizii foreach    
         $i=0;  
         
         
         
         
         do{
             $attrC--;
             
           
             
             switch($attbiute->type){
                case 1:
                   ?>
       
                
                
<label   class="control-label"><?PHP echo $attbiute->name;  ?></label>                
<?php Pjax::begin(); ?>         
<?= Html::beginForm(['setatt','id'=>$id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::input('text','att_value', $val[$i], ['class' => 'form-control']) ?>
    <?= Html::hiddenInput('att_id',$attbiute->id, ['class' => 'form-control']) ?>
    <?= Html::hiddenInput('value_id',$value_id[$i], ['class' => 'form-control']) ?>
    <?= Html::submitButton(' ذخیره', ['class' => 'btn', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<?PHP if($stringHash){  ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong><?PHP echo $stringHash  ?> </strong> 
</div>
<?PHP }  ?>
<?php Pjax::end(); ?>          
                   <?PHP  
                break;    
                case 2:
                   ?>
<label  class="control-label"><?PHP echo $attbiute->name;  ?></label>
                               
<?php Pjax::begin(); ?>         
<?= Html::beginForm(['setatt','id'=>$id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::textarea('att_value', $val[$i], ['class' => 'form-control']) ?>
    <?= Html::hiddenInput('att_id',$attbiute->id, ['class' => 'form-control']) ?>
    <?= Html::hiddenInput('value_id',$value_id[$i], ['class' => 'form-control']) ?>
    <?= Html::submitButton(' ذخیره', ['class' => 'btn', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<?PHP if($stringHash){  ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong><?PHP echo $stringHash  ?> </strong> 
</div>
<?PHP }  ?>
<?php Pjax::end(); ?> 
                   <?PHP  
                break;
                
                
                
                case 4:
                   ?>
<label  class="control-label"><?PHP echo $attbiute->name;  ?></label>
                               
<?php Pjax::begin(); ?>         
<?= Html::beginForm(['setatt','id'=>$id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?php 
    //echo $val[$i]."<br>";
    if($val[$i]==1){
        $valx = 1;
        $valy = 0;
        
    }else{
        $valx = 0;
        $valy = 1;
        
    }  
    //echo $valx."/".$valy;
    
    
    ?>
    <?= Html::radio("att_value", $valx, ['value' => 1,'label' => "دارد"]); ?>
    <?= Html::radio("att_value", $valy, ['value' => -1,'label' => "ندارد"]); ?>

    <?= Html::hiddenInput('att_id',$attbiute->id, ['class' => 'form-control']) ?>
    <?= Html::hiddenInput('value_id',$value_id[$i], ['class' => 'form-control']) ?>
    <?= Html::submitButton(' ذخیره', ['class' => 'btn', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<?PHP if($stringHash){  ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong><?PHP echo $stringHash  ?> </strong> 
</div>
<?PHP }  ?>
<?php Pjax::end(); ?> 
                   <?PHP  
                break;
                
                
                case 3:
                   ?>
<div id="multi_val">
<label  class="control-label"><?PHP echo $attbiute->name;  ?><b></b></label>
<?php Pjax::begin(); ?>         
<?= Html::beginForm(['setatt','id'=>$id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::input('text','att_value', $val[$i], ['class' => 'form-control valx','placeholder'=>'مقدار ویژگی']) ?>
    <?= Html::input('text','att_val_price', $valprice[$i], ['class' => 'form-control prix','placeholder'=>'قیمت اضافی']) ?>
    <?= Html::hiddenInput('att_id',$attbiute->id, ['class' => 'form-control']) ?>
    <?= Html::hiddenInput('value_id',$value_id[$i], ['class' => 'form-control validx']) ?>
    <?= Html::submitButton(' ذخیره', ['class' => 'btn', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<a class="btn btn-sm btn-success">+</a>
<?PHP if($stringHash){  ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong><?PHP echo $stringHash  ?> </strong> 
</div>

<?PHP }  ?>
<?php Pjax::end(); ?> 
<?PHP  
                break;
                
                
                case 5:
                   ?>
<div id="multi_val">
<label  class="control-label"><?PHP echo $attbiute->name;  ?><b></b></label>
     
    <?php
    
   
    
$op  = common\models\AttOption::find()->where(['att_id'=>$attbiute->id])->all();
$data3= array();

foreach( $op as $options){
$data3[$options->id] = $options->name;

}

$m = ProductAttValue::find()
     
     ->where('product_id='.$_GET['id'])
     ->all();
$arr_select = array();
//echo count($m);
foreach($m as $list){
    
    $arr_select[] = $list->value;
}


echo Select2::widget([
    'name' => 'name'.$attbiute->name,
  //  'id'=>'option',
    'value' => $arr_select,
    'data' => $data3,
    'options' => ['multiple' => true, 'placeholder' => 'Select options ...']
]);


    ?>
<input type="hidden" class="att_id" value="<?= $attbiute->id ?>" />
<input type="hidden" class="product_id" value="<?= $_GET['id'] ?>" />
<input type="button" class="option_select"  value="ذخیره">

<div class="resualt"> </div>

</div>
    
                   <?PHP  
                break;
            } // end switch 
            
            $i++;
         }while ($attrC>0);
         
            
         
      
            
         //$pm = common\models\AttValue::find()
         //        ->where('product_id='.$id." AND att_id=".$attbiute->id)
         //        ->one();  
         
            
            
           
            
            
        }
                
     }
     
    
        
    }
            
            
            
            
            
            
            
            
        
        
    
    
   
    
    ?>
    
     <?PHP
    
    $this->registerJs(
            
            
            
    '
 
num2 =2;
$( ".btn-sm" ).click(function() {

       alert("x");
       $( "#multi_val").clone().prop("id", "multi_val"+num2 ).insertAfter( "#multi_val"); 
       $( "#multi_val"+num2+" .valx").val("");
       $( "#multi_val"+num2+" .prix").val("");
       $( "#multi_val"+num2+" .validx").val("");

num2++;
});'
);
    ?>
    

</div>  
 