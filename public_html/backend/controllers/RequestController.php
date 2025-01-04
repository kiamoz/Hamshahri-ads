<?php

namespace backend\controllers;

use Yii;
use common\models\Request;
use common\models\Requestsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\web\Uploads;
use common\models\AdSearch;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class RequestController extends Controller {

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
     * Lists all Request models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Requestsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Request model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {


        $model = $this->findModel($id);
        $searchModel = new AdSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false, false, false, false, false, $model->user_id, false, false, false, false, 1);


        return $this->render('view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPay_benfit($id) {


        $model = $this->findModel($id);
        if (count($_POST['selection'])) {

            $main_benefit = round($model->benefit);
            foreach ($_POST['selection'] as $ad_) {


                $ad_model = \common\models\Ad::findOne($ad_);
                $remain = round($ad_model->benefit_price) - round($ad_model->benefit_paid);
                
                
               // echo $main_benefit;
               // echo $remain;
                
               // exit();
                if ($remain) {

                    if ($remain <= $main_benefit) {

                        $main_benefit -= $remain;
                        $ad_model->benefit_paid += $remain;
                        $ad_model->pay_status = 1;
                        
                        if($ad_model->benefit_paid >= $ad_model->benefit_price)
                         $ad_model->benefit  = 2;
                        
                        $ad_model->save();
                        continue;
                    } else {
                        
                        $ad_model->benefit_paid += $main_benefit;
                        
                        $ad_model->save();
                        
                        $main_benefit = 0;
                        
                        if($ad_model->benefit_paid >= $ad_model->benefit_price)
                         $ad_model->benefit  = 2;
                        
                        //print_r($ad_model);
                       // print_r($ad_model->getErrors());
                        break;
                    }
                }

                if ($main_benefit <= 0)
                    break;
            }

            $model->status = 1;
            $model->save();
        }
        return $this->redirect(['ad/request']);

        //print_r();
    }

    public static function generateRandomString($length = 10) {



        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';



        $charactersLength = strlen($characters);



        $randomString = '';



        for ($i = 0; $i < $length; $i++) {



            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }



        return $randomString;
    }

    /**
     * Creates a new Request model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Request();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Request model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->file->basename) {

            $basfname = "uploads/" . $this->generateRandomString(15);

            $model->file->saveAs($basfname . '.' . $model->file->extension);

            $model->attach = $basfname . '.' . $model->file->extension;
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {






            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Request model.
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
     * Finds the Request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Request::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
