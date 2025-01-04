<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;



$id=688;
for($i=17;$i<=100;$i++,$id++){
    $g= new common\models\Ad();
    $g->id = $id;
    if($i<100)
            $g->custom_id = "3,00".$i;
    else
         $g->custom_id = "3,0".$i;
    echo $g->custom_id."<br>";
    if(!$g->save()){
        echo "err";
    }
    
}



exit();

$ad = common\models\Ad::find()->where(['date_publish' => $model->date_publish]);

//\common\models\Sitesetting::send_sms('09123863215', 'sghl');
?>


<?php
//require( '/home/avishost/hamshahriads.ir/frontend/web/XLSXReader.php');

$target_file = "/home/avishost/hamshahriads.ir/frontend/web/ex.xlsx";

$uploadOk = 1;

// Check if image file is a actual image or fake image




date_default_timezone_set('UTC');

$xlsx = new \XLSXReader($target_file);
$sheetNames = $xlsx->getSheetNames();
foreach ($sheetNames as $sheetName) {


    if($sheetName!= 'کارگزاران')
    continue;

    $sheet = $xlsx->getSheet($sheetName);
    post($sheet->getData());
}

function Post($data) {


    foreach ($data as $row) {

       $m = new common\models\User();
       $m->type = 8;
       $m->status = 10;
       $m->setPassword(123456);
       $m->username = $row[0];
       $m->name_and_fam = $row[1];
       $m->code_kargozar = $row[0];
       $m->save();
       
       // echo $row[] . "\n";

        //$post = new \common\models\TmsPricing();
        //$post->weight_start = (string) $row[0];
        //$post->weight_to = (string) $row[1];
    }
}

exit();
?>



<table class="table table-bordered table-condensed">

    <tbody>
        <?php for ($i = 1; $i <= 12; $i++) { ?>
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

    <code><?= __FILE__ ?></code>
</div>


<script>

    $(function () {
        $(".label").draggable();
        $(".table tbody tr td").droppable({
            accept: ".label",
            drop: function (e, ui) {
                ui.draggable.appendTo($(this)).css({
                    top: "0.4em",
                    left: "0.2em"
                });
            }
        });
    });

</script>




