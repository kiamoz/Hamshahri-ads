<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BankBalance */

$this->title = 'Update Bank Balance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bank Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bank-balance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
