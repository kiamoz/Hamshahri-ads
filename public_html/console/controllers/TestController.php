<?php

namespace console\controllers;

date_default_timezone_set('Asia/Tehran');

use common\models\Ad;
use common\models\Persian;
use common\models\VatYear;
use yii\console\Controller;




/**
 * Test controller
 */
class TestController extends Controller
{

    public function actionFf()
    {



        \Yii::$app->params['vat'] = VatYear::get_vat_year();
        echo "....is here......\n...\n";


        //->andWhere(['pay_status'=>1])
        //'>', 'cash', 0]

        $i=0;

        //echo Ad::find()->where(['pay_status'=> 0])->andWhere(['>','custom_id',0])->andWhere(['<=','custom_id',19709])->orderBy(['custom_id'=>SORT_DESC])->createCommand()->getRawSql();
        //exit();
        foreach (Ad::find()->where(['pay_status'=> 0])->andWhere(['>','custom_id',0])->orderBy(['custom_id'=>SORT_DESC])->each(1000) as $ad) {

            $i++;
            echo $i." (".$ad->custom_id.")(".$ad->id.")\n";
            //echo $ad->custom_id."\n";
            $final_price = null;
            $vat_pric = null;

            if ($ad->vat) {

                $vat_pric = $ad->in_amount *  VatYear::vatfinder($ad);
            }


            if ($ad->naghdi_etebari == 2) {

                if ($ad->cash == ($ad->in_amount + $vat_pric))
                    $ad->pay_status = 1;
                else
                    $ad->pay_status = 0;
                

                echo "pay_etebari\n";    
                $ad->save(false);
                continue;
            }


            $final_price =   (int)(($ad->in_amount - $ad->benefit_price) + $vat_pric);
            
            
            if ($final_price != (int)$ad->cash) {

                echo "NOPAY -->".$vat_pric." ";

                echo $final_price . "  " . $ad->cash . "\n";
                $ad->pay_status = 0;

                //print_r($ad->getErrors());
            } else {
                echo "YESPAY\n";
                $ad->pay_status = 1;
            }

           
            //SAVE:
            if(!$ad->save(false)){
                print_r($ad->getErrors());
            }

            unset($ad);

            //sleep(1);
        }
    }



    public function actionIndex()
    {



        \Yii::$app->params['vat'] = VatYear::get_vat_year();
        echo "....is here......\n...\n";


        foreach (Ad::find()->where(['vat' => 1])->andWhere(['is', 'vat_price', null])->each(100) as $ad) {





            $ad->vat_price =  $ad->in_amount * VatYear::vatfinder($ad);
            if ($ad->save())
                echo $ad->id . " :done\n";
        }
    }



    public function actionSms()
    {



        require('/home/avishost/ham.avishost.com/frontend/web/XLSXReader.php');

        $target_file = "/home/avishost/ham.avishost.com/frontend/web/ex.xlsx";

        $uploadOk = 1;

        // Check if image file is a actual image or fake image




        date_default_timezone_set('UTC');

        $xlsx = new \XLSXReader($target_file);
        $sheetNames = $xlsx->getSheetNames();
        foreach ($sheetNames as $sheetName) {


            if ($sheetName != 'کارگزاران')
                continue;

            $sheet = $xlsx->getSheet($sheetName);
            post($sheet->getData());
        }

        function Post($data)
        {


            foreach ($data as $row) {

                $m = new common\models\User();
                $m->type = 8;
                $m->status = 10;
                $m->setPassword(123456);
                $m->username = $row[0];
                $m->name_and_fam = $row[1];
                $m->code_kargozar = $row[0];
                $m->save();

                echo $row[1] . "\n";

                //$post = new \common\models\TmsPricing();
                //$post->weight_start = (string) $row[0];
                //$post->weight_to = (string) $row[1];
            }
        }
    }
}