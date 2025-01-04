<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'دسته بندی محصولات', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-view">

    <h1 class="mb10"><?= Html::encode($this->title) ?></h1>

    <p class="mb10">
        <?= Html::a('مدیریت', ['index'], ['class' => 'btn btn-purple ']) ?>
        <?= Html::a('جدید', ['create'], ['class' => 'btn btn-primary ']) ?>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-blue-alt']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('محصول جدید', ['product/create'], ['class' => 'btn btn-success']) ?>
       
    </p>
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'name',
            [
            'attribute'=>'دسته اصلی',
            'value'=> \common\models\ProductCategory::findOne($model->parent_id)->name,
            ],
            
        ],
    ]) ?>

</div>
