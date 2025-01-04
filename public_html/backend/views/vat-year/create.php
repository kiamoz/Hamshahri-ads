<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VatYear */

$this->title = 'ثبت';
$this->params['breadcrumbs'][] = ['label' => 'Vat Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vat-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
