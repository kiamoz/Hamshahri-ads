<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$date_publish = $_GET['date_publish'];
$box_id = $_GET['box_id'];?>
 <?php
        echo "<img style='max-width:80%;' id=image2 src='" . "https://hamshahriads.ir/backend/web/".$file . "' >";
?><?php
//print_r(array_chunk($ad_id,47));
//print_r($ad);
//exit();
//\common\models\Sitesetting::send_sms('09123863215', 'sghl');
?>
<?php

?>
 
<?php

?>

<?= $content ?>


<style>

   
</style>


<script src="../../backend/web/dist/taggd.js"></script>
<script src="../../backend/web/dist/functions.js"></script>



<div class="site-about">
    <code><?= __FILE__ ?></code>
</div>




<!--

<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<script src="https://hamshahriads.ir/backend/web/theme/js-core/jquery-core.js"></script>
<script src="https://hamshahriads.ir/backend/web/theme/js-core/jquery-ui-core.js"></script>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


-->




<script>
           window.onload= function (){ 

            var image2 = document.getElementById('image2');

            var taggd2 = new Taggd(image2,{}, []);

            var data__ = [
                {
                    "position": {
                        "x": 0.19,
                        "y": 0.4
                    },
                    "text": "This is a tree",
                    "buttonAttributes": {},
                    "popupAttributes": {}
                },
                {
                    "position": {
                        "x": 0.5,
                        "y": 0.3
                    },
                    "text": "کیارش مظفری",
                    "buttonAttributes": {},
                    "popupAttributes": {}
                },
                {
                    "position": {
                        "x": 0.642578,
                        "y": 0.703125
                    },
                    "text": "New lllllll",
                    "buttonAttributes": {},
                    "popupAttributes": {}
                }
            ];
            for (var i = 0; i < data__.length; i++) {
                taggd2.addTag(Taggd.Tag.createFromObject(data__[i]));
              

            }

            // taggd.setTags();
            taggd2.enableEditorMode();

            var btnGenerateOutput = document.getElementById('btn-generate-output');
            var output = document.getElementById('output');
if(btnGenerateOutput){
            btnGenerateOutput.addEventListener('click', function () {
                output.innerHTML = JSON.stringify(taggd2.getTags(), null, 2);
            
            });
            }
        }   
        </script>
