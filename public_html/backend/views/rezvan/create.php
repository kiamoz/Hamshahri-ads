<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Rezvan */

$this->title = 'آپلود فایل رضوان';
$this->params['breadcrumbs'][] = ['label' => 'Rezvans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rezvan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
