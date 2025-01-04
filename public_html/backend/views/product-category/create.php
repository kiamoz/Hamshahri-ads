<?php

use yii\helpers\Html;

$this->title = 'دسته بندی محصول جدید';
$this->params['breadcrumbs'][] = ['label' => 'دسته بندی محصولات', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
