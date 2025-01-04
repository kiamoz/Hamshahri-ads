<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Ad;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Transitionsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'گردش های مالی';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transition-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php Html::a('Create Transition', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $url = \yii\helpers\Url::to(['/ad/listr']); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'date1',
                'format' => 'raw',
                'filterInputOptions' => [
                    'class' => 'form-control example1 first_date',
                    'autocomplete' => "off",
                    'data-name' => 'Transitionsearch[date2]',
                ],
                'value' => function ($data) {
                    if ($data->date != '0000-00-00' and $data->date != null)
                        return common\models\Persian::convert_date_to_fa($data->date, false);
                }
            ],
            [
                'attribute' => 'amount',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->amount)
                        return number_format($data->amount) . " " . \common\models\User::list_transition_icon[$data->type];
                },
                'footer' => number_format(Ad::getTotal($dataProvider->models, 'amount')) . "<br>" . number_format($dataProvider->query->sum('amount')),
            ],
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                // 'data'=>array($searchModel->customer_id=>'sss'),
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'language' => 'fa',
                    'initValueText' => common\models\User::findOne($searchModel->user_id)->name_and_fam,
                    'options' => ['placeholder' => 'نام کارگذار'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'لطفا صبر کنید . . . '; }"),
                        ],
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],
                ]),
                'value' => function ($data) {
                    // $user = common\models\Transition::find()->innerJoinWith('user')->where(['user_id' => $data->user_id])->all();
                    //   print_r( $user->createCommand()->getRawSql());
//                 print_r($user);
//                 exit();
                    return $data->user->name_and_fam;
                },
            ],
            ['attribute' => 'auto_date',
                'value' => function ($date) {
                    return common\models\Persian::convert_date_to_fa($date->auto_date, true);
                }],
//                    [
//                    'attribute' => 'type',
//                    'format' => 'raw',
//                    'value' => function ($data) {
//                        return common\models\User::list_transition[$data->type];
//                    }
//                ],
            [
                'header' => 'نوع',
                'format' => 'raw',
                'attribute' => 'type',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'type',
                    'data' => \common\models\User::list_transition,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => 'نوع',
                    ],
                ]),
                'value' => function ($data) {
                    return \common\models\User::list_transition[$data->type];
                },
            ],
            [
                'attribute' => 'detail',
                'format' => 'raw',
                'value' => function ($data) {


                    if ($data->cheque_date and $data->cheque_date != '0621-02-17')
                        $r .= common\models\Persian::convert_date_to_fa($data->cheque_date, true);
                    $r .= $data->detail . "<br>";

                    if ($data->cheque_num)
                        $r .= 'شماره چک:' . $data->cheque_num . "<br>";
                    if ($data->cheque_num)
                        $r .= 'تاریخ چک:' . \common\models\Persian::convert_date_to_fa($data->cheque_date) . "<br>";
                    if ($data->cheque_num)
                        $r .= 'بانک:' . common\models\Bank::findOne($data->bank_id)->name . "<br>";
                    if ($data->cheque_num)
                        $r .= 'شعبه' . $data->branch . " ,";



                    return $r;
                }
            ],
            'sanad',
            'resid',
            [
                'attribute' => 'balance_naghdi',
                'value' => function ($data) {
                    return number_format((int) $data->balance_naghdi);
                }
            ],
            [
                'attribute' => 'balance_etebari',
                'value' => function ($data) {
                    return number_format((int) $data->balance_etebari);
                }
            ],
            [
                'attribute' => 'wallet',
                'value' => function ($data) {
                    return number_format((int) $data->wallet);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{cash_cheque} {print} ',
                'buttons' => [
                    'cash_cheque' => function ($url, $model, $key) {

                        $options = ['data-confirm' => "مطئن هستید؟", 'data-pjax' => 0];
                        if ($model->type == 12)
                            return Html::a('<i class="icon-energy"></i>', Url::to([
                                                'cash-cheque', 'id' => $model->id]), $options);
                    },
                    'print' => function ($url, $model, $key) {


                        return Html::a('<i class="icon-printer"></i>', Url::to(['print', 'id' => $model->id]), $options);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
