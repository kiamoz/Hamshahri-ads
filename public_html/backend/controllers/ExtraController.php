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
use common\models\User;

ini_set('max_execution_time', 0);

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

    public $all_discount = [];

    public function actionUpload() {


        $target_file = "excel/1.xlsx";

        $uploadOk = 1;

// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<br>";

                date_default_timezone_set('UTC');

                $xlsx = new \XLSXReader($target_file);
                $sheetNames = $xlsx->getSheetNames();
                foreach ($sheetNames as $sheetName) {

                    //if ($sheetName == "ادرسها") {
                    $sheet = $xlsx->getSheet($sheetName);
                    $this->array2Table($sheet->getData());
                    //}
                    //echo $sheetName . "<br>";
                    // $sheet = $xlsx->getSheet($sheetName);
                    // $this->array2Table($sheet->getData());
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }



        return $this->render('/site/upload');
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

    function array2Table($data) {




        foreach ($data as $key => $row) {



            if ($key == 0)
                continue;


            /*  if($row[1]>=500){
              $model = new \common\models\Customer();
              $model->name = $row[2];
              $model->save(false);
              } */


            // continue;


            /* $model = new \common\models\Customer();
              $model->name = $row[0];
              $model->save(false);


              continue; */



            //print_r($row);





            $m = new \common\models\Ad();
            $kar = User::findOne(['code_kargozar' => $row[4]]);
            $m->resseler_id = $kar->id;


            //echo $kar->name_and_fam."<br>";

            if (!$m->resseler_id) {
                echo "RESE ERR<br>";
            }
            // continue;







            $m->title = $row[19];





            $name_ = \common\models\Customer::findOne(['name' => $row[7]]);

            echo "name_id:" . $name_->id . '<br>';

            if (!$name_->id) {
                $name_ = new \common\models\Customer();
                $name_->name = $row[7];
                $name_->type_h = 1;
                $name_->save(false);
            }

            $m->customer_id = $name_->id;




            // echo $row[4] . "<br>";

            $ar = [];

            for ($i = 20; $i < 24; $i++) {

                $mg = \common\models\DiscountItem::findOne(['name' => $row[$i]]);
                if (!in_array($mg->id, $ar)) {


                    if (!$mg) {

                        $mg = new \common\models\DiscountItem();
                        $mg->name = $row[$i];
                        if ($row[$i])
                            $mg->save(false);
                    }

                    array_push($ar, $mg->id);
                }
            }


            print_r($ar) . "<br>";







            $m->date_publish = \common\models\Persian::convert_date_to_en("13" . $row[17]);
            $m->box_qty = $row[25];
            $m->benefit_rate = str_replace("%", "", $row[24])*100;
            $m->logo = 1;
            $m->in_amount = str_replace(",", "", $row[33]);
            $m->box_price = str_replace(",", "", $row[27]);
            $m->discount_price = str_replace(",", "", $row[34]);
            $row[16] = str_replace(array('ي', 'ك'), array('ی', 'ک'), $row[16]);

            $box = \common\models\Box::findOne(['name' => $row[16]]);
            if (!$box) {
                $box = new \common\models\Box();
                $box->name = $row[16];
                $box->save(false);
            }
            $m->box_id = $box->id;

            //echo $box->id;

            if ($row[10])
                $m->paziresh_id = User::find()->andWhere(['>', 'lvl', 0])->andWhere(['<', 'lvl', 8])->orWhere(['lvl' => 22])->andWhere(['like', 'name_and_fam', $row[10]])->One()->id;

            $m->save(false);
            
            foreach ($ar as $disc) {

                echo $disc . "<br>";
                if ($disc > 0) {
                    $disc__ = new \common\models\AdHasDiscount();
                    $disc__->discount_id = $disc;
                    $disc__->ad_id = $m->id;
                    $disc__->save(false);
                }
            }
            
           // if($key>=10)
               // break;

            //print_r($m->getErrors());
            //exit();
            //exit();
            //if($key>=30)
            //    break;

            continue;


            $model = new \common\models\Customer();
            $model->name = $row[0];
            $model->save(false);


            continue;





            $model = new User();
            $model->type = 8;
            $model->username = $row[1];
            $model->status = 10;
            $model->setPassword(123456);
            $model->code_kargozar = $row[1];

            $model->name_and_fam = str_replace(array('ي', 'ك'), array('ی', 'ک'), $row[2]);

            if ($model->save(false)) {
                echo $row[1] . "<br>";
            } else {
                echo "ERR";
            }

            continue;

            if ($row[0] > 247) {


                $model = \common\models\User::findOne(['code_kargozar' => $row[1]]);


                if (!$model->id) {


                    print_r($row);

                    echo "no model ID $row[1]<br>";
                    $model = new User();
                    $model->username = $row[1];
                    $model->status = 10;
                    $model->setPassword($row[9]);
                    $model->code_kargozar = $row[1];
                    $model->code_sherkat = $row[5];
                    $model->name_and_fam = $row[2] . " " . $row[6];


                    echo $row[2] . " " . $row[6] . "~<br>";

                    $model->address = $row[7];
                    $model->postal_code = $row[8];
                    $model->social_code = $row[9];
                    $model->code_eghtesadi = $row[10];
                    $model->phone_number = $row[11];
                    $model->code_sabt = $row[12];





                    if ($model->save()) {
                        echo $row[1] . ":" . $row[0] . "::SAVE<br>";
                        //exit();
                    } else {
                        echo print_r($model->getErrors());
                    }
                } else {
                    echo $model->id . "<br>";
                }
            }
        }


        print_r($this->all_discount);
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
