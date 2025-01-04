<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <title>Taggd</title>

        <link rel="stylesheet" href="assets/layout.css">
        <link rel="stylesheet" href="dist/taggd.css">
        <link rel="stylesheet" href="themes/taggd-classic.css">
        <style>html, body { height: 125%; }</style>
    </head>
    <style>
        #output1{
            display:none;
        }
        #output{
            display:none;
        }
        .taggd{
            width:90%;
        }
    </style>
    <body>

        <main class="container">

            <?php
            echo "<img style='width:100%;' id=image2 src='" . "https://hamshahriads.ir/backend/web/" . $file . "' >";

            $on = Yii::$app->user->identity->id;
            $ad_id = $_GET['ad_id'];
            $file = $_GET['file'];
            $tagimg = common\models\Tagimage::find()->where(['ad_id' => $ad_id, 'file' => $file, 'user_id' => 2])->one();
            // print_r($tagimg);
            $data = json_decode($tagimg->data);
            if ($tagimg) {
                ?>

                <pre id="output" name="output"><?php echo json_decode($tagimg->data); ?></pre>
            <?php } else { ?>
                <pre id="output" name="output"></pre>
            <?php }
            ?>

            <button id="btn-generate-output">ذخیره</button>

        </main>
        <!----------------------------------------------------------->
        <h2 style="text-align:right !important; margin-bottom: 50px;margin-top:30px;">مشتری</h2>
        <main class="container">

            <?php
            echo "<img style='width:100%;' id=image1 src='" . "https://hamshahriads.ir/backend/web/" . $file . "' >";



            $tagimg1 = common\models\Tagimage::find()->where(['ad_id' => $ad_id, 'file' => $file, 'user_id' => 1])->one();
            // print_r($tagimg);
            $data1 = json_decode($tagimg1->data);
            if ($tagimg1) {
                ?>

                <pre id="output1" name="output"><?php echo json_decode($tagimg1->data); ?></pre>
            <?php } else { ?>
                <pre id="output1" name="output"></pre>
            <?php }
            ?>

            <button id="btn-generate-output1">ذخیره</button>

        </main>
        <script src="../../backend/web/dist/taggd.js"></script>
        <script src="../../backend/web/dist/functions.js"></script>
        <script>

            var image2 = document.getElementById('image2');

            var buttun = document.getElementById('output');

            var taggd2 = new Taggd(image2, {}, []);

            var pre = document.getElementById('output').innerHTML;

            console.log(pre);
            console.log("*");
            if (pre != "") {
                console.log("&");
                var data__ = <?php echo $data; ?>




                console.log('dataaaaaaaaa');
                console.log(data__);


                for (var i = 0; i < data__.length; i++) {
                    console.log('in for');
                    taggd2.addTag(Taggd.Tag.createFromObject(data__[i]));
                }

            }

            // taggd.setTags();


            taggd2.enableEditorMode();

            var btnGenerateOutput = document.getElementById('btn-generate-output');

            var output = document.getElementById('output');


            btnGenerateOutput.addEventListener('click', function () {
                output.innerHTML = JSON.stringify(taggd2.getTags(), null, 2);
                var obj = JSON.stringify(taggd2.getTags(), null, 2);
                var on = 2;

                var ad_id = "<?= $_GET['ad_id']; ?>";
                var file = "<?= $_GET['file']; ?>";
                console.log('*');
                console.log(file);
                console.log(ad_id);
                console.log(obj);

                var form_data = new FormData();

                form_data.append("ad_id", ad_id);
                form_data.append("file", file);
                form_data.append("on", on);
                form_data.append("data", (obj));
                var all = {};
                all['ad_id'] = ad_id;
                all['file'] = file;
                all['on'] = on;
                all['data'] = obj;
                $.ajax({
                    url: "https://hamshahriads.ir/ad/data",
                    data: all,
                    datatype: "json",
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                    }
                });

            });
















            var image1 = document.getElementById('image1');

            var buttun1 = document.getElementById('output1');

            var taggd1 = new Taggd(image1, {}, []);

            var pre1 = document.getElementById('output1').innerHTML;

            console.log(pre1);
            console.log("*");
            if (pre1 != "") {
                console.log("&");
                var data__1 = <?php echo $data1; ?>




                console.log('dataaaaaaaaa');
                console.log(data__1);


                for (var i = 0; i < data__1.length; i++) {

                    taggd1.addTag(Taggd.Tag.createFromObject(data__1[i]));
                }

            }

            // taggd.setTags();


            taggd1.enableEditorMode();

            var btnGenerateOutput1 = document.getElementById('btn-generate-output1');

            var output1 = document.getElementById('output1');


            btnGenerateOutput1.addEventListener('click', function () {
                output.innerHTML = JSON.stringify(taggd1.getTags(), null, 2);
                var obj1 = JSON.stringify(taggd1.getTags(), null, 2);
                var on1 = 1;

                var ad_id1 = "<?= $_GET['ad_id']; ?>";
                var file1 = "<?= $_GET['file']; ?>";
                console.log('*');
                console.log(file1);
                console.log(ad_id1);
                console.log(obj1);

                var form_data = new FormData();

                form_data.append("ad_id", ad_id1);
                form_data.append("file", file1);
                form_data.append("on", on1);
                form_data.append("data", (obj1));
                var all = {};
                all['ad_id'] = ad_id1;
                all['file'] = file1;
                all['on'] = on1;
                all['data'] = obj1;
                $.ajax({
                    url: "https://hamshahriads.ir/ad/data",
                    data: all,
                    datatype: "json",
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                    }
                });

            });


        </script>

    </body>
</html>
