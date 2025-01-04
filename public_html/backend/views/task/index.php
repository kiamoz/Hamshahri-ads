<?php

use yii\helpers\Html; 
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Tasksearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'وظایف';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php// print_r(json_decode(Yii::$app->user->identity->level_id));
//echo "*";

?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
                [
            'attribute' => 'title',
            'format'=>'raw',
            'value' => function($data) {
               
                    return $data->ad2->title;
            }
        ],
                [
            'attribute' => 'end_time',
            'format' => 'raw',
            'value' => function($data) {
              //if ($data->end_time !='0000-00-00')
                return  ($data->end_time);
            }
        ],
                [
            'attribute' => 'start_time',
            'format' => 'raw',
            'value' => function($data) {
              if ($data->start_time !='0000-00-00')
                return common\models\Persian::convert_date_to_fa($data->start_time);
            }
        ],
                
           'status',
           
            'model_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div> 
   