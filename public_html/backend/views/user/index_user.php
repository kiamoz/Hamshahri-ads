<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <?php //print_r(json_decode(Yii::$app->user->identity->level_id));
    ?>

    
     <?php if (in_array(14, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
     <a class="nav-link btn btn-success" href="<?= Url::to(['/user/create']) ?>"> کاربر جدید</a>

                                           
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_and_fam',
            [
                'attribute' => 'id',
                'value' => function ($data) {
                    return $data->id;
                }
            ],
            [
                'attribute' => 'type',
                'value' => function ($data) {
                    return \common\models\User::type_id_text[$data->lvl];
                }
            ],
            'username',
            [
                'header' => 'حاضر/ غایب',
                'format' => 'raw',
                'attribute' => 'status_p',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status_p',
                    'data' => \common\models\Ad::status_present,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => 'وضعیت کاربر',
                    ],
                ]),
                'value' => function ($data) {
                    return \common\models\Ad::status_present[$data->status_p];
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete} {login} ',
                'buttons' => [
                    'update' => function ($url, $model, $key) {


                        if (in_array(14, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
                    },
                   
                    'delete' => function ($url, $model, $key) {
                        $options = ['data-confirm' => "مطئن هستید؟", 'data-method' => 'post', 'data-pjax' => 0];
                        if (in_array(15, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
