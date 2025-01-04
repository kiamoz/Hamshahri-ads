<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Rezvansearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rezvans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rezvan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rezvan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ad_id',
            'user_id',
            'gallery',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
