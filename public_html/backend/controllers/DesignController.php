<?php

namespace backend\controllers;

use Yii;
use common\models\Design;
use common\models\Designsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DesignController implements the CRUD actions for Design model.
 */
class DesignController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Design models.
     * @return mixed
     */
     public function actionData()
    {
        $searchModel = new Designsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex()
    {
        $searchModel = new Designsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Design model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($file)
    {
//        $searchModel = new Designsearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('view', [
            //'model' => $this->findModel($file),
            'file'=>$file,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
        ]);
    }
public function actionView1($ad_id)
    {
         
        return $this->render('view1', [
            
            'ad_id'=>$ad_id, 
            
        ]);
    }
     public function actionView11($file)
    {
//        $searchModel = new Designsearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('view11', [
            //'model' => $this->findModel($file),
            'file'=>$file,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Creates a new Design model.
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
    public function actionCreate($id=null){
       
        $model = new Design();

        if ($model->load(Yii::$app->request->post()) ) {
            
            if ($_POST['Design']['gallery']) {

               $data_pic = explode("/backend/web/", $_POST['Design']['gallery']);
//print_r($_POST['Design']['gallery']);
//print_r($data_pic);
                $cc = count($data_pic);
                for ($i = 1; $i < $cc ; $i++) {

                    $model = new Design();
                    $data_pic[$i] = ltrim($data_pic[$i], ' ');
                    $model->attach = $data_pic[$i];
                    $model->ad_id = $id;
                    $model->tarahi_id = Yii::$app->user->identity->id;
                    $model->status = 0;
                    $model->date = date('Y-m-d H:m:s');
                    $model->save(false);
//print_r($model->getErrors());
//               
                }
                 $model = new Design();
            }
            return $this->redirect(['ad/view', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Design model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Design model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Design model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Design the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Design::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
