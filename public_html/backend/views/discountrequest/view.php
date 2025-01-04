<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Discountrequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Discountrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discountrequest-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('اعمال تخفیف', Url::to(['customer/update', 'id' => $model->customer_id,]), ['class' => 'btn btn-success']);?>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
         
            'customer_id',
            'discount_rate',
            [
                'attribute' => 'p_n',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->p_n == 1)
                        return "منفی";
                    elseif ($data->p_n == 2) {
                        return "مثبت";
                    }
                }
            ],
        ],
    ]) ?>

</div>
