<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\location */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
           
        ],
    ]) ?>

</div>

<div class="shipping-has-location-index">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            array(
            'header'=>'مدل ارسال',     
            'format' => 'raw',
            'value'=>function($data) { 
                return \common\models\shipping_method::find()
                        ->where('id='.$data->shipping_id)
                        ->One()->name;
                
                             
            },
        ),
            
            'price',
            'extra_price',

            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{my_button}',
           
            
            
            
'buttons' => [
    
    
    'e' => function ($url, $model, $key) {
        return '<a  class="fff">ggggg</a>';
    },
            
            
    'my_button' => function ($url, $model, $key)  {
        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>ویرایش<hr>',Url::to(['shipping-has-location/update','shipping_id'=>$model->shipping_id,'location_id'=>$model->location_id]));
    },
            
  
            
]
        ],
        ],
    ]); ?>
</div>
