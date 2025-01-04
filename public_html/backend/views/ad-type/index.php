<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ad Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create Ad Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete} {view} ',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if (in_array(8, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];
                        if (in_array(9, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
