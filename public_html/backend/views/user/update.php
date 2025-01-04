<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = ' ویرایش کاربر : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?php
  
    if($model->type==8){
    echo  $this->render('kar', [
        'model' => $model, 
         
    ]) ;
    }else{
        
         echo  $this->render('_form', [
        'model' => $model,
    ]); 
        
    }
?>

</div>
