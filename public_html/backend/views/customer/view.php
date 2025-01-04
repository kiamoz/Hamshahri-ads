<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\Ad;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$c = common\models\Ad::find()->where(['customer_id' => $data->id])->one();

echo Html::a('ثبت قرارداد تهاتر', Url::to(['contract/create', 'id' => $model->id,]), ['class' => 'btn btn-success']);
?>
<div class="customer-view">
    <?php
    //echo $model->id;
//exit();
    ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    //echo $c13->subject;
    ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
           // 'owner_id',
            'social_code',
            'addres',
            'city',
            'phone',
            'postal_code',
            'economical_code'
        ],
    ])
    ?>
    <?php
    //$add=Ad::find()->where(['customer_id' => $model->id])->one();
    $doc = common\models\Document::find()->where(['customer_id' => $model->id])->one();
//    echo $model->id;
//    echo $model->subject;
//    echo $model->file;
//   exit();
    ?>


    <h3 style="text-align:right;margin:5% 0 5% 0;">فایل های پیوست</h3>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'subject',
                'format' => 'raw',
                'value' => function ($d) {
                    return \common\models\Document::limitword($d->subject, 3) . ' ... ';
                }
            ],
            [
                'attribute' => 'file',
                'format' => 'raw',
                'value' => function ($d) {
                    return "<a target='_blank' href='/" . $d->file . "'>دانلود فایل پیوست</a>";
                }
            ],
        ],
    ]);
    ?>

    <h3 style="text-align:right;margin:5% 0 5% 0;">آگهی های مشتری فعلی</h3>



    <?php
    //     echo $model->id ."<br>";
//  $add=common\models\Ad::find()->where(['customer_id'=>$model->id])->all();
//  print_r($add) ."<br>";
//   exit();
    ?>
    <?php
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider_ad,
        'filterModel' => $searchModel_ad,
        'showFooter' => true,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($da) {
                    // $find = common\models\User::find()->where(['id' => $da->tarahi_id])->one();
                    return "<a href='" . Url::to(['ad/view', 'id' => $da->id]) . "'>" . $da->title . " <i class='icon-share-alt'></i> <a>";
                }
            ],
            [
                'attribute' => 'resseler_id',
                'format' => 'raw',
                'value' => function ($da) {
                    $find = common\models\User::find()->where(['id' => $da->resseler_id])->one();

                    return "<a href='" . Url::to(['user/view', 'id' => $da->resseler_id]) . "'>" . $find->name_and_fam . " <i class='icon-share-alt'></i> <a>";
                }
            ],
            [
                'attribute' => 'date_publish',
                'format' => 'raw',
                'value' => function ($da) {
                    if ($da->date_publish != '0000-00-00')
                        return common\models\Persian::convert_date_to_fa($da->date_publish);
                }
            ],
            [
                'attribute' => 'serial',
                'format' => 'raw',
                'value' => function($da) {
                    if ($da->serial)
                        return $da->serial;
                }
            ],
            [
                'attribute' => 'box_price',
                'format' => 'raw',
                'value' => function($da) {
                    if ($da->box_price)
                        return number_format($da->box_price);
                }
            ],
            [
                'attribute' => 'total_price',
                'format' => 'raw',
                'value' => function($da) {
                    if ($da->total_price)
                        return number_format($da->total_price);
                }
            ],
            [
                'attribute' => 'discount_price',
                'format' => 'raw',
                'value' => function($da) {
                    if ($da->discount_price)
                        return number_format($da->discount_price);
                },
                'footer' => number_format(Ad::getTotal($dataProvider_ad->models, 'discount_price')) . "<br>" . number_format($dataProvider_ad->query->sum('discount_price')),
            // 'footer' =>      $dataProvider->query->sum('discount_price'),
            ],
            [
                'attribute' => 'in_amount',
                'format' => 'raw',
                'value' => function($da) {
                    if ($da->in_amount)
                        return number_format($da->in_amount);
                }
            ],
            [
                'attribute' => 'benefit_price',
                'format' => 'raw',
                'value' => function($da) {
                    return $da->benefit_price ? number_format($da->benefit_price) : 'ثبت نشده';
                },
                'footer' => number_format(Ad::getTotal($dataProvider_ad->models, 'benefit_price')) . "<br>" . number_format($dataProvider_ad->query->sum('benefit_price')),
            ],
            [
                'header' => 'مبلغ نهایی(خالص)',
                'format' => 'raw',
                'value' => function($da) {
                    if ($da->discount_price)
                        return number_format($da->total_price - $da->discount_price - $da->benefit_price);
                },
            ],
        ]
    ]);
    ?>

</div>
