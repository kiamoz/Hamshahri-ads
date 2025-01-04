<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdMsg */

$this->title = 'Create Ad Msg';
$this->params['breadcrumbs'][] = ['label' => 'Ad Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-msg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
