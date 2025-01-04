<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = 'رد آگهی ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'cancel';
?>
<div class="ad-update"> 

    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= $this->render('_form_1', [
        'model' => $model,
    ]) ?>

</div>

