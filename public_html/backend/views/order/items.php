<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Price;
use common\models\Order;
use common\models\Item;
use common\models\ItemHasOrder;
use common\models\User;
use common\models\Product;
use yii\helpers\Url;
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    
    <table class="table table-striped">
        <tr>
           
            <td style="width:10%">قیمت</td>
            <td style="width:5%">تعداد</td>
            <td style="width:10%">نام محصول</td>
        </tr>
        
        <?PHP
        
        
        

   $order_id =  $model->id;
   $total = 0;
   $items = Item::find()->where('order_id='.$order_id)->all();
   foreach ($items as $item){
       $total+=(Price::get_lastPrice_by_pid($item->product_id)*$item->qty);
     ?>
        
        <tr>
        
            <td>
              <?PHP echo (Price::get_lastPrice_by_pid($item->product_id)) ;  ?>
            </td>
            <td>
              <?PHP echo (($item->qty)) ;  ?>
            </td>
            <td>
              <?PHP echo Product::getName($item->product_id)    ?>  
            </td>
            
        </tr>
        
        
        
     <?PHP   
       
     
   }
   ?>
        <tr style="margin-top: 30px; color: #199900; font-weight: bold;">
            
            <td>
                جمع کل : <?PHP echo $model->off;  ?>
            </td>
            <td> هزینه حمل : <?PHP echo $model->hazine_haml;  ?></td>
            
        </tr>     
   
        
    </table>
    
    
    
    
   
    
    
    
    
    

