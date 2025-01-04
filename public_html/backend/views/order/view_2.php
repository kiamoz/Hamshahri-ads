<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Price;
use common\models\Order;
use common\models\Item;
use common\models\ItemHasOrder;
use common\models\User;
use common\models\Product;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1 class=" alert alert-info"> شماره سفارش : <?= Html::encode($this->title) ?></h1>
    <h2 class=" alert alert-info"> روش پرداخت :
        <?php  
                switch ($model->ship_method ){
                   
                    case 5:
                        $ret= "پست پیشتاز";
                           break;
                        case 6:
                     
                        $ret= "تیپاکس";
                         break;
                     case 32:
                     
                        $ret= "پیک موتوری";
                         break;
                }
                    echo $ret;
                
                
                ?> 
    
    </h2>
    <p class=" alert alert-info"> شهر : 
    <?php $cty = common\models\location::findOne($model->city_name);
            echo $cty->name; ?>
    </p>
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
    
    
    
    
   
    <div class=" alert alert-info">
     
    <?PHP $usr = User::find()->where('id='.$model->user_id)->one();  ?>
    
    <table>
        <tr>
            <td><span>نام و نام خانوادگی :</span></td>
            <td> <?PHP echo $usr->name .' '. $usr->family ; ?></td>
            
        </tr>
        <tr>
            <td><span>شماره ثابت :</span></td>
            <td><?PHP echo $usr->phone_number; ?></td>
            
        </tr>
        <tr>
            <td><span>شماره تلفن همراه :</span></td>
            <td><?PHP echo $usr->cell_number; ?></td>
            
        </tr>
        <tr>
            <td><span>آدرس : </span></td>
            <td><?PHP echo $model->address; ?></td>
            
        </tr>
        <tr>
            <td><span>کد پستی:</span></td>
            <td><?PHP echo $usr->postal_code; ?></td>
            
        </tr>
        <tr>
            <td><span>کد پستی:</span></td>
            <td><?PHP echo $usr->postal_code; ?></td>
            
        </tr>
        <tr>
            <td><span>کد تخفیف نماینگی:</span></td>
            <td><?PHP echo $model->namayande_code; ?></td>
            
        </tr>
        <tr>
            <td><span>کد تخفیف هدیه:</span></td>
            <td><?PHP echo $model->gift_code; ?></td>
            
        </tr>
        <tr>
            <td><span>شماره فیش:</span></td>
            <td><?PHP echo $model->flasher; ?></td>
            
        </tr>
    </table>
    
        
    </div>
    
    
    
    

