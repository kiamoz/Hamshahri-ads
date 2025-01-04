<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserS */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'name_and_fam',
            
            'name',
            'family',
             array(
            'header'=>'کد نمایندگی',     
            'format' => 'raw',
             
            'value'=>function($data) { 
                             
                             
                             $usr = \common\models\NamayandeCode::find()->where('user_id='.$data->id)->one();
                             
                             return $usr->code ; 
                             
            },

             ),
            'username',
           

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
