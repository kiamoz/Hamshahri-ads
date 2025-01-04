<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Transition */

$this->title = 'Create Transition';
$this->params['breadcrumbs'][] = ['label' => 'Transitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transition-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
