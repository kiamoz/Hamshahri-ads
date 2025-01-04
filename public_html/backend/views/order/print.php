<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Price;
use common\models\Order;
use common\models\ProductItem as Item;
use common\models\ItemHasOrder;
use common\models\User;
use common\models\Product;
use yii\helpers\Url;
use common\models\Sitesetting;



$site_base = dirname(dirname(dirname(dirname(__FILE__))));
$order_id = $has_id;
$total = 0;
$items = Item::find()->where('order_id=' . $_GET['order_id'])->all();
$order = Order::findOne($order_id);
$total+= $ship->price;
$total_weight = 0;
?>

<?php
$width = 0;
if ($_GET['flag'] == 1) {
    $width = '100%';
} else {
    $width = "314px";
}
?> 
<style>
    body{
        margin: 0px;
    }
</style>

<div style=" width: <?php echo $width; ?>px">
    <div class="area-title bdr">

    </div>
    <div class="table-area" style="direction: rtl;">
        <div class="table-responsive">
            <table class="table table-bordered text-center" style=" width:<?php echo $width; ?>">
                <thead>
                    <tr style=" text-align: center">
                        <td colspan="4" style="font-family: tahoma"><?= \common\models\Sitesetting::findOne(1)->title ?>
                           
                        </td>

                    </tr>
                    <tr style=" text-align: center" >


                        <td style="padding: 5px;font-family: tahoma;font-size: 12px;">زمان سفارش :<?php
                            $order_p = Order::findOne($_GET['order_id']);
                            echo \common\models\Post::arabic_w2e($order_p->date_farsi);
                            ?> </td>
                        <td colspan="3" style="text-align: left;padding: 5px;font-family: tahoma;font-size: 12px;"> شماره فاکتور :<?php echo \common\models\Post::arabic_w2e($order_p->id); ?> </td>

                    </tr>
                    <tr style=" text-align: center" >


                        <td style="padding: 5px;font-family: tahoma;font-size: 12px;">
                            <?php
                            $_user = \common\models\Address::findOne($order_p->address_id);
                            ?> 
                            نام و نام خانوادگی : <?php echo \common\models\Post::arabic_w2e($_user->name_and_fam); ?>
                        </td>
                        <td colspan="3" style="text-align: left;padding: 5px;font-family: tahoma;font-size: 12px;">
                            شماره همراه :<?php echo \common\models\Post::arabic_w2e($_user->cell_number); ?> 
                        </td>

                    </tr>



                    <tr class="c-head">

                        <th style="padding: 5px;border: 1px solid #333;font-size: 12px;font-family: tahoma;width: 30%;">نام محصول</th>
                        <th style="padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 12px;">تعداد</th>
                        <th style="padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 12px;">قیمت</th>

                        <th style="padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 12px;">مجموع</th>

                    </tr>
                </thead>
                <?php
                foreach ($items as $item) {
                    $total_weight += (Product::findOne($item->product_id)->weight) * $item->qty;

                    $price = (Product::get_price($item->product_id));
                    
                    ?>
                    <tr>

                        <td style="width: 42%;padding: 5px;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-name">
                            <?PHP echo Product::getName($item->product_id) ?>
                        </td>
                        <td style="width: 10%;padding: 5px;text-align: center;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-qty">
                            <?php echo common\models\Post::arabic_w2e($item->qty); ?>
                        </td>
                        <td style="text-align: center;padding: 5px;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-price">  
                            <?PHP
                            $pr = ($item->price);
                           
                                echo $pr;
                            
                            ?> 


                        </td>

                        <td style="text-align: center;padding: 5px;border: 1px solid #333;font-size: 12px; font-family: tahoma" class="c-price"> 
                            <?php
                            
                                $_p1 = $item->price * $item->qty;
                                
                                    echo number_format($_p1);
                                
                            
                            ?> 
                    </tr>
                <?php } ?>
                <tfoot>
                    <tr class="summary bgorgm">

                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px;" class="total-action" colspan="4">
                            <label>  هزینه حمل : </label>
                            <span class="total" style="float: left;"><?= number_format($order_p->price_shipping)." ".Sitesetting::get_currency_symbol(); ?></span>                                                         
                        </td>



                    </tr>
                    <tr class="summary bgorgm">

                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px;" class="total-action" colspan="4">
                            <label>  جمع کل : </label>
                            <span class="total" style="float: left;"><?= number_format($order_p->price_final)." ".Sitesetting::get_currency_symbol(); ?></span>                                                         
                        </td>



                    </tr>
                   
                   
                    <tr class="summary bgorgm">


                        <td style="font-weight: bold;padding: 5px;border: 1px solid #333;font-family: tahoma;font-size: 13px; text-align: center" class="total-action" colspan="5">

                            <label>خرید آنلاین http://penarts.net </label>
                        </td>


                    </tr>

                </tfoot>
            </table>

        </div>
    </div>
</div>




<script>
    window.print();
</script>
<?php exit();
?>