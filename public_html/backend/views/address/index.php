<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'آدرس ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-index">

    <h1 class="mt15"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'address:ntext',
            'description:ntext',
            array(
                'header' => 'شهر',
                'format' => 'raw',
                //'attribute' => '',
                'value' => function($data) {

                    return \common\models\Address::get_city_name($data->city_id);
                }
            ),
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
