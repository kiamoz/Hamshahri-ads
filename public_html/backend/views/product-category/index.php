<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'دسته بندی محصولات';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">

    <h1 class="mb10"><?= Html::encode($this->title) ?></h1>
    

    <p class="mb10">
        <?= Html::a(' جدید', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('محصول جدید', ['product/create'], ['class' => 'btn btn-success']) ?>
       
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'options' => [
                'style'=>'overflow: auto; word-wrap: break-word;'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
            'label'=>'تعداد  محصولات',
            'format' => 'raw',
            'value' => function ($model) {                      
                
        return \common\models\ProductHasCategory::find()->where('product_category='.$model->id)->count();
         
                },
            ],
            
            
            [
            'label'=>'دسته اصلی',
            'format' => 'raw',
                 'contentOptions' => ['style'=>'max-width:150px;'],
            'value' => function ($model) { 
                    $daste=common\models\CategoryHasCategory::find()->where('category='.$model->id)->all();
                    foreach($daste as $cats){
                        
                        $ret2 = "";
                        $daste2=common\models\CategoryHasCategory::find()->where('category='.$cats->parent_category)->all();
                    foreach($daste2 as $cats2){
                        $ret2.= \common\models\ProductCategory::findOne($cats2->parent_category)->name." ";
                    }
                        $ret.= \common\models\ProductCategory::findOne($cats->parent_category)->name." (".$ret2.")";
                    }
                    return $ret;
                },
  ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
