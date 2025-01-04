<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tagimage */

$this->title = 'Create Tagimage';
$this->params['breadcrumbs'][] = ['label' => 'Tagimages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagimage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
