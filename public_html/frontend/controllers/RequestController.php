<?php

namespace frontend\controllers;

use Yii;
use common\models\Request;
use common\models\Requestsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Request model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $user_online = Yii::$app->user->identity->id;
        $ad_table = \common\models\Ad::find()->where(['resseler_id' => $user_online, 'benefit' => 1])->all();
        //print_r($ad_table);
        $count = count($ad_table);
        for ($i = 0; $i < $count; $i++) {
            $sum_benefit += $ad_table[$i]->benefit_price - $ad_table[$i]->benefit_paid;
        }
        //echo "jam: ".$sum_benefit;

        $model = new Request();
        if ($model->load(Yii::$app->request->post())) {
            $model->benefit = str_replace(',', '', $model->benefit);
            $bene = $model->benefit;



            if ($bene > $sum_benefit) {
                Yii::$app->session->setFlash('danger', 'مبلغ درخواست شده بیشتر از جمع تمام مبلغ کارمزد ها است');
                return $this->render('create', [
                            'model' => $model,
                ]);
            } elseif ($bene <= $sum_benefit) {

                $model->user_id = $user_online;
                $model->status = 0;
//       
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'درخواست شما ثبت شد  :' . $model->id);
                    return $this->render('create', [
                                'model' => $model,
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('danger', 'مشکلی پیش آمد بعدا تلاش کنید' . $model->id);
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionRequest($benefit) {
        $model = new Request();
        //$model->load(Yii::$app->request->post());
        $user_online = Yii::$app->user->identity->id;
        $ad_table = \common\models\Ad::find()->where(['resseler_id' => $user_online, 'benefit' => 1])->all();
        //print_r($ad_table);
        $count = count($ad_table);
        for ($i = 0; $i < $count; $i++) {
            $sum_benefit += $ad_table[$i]->benefit_price;
        }
        echo $sum_benefit;



        if ($benefit) {
            //echo "<br>benefit field: ".$bene;
            echo "*" . $benefit;

            if ($benefit > $sum_benefit) {
                Yii::$app->session->setFlash('danger', 'مبلغ درخواست شده بیشتر از جمع تمام مبلغ کارمزد ها است');
                return $this->render('request', [
                            'model' => $model,
                ]);
            } elseif ($benefit <= $sum_benefit) {

                $model->user_id = $user_online;
                $model->status = 0;
                $model->benefit = $benefit;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'درخواست شما ثبت شد' . $model->id);
                    return $this->render('request', [
                                'model' => $model,
                    ]);
                } else {
                    Yii::$app->session->setFlash('danger', 'مشکلی پیش آمد بعدا تلاش کنید' . $model->id);
                    return $this->render('request', [
                                'model' => $model,
                    ]);
                }
            }
        }
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
