<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Reject */

$this->title = 'رد';
$this->params['breadcrumbs'][] = ['label' => 'Rejects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
