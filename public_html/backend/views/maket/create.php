<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Maket */

$this->title = 'Create Maket';
$this->params['breadcrumbs'][] = ['label' => 'Makets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
