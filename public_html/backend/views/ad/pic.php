<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">

    </div>
    <div class="mx-auto d-flex justify-content-center col-lg-10">
       

        <?php
        echo "<img style='max-width:80%;' id=image2 src='" . "https://hamshahriads.ir/backend/web/" . $file . "' >";

//echo $m ."<br>";
        ?>

    </div>
    <div class="form-group">

    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>


    var image2 = document.getElementById('image2');







    var taggd2 = new Taggd(image2, {}, []);




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

    btnGenerateOutput.addEventListener('click', function () {
        output.innerHTML = JSON.stringify(taggd2.getTags(), null, 2);
    });
</script>
