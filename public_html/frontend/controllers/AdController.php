<?php

namespace frontend\controllers;

use Yii;
use common\models\Ad;
use common\models\Contract;
use common\models\Designsearch;
use common\models\Document;
use common\models\Maket;
use common\models\Tagimg;
use common\models\User;
use common\models\Task;
use common\models\Customer;
use common\models\AdSearch;
use common\models\AdMsgsearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\UploadedFile;
use app\web\Uploads;
use common\models\Persian;
use yii\helpers\Url;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends Controller {

    public function beforeAction($action) {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        // if ($action->id == 'saveexcel')
        $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'rej', 'verad', 'date', 'dateedit', 'cloneadedit', 'request', 'clonead', 'list3', 'list4', 'error', 'menu', 'about', 'uploadx', 'neworder', 'clone', 'taeid', 'list', 'document', 'data', 'cancelcustomer'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['maket', 'logout', 'index', 'clear', 'neworder', 'list', 'update', 'view', 'verify'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
//        $dataProvider = new ActiveDataProvider([
//        'query' => Ad::find()->
//              where(['resseler_id' => Yii::$app->user->identity->id ]),
//           ]);
//           echo Yii::$app->user->identity->id;
//           exit();
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMaket() {

        // return json_encode($_POST);
        $date_publish = $_POST['date_publish'];
        $box_id = $_POST['box_id'];

        $maket_table_overwrite = Maket::find()->where(['date' => $date_publish, 'box_id' => $box_id])->one();
        if ($maket_table_overwrite) {
            $maket_table_overwrite->maket = json_encode($_POST['maket']);
            if ($maket_table_overwrite->save(false)) {
                return json_encode(array('flag' => 1));
            }
        } else {
            $maket_t = new Maket();
            $maket_t->date = $date_publish;
            $maket_t->box_id = $box_id;
            $maket_t->maket = json_encode($_POST['maket']);
            if ($maket_t->save(false)) {
                return json_encode(array('flag' => 1));
            }
        }
    }

    public function actionData() {

        // return json_encode(array(1=>$_POST));
// print_r($_POST);
// exit();
        if (!$_POST['on']) {
            $user_on = Yii::$app->user->identity->id;
        } else {
            $user_on = $_POST['on'];
        }
        $ad_id = $_POST['ad_id'];
        $file = $_POST['file'];
//echo $ad_id."*".$file."*";
        $tagimg_table_overwrite = \common\models\Tagimage::find()->where(['ad_id' => $ad_id, 'file' => $file, 'user_id' => $user_on])->one();
        if ($tagimg_table_overwrite) {
            //echo $tagimg_table_overwrite->id . "*";
            $tagimg_table_overwrite->data = json_encode($_POST['data']);
            $tagimg_table_overwrite->save(false);
        } else {
            $tagimg_t = new \common\models\Tagimage();
            $tagimg_t->ad_id = $ad_id;
            $tagimg_t->data = json_encode($_POST['data']);
            $tagimg_t->file = $file;
            if ($_POST['on'])
                $tagimg_t->user_id = $_POST['on'];

            //echo $tagimg_t->id . "*";
            $tagimg_t->save(false);
        }
        if ($_POST['data'] and Yii::$app->user->identity->lvl == 8) {
            $ad_table = Ad::find()->where(['id' => $ad_id])->one();
            $ad_table->status = 2;
            $ad_table->save(false);
        }
        if (( $tagimg_t->save())) {
            return json_encode(array('flag' => 1));
        }

//        print_r($maket_table->getErrors());
//        exit();
    }

    /**
     * Displays a single Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionAdstage() {
        $ad = new Ad();
    }

    public function actionRej($id, $task_id) {
        $searchModel_rej = new \common\models\Rejectsearch();
        $dataProvider_rej = $searchModel_rej->search(Yii::$app->request->queryParams, $id);

        return $this->render('rej', [
                    'searchModel_rej' => $searchModel_rej,
                    'dataProvider_rej' => $dataProvider_rej,
        ]);
    }

    public function actionView($id, $task_id = null) {
//        echo $task_id;
        $model_t = \common\models\Task::findOne($task_id);
//         print_r($model_t);
        $searchModel_adm = new AdMsgsearch();
        $dataProvider_adm = $searchModel_adm->search(Yii::$app->request->queryParams, $id);

        $searchModel_rej = new \common\models\Rejectsearch();
        $dataProvider_rej = $searchModel_rej->search(Yii::$app->request->queryParams, $id);

        $searchModel_1 = new Designsearch();
        $dataProvider_1 = $searchModel_1->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
                    'model' => $this->findModel($id), 'model_t' => $model_t,
                    'searchModel_adm' => $searchModel_adm,
                    'dataProvider_adm' => $dataProvider_adm,
                    'searchModel_1' => $searchModel_1,
                    'dataProvider_1' => $dataProvider_1,
                    'searchModel_rej' => $searchModel_rej,
                    'dataProvider_rej' => $dataProvider_rej,
        ]);
    }

    public function actionDocument($id) {

        // $model=new Ad;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->doc = $_POST['Ad']['doc'];


            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file->basename) {
                $basfname = "uploads/" . $this->generateRandomString(15);
                $model->file->saveAs($basfname . '.' . $model->file->extension);
                $model->attachh = $basfname . '.' . $model->file->extension;
            }

            $model->save(false);
//         echo $model->attachh ."*"."<br>";
//           print_r($model->getErrors());
//           if($model->attachh)
//                    echo "yes";
//            else echo "no";
//            exit();
//            print_r($model->getErrors());
//            echo  $model->attachh;
//            exit();
            Yii::$app->session->setFlash('success', 'ثبت شد' . $model->id);
        }return $this->render('document', [
                    'model' => $model,
        ]);
    }

    public function actionVerify($ad_id, $task_id) {
        $model_t = \common\models\Task::findOne($task_id);
        $model_t->status = 1;
        $model_t->end_time = date('Y-m-d H:i:s');
//        $model_t->save();
        $model_ad = Ad::findOne($ad_id);
        if ($model_ad->status == 2) {
            $model_ad->status = 2;
            $model_ad->active_user_id = $model_ad->paziresh_id;
            $tt = new Task();
            $tt->user_id = $model_ad->paziresh_id;
            $tt->start_time = date('Y-m-d H:i:s');
            $tt->model_id = $ad_id;
            $tt->status = 0;
            $tt->save(false);
        } else {
            $model_ad->status = 9;

            $user_p = User::find()->where(['lvl' => 9, 'status_p' => 1])->all();
            $array_list = array();
            foreach ($user_p as $a) {
                $c = 0;
                $c = \common\models\Task::find()->where(['user_id' => $a->id])->count();
                array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
            }
            $keys = array_column($array_list, 'count');
            array_multisort($keys, SORT_ASC, $array_list);
            $next_user_id = $array_list[0]['user_id'];
//            echo $next_user_id ."*";
//            echo "<br>";
            //
            $model_ad->{Ad::ad_order[$model_ad->status]} = $next_user_id;
            $model_ad->active_user_id = $next_user_id;
//            echo "nest: ".Ad::ad_order[$model_ad->status];
//             echo "<br>";
            $task_tab = new \common\models\Task();
            $task_tab->status = 0;
            $task_tab->user_id = $next_user_id;
            $task_tab->model_id = $ad_id;
            $task_tab->start_time = date('Y-m-d H:i:s');
            $task_tab->save(false);
//              echo "user task: ". $task_tab->user_id;
//              echo "id: ".$ad_id;
//                 echo "<br>";
//                   $task_tab->model_id ."&";
//                   exit();
        }
//        $model_ad->save();
        //$model_ad->save(false);
        if ($model_ad->save() && $model_t->save()) {

            Yii::$app->session->setFlash('success', ' تایید شد منتظر تایید دبیری باشید' . $model_ad->title);
            return $this->redirect(['index']);
        } else {
            print_r($model_ad->getErrors());
            Yii::$app->session->setFlash('error', ' خطایی پیش آمد در فرصتی دیگر تلاش کنید' . $model_ad->title);
//              return $this->redirect('view',['id'=>$ad_id , 'task_id'=>$task_id] );
        }
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Ad();

        //$model->scenario = "insret";

        if ($model->load(Yii::$app->request->post())) {


            $model->date = \common\models\Persian::convert_date_to_fa(date("Y-m-d"));


            if (!is_numeric($model->customer_id)) {
                $m = new \common\models\Customer();
                $m->name = $model->customer_id;
                $m->save(FALSE);
                $model->customer_id = $m->id;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'آگهی ثبت شد' . $model->id);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }



            return $this->redirect(['create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCancelcustomer($id) {
        $model = $this->findModel($id);



        $model->cancel_user_id = Yii::$app->user->identity->id;


        $model->status = -10;
        $model->save(false);


        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'آگهی با موفقیت رد شد' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('danger', 'خطایی رخ داد زمان دیگری تلاش کنید' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionVerad($id, $task) {
        $model = $this->findModel($id);
        $model->status = 6;
        $model->active_user_id = $model->dabiri_id;
        $task = Task::findOne($task);
        $task->status = 1;
        $task->end_time = date('Y-m-d H:i:s');
        $task->save();
        $user = User::find()->where(['lvl' => 6])->all();
        if ($user) {
            foreach ($user as $u) {
                $task_table = new Task();
                $task_table->user_id = $u->id;
                $task_table->start_time = date('Y-m-d H:i:s');
                $task_table->status = 0;
                $task_table->model_id = $id;
                $task_table->save(false);
            }
        }
        //  $model->save(false);

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'آگهی با موفقیت تایید شد' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionTaeid($id) {
        $model = $this->findModel($id);
        $model->status = 22;
        $user_p = User::find()->where(['lvl' => 22])->all();
        $array_list = array();
        foreach ($user_p as $a) {
//                    $task = new Task;
//                    $task->model_id = $ad_id;
//                    $task->user_id = $a->id;
//                    $task->start_time = date('Y-m-d H:i:s');
//                    $task->status = 0;
//                    $task->save(false);
            $c = 0;
            $c = Task::find()->where(['user_id' => $a->id])->count();
            array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
        }
        $keys = array_column($array_list, 'count');
        array_multisort($keys, SORT_ASC, $array_list);
        $next_user_id = $array_list[0]['user_id'];
//            echo $next_user_id;
//            exit();
        $model->rezvan_id = $next_user_id;
        $model->active_user_id = $next_user_id;

        $task_table = new Task();
        $task_table->user_id = $next_user_id;
        $task_table->start_time = date('Y-m-d H:i:s');
        $task_table->status = 0;
        $task_table->model_id = $id;
        $task_table->save(false);
        $model->save(false);

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'آگهی با موفقیت تایید شد' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionCloneadedit() {
//        print_r($_POST);
//exit();
        $id = $_POST['Ad']['id'];
        //echo "<br>" . $id . "*";
        $ad_table = Ad::find()->where(['id' => $id])->One();
        $count = count($_POST['Ad']['date_publish']);
//        echo "count: ".$count;

        foreach ($_POST['Ad']['date_publish'] as $d) {
            if ($d == '' or $d == null)
                continue;
//            echo $d."*";
            $clone = new Ad();
            $clone->setAttributes($ad_table->attributes);
            $clone->copy_ad_id = $ad_table->id;
            $clone->status = 22;


            $user_p = User::find()->where(['lvl' => 22])->all();
            $array_list = array();
            foreach ($user_p as $a) {
//                    $task = new Task;
//                    $task->model_id = $ad_id;
//                    $task->user_id = $a->id;
//                    $task->start_time = date('Y-m-d H:i:s');
//                    $task->status = 0;
//                    $task->save(false);
                $c = 0;
                $c = Task::find()->where(['user_id' => $a->id])->count();
                array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
            }
            $keys = array_column($array_list, 'count');
            array_multisort($keys, SORT_ASC, $array_list);
            $next_user_id = $array_list[0]['user_id'];
//            echo $next_user_id;
//            exit();
            $clone->rezvan_id = $next_user_id;
            $clone->active_user_id = $next_user_id;

            $clone->date = date('Y-m-d');
            $clone->date_publish = Persian::convert_date_to_en(Persian::persian_digit_replace($d));
            $clone->save(false);

            $document_table = \common\models\Document::find()->where(['ad_id' => $id])->all();
            foreach ($document_table as $doc) {
                $clone1 = new \common\models\Document;
                $clone1->setAttributes($doc->attributes);
                $clone1->ad_id = $clone->id;
                $clone1->save(false);
            }
            $adhd = \common\models\AdHasDiscount::find()->where(['ad_id' => $id])->all();
            foreach ($adhd as $dis) {
                $clone2 = new \common\models\AdHasDiscount;
                $clone2->setAttributes($dis->attributes);
                $clone2->ad_id = $clone->id;
                $clone2->discount_price = $ad_table->discount_price;
                $clone2->save(false);
            }
            $transition = \common\models\Transition::find()->where(['ad_id' => $id])->all();
            foreach ($transition as $trans) {
                $clone3 = new \common\models\Transition();
                $clone3->setAttributes($trans->attributes);
                $clone3->ad_id = $clone->id;
                $clone3->amount = $ad_table->in_amount;
                $clone3->save();
            }
            $task = \common\models\Task::find()->where(['model_id' => $id])->all();
            foreach ($task as $tass) {
                $clone4 = new \common\models\Task();
                $clone4->setAttributes($tass->attributes);
                $clone4->model_id = $clone->id;
                $clone4->start_time = date('Y-m-d H:i:s');
                $clone4->user_id = $next_user_id;
                $clone4->save();
            }
        }
// exit();
        Yii::$app->session->setFlash('success', 'ثبت شد' . $clone->id);
        return $this->redirect(['/ad']);
    }

    public function actionClonead() {
//        print_r($_POST);

        $id = $_POST['Ad']['id'];
        //echo "<br>" . $id . "*";
        $ad_table = Ad::find()->where(['id' => $id])->One();
        $count = count($_POST['Ad']['date_publish']);
//        echo "count: ".$count;

        foreach ($_POST['Ad']['date_publish'] as $d) {
            if ($d == '' or $d == null)
                continue;
//            echo $d."*";
            $clone = new Ad();
            $clone->setAttributes($ad_table->attributes);
            $clone->copy_ad_id = $ad_table->id;
            $clone->status = 22;


            $user_p = User::find()->where(['lvl' => 22])->all();
            $array_list = array();
            foreach ($user_p as $a) {
//                    $task = new Task;
//                    $task->model_id = $ad_id;
//                    $task->user_id = $a->id;
//                    $task->start_time = date('Y-m-d H:i:s');
//                    $task->status = 0;
//                    $task->save(false);
                $c = 0;
                $c = Task::find()->where(['user_id' => $a->id])->count();
                array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
            }
            $keys = array_column($array_list, 'count');
            array_multisort($keys, SORT_ASC, $array_list);
            $next_user_id = $array_list[0]['user_id'];
            $clone->rezvan_id = $next_user_id;
            $clone->active_user_id = $next_user_id;


            $clone->date = date('Y-m-d');
            $clone->date_publish = Persian::convert_date_to_en(Persian::persian_digit_replace($d));
            $clone->save(false);

            $document_table = \common\models\Document::find()->where(['ad_id' => $id])->all();
            foreach ($document_table as $doc) {
                $clone1 = new \common\models\Document;
                $clone1->setAttributes($doc->attributes);
                $clone1->ad_id = $clone->id;
                $clone1->save(false);
            }
            $adhd = \common\models\AdHasDiscount::find()->where(['ad_id' => $id])->all();
            foreach ($adhd as $dis) {
                $clone2 = new \common\models\AdHasDiscount;
                $clone2->setAttributes($dis->attributes);
                $clone2->ad_id = $clone->id;
                $clone2->discount_price = $ad_table->discount_price;
                $clone2->save(false);
            }
            $transition = \common\models\Transition::find()->where(['ad_id' => $id])->all();
            foreach ($transition as $trans) {
                $clone3 = new \common\models\Transition();
                $clone3->setAttributes($trans->attributes);
                $clone3->ad_id = $clone->id;
                $clone3->amount = $ad_table->in_amount;
                $clone3->save();
            }
            $task = \common\models\Task::find()->where(['model_id' => $id])->all();
            foreach ($task as $tass) {
                $clone4 = new \common\models\Task();
                $clone4->setAttributes($tass->attributes);
                $clone4->model_id = $clone->id;
                $clone4->start_time = date('Y-m-d H:i:s');
                $clone4->user_id = $next_user_id;
                $clone4->save();
            }
        }
// exit();
        Yii::$app->session->setFlash('success', 'ثبت شد' . $clone->id);
        return $this->redirect(['/ad']);
    }

    public function actionClone($id) {
        $ad_table = Ad::find()->where(['id' => $id])->One();
        $clone = new Ad();
        $clone->setAttributes($ad_table->attributes);
        $clone->status = -3;
        $clone->copy_ad_id = $ad_table->id;
        $clone->save(false);
        $document_table = \common\models\Document::find()->where(['ad_id' => $id])->One();
        $clone1 = new \common\models\Document;
        $clone1->setAttributes($document_table->attributes);

        $clone1->ad_id = $clone->id;
        $clone1->save(false);
//        echo  $clone1->ad_id;
//        print_r( $clone1->getErrors());
//        exit();
        Yii::$app->session->setFlash('success', 'آگهی کپی شد' . $clone->id);
        return $this->redirect(['/ad']);
    }

    public function actionDate($id) {

        return $this->render('date');
    }

    public function actionDateedit($id) {

        return $this->render('dateedit');
    }

    public function actionRequest() {
        $searchModel_r = new \common\models\Requestsearch();
        $dataProvider_r = $searchModel_r->search(Yii::$app->request->queryParams, true);

        return $this->render('request', [
                    'searchModel_r' => $searchModel_r,
                    'dataProvider_r' => $dataProvider_r,
        ]);
    }

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



            $filepath = sprintf('uploaded_document/%s_%s', uniqid(), $_FILES['file']['name']);



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

    public function actionNeworder() {
        $yeki = (explode("#", $_POST['edit_id']));
        $yeki1 = (explode("#", $_POST['ad_id']));

        $pay = $_POST['naghdi_etebari'];

        if ($_POST['ad_id']) {
//            $ad_id = $yeki[1];
            if (strpos($_POST["ad_id"], "#") !== false) {
                $y = (explode("#", $_POST['ad_id']));
                $ad_id = $y[1];
            } else {

                $ad_id = $_POST['ad_id'];
            }
        } elseif ($_POST['edit_id']) {
//            $ad_id = $yeki1[1];
            if (strpos($_POST["edit_id"], "#") !== false) {
                $y = (explode("#", $_POST['edit_id']));
                $ad_id = $y[1];
            } else {
                $ad_id = $_POST['edit_id'];
            }
        }








//      echo $ad_id."ad";
//        exit();
        $edit_id = $_POST['edit_id'];
        $user_online = Yii::$app->user->identity->id;
        if ($edit_id != null) {
            // echo    $_POST['edit_id'];
            $ad = Ad::findOne($ad_id);
//            $ad = Ad::findOne($yeki1[1]);
        } else {
//         
            $ad = Ad::check_new_order($ad_id);
        }


        $customer = Customer::findOne($ad->customer_id);
        //if($ad->ad_type==9)
        //return json_encode(['flag' => -1, 'eer' => array(1 => 'برای  آگهی های خارجی  افزایش تعرفه اجباری است')]);



        $dddd = $_POST['ad_id'];

//echo $_POST['ad_type']."&";
        $ad_typee = $_POST['ad_type'];
//  echo $ad_typee;
        // return json_encode(['data' => $_POST['ad_id']]);
//echo $ad->resseler_id."pppppp";
        $user_table = User::find()->where(['id' => $ad->resseler_id])->one();

        if (!$edit_id) {
            $in_pub = $ad->in_amount * $ad->pub_qty . "<br>";
//        echo $ad_typee."<br>";
//        echo $user_online."<br>";
            $model_ad = Ad::find()->where(['id' => $ad_id])->one();
            if (Yii::$app->user->identity->sub_type == 1) {
                if ($model_ad->ad_type == 1 or $model_ad->ad_type == 11) {
                    $model_ad->constt = 2;
                } else {
                    $model_ad->constt = 1;
                }
//            echo "pass";
//            exit();
                if ($ad_typee != 4 and $ad_typee != 6 and $pay == 2 and $ad_typee != 1 and $ad_typee != 11 and!$_POST['edit_id']) {
//          echo "etebari"."<br>";
//             exit();
                    $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
                    $sum_credit_saghf = $user_table->credit + $user_table->saghf_etebar;
                    $sum = $user_table->credit + $user_table->saghf_etebar;

                    $summ = $sum - $ad->in_amount; //+ $str_credit;
                    if ($summ < 0)
                        return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار شما کافی نیست*۱' . number_format($summ))]);
                    elseif ($user_table->etebar == 1 and $in_pub <= $sum_credit_saghf) {
                        $credit = $user_table->credit;
                        $credit -= $ad->in_amount;
                        $user_table->credit -= $ad->in_amount * $ad->pub_qty;
                        $user_table->save(false);
                        $ad->credit = $ad->in_amount;
                        $ad->benefit_status = 1;
                        $ad->save(false);
                    } elseif ($user_table->etebar == 0)
                        return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار ندارید' . number_format($summ))]);
                } elseif ($pay == 1 and!$_POST['edit_id']) {
//           
                    $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
                    $sum_credit_saghf = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
                    $sum = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
                    //$str_credit = (string) $user_table->credit_naghdi;
                    //$str_credit = str_replace("-", "", $str_credit);

                    $summ = $sum - $ad->in_amount; //+ $str_credit;
                    // echo $user_table->id."kkkkkk";
//echo "summ".$summ."<br>";
                    if ($user_table->etebar_naghdi == 0) {
                        return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی ندارید  ' . $user_table->etebar_naghdi . "*" . $user_table->id)]);
                    } elseif ($summ < 0) {
                        return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی شما کافی نیست2  ' . number_format($summ))]);
                    } elseif ($user_table->etebar_naghdi == 1 and $in_pub <= $sum_credit_saghf) {
                        $credit = $user_table->credit_naghdi;
                        $credit -= $ad->in_amount * $ad->pub_qty;
                        $user_table->credit_naghdi -= $ad->in_amount * $ad->pub_qty;

                        $user_table->save(false);
//               
                        $ad->credit = $ad->in_amount;
                        $ad->benefit_status = 1;
                        //$ad->in_the_time = date('Y-m-d H:m:s');
                        $ad->save(false);
                    }
                } elseif (($ad_typee == 1 or $ad_typee == 11) and!$_POST['edit_id']) {
                    $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
                    $ad->credit = $ad->in_amount;
                    $user_table->credit -= $ad->in_amount;
                    $user_table->save();
                    $ad->save();
                }

                $model_ad->status = 3;
                $model_ad->sarparast_first = 1;
                $user_p = User::find()->where(['lvl' => 3])->all();
                $array_list = array();
                foreach ($user_p as $a) {

                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
                $keys = array_column($array_list, 'count');
                array_multisort($keys, SORT_ASC, $array_list);
                $next_user_id = $array_list[0]['user_id'];
//                $next_user_id = 462;
                $model_ad->{Ad::ad_order[3]} = $next_user_id;
                $model_ad->active_user_id = $next_user_id;
                if (Yii::$app->user->identity->sub_type == 1 and Yii::$app->user->identity->lvl == 2) {
                    $model_ad->paziresh_id = Yii::$app->user->identity->id;
                }
            } elseif (Yii::$app->user->identity->sub_type != 1) {
                $model_ad->constt = 1;


                // echo "here".$ad->id." ".$ad->resseler_id;

                if ($ad_typee != 4 and $ad_typee != 6 and $pay == 2 and!$_POST['edit_id']) {
//          echo "etebari"."<br>";
//             exit();
                    $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
                    $sum_credit_saghf = $user_table->credit + $user_table->saghf_etebar;
                    $sum = $user_table->credit + $user_table->saghf_etebar;
//echo $user_table."<br>";
                    //  echo $user_table->credit." ".$user_table->saghf_etebar;
//$sum  = 9999999999999999; // // eetebarr rewrite
                    $summ = $sum - $ad->in_amount; //+ $str_credit;

                    if ($summ < 0)
                        return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار شما کافی نیستت*۳' . $user_table->id . ">>>>" . number_format($summ))]);
                    elseif ($user_table->etebar == 1 and $in_pub <= $sum_credit_saghf) {
                        $credit = $user_table->credit;
                        $credit -= $ad->in_amount;
                        $user_table->credit -= $ad->in_amount * $ad->pub_qty;
                        $user_table->save(false);
                        $ad->credit = $ad->in_amount;
                        $ad->benefit_status = 1;
                        $ad->save(false);
                        // $user_table->etebar = 1; // eetebarr rewrite
                    } elseif ($user_table->etebar == 0)
                        return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار ندارید*' . $user_table->id . ">> " . number_format($summ))]);
                } elseif ($pay == 1 and!$_POST['edit_id'] and Yii::$app->user->identity->sub_type != 1) {
//           
                    $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
//            
                    $sum_credit_saghf = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
                    $sum = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
                    $summ = $sum - $ad->in_amount;


                    if (!$user_table->etebar_naghdi) {


                        if ($user_table->credit_naghdi) {


                            if ($user_table->credit_naghdi < $ad->in_amount) {
                                return json_encode(['flag' => -1, 'eer' => array(1 => 'شارژ حساب شما کافی نیست (' . number_format($user_table->credit_naghdi - $ad->in_amount) . ')')]);
                            } else {



                                $user_table->credit_naghdi -= $ad->in_amount * $ad->pub_qty;
                                $user_table->save(false);


                                $ad->cash = $ad->in_amount;
                                $ad->pay_status = 1;
                                $ad->save(false);



                                // naghdi !
                            }
                        } else {
                            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی ندارید  ')]);
                        }
                    } else {// etebar naghdi darim
                        if ($summ < 0) {
                            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی شما کافی نیست # ' . number_format($summ))]);
                        } elseif ($user_table->etebar_naghdi and $in_pub <= $sum_credit_saghf) {


                            //$credit = $user_table->credit_naghdi;
                            //$credit -= $ad->in_amount * $ad->pub_qty;
                            $user_table->credit_naghdi -= $ad->in_amount * $ad->pub_qty;

                            $user_table->save(false);

                            $ad->credit = $ad->in_amount;
                            $ad->benefit_status = 1;
                            //$ad->in_the_time = date('Y-m-d H:m:s');
                            $ad->save(false);
                        }
                    }
                }
                $model_ad->status = 22;
                $user_p = User::find()->where(['lvl' => 22])->all();
                $array_list = array();
                foreach ($user_p as $a) {

                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
                $keys = array_column($array_list, 'count');
                array_multisort($keys, SORT_ASC, $array_list);
                $next_user_id = $array_list[0]['user_id'];
                $model_ad->{Ad::ad_order[22]} = $next_user_id;
                $model_ad->active_user_id = $next_user_id;
            }
            $gall = array();
            if ($_POST['gallery']) {
                $data_pic = explode(PHP_EOL, $_POST['gallery']);
                $cc = count($data_pic);
                for ($i = 0; $i < $cc; $i++) {

                    if ($data_pic[$i] != null and $data_pic[$i] != '') {
                        $doc = new \common\models\Document();
                        $dataa = explode('/frontend/web/', $data_pic[$i]);

                        $dataag = $dataa[1];
                        if (!in_array($dataag, $gall)) {
                            $doc->file_doc = $dataag;
                            $doc->ad_id = $ad_id;

                            $doc->customer_id = $_POST['customer_id'];
                            $doc->save(false);
                            array_push($gall, $dataag);
                        }
                    }
                }
            }
            $date_pub = $_POST['date_publish'];
            $date_pub2 = Persian::convert_date_to_en(Persian::persian_digit_replace($date_pub));
            $box_id = $_POST['box_id'];
            $ad_table = Ad::find()->where(['date_publish' => $date_pub2, 'box_id' => $box_id])->all();


            foreach ($ad_table as $add) {
                $sum_box += $add->box_qty;
            }
            $sum_box += $ad->box_qty;
            $date_pub = $_POST['date_publish'];
            if ($date_pub)
                $date_pub = Persian::convert_date_to_en(Persian::persian_digit_replace($date_pub));
            $iddd = $_POST['id'];

            if ($iddd != null) {

                $ad_id = $iddd;
            } else {
                $ad_id = $ad->id;
            }



            $transition_table = new \common\models\Transition();
            $transition_table->user_id = $ad->resseler_id;

            $transition_table->type = User::transition_list['new ad'];
            $transition_table->ad_id = $ad_id;

            $transition_table->amount = $ad->in_amount;
            $transition_table->save(false);



            $model_ad->scenario = "create_final";

            $model_ad->info = $_POST['body'];
            $model_ad->fani = $_POST['fani'];
            $model_ad->date = date('Y-m-d');

            $model_ad->box_id = $_POST['box_id'];
            $model_ad->logo = $_POST['logo'];
            $model_ad->first_page = $_POST['first_page'];

            $model_ad->frame = $_POST['frame'];
            $model_ad->ad_type = $_POST['ad_type'];
            $model_ad->code_namayandegi = $_POST['code_namayandegi'];
            $model_ad->benefit = 1;


            if ($model->ad_type == 11) {
                $model_ad->box_price = \common\models\Box::findOne($model_ad->box_id)->price_dolati;
            } else {
                $model_ad->box_price = \common\models\Box::findOne($model_ad->box_id)->price;
            }



            //$model_ad->status = 11;

            if (strtotime($model_ad->date_publish) < time()) {
                $model_ad->status = 11;
            } else {
                $task_table = new Task();
                $task_table->user_id = $next_user_id;
                $task_table->start_time = date('Y-m-d H:i:s');
                $task_table->status = 0;
                $task_table->model_id = $ad_id;
                $task_table->save(false);
            }


            $contract_table = Contract::find()->where(['id' => $model_ad->contract_id])->one();
            if ($contract_table) {
                $contract_table->ad_id = $model_ad->id;
                $contract_table->status = 0;
                $remainder = ($contract_table->price) - ($model_ad->in_amount);
                //echo $remainder;
                $contract_table->remainder = $remainder;
                $contract_table->save(false);
            }


            // return json_encode(['flag' => -1, 'eer' => $model_ad->getErrors(),'customer'=>$_POST['customer_id']]);
//print_r($_POST);
//exit();
            if ($model_ad->save(false)) {



                Yii::$app->session->setFlash('success', "آگهی ثبت شد منتظر تایید بمانید...");
                return json_encode(array('flag' => 1));
            } else {
                Yii::$app->session->setFlash('erroro', " خطایی پسش آمد در فرصتی دیگر  تلاش کنید");
                return json_encode(['flag' => -1, 'eer' => $model_ad->getErrors()]);
            }
            return json_encode($model_ad->id);


            if (!$_GET['id']) {
                return $this->render('site/new_order', [
                            '$model_ad' => $model_ad,
                ]);
            } elseif ($_POST['edit_id']) {
                Yii::setAlias('@example', Url::to('https://hamshahriads.ir/ad/view?id=5591=' . $_GET['id']));
                return $this->render('@example');
            }
//        else {
//            Yii::setAlias('@example', Url::to('https://hamshahriads.ir/backend/web/index.php?r=ad%2Fview&id=' . $_GET['id']));
//
//            return $this->render('@example');
//        }
        } else {
            $new_qty = $_POST['pub_qty'];
            $old_qty = $ad->pub_qty;
//             echo "<br>".$new_qty."<br>";
//             echo $old_qty."<br>";
//            echo "ediiit<br>";
            $_POST['in_amount'] = str_replace(",", "", $_POST['in_amount']);
            $_POST['benefit_price'] = str_replace(",", "", $_POST['benefit_price']);
            if ($_POST['in_amount'] != $ad->in_amount) {
//                echo "different<br>";
//                exit();

                $clone_id = $ad->id;
//                echo "old: " . $ad->in_amount . "<br>";
//                echo "post: " . $_POST['in_amount'] . "<br>";
                $old_amount = $ad->in_amount;
                $new_amount = $_POST['in_amount'];


                if ($old_amount > $new_amount) {
//                    echo "old > new<br>";
                    $diff = $old_amount - $new_amount;
                    $res = User::findOne($ad->resseler_id);
                    if ($ad->naghdi_etebari == 1) {
//                        echo "1<br>";
                        $cre = $res->credit_naghdi;
//                        echo $cre."<br>";
                        $res->credit_naghdi = (float) $cre + $diff;
//                        echo $res->credit_naghdi."<br>";
                        $ad->credit = $new_amount - $old_amount;
                        $res->save();
                    } elseif ($ad->naghdi_etebari == 2) {
//                         echo "2<br>";
                        $cre = $res->credit;
//                          echo $cre."<br>";
                        $res->credit = (float) $cre + $diff;
//                         echo $res->credit."<br>";
                        $ad->credit = $new_amount - $old_amount;
                        $res->save();
                    }
//                    exit();
                } elseif ($old_amount < $new_amount) {
//echo "old < new<br>";
//                    echo $old_amount."<br>";
//                     echo $new_amount."<br>";
//                     exit();
                    if ($ad->naghdi_etebari == 1) {
//echo"naghdi<br>";
                        $diff = $new_amount - $old_amount;
                        $user_table = User::findOne($ad->resseler_id);
//                        echo $user_table->credit_naghdi."<br>";
                        $credit = $user_table->credit_naghdi;
//                        $user_table->credit_naghdi = str_replace("-", "", $user_table->credit_naghdi);
//echo $user_table->credit_naghdi."<br>";
                        $sum_credit_saghf = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
                        $sum = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
                        $summ = $sum - $diff; //+ $str_credit;
//                        echo $user_table->credit_naghdi . "<br>";
//                        echo $user_table->saghf_etebar_naghdi. "<br>";
//                        echo $sum . "<br>";
//                        echo $diff . "<br>";
//                        exit();
                        if ($user_table->etebar_naghdi == 0) {
                            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی ندارید ادیت^' . $user_table->etebar_naghdi . "*" . $user_table->id)]);
                        } elseif (($sum) < $diff) {

//                            echo "sum<diff";
                            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی شما کافی نیست  ادیت' . number_format($diff - $sum))]);
                        } elseif ($user_table->etebar_naghdi == 1 and $user_table->credit_naghdi + $diff <= $user_table->saghf_etebar_naghdi) {

                            $user_table->credit_naghdi = (float) $credit - $diff;
//                            echo $user_table->credit_naghdi."*".$diff;
//                            exit();
                            $user_table->save(false);
                            $ad->credit = $new_amount;
                            $ad->benefit_status = 1;
                            // $ad->save(false);
                        }
                    } elseif ($ad->naghdi_etebari == 2) {
//                        echo"etebari<br>";
                        $diff = $new_amount - $old_amount;
                        $user_table = User::findOne($ad->resseler_id);
                        $credit = $user_table->credit;
                        $sum_credit_saghf = $user_table->credit + $user_table->saghf_etebar;
                        $sum = $user_table->credit + $user_table->saghf_etebar;
                        $summ = $sum - $ad->in_amount; //+ $str_credit;
//                        $user_table->credit = str_replace("-", "", $user_table->credit);
                        if ($user_table->etebar == 0) {
                            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتباری ندارید ادیت' . $user_table->etebar . "*" . $user_table->id)]);
                        } elseif ($user_table->credit + $diff > $user_table->saghf_etebar) {
                            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبای شما کافی نیست ادیت ' . number_format($diff))]);
                        } elseif ($user_table->etebar == 1 and $user_table->credit + $diff <= $user_table->saghf_etebar) {

                            //$credit -= $ad->in_amount * $ad->pub_qty;
                            $user_table->credit = (float) $credit - $diff;
                            $user_table->save(false);
                            $ad->credit = $new_amount;
                            $ad->benefit_status = 1;
                        }
                    }
                }
//echo $_POST['in_amount']."<br>";
//echo $_POST['pub_qty']."<br>";
                $ad->info = $_POST['body'];
                $ad->ad_type = $_POST['ad_type'];
                $pub_date = Persian::convert_date_to_en(Persian::persian_digit_replace($_POST['date_publish']));
                $ad->date_publish = $pub_date;
                $ad->info = $_POST ['body'];
                $ad->logo = $_POST['logo'];
                $ad->first_page = $_POST['first_page'];
                $ad->customer_confirmation = $_POST['customer_confirmation'];
                $ad->fani = $_POST['fani'];
                $ad->date = date('Y-m-d');
                $ad->box_id = $_POST['box_id'];
                $ad->box_qty = $_POST['all_qty'] / $_POST['pub_qty'];
                $ad->pub_qty = $_POST['pub_qty'];
                $ad->logo = $_POST['logo'];
                $ad->first_page = $_POST['first_page'];
                $ad->in_amount = $_POST['in_amount'] / $_POST['pub_qty'];
//                echo $ad->in_amount;
//                exit();
                $ad->benefit_price = $_POST['benefit_price'] / $_POST['pub_qty'];
                $ad->total_price = $_POST['in_amount'];
//                echo $_POST['discount_price']."****";
//                exit();
                $ad->discount_price = $_POST['discount_price'];
                $ad->price_after_discount = $_POST['in_amount'] - $_POST['discount_price'];
                $ad->frame = $_POST['frame'];
                $ad->ad_type = $_POST['ad_type'];
                $ad->customer_id = $_POST['customer_id'];
                $ad->code_namayandegi = $_POST['code_namayandegi'];

                $transition_delete = \common\models\Transition::find()->where(['type' => 1, 'ad_id' => $edit_id])->one();
                //echo $transition_delete->id;

                if (!$transition_delete->delete()) {
                    //echo "no delete";
                    //print_r($transition_delete->getErrors());
                }
                //exit();
//                \Yii::$app
//                        ->db
//                        ->createCommand()
//                        ->delete('transition', ['id' => $transition_delete->id])
//                        ->execute();


                $transition_table = new \common\models\Transition();
                $transition_table->user_id = $ad->resseler_id;
                $transition_table->type = User::transition_list['new ad'];
                $transition_table->ad_id = $ad->id;
                $transition_table->amount = $new_amount / $_POST['pub_qty'];
                $transition_table->save(false);



//            echo $d."*";
//                if ($_POST['pub_qty'] >= 1) {
//                    for ($i = 1; $i < $_POST['pub_qty']; $i++) {
//                        $clone = new Ad();
//                        $clone->setAttributes($ad_table->attributes);
//                        $clone->copy_ad_id = $clone_id;
//                        $clone->status = 2;
//                        $clone->date = date('Y-m-d');
//                        $clone->date_publish = Persian::convert_date_to_en(Persian::persian_digit_replace($d));
//                        $clone->save(false);
//
//                        $document_table = \common\models\Document::find()->where(['ad_id' => $id])->all();
//                        foreach ($document_table as $doc) {
//                            $clone1 = new \common\models\Document;
//                            $clone1->setAttributes($doc->attributes);
//                            $clone1->ad_id = $clone->id;
//                            $clone1->save(false);
//                        }
//                        $adhd = \common\models\AdHasDiscount::find()->where(['ad_id' => $clone_id])->all();
//                        foreach ($adhd as $dis) {
//                            $clone2 = new \common\models\AdHasDiscount;
//                            $clone2->setAttributes($dis->attributes);
//                            $clone2->ad_id = $clone->id;
//                            $clone2->discount_price = $ad_table->discount_price;
//                            $clone2->save(false);
//                        }
//                        $transition = \common\models\Transition::find()->where(['ad_id' => $id])->all();
//                        foreach ($transition as $trans) {
//                            $clone3 = new \common\models\Transition();
//                            $clone3->setAttributes($trans->attributes);
//                            $clone3->ad_id = $clone->id;
//                            $clone3->save();
//                        }
//                    }
//                }
                $ad->save(false);

                if ($new_qty <= $old_qty) {
//                    echo "koochiktar";
//                    exit();
                    // Yii::setAlias('@example', Url::to('https://hamshahriads.ir/ad/view?id=' . $_GET['id']));
                    // return $this->render('@example');
//                    echo $iddd."*****";
                    //return $this->redirect(['ad/view', 'id' => $edit_id]);
                    return json_encode($edit_id);
                } elseif ($new_qty > $old_qty) {
//                    echo $new_qty."*".$old_qty;
//                    exit();
                    return json_encode(['flag' => 5, 'eer' => $new_qty - $old_qty]);

//                    return json_encode($edit_id);
                }
            }
        }
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->date_publish = \common\models\Persian::convert_date_to_en(Persian::persian_digit_replace($model->date_publish), TRUE);
            ;


            if (!is_numeric($model->customer_id)) {
                $m = new \common\models\Customer();
                $m->name = $model->customer_id;
                $m->save(FALSE);
                $model->customer_id = $m->id;
            }
            $model->filedoc = UploadedFile::getInstance($model, 'filedoc');
            if ($model->filedoc->basename) {
                $basfname = "uploaded_document/" . $this->generateRandomString(15);
                $model->filedoc->saveAs($basfname . '.' . $model->filedoc->extension);
                $model->document = $basfname . '.' . $model->filedoc->extension;
            }

            $model->save(false);
//            print_r($model->getErrors())."<br>";
//            echo  $model->document;
//            exit();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'آگهی ویرایش شد' . $model->id);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }



            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete2($id) {
        //$m = $this->findModel($id)->delete();
        //print_r($m);

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //rename 
    function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function actionList3($q = null, $id = 1) {

        $q = str_replace(array('ي', 'ك'), array('ی', 'ک'), $q);


        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        // \common\models\Customer::check_new_city($q);
//echo $id."**************";

        if (!is_null($q)) {
            $query = new Query;
            if ($id == 1) {


                $query->select(['CONCAT(customer.name) AS text', 'customer.id',])
                        //->select(['cities.name AS text', 'cities.id',])
                        ->from('customer')
                        ->andwhere(['like', 'customer.name', $q])
                        ->andWhere(['owner_id' => Yii::$app->user->identity->id]);
                       // ->andWhere(['status' => 1]);
            } elseif ($id == 0) {


                $query
                        ->select(['CONCAT(customer.name) AS text', 'customer.id',])
                        //->select(['cities.name AS text', 'cities.id',])
                        ->from('customer')
                        ->andWhere(['like', 'customer.name', $q])
                       // ->andWhere(['status' => 1])
                        ->andWhere(['or',
                            ['owner_id' => Yii::$app->user->identity->id],
                            ['is', 'owner_id', NULL],
                            ['owner_id' => 0],
                ]);

                // ->orWhere(['is', 'owner_id', new \yii\db\Expression('null')])
                //->OrWhere(['owner_id' => 0])
            }


            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }

        return $out;
    }

    public function actionList($q = null, $id = null) {

        $q = str_replace(array('ي', 'ك'), array('ی', 'ک'), $q);


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
