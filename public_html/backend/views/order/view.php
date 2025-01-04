<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Price;
use common\models\Order;
use common\models\ProductItem;
use common\models\ItemHasOrder;
use common\models\User;
use common\models\Product;
use yii\helpers\Url;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    
    <a style="" target="_blank" href="<?php echo Url::to(['order/print', 'order_id' => $model->id, 'flag' => 2]) ?>"> 
        <button class="print btn btn-info">چاپ فاکتور (پرینتر حرارتی)  </button>
    </a>
    <a style="" target="_blank" href="<?php echo Url::to(['order/print', 'order_id' => $model->id, 'flag' => 1]) ?>"> 
        <button class="print btn btn-info">چاپ فاکتور (پرینتر عادی)  </button>
    </a>
    <a href="<?= Url::to(['update','id'=>$model->id]) ?>"><button class="print btn btn-success"> ویرایش وضعیت  </button></a>
    وضعیت:<?= Order::status_text[$model->status]; ?>
    <br><br>
    
    <?php
    $site_base = dirname(dirname(dirname(dirname(__FILE__))));
    $order_id = $has_id;
    $total = 0;
    $items = ProductItem::find()->where('order_id=' . $_GET['id'])->all();
    $order = Order::findOne($order_id);
    $total+= $ship->price;
    $total_weight = 0;
    ?>
    
    <style>
        td{
            text-align: right !important;
            direction: rtl;
        }
    </style>


    <div class="col-md-8 col-md-push-4">
        <div class="area-title bdr">

        </div>
        <div class="table-area" style="border: 1px solid #abb;direction: rtl;">
            <div class="table-responsive">
                <table class="table table-bordered text-center" style=" direction: rtl; width:<?php echo $width; ?>px">
                    <thead>
                        <tr style=" text-align: center">
                            <td colspan="4" style="font-family: tahoma"> 
                                <?php
                                $sitesetting= common\models\Sitesetting::findone(1);
                                echo $sitesetting->title;
                                ?>
                                <br>
                                <label>
                                    <?= $sitesetting->tell ?>
                                </label>
                            </td>

                        </tr>
                        <tr style=" text-align: center" >


                            <td style="padding: 5px;font-family: tahoma;font-size: 12px;">زمان سفارش :<?php
                                $order_p = Order::findOne($_GET['id']);
                                echo \common\models\Post::arabic_w2e($order_p->date_farsi);
                                ?> </td>
                            <td colspan="3" style="text-align: left;padding: 5px;font-family: tahoma;font-size: 12px;"> شماره فاکتور :<?php echo \common\models\Post::arabic_w2e($order_p->id); ?> </td>

                        </tr>
                        


                        <tr class="c-head">

                            <th style="padding: 5px;border: 1px solid #abb;font-size: 12px;font-family: tahoma;width: 30%;">نام محصول</th>
                            <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">تعداد</th>
                            <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">قیمت</th>

                            <th style="padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 12px;">مجموع</th>

                        </tr>
                    </thead>
                    <?php
                    foreach ($items as $item) {
                        $total_weight += (Product::findOne($item->product_id)->weight) * $item->qty;

                        $price = (Product::get_price($item->product_id,FALSE,FALSE));
                        if ($item->variant_id) {
                            $variant_pice = \common\models\Variant::findOne($item->variant_id);

                            $total_v += (($variant_pice->price) * ($item->qty));
                        } else {
                            $total += (Product::get_price($item->product_id,FALSE,FALSE) * $item->qty);
                        }

                       
                        ?>
                        <tr>

                            <td style="width: 42%;padding: 5px;border: 1px solid #abb;font-size: 12px; font-family: tahoma" class="c-name">
                                <?PHP echo Product::getName($item->product_id);?>
                                <br>
                               

                            </td>
                            <td style="width: 10%;padding: 5px;text-align: center;border: 1px solid #abb;font-size: 12px; font-family: tahoma" class="c-qty">
                                <?php echo common\models\Post::arabic_w2e($item->qty); ?>
                            </td>
                            <td style="text-align: center;padding: 5px;border: 1px solid #abb;font-size: 12px; font-family: tahoma" class="c-price">  
                                <?PHP
                                $pr = $item->price;
                                
                                    if ($pr>0) {
                                        
                                        echo common\models\Post::arabic_w2e(number_format($pr));
                                    }
                               
                                ?> 


                            </td>

                            <td style="text-align: center;padding: 5px;border: 1px solid #abb;font-size: 12px; font-family: tahoma" class="c-price"> 
                                <?php
                                if ($item->variant_id) {
                                    echo common\models\Post::arabic_w2e(number_format(($variat_items->price) * $item->qty));
                                } else {
                                    $_p1 = ($item->price) * $item->qty;
                                    if ($_p1 > 0) {
                                        echo common\models\Post::arabic_w2e(number_format($_p1));
                                    }
                                }
                                ?> 
                        </tr>
                    <?php } ?>
                    <tfoot>
                   
                 
                        <tr class="summary bgorgm">

                            <td style="font-weight: bold;padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 13px;" class="total-action" colspan="4">
                                <label>  جمع قابل پرداخت : </label>
                                <span class="total" style="float: left;"> 
                                    <?php
                                   
                                        echo \common\models\Post::arabic_w2e(number_format($order_p->price_final));
                                    
                                    ?> 

                                    تومان</span>                                                         
                            </td>



                        </tr>
                        <tr class="summary bgorgm">


                            <td style="font-weight: bold;padding: 5px;border: 1px solid #abb;font-family: tahoma;font-size: 13px; text-align: center" class="total-action" colspan="5">

                                <label>خرید آنلاین  </label>
                            </td>


                        </tr>

                    </tfoot>
                </table>

            </div>
        </div>
        <div class=" alert alert-info " style="margin-top: 10px;">

            <?PHP 
            
            
            $usr = User::find()->where('id=' . $model->user_id)->one();
            $address = common\models\Address::findOne($model->address_id);
            
            ?>

            <table>
                <tr>
                    <td><span>نام و نام خانوادگی :</span></td>
                    <td> <?PHP echo $usr->name_and_fam."|".$address->name_and_fam?></td>

                </tr>
                
                <tr>
                    <td><span>شماره تلفن همراه :</span></td>
                    <td><?PHP echo $address->cell_number; ?></td>

                </tr>
                <tr>
                    <td><span>آدرس : </span></td>
                    <td><?PHP echo $address->address; ?></td>

                </tr>    

                <tr>
                    <td><span>کد پستی:</span></td>
                    <td><?PHP echo $address->postal_code; ?></td>

                </tr>
                
                <tr>
                    <td><span>توضیحات:</span></td>
                    <td><?PHP echo $address->description; ?></td>

                </tr>

            
        
                <tr>
                    <td><span>شهر :</span></td>
                    <td><?php
                        $cty = common\models\location::findOne($address->city_id);
                        echo $cty->name;
                        ?></td>
                </tr>
            </table>


        </div>
    </div>












