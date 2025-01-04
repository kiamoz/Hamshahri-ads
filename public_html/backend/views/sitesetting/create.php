<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sitesetting */

$this->title = 'تنظیمات سایت جدید';
$this->params['breadcrumbs'][] = ['label' => 'تنظیمات سایت', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitesetting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
