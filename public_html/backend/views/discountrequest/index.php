<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\Ad;
/* @var $this yii\web\View */
/* @var $searchModel common\models\Discountrequestsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Discountrequests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discountrequest-index">

    <h1>درخواست های تخفیف</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php//echo Html::a('Create Discountrequest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php $url = \yii\helpers\Url::to(['/ad/list']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
  
            [
            'attribute' => 'customer_id',
            'format' => 'raw',
            // 'data'=>array($searchModel->customer_id=>'sss'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'customer_id',
                'language' => 'fa',
                'initValueText' => common\models\Customer::findOne($searchModel->customer_id)->name,
                'options' => ['placeholder' => 'نام مشتری'],
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
        $find= common\models\Customer::findOne($data->customer_id);
                return $find->name;
            },
        ],
            'discount_rate',
           [
                'attribute' => 'p_n',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->p_n == 1)
                        return "منفی";
                    elseif ($data->p_n == 2) {
                        return "مثبت";
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
