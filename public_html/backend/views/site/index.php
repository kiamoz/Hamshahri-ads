
<?php

use yii\helpers\Url;
?>
<style>
    .avis-card{
       min-height:200px !important;
       padding:0 !important;
    }
    .avis-card:hover{
         box-shadow:11px 11px 11px 11px rgba(94,37,114,.3); 
    }
</style>
<div style="text-align:center;">
    <div class="row">
        <div class="col-12 ">
            <!--<ul class="navbar-nav navbar-nav-right">-->
<?php

$user_id = Yii::$app->user->identity->id;
// echo $user_id;
// $task1=\common\models\Task::find()->where(['user_id' => $user_id])->andwhere(['status' => 0])->all();
// $adt=\common\models\Ad::find()->where(['active_user_id' => $user_id])->all();
$adt = \common\models\Task::find()->where(['user_id' => $user_id, 'status' => 0])->orderBy(['id' => SORT_DESC])->all();
//  $count = count ( $task1 );

$count = count($adt);
?>
            <!--<li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-bell-outline mx-0"></i>
                    <span class="count"></span>
                </a>-->  

            <p class="" style=" color:black; font-size:16px; font-weight:bold; padding-bottom: 1.5rem;">شما <?php echo $count ?> اعلان دارید
            </p>

            </a>
<?php // foreach($task1 as $t){  ?> <?php

foreach ($adt as $t) {
    $add = \common\models\Ad::find()->where(['id' => $t->model_id])->one();
//    echo "<div style='background-color:" . \common\models\Ad::status_color[$add->status] . "'>";
//    ?>          

            
            
            
            
            
            <div class='col-md-12 grid-margin stretch-card avis-card ' style='position:relative; transition: box-shadow .3s;'>
               
                 <a class=""  href="<?= Url::to(['/ad/view', 'id' => $t->model_id]) ?>" style="text-decoration: none;">
                     
                     <?php echo "<div class='card ' style=' background-color:" . \common\models\Ad::status_color[$add->status] . "'>";?>
                    <div class="card-body text-center bbox" style=" ">
                        <?php if($add->if_rejected==1 or ($add->status==5 and $add->dabiri_id and Yii::$app->user->identity->lvl==5)){?>
                        <div class="badge badge-danger badge-pill" style='background-color:red; color:black;font-size: 22px; width: 7%;'>رد شده</div>
                        <?php } ?>
                        <?php 
                        $find_rej= \common\models\Reject::find()->where(['ad_id'=>$add->id,'status'=>1])->one();
                        if($find_rej and $add->status==2 and Yii::$app->user->identity->lvl==2){?>
                        <div class="badge badge-danger badge-pill" style='background-color:red; color:black;font-size: 22px; width: 300px;'>رد شده توسط دبیری برای کارگذار </div>
                        <?php } ?>
                        <div class="text-primary mb-4">
                          
                        <i class="mdi mdi-account-multiple mdi-36px" style="color:black;"></i>
                        <p class="font-weight-medium mt-2" style='font-size:18px; color:white;'><?php $this_ad = \common\models\Ad::findOne($t->model_id); ?> 
                        <?= \common\models\Ad::status_text[$this_ad->status]; ?></p>
                      </div>
                      <h2 class="font-weight-light" style='color:white;text-align:center;'> <?= $this_ad->title; ?></h2>
                      <p style='color:white;text-align:center;font-size:14px;'>نام کارگذار: <?php $ad= common\models\Ad::findOne($t->model_id); $user= common\models\User::findOne($ad->resseler_id);echo $user->name_and_fam;  ?> </p>
                      <p style='color:white;text-align:center;font-size:14px;'>نام مشتری: <?php $cust= common\models\Customer::findOne($ad->customer_id);echo $cust->name;  ?></p>
                    </div>
                      </a>
                  </div>
                </div>
        <?php } ?>
    </div>
</div>

<!-- </li>    -->  </div>