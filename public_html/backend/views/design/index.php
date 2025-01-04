<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Designsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Designs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="design-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Design', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ad_id',
            'tarahi_id',
            'attach',
            'status',
            //'why_reject',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
