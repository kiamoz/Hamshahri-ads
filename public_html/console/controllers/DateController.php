<?php

namespace console\controllers;

date_default_timezone_set('Asia/Tehran');

use yii\console\Controller;

/**
 * Test controller
 */
class DateController extends Controller {

    public function actionIndex() {
        
  
        $this_persin = \common\models\Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
   // echo $this_persin[0].$this_persin[1].$this_persin[2];
          //print_r(date('y-m-d')) ."<br>";
        $start_miladi = \common\models\Persian::jalali_to_gregorian($this_persin[0], $this_persin[1] - 3,$this_persin [2]);
          //echo $start_miladi[0].$start_miladi[1].$start_miladi[2]."<br>";
          //print_r($start_miladi) ."<br>";
        //  echo var_dump($start_miladi<$this_persin)."<br>";
          $date=$start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
        //  echo "dattttteeeeeee: ".$date;
        $customer_d = \common\models\Customer::find()->where(['<','date',$date])->all();
        //echo $customer_d->createCommand()->getRawSql();
      //  print_r($customer_d) ;
     // echo count($customer_d);
       // echo date('y-m-d');
     // echo "in";
        if($customer_d){
        foreach($customer_d as $c){
            echo $c->id;
            $c->owner_id='';
            $c->save(false);
            echo "saved";
        } 
        
    }
    
    }
 

}
