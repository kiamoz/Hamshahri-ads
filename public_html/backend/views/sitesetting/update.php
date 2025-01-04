<?php

use yii\helpers\Html;


$this->title = 'ویرایش تنظیمات سایت: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'تنظیمات سایت', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="sitesetting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
