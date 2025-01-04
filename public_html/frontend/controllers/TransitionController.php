<?php

namespace frontend\controllers;

use Yii;
use common\models\Transition;
use common\models\User;
use common\models\Transitionsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    /**
     * Creates a new Transition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Transition();
        $user_on = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post())) {
            
            
            $model->amount = str_replace(',', '', $model->amount);

            $model->date = date('Y-m-d H:i:s');
            $model->user_id = $user_on;
            $model->type = User::transition_list['online'];
            //$model->amount = $_POST['Transition']['amount'];
            
            
            
            $model->save();
            //  print_r($model->getErrors());
            $bestankari = $model->amount;
            $amount = $model->amount;
            $ad = \common\models\Ad::find()->where(['resseler_id' => $user_on,'naghdi_etebari'=>1])->andWhere(['IS', 'pay_status', NULL])->all();
            $user = User::findOne($user_on);

            $user->credit_naghdi += $amount;
            if (!$ad) {

                //$user->credit_naghdi += $bestankari;
            } elseif ($ad) {

                foreach ($ad as $a) {

                    $needed = $a->in_amount - $a->cash;


                    if ($needed <= $amount) {
                        $a->cash += $needed;
                        $amount -= $needed;
                        $a->pay_status = 1;
                        $a->save();
                    } else {
                        $a->cash += $amount;
                        $a->save();
                        $amount = 0;
                    }
                }


                if ($amount > 0) {
                    //$user->credit_naghdi += $amount;
                    // print_r($user->getErrors());
                }
            }

            $user->save();


            Yii::$app->session->setFlash('success', ' ثبت شد');
            return $this->redirect(['create']);
        }


        return $this->render('create', [
                    'model' => $model,
        ]);
    }

//    public function actionCreate() {
//        
//       
//         
//        $user_online = Yii::$app->user->identity->id;
//        $model = new Transition();
//        $model->date = date('Y-m-d H:i:s');
//        $model->user_id = $user_online;
//        $model->type = User::transition_list["online"];
//
//
//        $model->amount = $_POST['Transition']['amount'];
//
//        $amount = $model->amount;
//        $bestankari = $model->amount;
//
//        $user_table = User::find()->where(['id' => $user_online])->one();
//        $remainder = 0;
//        if ($user_table->credit_naghdi < 0 and $amount > 0) {
////            $str_credit = (string) $user_table->credit;
////            $str_credit = str_replace("-", "", $str_credit);
//            // echo "str_credit: " . $str_credit . "<br>";
//            if (strpos($str_credit, '-')) {
//                $str_credit = $user_table->credit;
//                // echo "credit: " . $str_credit . "<br>";
//            } if ($str_credit < $amount) {
//                $amount -= $str_credit;
//                $user_table->credit = 0;
//                //echo "amount: " . $amount . "<br>";
//                $remainder = $amount;
//            } elseif ($str_credit > $amount) {
//
//                $user_table->credit += $amount;
//                $amount = 0;
//            } elseif ($str_credit == $amount) {
//
//                $user_table->credit = 0;
//                $amount = 0;
//            }
//        } else {
//            $remainder = $amount;
//        }
//        $user_table->save(false);
////      
//        $ad = \common\models\Ad::find()->where(['resseler_id' => $user_online])->orderby(['date_publish' => SORT_DESC])->all();
////        echo $remainder . "<br>";
//        if ($ad) {
//            foreach ($ad as $add) {
//                $in_amount = $add->in_amount;
//                $cash = $add->cash;
//                $minus = $in_amount - $cash;
//                if ($cash < $in_amount and $remainder > 0) {
//                    if ($remainder >= $minus) {
////                        echo "cash: " . $cash . "<br>";
////                        echo "remainder" . $remainder . "<br>";
//                        $remainder -= $minus;
//                        $cash += $minus;
//                    } elseif ($remainder < $minus) {
////                        echo "minus: ".$minus. "<br>";
////                        echo "cash::" . $cash . "<br>";
////                        echo "remainder" . $remainder . "<br>";
//                        $cash += $remainder;
//                        $remainder = 0;
//                    }
//                }
//                $add->cash = $cash;
//                $add->save(false);
//            }
//        } else {
//            $model->bestankari = $bestankari;
//            $user_table = User::findOne($user_online);
////            print_r($user_table);
//            $user_table->credit_naghdi = 22+$bestankari;
//         
////            print_r($user_table->getErrors());
//        }
//
//        
//      //   echo "*****";
//            $user_table->save();
//
////        print_r($model->getErrors());
//        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
//            Yii::$app->session->setFlash('success', ' ثبت شد');
//            return $this->redirect(['create']);
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing Transition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

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
