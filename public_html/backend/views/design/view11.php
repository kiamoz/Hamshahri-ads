<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Taggd</title>

          <link rel="stylesheet" href="/assets/layout.css">
        <link rel="stylesheet" href="/dist/taggd.css">
        <link rel="stylesheet" href="/themes/taggd-classic.css">
        <style>html, body { height: 125%; }</style>
    </head>
    <style>
        #output{
            display:none;
        }
    </style>
    <body>

        <main class="container">
            
               <?php 
        echo "<img style='' id=image2 src='" . "https://hamshahriads.ir/backend/web/".$file . "' >";
         $ad_id =  $_GET['ad_id'];
        $file= $_GET['file'];
        $find= common\models\Ad::find()->where(['id'=>$ad_id])->one();
        
        
       
       
     
        $tagimg= common\models\Tagimage::find()->where(['ad_id'=>$ad_id,'file'=>$file,'user_id'=>$find->resseler_id])->one();
        if($tagimg){
            $data_table= json_decode($tagimg->data);?>
            <pre id="output" name="tarahioutput"><?php echo $data_table; ?></pre>
       <?php }else{?>
           <pre id="output" name="tarahioutput"></pre>
    <?php   } 
?>

            <button id="btn-generate-output">ذخیره</button>

        </main>

 <script src="/dist/taggd.js"></script>
<script src="/dist/functions.js"></script>
        <script> 
            

            var image2 = document.getElementById('image2');

            var buttun=document.getElementById('output');
            console.log(output);



            var taggd2 = new Taggd(image2,{}, []);



           var pre=document.getElementById('output').innerHTML;
          
         console.log(pre);
         console.log("*");
         if(pre !=""){
             console.log("&");
           var data__ = <?php echo $data_table; ?>
       
          
           console.log(data__);

           console.log('dataaaaaaaaa');
           console.log(data__);


            for (var i = 0; i < data__.length; i++) {
                taggd2.addTag(Taggd.Tag.createFromObject(data__[i]));
            }

           }
            // taggd.setTags();

           
            taggd2.enableEditorMode();

            var btnGenerateOutput = document.getElementById('btn-generate-output');
            var output = document.getElementById('output');

            btnGenerateOutput.addEventListener('click', function () {
                output.innerHTML = JSON.stringify(taggd2.getTags(), null, 2);
                var obj=JSON.stringify(taggd2.getTags(), null, 2);
                
 var ad_id = "<?= $_GET['ad_id']; ?>";
 var file = "<?= $_GET['file']; ?>";
 console.log('fileeee');
 console.log(file); 
  console.log('objjjjjjjjjj');
                console.log(obj);
                
        var form_data = new FormData();

 
 
 
        form_data.append("ad_id", ad_id);
        form_data.append("file", file);
        form_data.append("data", (obj));
        var all = {};
        all['ad_id'] = ad_id;
        all['file'] = file;
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
            
            

        </script>

    </body>
</html>