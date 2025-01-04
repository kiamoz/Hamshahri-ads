<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use common\models\task;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'آگهی';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php  $date=$date=date('Y-m-d').' '.'00:00:00'; //echo $date;?>
<div class="ad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    $gridColumns = [
        [
            'attribute' => 'start_time',
            'format'=>'raw',
            'value' => function($data) {
               
                    return $data->start_time;
            }
        ],
                [
            'attribute' => 'end_time',
            'format'=>'raw',
            'value' => function($data) {
               
                    return $data->end_time;
            }
        ],           
        [
            'attribute' => 'model_id', 
            'format'=>'raw',
            'value' => function($data) {
               
                    return $data->model_id;
            }
        ],
               
                 [
            'header' => 'وضعیت', 
            'format'=>'raw',
            'value' => function($data) {
               $ad= common\models\Ad::findOne($data->model_id);
                    return \common\models\Ad::status_text[$ad->status];
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ];
// You can choose to render your own GridView separately
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider_t,
        'filterModel' => $searchModel_t,
        'columns' => $gridColumns,
        'emptyCell'=>'-',
    ]);
    ?>
</div>
