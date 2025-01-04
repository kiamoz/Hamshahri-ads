<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InvoiceType_serach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'مدل های فاکتور';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('ثبت مدل فاکتور', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ad_type',
            'account_number',
            'number_of_card_title',
            'pages',
            //'andazegiri',

           
            
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}  {delete} {view}',
            'buttons' => [
               
                'update' => function ($url, $model, $key) {
                    if (in_array(2, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
                },
                'view' => function ($url, $model, $key) {

                    return Html::a('<i class="icon-eye"></i>', Url::to(['view', 'id' => $model->id]), $options);
                },
                'delete' => function ($url, $model, $key) {

                    $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];
                    if (in_array(3, (array) json_decode(Yii::$app->user->identity->level_id)))
                        return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                }
            ],
        ],
            
            
            
        ],
    ]); ?>
</div>
