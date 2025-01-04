<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$ad=common\models\Ad::find()->where(['date_publish'=>$model->date_publish]);









//\common\models\Sitesetting::send_sms('09123863215', 'sghl');
?>

<table class="table table-bordered table-condensed">
  
  <tbody>
      <?php for($i=1;$i<=12;$i++){ ?>
    <tr>
      <td></td>
      <td><span class="label">#68213</span></td>
      <td></td>
      <td></td>
    </tr>
      <?php } ?>
    
     
  </tbody>
</table>

<style>
    
    td span.label {
    background: #CCC;
    width: 98%;
    height: 73%;
}
    
    td{
        width: 200px;
        height: 50px;
    }
    table-bordered {
  border: 1px solid #000;
}

.table-condensed {
  border-collapse: collapse;
}

.table tr {
  padding: 0.2em;
  border: 1px solid #000;
}

.table tr td {
  border-left: 1px solid #000;
  min-width: 1.5em;
  min-height: 1.5em;
  position: relative;
}

.table tr td span.label {
  position: absolute;
  top: 0.4em;
  left: 0.2em;
}

    </style>



<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<script src="https://hamshahriads.ir/backend/web/theme/js-core/jquery-core.js"></script>
<script src="https://hamshahriads.ir/backend/web/theme/js-core/jquery-ui-core.js"></script>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?=__FILE__ ?></code>
</div>


<script>
    
    $(function() {
  $(".label").draggable();
  $(".table tbody tr td").droppable({
    accept: ".label",
    drop: function(e, ui) {
      ui.draggable.appendTo($(this)).css({
        top: "0.4em",
        left: "0.2em"
      });
    }
  });
});
    
    </script>




