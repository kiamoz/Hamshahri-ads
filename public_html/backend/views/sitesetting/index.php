<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = 'تنظیمات سایت';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitesetting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
        
            
            ['class' => 'yii\grid\SerialColumn'],

            //'fav',
            //'logo',
            'title',
           // 'description',
            

                   ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                        'update' => function ($url, $model, $key) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update','id'=>$model->id]), ['class' => ' label']);
                    },
                            ]
                    
                ],
        ],
    ]); ?>
</div>
