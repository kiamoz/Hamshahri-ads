<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$date_publish = $_GET['date_publish'];
$box_id = $_GET['box_id'];

$ad = common\models\Ad::find()->where(['date_publish' => $date_publish, 'box_id' => $box_id])->all();
$count = count($ad);
$box_qty = array();
$ad_id = array();
$ad_id_extra = array();
foreach ($ad as $d) {
    //  echo $d->id . " " . $d->box_id . "<br>";
    for ($i = 0; $i < $d->box_qty; $i++) {
        array_push($ad_id, array($d->id, $i + 1));
    }
}

echo "<br>";


//print_r(array_chunk($ad_id,47));
//print_r($ad);
//exit();
//\common\models\Sitesetting::send_sms('09123863215', 'sghl');
?>
<?php
$ad = 0;
$qt = 0;
?>

<?php
$arr_all = array();
$maket_arr = array();
for ($ii = 0; $ii < 48; $ii++) {

    array_push($arr_all, "*");
}
//print_r($arr_all);
foreach ($arr_all as $key => $value) {
    // echo $key." ".$value."<br>";
    $arr_all[$key] = $ad_id[$key];
}
?>

<?= $content ?>


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



<div class="site-about">
    <code><?= __FILE__ ?></code>
</div>






<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<script src="https://hamshahriads.ir/backend/web/theme/js-core/jquery-core.js"></script>
<script src="https://hamshahriads.ir/backend/web/theme/js-core/jquery-ui-core.js"></script>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<script>

    $('#maket tr td').each(function () {
        // alert($(this).html());
    });
</script>



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


    $(document).ready(function () {
        $('#maket tr td').change(function () {
            console.log("call");
        });
        document.getElementById("maket_form").style.display = 'none';
    });
    $('#jabja').click(function () {
        document.getElementById("maket_form").style.display = 'block';
        console.log('hh');
    });



    function table() {

        var i = 0;
        var obj = {};

        $("td").each(function () {
            obj[i] = $(this).text();
            i++;
        });

//console.log(arr);
//console.log(Object.assign({},arr));
        console.log('obj');
        console.log(obj);
        var date_publish = "<?= $_GET['date_publish']; ?>";
        var box_id = "<?= $_GET['box_id']; ?>";
        console.log(date_publish);
        console.log(box_id);
        var form_data = new FormData();

        form_data.append("box_id", box_id);
        form_data.append("date_publish", date_publish);
        form_data.append("maket", (obj));
        var all = {};
        all['box_id'] = box_id;
        all['date_publish'] = date_publish;
        all['maket'] = obj;
        $.ajax({
            url: "https://hamshahriads.ir/ad/maket",
            data: all,
            datatype: "json",
            type: "POST",
            success: function (data) {
                clickJStoPHPResponse(data);
            }
        });


    }






    function clickJStoPHP(event) {


        var obj = {};
        for (i = 0; i < 10; i++) {


            obj['index' + i] = '9812638' + i;




        }

        console.log(obj);


        $.ajax({
            url: "https://hamshahriads.ir/ad/maket",
            data: {name: "AxxG", id: 31232},
            datatype: "json",
            type: "POST",
            success: function (data) {
                clickJStoPHPResponse(data);
            }
        });
    }

    function clickJStoPHPResponse(data) {
        // Antwort des Server ggf. verarbeiten
        var response = $.parseJSON(data);
        console.log(response);
    }




</script>



