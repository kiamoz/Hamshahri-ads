<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $model common\models\Contract */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'benefit_rate',
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => function($data) {
                    return number_format($data->price);
                }
            ],
            [
                'attribute' => 'customer_id',
                'format' => 'raw',
                'value' => function($data) {
                    $c = Customer::find()->where(['id' => $data->customer_id])->one();
                    // $model_customer = Customer::find()->where(['name' => $customer_name])->one();
                    return $c->name;
                }
            ],
            'contract_number',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {
                    if ($data == 1)
                        return 'فعال';
                    elseif ($data == 0)
                        return 'غیر فعال';
                }
            ],
        ],
    ])
    ?>

</div>
