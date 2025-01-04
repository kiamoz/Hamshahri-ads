<?php

use yii\helpers\Html;

$this->title = 'ویرایش دسته بندی محصول: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'دسته بندی محصولات', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="product-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
