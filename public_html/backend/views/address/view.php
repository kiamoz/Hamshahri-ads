<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->address;
$this->params['breadcrumbs'][] = ['label' => 'آدرس ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-view">

    <h1 class="mt15"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'از حذف این آدرس اطمینان دارید؟',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('بازگشت', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'address:ntext',
            'description:ntext',
            [
            'attribute'=>'city_id',
            'value'=>  \common\models\Address::get_city_name($model->city_id),
            'format' => ['raw'],
            ],
           
        ],
    ]) ?>

</div>
