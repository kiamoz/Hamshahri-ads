<?php

namespace backend\controllers;

use Yii;
use common\models\BoxMaket;
use common\models\BoxMaketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoxMaketController implements the CRUD actions for BoxMaket model.
 */
class BoxMaketController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                  //  'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BoxMaket models.
     * @return mixed
     */
    public function actionIndex() {
//        $box = \common\models\Box::find()->all();
//        foreach ($box as $b) {
//            $box_m = new BoxMaket();
//            $box_m->name = $b->name;
//            $box_m->price = $b->price;
//            $box_m->price_nafti = $b->price_nafti;
//            $box_m->price_sabti = $b->price_sabti;
//            $box_m->price_dolati = $b->price_dolati;
//            $box_m->save(false);
//        }
        $searchModel_b = new \common\models\BoxMaketSearch();
        $dataProvider_b = $searchModel_b->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel_b' => $searchModel_b,
                    'dataProvider_b' => $dataProvider_b,
        ]);
    }

    public function actionAddpage() {
        $searchModel_b = new \common\models\BoxMaketSearch();
        $dataProvider_b = $searchModel_b->search(Yii::$app->request->queryParams);
        return $this->render('addpage', [
                    'searchModel_b' => $searchModel_b,
                    'dataProvider_b' => $dataProvider_b,
        ]);
    }

    /**
     * Displays a single BoxMaket model.
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
     * Creates a new BoxMaket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=null) {
        $model = new BoxMaket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['ad/update', 'id' => $id]);
        }else{
            //print_r($model->getErrors());
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing BoxMaket model.
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
     * Deletes an existing BoxMaket model.
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
     * Finds the BoxMaket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoxMaket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BoxMaket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
