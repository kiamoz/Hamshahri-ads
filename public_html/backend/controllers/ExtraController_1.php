<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Post;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Product;
use common\models\ProductPrice;
use common\models\ProductTag;
use common\models\ProductHasTag;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ExtraController extends Controller {

    public function beforeAction($action) {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        // if($action->id == 'payment_verify'  )
        $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    public function actionUpload() {


        $target_file = "excel/price_.xlsx";

        $uploadOk = 1;

// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<br>";

                date_default_timezone_set('UTC');

                $xlsx = new \XLSXReader($target_file);
                $sheetNames = $xlsx->getSheetNames();
                foreach ($sheetNames as $sheetName) {
                    $sheet = $xlsx->getSheet($sheetName);
                    $this->array2Table($sheet->getData());
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }



        return $this->render('/site/upload');
    }

    public function actionUpload_tag() {


        $target_file = "atc2.xlsx";

        $uploadOk = 1;

// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<br>";

                date_default_timezone_set('UTC');

                $xlsx = new \XLSXReader($target_file);
                $sheetNames = $xlsx->getSheetNames();
                foreach ($sheetNames as $sheetName) {
                    $sheet = $xlsx->getSheet($sheetName);
                    $this->array2Tag($sheet->getData());
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }



        return $this->render('/site/upload_tag');
    }

    public function actionParseDelete($path) {

        date_default_timezone_set('UTC');

        $xlsx = new \XLSXReader('excel/' . $path);
        $sheetNames = $xlsx->getSheetNames();
        foreach ($sheetNames as $sheetName) {
            $sheet = $xlsx->getSheet($sheetName);
            $this->array2Delete($sheet->getData());
        }
    }

    public function actionParsePrice($path) {

        date_default_timezone_set('UTC');

        $xlsx = new \XLSXReader('excel/' . $path);
        $sheetNames = $xlsx->getSheetNames();
        foreach ($sheetNames as $sheetName) {
            $sheet = $xlsx->getSheet($sheetName);
            $this->array2Table($sheet->getData());
        }
    }

    public function actionParseTag() {

        date_default_timezone_set('UTC');

        $xlsx = new \XLSXReader('excel/' . $path);
        $sheetNames = $xlsx->getSheetNames();
        foreach ($sheetNames as $sheetName) {
            $sheet = $xlsx->getSheet($sheetName);
            $this->array2Tag($sheet->getData());
        }
    }

    function array2Delete($data) {

        foreach ($data as $row) {

            if ($row[0] > 0) {


                $model = Product::findOne(['code' => $row[0]]);

                if ($model->id) {
                    if ($model->delete()) {

                        echo $row[0] . "::Deleted <br>";
                    }
                }
            }
        }
    }

    function assign_category($model, $row) {



        for ($i = 7; $i <= 10; $i++) {
            $has_brand = \common\models\ProductCategory::findOne(['name' => $row[$i]]);
            if (!$has_brand) {
                $has_brand = new \common\models\ProductCategory();
                $has_brand->name = $row[$i];
                $has_brand->save();
            }


            $has_cat = \common\models\ProductHasCategory::findOne(['product_id' => $model->id, 'product_category' => $has_brand->id]);
            if (!$has_cat) {

                $m = new \common\models\ProductHasCategory();
                $m->product_id = $model->id;
                $m->product_category = $has_brand->id;
                $m->save();
            }
        }

        //8 ta 11
    }

    function get_tag($row) {

        $ret = "";


        for ($i = 1; $i <= 2; $i++) {
            $ret .= $row[$i] . " ";
        }

        for ($i = 7; $i <= 10; $i++) {
            $ret .= $row[$i] . " ";
        }

        for ($i = 12; $i <= 24; $i++) {
            $ret .= $row[$i] . " ";
        }

        //$ret.= "/";
        //$ret.= "بدون تخفیف";


        return str_replace(["/", "-", "بدون تخفیف", "*", "0بدون تخفیف", "aبدون تخفیف", "-1"], ' ', $ret);
    }

    function array2Tag($data) {

        $i = 0;
        date_default_timezone_set('Asia/Tehran');
        foreach ($data as $row) {

            $i++;



            if (!is_numeric($row[0]))
                continue;


            $model = new Product();
            $temp_p = Product::findOne(['code' => $row[1]]);
            if ($temp_p->id) {
                $model = $temp_p;
            }


            //echo $model->tag_string."<br>";
            //if($i==20)
            // break;
            //continue;




            $model->name = $row[2];
            //echo $model->name;
            // exit();
            $model->code = $row[1];
            $model->unit = $row[3];

            if ($row[11] == 'نمایش') {
                $model->visible = 1;
            } else {
                $model->visible = 0;
            }

            $model->qty = $row[4];


            $has_brand = \common\models\Brand::findOne(['name' => $row[6]]);


            if (!$has_brand) {
                $has_brand = new \common\models\Brand();
                $has_brand->name = $row[6];
                $has_brand->save();
            }
            $model->brand_id = $has_brand->id;
            $model->tag_string = $this->get_tag($row);
            $model->auto_update = date('Y-m-d H:i:s');

            if (!$model->save()) {
                print_r($model->getErrors());
                echo $model->code . "<br>";
                continue;
            } else {
                //echo $model->id;
            }




            //print_r($model->getErrors());


            $price = new ProductPrice();

            $price->selling_rate = $row[5];
            $price->product_id = $model->id;
            $price->save();




            $this->assign_category($model, $row);
            //echo $model->auto_update." ".date("H:m");
            //exit();
        }
    }

    function array2Table($data) {

        foreach ($data as $row) {

            if ($row[0] > 0) {


                $model = Product::findOne(['code' => $row[0]]);


                if (!$model->id) {

                    echo "no model ID $row[0]<br>";
                    $model = new Product();
                    $model->name = $row[1];
                    $model->code = $row[0];
                    if ($model->save())
                        echo $row[1] . ":" . $row[0] . "::SAVE<br>";
                } else {
                    echo $model->id . "<br>";
                }

                $price = new ProductPrice();

                $price->selling_rate = $row[3];
                $price->product_id = $model->id;

                if ($price->save()) {

                    echo $row[0] . "::PRICE ADDED <br>";
                }
                //print_r($price->getErrors());
                //    echo $row[0] . "::PRICE ADDED <br>";
            }
        }
    }

    function debug($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }

}
