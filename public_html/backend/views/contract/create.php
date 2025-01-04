<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Contract */

$this->title = 'Create Contract';
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-create">
<?php $id=$_GET['id']; ?>
<?php $customer= \common\models\Customer::findOne($id); ?>
    <h1 style="margin-bottom:50px;">ثبت قرارداد تهاتر برای <?php echo $customer->name; ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
