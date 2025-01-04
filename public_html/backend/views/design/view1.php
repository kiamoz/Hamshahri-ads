<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Taggd</title>

        <link rel="stylesheet" href="assets/layout.css">
        <link rel="stylesheet" href="dist/taggd.css">
        <link rel="stylesheet" href="themes/taggd-classic.css">
        <style>html, body { height: 125%; }</style>
    </head>
    <body>

        <main class="container">
            <div class="row" style="text-align:center; margin-bottom:2%;">
                <div class="col-12 col-lg-6">
                    <h2>عکس طراحی</h2>
                </div>
                <div class="col-12 col-lg-6">
                    <h2>عکس مشتری</h2>
                </div>
            </div>
            <?php
            $ad_id = $_GET['ad_id'];
            $design_table = \common\models\Design::find()->where(['ad_id' => $ad_id])->all();
            $document_table = \common\models\Document::find()->where(['ad_id' => $ad_id])->all();
            $count_document = count($document_table);
            $count_design = count($design_table);
//             echo "document: ".$count_document."<br>";
//             echo "design: " .$count_design;
            if ($count_document > $count_design) {
                $count = $count_document;
            } else {
                $count = $count_design;
            }
            for ($i = 0; $i < $count; $i++) {
                ?>

                <div class="row" style="margin-bottom:5%;">
                    <div class="col-12 col-lg-6">
                        <?php
                        if ($design_table[$i]->attach != null)
                            echo "<img style='width:95%;' id=image2 class=myimage src='https://hamshahriads.ir/backend/web/" . $design_table[$i]->attach . "' >";
                        ?>
                    </div>
                    <div class="col-12 col-lg-6"> 
                        <?php
                        if (strpos($document_table[$i]->file, 'uploads/') !== false) {
                            echo"<div class=img-magnifier-container>";
                            echo "<img style='width:95%;' class=myimage  src='https://hamshahriads.ir/backend/web/" . $document_table[$i]->file . "' >";
                            echo "</div>";
                        } elseif (strpos($document_table[$i]->file_doc, 'uploaded_document/') !== false) {
                            echo"<div class=img-magnifier-container>";

                            echo "<img style='width:95%;' class='myimage' src='/" . $document_table[$i]->file_doc . "' >";
                            echo "</div>";
                        } elseif (strpos($document_table[$i]->file, 'uploaded_document/') !== false) {
                            echo"<div class=img-magnifier-container>";

                            echo "<img style='width:95%;' class='myimage' src='/" . $document_table[$i]->file . "' >";
                            echo "</div>";
                        }
                      //  echo "<img style='width:95%;' id=image2 src='https://hamshahriads.ir/backend/web/" . $document_table[$i]->file . "' >";
                        ?>
                    </div>
                </div> 
            <?php } ?>
        </main>

        <style>
            * {box-sizing: border-box;}

.img-magnifier-container {
  position: relative;
}

.img-magnifier-glass {
  position: absolute;
  border: 3px solid #000;
  border-radius: 50%;
  cursor: none;
  /*Set the size of the magnifier glass:*/
  width: 100px;
  height: 100px;
}
        </style>


     <script>

            function zoom(imgID) {
                img = document.getElementsByClassName(imgID);
                console.log(img);
                var i;
                for (i = 0; i < img.length; i++) {
                    console.log(img[i]);
                    magnify(img[i], 3);
                }
               
            }

            function magnify(img, zoom) {
                var  glass, w, h, bw;




                /* Create magnifier glass: */
                glass = document.createElement("DIV");
                glass.setAttribute("class", "img-magnifier-glass");

                /* Insert magnifier glass: */
                img.parentElement.insertBefore(glass, img);

                /* Set background properties for the magnifier glass: */
                glass.style.backgroundImage = "url('" + img.src + "')";
                glass.style.backgroundRepeat = "no-repeat";
                glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
                bw = 3;
                w = glass.offsetWidth / 2;
                h = glass.offsetHeight / 2;

                /* Execute a function when someone moves the magnifier glass over the image: */
                glass.addEventListener("mousemove", moveMagnifier);
                img.addEventListener("mousemove", moveMagnifier);

                /*and also for touch screens:*/
                glass.addEventListener("touchmove", moveMagnifier);
                img.addEventListener("touchmove", moveMagnifier);
                function moveMagnifier(e) {
                    var pos, x, y;
                    /* Prevent any other actions that may occur when moving over the image */
                    e.preventDefault();
                    /* Get the cursor's x and y positions: */
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;
                    /* Prevent the magnifier glass from being positioned outside the image: */
                    if (x > img.width - (w / zoom)) {
                        x = img.width - (w / zoom);
                    }
                    if (x < w / zoom) {
                        x = w / zoom;
                    }
                    if (y > img.height - (h / zoom)) {
                        y = img.height - (h / zoom);
                    }
                    if (y < h / zoom) {
                        y = h / zoom;
                    }
                    /* Set the position of the magnifier glass: */
                    glass.style.left = (x - w) + "px";
                    glass.style.top = (y - h) + "px";
                    /* Display what the magnifier glass "sees": */
                    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
                }

                function getCursorPos(e) {
                    var a, x = 0, y = 0;
                    e = e || window.event;
                    /* Get the x and y positions of the image: */
                    a = img.getBoundingClientRect();
                    /* Calculate the cursor's x and y coordinates, relative to the image: */
                    x = e.pageX - a.left;
                    y = e.pageY - a.top;
                    /* Consider any page scrolling: */
                    x = x - window.pageXOffset;
                    y = y - window.pageYOffset;
                    return {x: x, y: y};
                }
            }




            zoom("myimage");
        </script>


    
    </body>
</html>
