<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'مشتریان';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('مشتری جدید', ['create'], ['class' => 'btn btn-primary mr-2']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'format' => 'raw',
                'attribute' => 'name',
                'value' => function ($model) {
                    $tx = $model->name;
                    $tx .= " (<a target='_blank'  href='" . Url::to(['/ad', 'AdSearch[customer_id]' => $model->id]) . "'>" . common\models\Ad::find()->where(['customer_id' => $model->id])->count() . "</a>)";
                    return $tx;
                    ;
                },
            ],
            [
                'header' => 'نام کارگذار',
                'format' => 'raw',
                // 
                'value' => function ($model) {

                    $user_table = common\models\User::find()->where(['id' => $model->owner_id])->one();
                    return ($user_table->name_and_fam);
                }
            ],
            'social_code',
            'economical_code',
            // 'city',
            // 'phone',
            // 'postal_code',
//            [
//                'header' => 'تخفیف های فعال',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    $ret = "";
//                    foreach (json_decode(common\models\Ad::get_customer_discount($model->id)) as $disc) {
//
//                        $ret .= $disc->text . "<br>";
//                    }
//
//                    return $ret;
//                }
//            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if (in_array(21, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id]), $options);
                    },
                    'view' => function ($url, $model, $key) {
                        // if (in_array(21, (array) json_decode(Yii::$app->user->identity->level_id)))
                        //     return Html::a('<i class="icon-eye"></i>', Url::to(['view', 'id' => $model->id]), $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = ['data-confirm' => "مطئن هستید؟", 'data-method' => 'post', 'data-pjax' => 0];
                        if (in_array(22, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                ],
            ],
        ],
    ]);
    ?>

</div>
