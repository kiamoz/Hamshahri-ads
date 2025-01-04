<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Transition */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transition-view">

    <h1>شناسه: <?= Html::encode($this->title) ?></h1>

    <p>
        <?php Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('حذف', ['delete', 'id' => $model->id], [
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
            'id',
            'date',
            'amount',
            'user_id',
            'ad_id',
            'type',
            'etebar',
            'actor_id',
        ],
    ]) ?>

</div>
