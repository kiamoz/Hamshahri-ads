<?php

namespace backend\controllers;

use Yii;
use common\models\Reject;
use common\models\Rejectsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RejectController implements the CRUD actions for Reject model.
 */
class RejectController extends Controller {

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
     * Lists all Reject models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Rejectsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reject model.
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
     * Creates a new Reject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUploadx() {




        header('Content-type:application/json;charset=utf-8');



        try {
            if (
                    !isset($_FILES['file']['error']) ||
                    is_array($_FILES['file']['error'])
            ) {
                //throw new RuntimeException('Invalid parameters.');
            }

            switch ($_FILES['file']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            $filepath = sprintf('uploads/%s_%s', uniqid(), time() . "." . $ext);

            if (!move_uploaded_file(
                            $_FILES['file']['tmp_name'], $filepath
                    )) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            // All good, send the response
            echo json_encode([
                'status' => 'ok',
                'path' => $filepath
            ]);
        } catch (RuntimeException $e) {
            // Something went wrong, send the err message as JSON
            http_response_code(400);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
  public function actionSend($id = null) {
      
     $rejj=Reject::find()->where(['ad_id'=>$id,'status'=>1])->all();
      foreach($rejj as $r){
          $r->status=2;
          $res_id=$r->reseller_id;
          $r->save();
      }
      $taskkk= \common\models\Task::find()->where(['model_id'=>$id,'status'=>0])->one();
      if($taskkk){
          $taskkk->status=1;
          $taskkk->end_time=date('Y-m-d H:i:s');
          $taskkk->save(false);
      }
      $task=new \common\models\Task();
      $task->status=0;
      $task->user_id=$res_id;
      $task->model='dabiri';
      $task->start_time=date('Y-m-d H:i:s');
      $task->model_id=$id;
      $task->save();
      $ad= \common\models\Ad::findOne($id);
      $ad->active_user_id=$ad->resseler_id;
      $ad->status=8;
      $ad->save(false);
      
       return $this->redirect(['ad/view', 'id' => $id]);
  }
    public function actionCreate($id = null) {

        $model = new Reject();

        if ($model->load(Yii::$app->request->post())) {
//echo $_POST['Reject']['text'];
//exit();
            if ($_POST['Reject']['gallery']) {

                $data_pic = explode("/backend/web/", $_POST['Reject']['gallery']);
//print_r($_POST['Design']['gallery']);
//print_r($data_pic);
                $cc = count($data_pic);
                for ($i = 1; $i < $cc; $i++) {

                    $model = new Reject();
                    $data_pic[$i] = ltrim($data_pic[$i], ' ');
                    $model->gallery = $data_pic[$i];
                    $model->ad_id = $id;
                    $find = \common\models\Ad::findOne($id);
                    $find->active_user_id=$find->paziresh_id;
                    $find->status=2;
                    $model->reseller_id = $find->resseler_id;
                    $model->status=1;
                    $model->text=$_POST['Reject']['text'];
                    $model->paziresh_id = $find->paziresh_id;
                    $model->dabiri_id = Yii::$app->user->identity->id;
                    $model->save(false); 
                    $find->save(false);
                }
                $model = new Reject();
            }
            $task = \common\models\Task::find()->where(['model_id' => $id, 'status' => 0])->all();
            if ($task) {
                foreach ($task as $t) {
                    $t->status = 1;
                    $t->end_time = date('Y-m-d H:i:s');
                    $t->save();
                }
            }
            $t = new \common\models\Task();
            $t->user_id = $find->paziresh_id;
            $t->status = 0;
            $t->start_time = date('Y-m-d H:i:s');
            $t->model_id = $id;
            $t->save();
            return $this->redirect(['ad/view', 'id' => $id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reject model.
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
     * Deletes an existing Reject model.
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
     * Finds the Reject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Reject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
