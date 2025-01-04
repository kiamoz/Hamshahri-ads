<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BoxMaket */

$this->title = 'Update Box Maket: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Box Makets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box-maket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
