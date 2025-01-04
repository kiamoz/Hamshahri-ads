
<style>
    .select2s{
        width: 500px;
    }
    span.select2.select2-container.select2-container--krajee{
        margin-top: 7px;
    }
    span.select2-selection.select2-selection--multiple , .select2-results__option{
        text-align: right;
        direction: rtl;
    }
    .select2-container .select2-search--inline{
        float: right;
        width: auto;
    }
    .select2-container--krajee .select2-selection--multiple .select2-selection__choice{
        float: right;
        margin: 5px 4px 0 6px;
    }
    </style>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Product;
use yii\helpers\url;
use kartik\select2\Select2; 
use common\models\Optionn;


$this->title = $model->name."*";
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
 
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
            'date',
     
            [
            'attribute'=>'thumbnail',
            'value'=>'http://'.$_SERVER['SERVER_NAME'].'/backend/web/'.$model->image,
            'format' => ['image',['width'=>'200',]],
            ],
           
                    
           
            
        ],
    ]); ?>
    
    <?PHP
    echo $model->date; 
    if(file_exists($site_base.'/backend/web/'.$model->image)){
       echo Product::resize_img($site_base.'/backend/web/'.$model->image	, 90,90, "_".$model->id);
    }
    
    ?>
    
 
</div> 
    
    