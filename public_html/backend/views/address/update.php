<?php

use yii\helpers\Html;

$this->title = 'ویرایش آدرس : ' . $model->address;
$this->params['breadcrumbs'][] = ['label' => 'آدرس ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="address-update">

    <h1 class="mt15"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
