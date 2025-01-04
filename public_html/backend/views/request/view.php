<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Request */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-view">

    <h1>شناسه درخواست: <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('حذف', ['delete', 'id' => $model->id], [
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
            [
                'attribute' => 'benefit',
                'format' => 'raw',
                'value' => function($data) {


                    return number_format($data->benefit);
                }
            ],
            ['attribute' => 'user_id',
                'format' => 'raw',
                'value' => function($data) {

                    $user = \common\models\User::findOne($data->user_id);
                    return $user->name_and_fam;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {


                    return \common\models\Ad::status_request[$data->status];
                }
            ],
        ],
    ]);
    ?>

    <?php
   
    
    echo Html::beginForm(['pay_benfit','id'=>$model->id], 'post');
    ?>
    <input type="hidden" name="pager" value="<?= $_GET['page'] ?>" />
    <?php
    if(!$model->status)
    echo Html::submitButton('وصول انتخاب شده ها تا سقف :'. number_format($model->benefit)." ", ['class' => 'btn btn-success',]);
    

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',],
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'benefit_price',
                'value' => function($data) {
                    return number_format($data->benefit_price);
                }
            ],
            [
                'attribute' => 'benefit_paid',
                'value' => function($data) {
                    return number_format($data->benefit_paid);
                }
            ],
        ],
    ]);
    ?>

</div>
<div>
<?php
$id = $_GET['id'];
$request = common\models\Request::find()->where(['id' => $id])->all();
    foreach ($request as $r) {
        if ($r->attach)
            
            ?>
        <?php
        echo "<img style='width:60%;height:auto;' id=image1 src='" . "" . $r->attach . "' >";
    }
    ?>
</div>