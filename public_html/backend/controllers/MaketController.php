<?php

namespace backend\controllers;

use Yii;
use common\models\Maket;
use common\models\Maketsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaketController implements the CRUD actions for Maket model.
 */
class MaketController extends Controller {

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
     * Lists all Maket models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Maketsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Maket model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($date_publish, $box_id=null) {
        return $this->render('view', [
                    'model' => Maket::findOne(['date' => $date_publish, 'box_id' => $box_id])
        ]);
    }

    /**
     * Creates a new Maket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Maket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionMove($date_publish, $box_id) {

       if ($_POST['Maket']['special_page_maket']) {
          $maket_table = Maket::find()->where(['date' => $date_publish, 'box_id' => $box_id])->one();
          print_r($maket_table->special_page_maket)  ;

            $maket=array(); 
            $maket= json_decode($maket_table->maket);
           // print_r($maket);
            echo "<br>";
            echo "<br>";
            $counts = array_count_values($maket);
            $countfinal= $counts[$_POST['Maket']['special_page_maket']];
           // echo $countfinal;
            echo "<br>";  
            $i = 1;
            $arr = array();
            for ($i; $i <= $countfinal; $i++) {
              array_push($arr,$_POST['Maket']['special_page_maket']); 
            }
            // echo $countfinal; 
             $j = 1;
              
              for ($j; $j <= $countfinal; $j++) {
             
             $pos= array_search($_POST['Maket']['special_page_maket'],$maket);
             unset($maket[$pos]);
//             print_r($maket);
//             exit();
            }
            
          }
           $maket_table->maket=json_encode($maket);
            $maket_table->special_page_maket.=json_encode($arr);
             $maket_table->save(false);
              return $this->render('view', [
                   'date_publish' => $date_publish,
                   'box_id' => $box_id,
                   
        ]);
    }

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
     * Deletes an existing Maket model.
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
     * Finds the Maket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Maket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Maket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
