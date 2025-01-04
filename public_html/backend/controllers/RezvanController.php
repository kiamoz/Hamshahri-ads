<?php

namespace backend\controllers;

use Yii;
use common\models\Rezvan;
use common\models\Rezvansearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RezvanController implements the CRUD actions for Rezvan model.
 */
class RezvanController extends Controller {

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
     * Lists all Rezvan models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Rezvansearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rezvan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$file) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rezvan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionUploadx() {
//
//
//
//
//        header('Content-type:application/json;charset=utf-8');
//
//
//
//        try {
//            if (
//                    !isset($_FILES['file']['error']) ||
//                    is_array($_FILES['file']['error'])
//            ) {
//                //throw new RuntimeException('Invalid parameters.');
//            }
//
//            switch ($_FILES['file']['error']) {
//                case UPLOAD_ERR_OK:
//                    break;
//                case UPLOAD_ERR_NO_FILE:
//                    throw new RuntimeException('No file sent.');
//                case UPLOAD_ERR_INI_SIZE:
//                case UPLOAD_ERR_FORM_SIZE:
//                    throw new RuntimeException('Exceeded filesize limit.');
//                default:
//                    throw new RuntimeException('Unknown errors.');
//            }
//
//
//            $name = $_FILES["file"]["name"];
//            $ext = end((explode(".", $name)));
//
//            $filepath = sprintf('uploads/%s_%s', uniqid(), time() . "." . $ext);
//
//            if (!move_uploaded_file(
//                            $_FILES['file']['tmp_name'], $filepath
//                    )) {
//                throw new RuntimeException('Failed to move uploaded file.');
//            }
//
//            // All good, send the response
//            echo json_encode([
//                'status' => 'ok',
//                'path' => $filepath
//            ]);
//        } catch (RuntimeException $e) {
//            // Something went wrong, send the err message as JSON
//            http_response_code(400);
//
//            echo json_encode([
//                'status' => 'error',
//                'message' => $e->getMessage()
//            ]);
//        }
//    }
    public function actionCreate($id = null) {
        $model = new Rezvan();

        if ($model->load(Yii::$app->request->post())) {
            if ($_POST['Rezvan']['gallery']) {

                $data_pic = explode("/backend/web/", $_POST['Rezvan']['gallery']);
//            print_r($data_pic);
                $cc = count($data_pic);
                for ($i = 1; $i < $cc ; $i++) {

                    if ($data_pic[$i] != '') {
                        $data_pic[$i] = ltrim($data_pic[$i], ' ');
                        $model->gallery = $data_pic[$i];
                        $model->ad_id = $id;
                        $model->user_id = Yii::$app->user->identity->id;
                        $model->save(false);
//                    echo "<br>" . $model->gallery . "*<br>";
                    }
                    $model = new Rezvan();
                }
            }
            return $this->redirect(['ad/view', 'id' => $id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rezvan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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

    public function actionUpdate($id) {
        //$model = $this->findModel($id);
        print_r($_POST);
//        echo "<br>";
        $ad = \common\models\Ad::findOne($id);
        if ($_POST['Rezvan']['gallery']) {

            $data_pic = explode("/backend/web/", $_POST['Rezvan']['gallery']);
            print_r($data_pic);
            $cc = count($data_pic);
            for ($i = 0; $i < $cc - 1; $i++) {

                if ($data_pic[$i] != '') {
                    $model = new Rezvan();
                    $data_pic[$i] = ltrim($data_pic[$i], ' ');
                    $model->gallery = $data_pic[$i];
                    $model->ad_id = $id;
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->save(false);
                    echo "<br>" . $model->gallery . "*<br>";
                }
            }

            return $this->redirect(['ad/view', 'id' => $id]);
        }
//        exit();
//        $model = new Rezvan();




        return $this->render('update', [
                    'model' => $model,
                    'ad' => $ad
        ]);
    }

    /**
     * Deletes an existing Rezvan model.
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
     * Finds the Rezvan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rezvan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Rezvan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
