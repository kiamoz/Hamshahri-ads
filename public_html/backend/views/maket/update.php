<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Maket */

$this->title = 'Update Maket: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Makets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="maket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
