<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DiscountItem */

$this->title = 'ایجاد تخفیف جدید';
$this->params['breadcrumbs'][] = ['label' => 'Discount Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
