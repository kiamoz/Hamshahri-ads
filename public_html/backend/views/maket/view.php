<?php
$this->context->layout = 'main_maket';

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Maket;

/* @var $this yii\web\View */
/* @var $model common\models\Maket */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Makets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maket-view">

    <h1><?php //echo Html::encode($this->title)  ?></h1>

    <?php
//$this->title = 'About';
    $this->params['breadcrumbs'][] = $this->title;
    $date_publish = $_GET['date_publish'];
    $box_id = $_GET['box_id'];
    if ($box_id == 9) {
        
    } elseif ($box_id == 7) {
        
    }

    $findddd = common\models\Box::find()->where(['id' => $box_id])->one();
    ?>
    <h1>صفحه: <?php $findddd->name;
    $ff = common\models\BoxMaket::findOne($box_id);
    echo $ff->name; ?></h1>
    <?php
//echo $date_publish."<br>";
//echo $box_id."<br>"; 
//echo"********id ad haye date o box_id******"."<br>";
    $ad = common\models\Ad::find()->where(['date_publish' => $date_publish, 'box_id' => $box_id])->all();
    foreach ($ad as $hhh) {
//    echo "id: ".$hhh->id;
//    echo "<br>";
    }
//echo "*************************************<br>";
    $counter = 0;
    foreach ($ad as $a) {
        $counter += $a->box_qty;
    }
    $count = count($ad);
//echo "count_box_qty: ". $counter;
    $box_qty = array();
    $ad_id = array();
    $extra = array();
//echo "<br>";
    foreach ($ad as $d) {
        //  echo $d->id . " " . $d->box_id . "<br>";
        for ($i = 0; $i < $d->box_qty; $i++) {
            array_push($ad_id, $d->id);
        }
    }
    $arr_all_last = array();
    for ($i = 0; $i < 48; $i++) {
        array_push($arr_all_last, $ad_id[$i]);
    }
//echo "<hr>";
//echo "adid<br>";
//print_r($ad_id);

    $ja = array();
    $count_ad = count($ad_id);
    for ($i = 0; $i < $count_ad; $i++) {
        if (!in_array($ad_id[$i], $ja)) {
            array_push($ja, $ad_id[$i]);
        }
    }
//echo "<hr>";
//echo "newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww<br>";
//print_r($ja);
//echo "<hr>";

    $ezafi = array();
    $m = array();
    for ($i = 0; $i < 48; $i++) {
        array_push($m, $ad_id[$i]);
    }
    for ($j = 48; $j < $counter; $j++) {
        array_push($ezafi, $ad_id[$j]);
    }
//echo "<hr>";
//echo "m<br>";
//print_r($m);
//echo "<hr>";
//echo "ezafi<br>";
//print_r($ezafi);
//echo "<hr>"; 
    ?>
    <?php
    $ad = 0;
    $qt = 0;
    ?>

    <?php
    $arr_all = array();
    $maket_arr = array();
//
//echo "<br>";
//
//echo "<hr>";
    ?>

    <?php
    $makket = Maket::find()->where(['date' => $date_publish, 'box_id' => $box_id])->one();


    if ($makket) {
        $makket->maket = json_decode($makket->maket);

//    
//echo "<hr>";
//echo "maket->maket<br>";
//
//echo "<br>";
//echo "count:".count($makket->maket)."*"."<br>";
        $arr_all_maket = array();

        $p = 0;
//echo "<hr>";

        foreach ($makket->maket as $exist) {
            $arr_all_maket[$p] = $exist;
            $p++;
        }
//echo "<hr>";
//echo "arrall maket<br>";
//print_r($arr_all_maket);
//echo "<hr>";
//echo "count arr all maket".count($makket->maket);
//echo "<hr>";
        $i = count($makket->maket);
        $count_arr_maket = count($arr_all_maket);
        foreach ($ad_id as $value) {
            if ($i < 48) {
                array_push($arr_all_maket, $value);
            }
            $i++;
        }
//echo "array after push";
//print_r($arr_all_maket);
        if (in_array(null, $arr_all_maket)) {
//    echo "h.<br>";
        }
        for ($i = 0; $i < count($arr_all_maket); $i++) {
            if (!in_array($arr_all_maket[$i], $ad_id)) {
                $arr_all_maket[$i] = "|";
            }
        }
//echo "<hr>";
//echo "arrall maket<br>";
//print_r($arr_all_maket);
        $ja_nashode = array();
//echo "<h4>آگهی هایی که در این صفحه جا نشدند<h4>";
//foreach($ezafi as $o){
//   
//    if($olddd != $o){
//        echo "<a href='".Url::to(['/ad/update', 'id' => $o])."'>".$o ."</a>"."<br>";
//        array_push($ja_nashode,$o);}
//        $olddd=$o;
//}
//$m_count=count($m);
//for($i=0;$i<$m_count;$i++){
//    if (!in_array($m[$i], $arr_all_maket)){
//        if ($oo!=$m[$i]){
//        echo "<a href='".Url::to(['/ad/update', 'id' =>$m[$i] ])."'>".$m[$i] ."</a>"."<br>";
//        //echo "ezafiiii jadidi: ".$m[$i]."<br>";  
//         array_push($ja_nashode,$m[$i]);
//        }
//        $oo=$m[$i];
//    }
//}
//$ma=0;
//$not_repeated=array();
//$arr_all_maket_count=count($arr_all_maket);
//for($i=0;$i<$arr_all_maket_count;$i++){
//    //echo $arr_all_maket[$i];exit();
//   if($ma!=$arr_all_maket[$i] and (!in_array($arr_all_maket[$i], $not_repeated)))
//   {
//       array_push($not_repeated,$arr_all_maket[$i]);
//       $ma=$arr_all_maket[$i];
//       
//       echo "second: ".$ma."<br>";
//       $ad_table= common\models\Ad::find()->where(['id'=>$ma])->one();
//       $c_qrt=$ad_table->box_qty;
//       $counts = array_count_values($arr_all_maket);
//       $count_value= $counts[$ma];
//       if ($ma<$c_qrt)
//            array_push($ja_nashode,$ma);
//   }
//    
//}
//
//echo "<hr>";
//echo "ja nshodeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee:<br>";
//
//print_r($ja_nashode);
//
//echo "<hr>";
//echo "ja nashode<br>";
//echo count($ja_nashode);
//print_r($ja_nashode);
//echo "<hr>";
        $coutnt_maket = count($arr_all_maket);
        for ($i = 0; $i <= $coutnt_maket - 1; $i++) {
            if (!is_numeric($arr_all_maket[$i])) {
                $arr_all_maket[$i] = '|';
//       echo $i."<br>";
            }
        }

//echo "<hr>";
//echo "arr all maket before save<br>";
//print_r($arr_all_maket);
//
//echo "<br>";
//echo "<hr>";
//print_r($ja);
        $count_ja = count($ja);
//echo "count:".$count_ja."<br>";
//echo gettype($count_ja);
//for($i=0;$i<$count_ja;$i++){
        $replace = array();
        foreach ($ja as $jaa) {
            $ja_id = common\models\Ad::find()->where(['id' => $jaa])->one();
            $ja_qty = $ja_id->box_qty;
            $counts = array_count_values($arr_all_maket);
            $count_ja = $counts[$jaa];
            $ja_maket = $ja_qty - $count_ja;
            echo "شناسه آگهی: " . $jaa . "<br>";
            echo "تعداد کل کادر آگهی: " . $ja_qty . "<br>";
            echo "تعداد جا شده در ماکت: " . $count_ja . "<br>";
            echo "تعداد جا مانده: " . $ja_maket . "<br>";
            echo "<a href='" . Url::to(['ad/update', 'id' => $jaa]) . "'>" . 'تغییر آگهی' . "</a>" . "<br>";
            echo "<hr>";
            if ($ja_qty != $count_ja) {
                array_push($replace, $jaa);
            }
        }
//print_r($replace);
//echo "<hr>";
////echo count($makket->maket)."*";
//echo "<hr>";
//
//echo "<hr>";
//echo "arr_all_maket"."<br>";
//
//
//echo "<hr>";
//echo "jaaaaa nashode haaaaaaa:<br>";
//print_r($ja_nashode);
//echo "<hr>";

        $replace_count = count($replace);

        $h = 1;
//echo "last index: ".$replace[$ja_nashode_count-$h];
        $last = common\models\Ad::find()->where(['id' => $replace[$replace_count - $h]])->one();
        $last_qty = $last->box_qty;
        for ($i = 0; $i < 48; $i++) {
            if ($arr_all_maket[$i] == "|" or ! is_numeric($arr_all_maket[$i])) {
                $arr_all_maket[$i] = $replace[$replace_count - $h];
                $last_qty--;
            }
            if ($last_qty <= 0) {
                $h++;
                $last = common\models\Ad::find()->where(['id' => $ja_nashode[$ja_nashode_count - $h]])->one();
                $last_qty = $last->box_qty;
            }
        }
//echo "<hr>";
//echo "jaaaaa nashode haaaaaaa:<br>";
//print_r($ja_nashode);
//echo "<hr>";
//echo "<br>";
        for ($i = 0; $i < $ja_nashode_count; $i++) {

            $ad_tata = common\models\Ad::find()->where(['id' => $ja_nashode[$i]])->one();
            $qty = $ad_tata->box_qty;
            $counts = array_count_values($arr_all_maket);
            $kol = $counts[$ja_nashode[$i]];
            if ($kol != $qty) {


                echo "<br>";

                echo "ad id ja nashode: ";
                //echo "<a href='".Url::to(['/ad/update', 'id' => $o])."'>".$o ."</a>"."<br>";
                echo $ad_tata->id;
                echo "<br>";
                $qty = $ad_tata->box_qty;
                echo "tedad kol: " . $qty . "<br>";
                $counts = array_count_values($arr_all_maket);
                echo "tedad ja shode dar maket: " . $counts[$ja_nashode[$i]] . "<br>";
                $remainder = ($qty) - ($counts[$ja_nashode[$i]]);
                echo "tedad ja mande: " . $remainder . "<br>";
                echo "<a href='" . Url::to(['ad/update', 'id' => $ad_tata->id]) . "'>" . 'تغییر آگهی' . "</a>" . "<br>";
            }
        }



        $makket->maket = json_encode($arr_all_maket);
        $makket->save(false);
    }

    echo "<br>";
    echo "<br>";

    if ($makket)
        $makket->maket = json_decode($makket->maket);
    $i = 0;



    $ff = common\models\Ad::find()->where(['id' => $makket->maket])->one();

    echo "<br>";
    ?>
<?= $content ?>
                    <?php if ($makket) { ?>
        <div style="display:block;">
            <div style="width:60%;">
                <table class="table table-bordered table-condensed" id="maket" style="display:inline;float:left;">
                    <tbody>
                        <?php
                        $i = 0;

                        $j = 1;
                        $c = 0;
                        echo "<tr>";
                        foreach ($arr_all_maket as $td) {
                            $fff = common\models\Ad::find()->where(['id' => $td])->one();
                            if ($i == 4) {
                                echo "</tr><tr>";
                                $i = 0;
                                $j++;
                            }
                            $ii = $i + 1;


                            echo "<td ><a href='" . Url::to(['/ad/view', 'id' => $fff->id]) . "'><span class=label style='background-color:" . \common\models\Ad::status_color[$fff->status] . "'>" . $makket->maket[$c] . "<span></a></td>";


                            $i++;
                            $c++;
                        }
                        // print_r($_GET);
                        $date_publish = $_GET['date_publish'];
                        $box_id = $_GET['box_id'];


                        //$makket->maket=explode('"',strval($makket->maket));
                        //  print_r($makket->maket);
                        echo "<br>";
                        // print_r($makket->maket[8]);
                        ?> 

                    </tbody>
                </table>
            </div>

            <div style="direction:rtl; width:40%; float:right;">
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #88884477;"></div><p style="display:inline; margin-right:5px;">در دست رضوان  </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #ff000096;"></div><p style="display:inline; margin-right:5px;">کنسل شده</p></div>
                <div style="margin-bottom:20px; display:block;"><div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #0000ffa1;"></div><p style="display:inline; margin-right:5px;">در دست پذیرش </p></div>
                <div style="margin-bottom:20px; display:block;"><div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #0fffffa1;"></div><p style="display:inline; margin-right:5px;">در دست سرپرست دبیری </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #f1a10996;"></div><p style="display:inline; margin-right:5px;">در دست  ماکت </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #ffbbff7d;"></div><p style="display:inline; margin-right:5px;"> در دست  طراحی</p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #ff00ff8c;"></div><p style="display:inline; margin-right:5px;">در دست  دبیری </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #0080808a;"></div><p style="display:inline; margin-right:5px;">در دست  پذیرش اول </p></div>
                <div style="margin-bottom:20px; display:block;"><div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #a52a2ab0;"></div><p style="display:inline; margin-right:5px;">در دست مشتری </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #80008085;"></div><p style="display:inline; margin-right:5px;">تایید مالی </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #0080008c"></div><p style="display:inline; margin-right:5px;">چاپ شده </p></div>
                <div style="margin-bottom:20px; display:block;"> <div style="display:inline; border:1px black solid;padding:3px; padding-right:15px; background-color: #7b797996;"></div><p style="display:inline; margin-right:5px;">در دست سوپروایزر </p></div>
            </div>
        </div>
            <?php } else { ?>
        <table class="table table-bordered table-condensed" id="maket">
            <tbody>
                <?php
                $i = 0;
                $c = 0;
                $j = 1;
                echo "<tr>";
                foreach ($arr_all_last as $td) {
                    $ff = common\models\Ad::find()->where(['id' => $td])->one();

                    if ($i == 4) {
                        echo "</tr><tr>";
                        $i = 0;
                        $j++;
                    }
                    $ii = $i + 1;
                    echo "<td ><a href='" . Url::to(['/ad/view', 'id' => $ff->id]) . "'><span class=label style='background-color:" . \common\models\Ad::status_color[$ff->status] . "'>" . $ff->id . "<span></a></td>";
                    $i++;
                }
                // print_r($_GET);
                $date_publish = $_GET['date_publish'];
                $box_id = $_GET['box_id'];

                $makket = Maket::find()->where(['date' => $date_publish, 'box_id' => $box_id])->one();
                //   print_r($makket->maket);
                echo "<br>";
                //print_r($makket->maket[8]);
                ?>     
            </tbody>
        </table>
<?php } ?>

    <br>
    <label style='cursor:pointer; border: 1px solid black; padding: .5% 3%;margin-bottom:5%; display:inline-block; float:right;' href="" onclick="table()">اتمام</label>

    <br>
    <div class="clearfix"></div>


    <div class="maket-form" id="maket_form" style="margin-top:5%;">





    </div>

    <style>
        code{
            display:none;
        }
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




    <script>

    </script>

</div>

