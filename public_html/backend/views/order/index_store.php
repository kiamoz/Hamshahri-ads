<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [ 'style' => 'overflow: auto; word-wrap: break-word;'],
        'rowOptions' => function ($model, $index, $widget, $grid) {

            if ($model->status == 2) {
                return ['class' => 'green'];
            }
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    array(
                        'header' => 'تاریخ',
                        'format' => 'raw',
                        'attribute' => 'status',
                        'value' => function($data) {


                            return $data->date_farsi;
                        }
                    ),
                     array(
                        'header' => 'شماره همراه',
                        'format' => 'raw',
                        //'attribute' => 'name_and_fam', 
                        'value' => function($data) {


                            $usr = \common\models\User::findOne($data->user_id);

                            return \common\models\Post::arabic_w2e($usr->cell_number);
                        },
                    ),
                                array(
                        'header' => ' نام سفارش دهنده',
                        'format' => 'raw',
                        //'attribute' => 'name_and_fam', 
                        'value' => function($data) {


                            $usr = \common\models\User::findOne($data->user_id);

                            return '<a target="_blank" href="' . Url::to(['order/index_user', 'id' => $data->user_id]) . '">' .$usr->name_and_fam .' '.\common\models\Post::arabic_w2e($usr->cell_number). '</a>';
                            
                        },
                    ),
                    array(
                        'header' => 'مبلغ سفارش',
                        'format' => 'raw',
                        // 'attribute' => 'some_title',
                        'value' => function($data) {

                           return common\models\Post::arabic_w2e(number_format($data->amount));
                        },
                    ),
                    array(
                        'header' => 'با تخفیف',
                        'format' => 'raw',
                        // 'attribute' => 'some_title',
                        'value' => function($data) {

                            return common\models\Post::arabic_w2e(number_format($data->off));
                        },
                    ),
                    array(
                        'header' => 'وضعیت سفارش',
                        'format' => 'raw',
                        'attribute' => 'status',
                        'value' => function($data) {


                            return common\models\Order::getStatus($data->status);
                        }
                    ),
                    
                    array(
                        'header' => 'نحوه ی فروش ',
                        'format' => 'raw',
                        // 'attribute' => 'some_title',
                        'value' => function($data) {
                            $ret = "";
                            $ship = \common\models\Order::findOne($data->id);
                            switch ($ship->forosh) {
                                case 0:
                                    $ret = "حضوری";
                                    break;
                                case 1:

                                    $ret = "ارسال";
                                    break;
                                
                            }
                            return $ret;
                        },
                    ),
                    array(
                        'header' => 'نحوه ی تسویه',
                        'format' => 'raw',
                        'value' => function($data) {
                            $ret = "";
                            $pay = \common\models\Order::findOne($data->id);
                            
                            $_payment=array();
                            $_payment=['نقدی','کارت','کارت به کارت','pos','امانی'];
                            return  $_payment[$pay->payment];
                            
                            
                        },
                    ),
                    array(
                        'header' => 'تخفیف',
                        'format' => 'raw',
                        // 'attribute' => 'some_title',
                        'value' => function($data) {
                            
                            
                            switch ($data->off_type) {
                                case 0:
                                    $ret = "درصد";
                                    break;
                                case 1:

                                    $ret = "رقم";
                                    break;
                                
                            }
                            if($data->off_price==0){
                                return '-';
                            }else{
                                return $ret;
                            }
                            
                        },
                    ),
                                array(
                        'header' => 'مقدار تخفیف',
                        'format' => 'raw',
                        // 'attribute' => 'some_title',
                        'value' => function($data) {
                            
                            
                            
                            return \common\models\Post::arabic_w2e($data->off_price);
                        },
                    ),
                                
                                
                            
                            
                            
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>

</div>
