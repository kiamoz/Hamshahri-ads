<?php

namespace frontend\controllers;

use Yii;
use common\models\Customer;
use common\models\CustomerSearch;
use common\models\AdSearch;
use common\models\Ad;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\UploadedFile;
use app\web\Uploads;
use common\models\Documentsearch;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller {

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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
       
//     $dataProvider = new ActiveDataProvider([
//        'query' => Customer::find()->
//              where(['owner_id' => Yii::$app->user->identity->id ]),
//           ]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                   
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $task_id = null) {
        $searchModel = new Documentsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        $searchModel_ad = new AdSearch();
        $dataProvider_ad = $searchModel_ad->search(Yii::$app->request->queryParams, FALSE, FALSE, $id);


        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'task_id' => $task_id,
                    'customer_id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModel_ad' => $searchModel_ad,
                    'dataProvider_ad' => $dataProvider_ad,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Customer();
        if ($model->load(Yii::$app->request->post()) ) {
          $model->owner_id=Yii::$app->user->identity->id;
       
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              $model->discount_type= json_encode($model->discount_type);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionUploadpage($task, $customer_id) {
//        echo $task.'%%%5';


        $model_t = \common\models\Task::findOne($task);


        if ($model_t->load(Yii::$app->request->post())) {

            $model_doc = new \common\models\Document;
            $model_doc->customer_id = $customer_id;

            $model_doc->subject = $model_t->subject;
            $model_t->filedoc = UploadedFile::getInstance($model_t, 'filedoc');

            if ($model_t->filedoc->basename) {



                $basfname = "uploaded_document/" . $this->generateRandomString(15);
                $model_t->filedoc->saveAs($basfname . '.' . $model_t->filedoc->extension);
                $model_doc->file = $basfname . '.' . $model_t->filedoc->extension;
                $model_doc->ad_id=$model_t->model_id;
                //echo  $model_doc->file;
                $model_t->status = 1;
                $model_t->end_time=date('Y-m-d H:i:s');
                $model_t->save(false);
                $model_doc->save(false);
//                print_r( $model_doc->getErrors());
//                exit();
            }
            $adtable=Ad::find()->where (['id'=> $model_t->model_id])->One();
            $adtable->active_user_id=$adtable->paziresh_id;
            $adtable->status=2;
            $adtable->save(false);
            $tt=new \common\models\Task();
            $tt->user_id=$adtable->paziresh_id;
            $tt->start_time = date('Y-m-d H:i:s');
            $tt->model_id=$model_t->model_id;
            $tt->status=0;
            $tt->save(false);

//            $model_doc->save();
            if ($model_doc->save()) {
                Yii::$app->session->setFlash('success', 'فایل آپلود شد منتظر تایید دبیری باشید');
                return $this->redirect(['index']);
            } else {
//                print_r($model_doc->getErrors());
                Yii::$app->session->setFlash('error', 'مشکلی پیش آمد در فرصتی دیگر تلاش کنید');
            }
        }



//        print_r($task);
        return $this->render('upload_file', ['model_t' => $model_t, 'customer_id' => $customer_id
        ]);
    }

    function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function actionDocupload($task_id) {

        if ($_POST["subject"]) {

            exit();
        }




        //   exit();
        $model_t = \common\models\Task::find()->where(['id' => $task_id])->one();
        $model_doc = new \common\models\Document;


        $model_doc->customer_id = $task->customer_id;
        $model_doc->task_id = $task_id;
        $model_doc->subject = $task->subject;
        $task->filedoc = UploadedFile::getInstance($task, 'filedoc');

        if ($task->filedoc->basename) {

            $basfname = "uploaded_document/" . $this->generateRandomString(15);
            $task->filedoc->saveAs($basfname . '.' . $task->filedoc->extension);

            $model_doc->document = $basfname . '.' . $task->filedoc->extension;
        }
        $model_doc->save();
//            print_r($model->getErrors())."<br>";
//            echo  $model->document;
//            exit();
        if ($model_doc->save()) {
            $model_t->status = 1;
            Yii::$app->session->setFlash('success', 'فایل آپلود شد' . $model->id);
        } else {
            Yii::$app->session->setFlash('success', 'فایل  ' . $model->id);
        }
    }

    /**
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionList($q = null, $id = null) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        // \common\models\Customer::check_new_city($q);


        if (!is_null($q)) {
            $query = new Query;

            $query->select('id, name')
                    ->from('customer')
                    ->orwhere(['like', 'customer.name', $q])
                    ->andWhere(['owner_id' => Yii::$app->user->identity->id]);
            $query
                    ->select(['CONCAT(customer.name) AS text', 'customer.id',])
                    //->select(['cities.name AS text', 'cities.id',])
                    ->from('customer')
                    ->orwhere(['like', 'customer.name', $q])
                    ->andWhere(['owner_id' => Yii::$app->user->identity->id]);
            // ->orwhere(['like', 'Customer.post_code', $q]);
            //->andWhere('price.id= (Select Max(D2.id) From price As D2 Where D2.product_id = product.id) ')

            /*
             * 
             *  And d.ID = (
              Select Max(D2.Id)
              From customer_data As D2



              )
             * 
             */


            //->groupBy('name')
            //->orderBy('update_date')
            //->limit(20);
            //echo $query;

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }

        return $out;
    }

}
