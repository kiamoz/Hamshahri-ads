<?php

namespace backend\controllers;

use Yii;
use common\models\Transition;
use common\models\Transitionsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\models\User;
use common\models\VatYear;

/**
 * TransitionController implements the CRUD actions for Transition model.
 */
class TransitionController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transition models.
     * @return mixed
     */
    public function actionCashCheque($id) {

        $model = $this->findModel($id);
        $model->type = 13;
        $model->save();
        $user = User::findOne($model->user_id);
        $user->wallet += $model->amount;
        $user->save();
        //print_r($user->getErrors());
        Yii::$app->session->setFlash('success', "چم نقد و به کیف پول  کارگزار اضافه شد");
        $this->redirect(['transition/index']);
    }

    public function actionUnpaid($id) {

        $ad = [];
        foreach (\common\models\Ad::find()->where(['resseler_id' => $id, 'pay_status' => 0])->andWhere(['<>', 'status', -10])->all() as $a) {

             if ($a->vat){
                $v = VatYear::vatfinder($a);
                
                $a->in_amount *= (1+$v);
             }
               
            
            if ($a->naghdi_etebari == 1) {
                //echo "H1";
                $et = " (نقدی)";
                $needed = ($a->in_amount - $a->benefit_price) - $a->cash;
            } elseif ($a->naghdi_etebari == 2) {
                $et = " (اعتباری)";
                $needed = ($a->in_amount) - $a->cash;
            } elseif ($a->naghdi_etebari == 3) {
                $et = " (تهاتر)";
                $needed = ($a->in_amount) - $a->cash;
            }

           

            $ad[$a->id] = $a->custom_id . $et . " (" . number_format((int) ($needed)) . ")";
        }
        return json_encode($ad);
    }

    public function actionIndex() {
        $searchModel = new Transitionsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transition model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionPrint($id) {
        return $this->render('print', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Transition();

        if ($model->load(Yii::$app->request->post())) {


            //echo $model->date;
            $model->auto_date = date("Y-m-d H:i:s");
            $model->date = \common\models\Persian::convert_date_to_en($model->date);
            if ($model->cheque_date)
                $model->cheque_date = \common\models\Persian::convert_date_to_en($model->cheque_date);
            if ($model->cheque_date)
                $model->cheque_date = \common\models\Persian::convert_date_to_en($model->cheque_date);
            $model->amount = str_replace(',', '', $model->amount);
            $temp_am = $model->amount;

            //echo $model->date;
            $model->actor_id = Yii::$app->user->id;
            $user = User::findOne($model->user_id);

            //echo $user->credit_naghdi."*";
            if ($model->type == 100) {

//echo "X";
                if ($model->amount <= $user->wallet) {
                    $user->wallet -= $model->amount;

                    $model->detail .= "<br>برداشت از کیف پول کارگزار به ارزش: " . number_format($model->amount) . " ریال";
                } else {
                    echo "موجودی کیف پول کارگزار کافی نیست..";
                    exit();
                }
            }


            //exit();
            //echo $model->type."*";
            //exit();

            if (!in_array($model->type, [12, 15, 5, 6, 7, 8])) {





                //echo "X";
                //exit();
                //echo $model->amount;
                //print_r($model->priority_id);
                //echo \common\models\Ad::find()->where(['resseler_id' => $model->user_id, 'naghdi_etebari' => $model->etebar, 'pay_status' => 0,'id'=>$model->priority_id])->createCommand()->getRaWSql();

                $ad = \common\models\Ad::find()->where(['resseler_id' => $model->user_id, 'pay_status' => 0]);

                $ad = $ad->andWhere(['id' => $model->priority_id]);

                //echo $ad->createCommand()->getRaWSql();

                $ad = $ad->orderBy(['id' => SORT_DESC])->all();

                if ($model->priority_id) {

                    //echo count($ad);
                    //exit();

                    $model->detail .= "<br>";

                    foreach ($ad as $a) {


                        if ($a->naghdi_etebari == 1) {
                            //echo "H1";
                            $needed = ($a->in_amount - $a->benefit_price) - $a->cash;
                        } elseif ($a->naghdi_etebari == 2 or $a->naghdi_etebari == 3) {
                            $needed = ($a->in_amount) - $a->cash;
                        }

                        // echo "X<br>";
                       // echo $needed."<br>";
                       // echo $needed*.1."<br>";
                        if ($a->vat)
                            $needed += $a->in_amount*VatYear::vatfinder($a);

                     //   echo $needed."<br>";
                     //   echo "X<br>";
                     //   exit();



                        if ($needed <= $model->amount) {
                            $a->cash += $needed;
                            $model->amount -= $needed;

                            //echo $a->naghdi_etebari ;
                            //exit();
                            $a->pay_status = 1;
                            if ($a->naghdi_etebari == 1) {

                                //$user->wallet += ($a->in_amount - $a->benefit_price);
                                //$user->credit_naghdi += ($a->in_amount - $a->benefit_price);
                                //$model->detail .= "<br> کاهش بدهی نقدی کارگزار  در اگهی:" . $a->id . "|" . $a->customer->name . ", " . " به ارزش " . number_format(($a->in_amount - $a->benefit_price)) . "ریال";
                            } elseif ($a->naghdi_etebari == 2) {

                                //$user->credit += ($a->in_amount);
                                // باید حذف شود...$user->credit_naghdi += ( $a->benefit_price);
                                $user->wallet += ( $a->benefit_price);
                                //$model->detail .= "<br> کاهش بدهی اعتباری کارگزار  در اگهی:" . $a->id . "|" . $a->customer->name . ", " . " به ارزش " . number_format($a->in_amount) . "ریال";
                                $model->detail .= "<br> واریز کارمزد آگهی:[" . $a->custom_id . "]|" . $a->customer->name . ", " . " به ارزش " . number_format($a->benefit_price) . " ریال به کیف پول کارگزار";
                            } elseif ($a->naghdi_etebari == 3 and $model->type == 101) {
                                $user->credit_tahator += ($a->in_amount);
                                // باید حذف شود...$user->credit_naghdi += ( $a->benefit_price);
                                $user->wallet += ( $a->benefit_price);
                                $model->detail .= "<br> کاهش بدهی تهاتر کارگزار  در اگهی:" . $a->custom_id . "|" . $a->customer->name . ", " . " به ارزش " . number_format($a->in_amount) . "ریال";
                                $model->detail .= "<br> واریز کارمزد تهاتر آگهی:" . $a->custom_id . "|" . $a->customer->name . ", " . " به ارزش " . number_format($a->benefit_price) . " ریال به کیف پول کارگزار";
                            }




                            $model->detail .= "<br> فاکتور:[" . $a->custom_id . "]|" . $a->customer->name . ", " . " کامل پرداخت شد به ارزش " . number_format($needed) . " ریال";

                            $a->save();
                        } else {
                            //echo "here";
                            $a->cash += $model->amount;
                            $temp = $model->amount;
                            $a->save();
                            //print_r($a->getErrors());
                            //exit();
                            $model->amount = 0;

                            $model->detail .= "<br> فاکتور:[" . $a->custom_id . "]|" . $a->customer->name . ", " . " ناقص پرداخت شد به ارزش " . number_format($temp) . " ریال";

                            break;
                        }
                    }
                }




                //echo $model->amount;
                //exit();

                if ($model->amount > 0) {
                    $model->detail .= "<br> واریز به کیف پول کارگزار به ارزش: " . number_format($model->amount) . " ریال";
                    $user->wallet += $model->amount;
                    //$user->credit_naghdi += $amount;
                    // print_r($user->getErrors());
                }



                //echo  $user->wallet;
            } elseif ($model->type == 15) {

                $model->detail .= "<br>برداشت از کیف پول کاگزار جهت واریز کارمزد هایش به مبلغ" . number_format($model->amount) . " ریال";

                $user->wallet -= $model->amount;
            } elseif ($model->type == 5) {

                $model->detail .= "<br>تغییرات بدهی اعتباری به ارزش" . number_format($model->amount) . " ریال";
                $user->credit += $model->amount;
            } elseif ($model->type == 6) {

                $model->detail .= "<br>تغییرات بدهی نقدی به ارزش" . number_format($model->amount) . " ریال";
                $user->credit_naghdi += $model->amount;
            } elseif ($model->type == 7) {


                $model->detail .= "<br>تغییرات مبلغ کیف پول به ارزش" . number_format($model->amount) . " ریال";
                $user->wallet += $model->amount;
            }


            $model->balance_naghdi = Transition::get_live_balance($model->user_id, 1) * (-1);
            $model->balance_etebari = Transition::get_live_balance($model->user_id, 2) * (-1);
            $model->wallet = $user->wallet;

            $model->amount = $temp_am;
            $model->save();
            $user->save();

            //print_r($model->getErrors());
            //exit();


            \common\models\Ad::check_all_un_paid_ads();
            return $this->redirect(['index', 'id' => $model->id]);
        }



        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionList($q = null, $id = null) {


        $q = str_replace(array('ي', 'ك'), array('ی', 'ک'), $q);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;

            $query->select('id, name_and_fam')
                    ->from('user')
                    ->orwhere(['like', 'user.name_and_fam', $q]);

            $query
                    ->select(['CONCAT(user.name_and_fam) AS text', 'user.id',])
                    //->select(['cities.name AS text', 'cities.id',])
                    ->from('user')
                    ->orwhere(['like', 'user.name_and_fam', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    /**
     * Updates an existing Transition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->date = \common\models\Persian::convert_date_to_en($model->date);
            $model->cheque_date = \common\models\Persian::convert_date_to_en($model->cheque_date);
            $model->amount = str_replace(',', '', $model->amount);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }


        $model->date = \common\models\Persian::convert_date_to_fa($model->date);
        $model->cheque_date = \common\models\Persian::convert_date_to_fa($model->cheque_date);
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Transition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
