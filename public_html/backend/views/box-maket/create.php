<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BoxMaket */

$this->title = 'ایجاد صفحه';
$this->params['breadcrumbs'][] = ['label' => 'Box Makets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-maket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
