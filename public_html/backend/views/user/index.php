<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index">

    <h1>کارگزاران</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?php if (in_array(17, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
        <a class="nav-link btn btn-success" href="<?= Url::to(['/user/kar']) ?>">ثبت کارگزار جدید </a> 
    <?php } ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_and_fam',
            [
                'attribute' => 'code_kargozar',
                'value' => function ($data) {
                    return $data->code_kargozar;
                }
            ],
            'company_name',
            [
                'attribute' => 'type',
                'value' => function ($data) {
                    return \common\models\User::type_id_text[$data->lvl];
                }
            ],
            'username',
            [
                'attribute' => 'etebar',
                'value' => function ($model) {


                    if ($model->etebar == 1)
                        return "اعتبار منفی دارد";
                    else
                        return "اعتبار منفی ندارد";
                }
            ],
            [
                'attribute' => 'tarikh_gharardad',
                'value' => function ($model) {


                    if ($model->tarikh_gharardad != '0000-00-00' and $model->tarikh_gharardad)
                        return common\models\Persian::convert_date_to_fa($model->tarikh_gharardad);
                    else
                        return "وارد نشده";
                }
            ],
            'lvl',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update} {login} {delete}',
                'buttons' => [
                    'login' => function ($url, $model, $key) {

                        if (in_array(19, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return "<a href='https://hamshahriads.ir/site/asuser?id=" . $model->id . "&p_id=".Yii::$app->user->identity->id."'><i class='icon-user'></i></a>";
                    },
                    'view' => function ($url, $model, $key) {

                        return Html::a('<i class="icon-eye"></i>', Url::to(['view', 'id' => $model->id]), $options);
                    },
                    'update' => function ($url, $model, $key) {


                        if (in_array(17, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-pencil"></i>', Url::to(['update', 'id' => $model->id, 'code_kargozar' => $model->code_kargozar, 'id' => $model->id]), $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = ['data-confirm' => "مطئن هستید؟", 'data-method' => 'post', 'data-pjax' => 0];
                        if (in_array(18, (array) json_decode(Yii::$app->user->identity->level_id)))
                            return Html::a('<i class="icon-trash"></i>', Url::to(['delete', 'id' => $model->id]), $options);
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
