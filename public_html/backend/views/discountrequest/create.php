<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Discountrequest */

$this->title = 'Create Discountrequest';
$this->params['breadcrumbs'][] = ['label' => 'Discountrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discountrequest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
