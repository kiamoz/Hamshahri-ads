<?php

use yii\helpers\Html;
use yii\widgets\DetailView; 
use common\models\Ad;
use common\models\User;
use yii\grid\GridView;
use kartik\select2\Select2; 
/* @var $this yii\web\View */
/* @var $model common\models\Ad */ 

//$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        
        <?php 
//        $h=$model->id;
//        echo $h;
//        exit();
        
//        $my_ad=Ad::findOne($model->id);
        //print_r(getErrors( $my_ad));
//       print_r ($my_ad->getErrors());
//       echo $my_ad;
//print_r(getErrors($task));
//        echo $my_ad;
//        exit();
//        echo "my_ad". $my_ad ."<br>";
        $user_id = Yii::$app->user->identity->id;
       // $taskk=Task::find()->where(['id' =>$id])->one();
      //  echo "user_id". $user_id."<br>";
      // echo "active user". $model->active_user_id."<br>";
        //echo $model->dabiri_id;
echo $model->status;
        if ((Yii::$app->user->identity->lvl==1) or ($model->active_user_id==$user_id)){
            ?>
        <?= Html::a('تایید وضعیت فعلی ', ['verify', 'id' => $model->id],['class' => 'btn btn-success']) ?>
        <?php } ?>
     
         
       
       
  
        
    <h2>وضعیت فعلی:<?= Ad::status_text[$model->status] ?></h2>
        
        
        
        
            
            
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

   
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
           
            
    
    [
            'attribute' => 'start_time',
            'format'=>'raw',
            'value' => function($data) {
               if ($data->start_time !='0000-00-00 00:00:00')
                return common\models\Persian::convert_date_to_fa($data->start_time,true);
                 
            }
            
        ],
                [
            'attribute' => 'end_time',
            'format'=>'raw',
            'value' => function($data) {
             if ($data->end_time !='0000-00-00 00:00:00')
                return  common\models\Persian::convert_date_to_fa($data->end_time,true);
            }
        ],
            [
                'header' => 'وضعیت',
                'format' => 'raw',
                'attribute' => 'status',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => \common\models\Task::status_task,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => 'وضعیت آگهی',
                    ],
                ]),
                'value' => function($data) {
                    return  \common\models\Task::status_task[$data->status];
                }, 
                 ],
                [
            'attribute' => 'user_id',
            'format'=>'raw',
            'value' => function($data) {
            $c=User::find()->where(['id'=>$data->user_id])->one();
                     // $model_customer = Customer::find()->where(['name' => $customer_name])->one();
                return  $c->name_and_fam;
            }
        ],
               
              //'user_id'  
            
           
        ],
    ]); ?>

</div>
