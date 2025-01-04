<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CustomerDuration */

$this->title = 'Create Customer Duration';
$this->params['breadcrumbs'][] = ['label' => 'Customer Durations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-duration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
