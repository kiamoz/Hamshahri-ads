<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DiscountItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'لیست تخفیف ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('ثبت تخفیف جدید', ['create'], ['class' => 'btn btn-primary mr-2']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'cat_id',
            'discount',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete} ',
                'buttons' => [
                    'update' => function ($url, $model, $key) {


 if (in_array(11, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = ['data-confirm' => "مطئن هستید؟", 'data-method' => 'post', 'data-pjax' => 0];
 if (in_array(12, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
