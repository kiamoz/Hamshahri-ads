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
                        'actions' => ['login', 'list3', 'error', 'menu', 'about', 'neworder', 'clone', 'taeid', 'list', 'document', 'data', 'cancelcustomer'],
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



        //  return json_encode(array(1=>$_POST));
        $date_publish = $_POST['date_publish'];
        $box_id = $_POST['box_id'];

        $maket_table_overwrite = Maket::find()->where(['date' => $date_publish, 'box_id' => $box_id])->one();
        if ($maket_table_overwrite) {
            $maket_table_overwrite->maket = json_encode($_POST['maket']);
            $maket_table_overwrite->save(false);
        } else {
            $maket_t = new Maket();
            $maket_t->date = $date_publish;
            $maket_t->box_id = $box_id;
            $maket_t->maket = json_encode($_POST['maket']);
            $maket_t->save(false);
        }

        if (($maket_table_overwrite->save(false)) or ( $maket_t->save(false))) {
            return json_encode(array('flag' => 1));
        }

//        print_r($maket_table->getErrors());
//        exit();
    }

    public function actionData() {

        // return json_encode(array(1=>$_POST));
        $user_on = Yii::$app->user->identity->id;
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

    public function actionView($id, $task_id = null) {
//        echo $task_id;
        $model_t = \common\models\Task::findOne($task_id);
//         print_r($model_t);
        $searchModel_adm = new AdMsgsearch();
        $dataProvider_adm = $searchModel_adm->search(Yii::$app->request->queryParams, $id);


        $searchModel_1 = new Designsearch();
        $dataProvider_1 = $searchModel_1->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
                    'model' => $this->findModel($id), 'model_t' => $model_t,
                    'searchModel_adm' => $searchModel_adm,
                    'dataProvider_adm' => $dataProvider_adm,
                    'searchModel_1' => $searchModel_1,
                    'dataProvider_1' => $dataProvider_1,
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
        $model_ad->save(false);
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

    public function actionTaeid($id) {
        $model = $this->findModel($id);
        $model->status = 2;
        $user_p = User::find()->where(['lvl' => 2, 'status_p' => 1])->all();
        $array_list = array();
        foreach ($user_p as $a) {
            $c = 0;
            $c = Task::find()->where(['user_id' => $a->id])->count();
            array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
        }
        $keys = array_column($array_list, 'count');
        array_multisort($keys, SORT_ASC, $array_list);
        $next_user_id = $array_list[0]['user_id'];
        $model->paziresh_id = $next_user_id;
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

    public function actionNeworder() {

        //return json_encode(['data' => $_POST]);
        //print_r($_POST);


        $pay = $_POST['naghdi_etebari'];
//        echo $pay;
//        exit();
        $edit_id = $_POST['edit_id'];
        $user_online = Yii::$app->user->identity->id;
        if ($edit_id != null) {

            $ad = Ad::findOne($_POST['edit_id']);
        } else {
            $ad = Ad::check_new_order($_POST['ad_id']);
        }

//echo $_POST['ad_id']."*";
        $dddd = $_POST['ad_id'];
//echo $dddd."*";
//echo $_POST['ad_type']."&";
        $ad_typee = $_POST['ad_type'];
//  echo $ad_typee;
        // return json_encode(['data' => $_POST['ad_id']]);
        
        
        if ($pay == 2) {
            $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
            $sum_credit_saghf = $user_table->credit + $user_table->saghf_etebar;
            $sum = $user_table->credit + $user_table->saghf_etebar;
            $str_credit = (string) $user_table->credit;
            $str_credit = str_replace("-", "", $str_credit);

            $summ = $ad->in_amount - $str_credit;
        }
        if ($pay == 1) {
            $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
            $sum_credit_saghf = $user_table->credit_naghdi + $user_table->saghf_etebar_naghdi;
            $sum = $user_table->credit + $user_table->saghf_etebar_naghdi;
            $str_credit = (string) $user_table->credit_naghdi;
            $str_credit = str_replace("-", "", $str_credit);

            $summ = $ad->in_amount - $str_credit;
//            echo $summ;
        }
        //echo $sum_credit_saghf;
        //$ad_add = Ad::find()->where(['id' => $dddd])->one();
        //echo $ad_add->ad_type."*";
        // echo $ad_typee."++";
//        if($ad_typee==5){
//            echo"yes";
//        } else {
//            echo "no";
//        }
//        exit();
        // echo  "typeee: ".$_POST['ad_type'];
        // echo json_encode(['data' => $_POST]);
        if ($ad_typee != 4 and $ad_typee != 6 and $pay == 2) {


//     echo $user_table->etebar."*".$user_table->id."*";
//     exit();
            if ($user_table->etebar == 0 or $ad->in_amount > $user_table->saghf_etebar or $summ > $user_table->saghf_etebar)
                return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار شما کافی نیستت')]);
            elseif ($user_table->etebar == 1 and $ad->in_amount <= $sum_credit_saghf) {
                $credit = $user_table->credit;
                $credit -= $ad->in_amount;
                $user_table->credit = $credit;
                $user_table->save(false);
                $ad->credit -= $ad->in_amount;
                $ad->save(false);
            } else
                return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار شما کافی نیست')]);
        }

        if ($pay == 1) {
            if ($user_table->etebar_naghdi == 0) {
                return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی ندارید  ')]);
            } elseif ($ad->in_amount > $user_table->saghf_etebar_naghdi or $summ > $user_table->saghf_etebar_naghdi) {
                return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی شما کافی نیست  ' . $summ)]);
            } elseif ($user_table->etebar_naghdi == 1 and $ad->in_amount <= $sum_credit_saghf) {
                $credit = $user_table->credit;
                $credit -= $ad->in_amount;
                $user_table->credit_naghdi = $credit;
                $user_table->save(false);
//                echo $ad->in_amount." ".$credit;
//                exit();
//                $ad->credit_naghdi -= $ad->in_amount;
//                $ad->save(false);
            }
            //else
            // return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبارنقدی شما کافی نیست')]);
        }
        $doc = new \common\models\Document();




        if ($_FILES["file"]["name"] != '') {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = rand(100000, 99999999) . '.' . $ext;
            $location = 'uploaded_document/' . $name;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
            //$m =  '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
        }
//
        if ($_FILES["file_doc"]["name"] != '') {
            $test1 = explode('.', $_FILES["file_doc"]["name"]);
            $ext1 = end($test1);
            $name1 = rand(100000, 99999999) . '.' . $ext1;
            $location1 = 'uploaded_document/' . $name1;
            move_uploaded_file($_FILES["file_doc"]["tmp_name"], $location1);
            //$m =  '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
        }





        $date_pub = $_POST['date_publish'];
        $date_pub2 = Persian::convert_date_to_en(Persian::persian_digit_replace($date_pub));
        $box_id = $_POST['box_id'];
        $ad_table = Ad::find()->where(['date_publish' => $date_pub2, 'box_id' => $box_id])->all();
        // print_r($ad_table);

        foreach ($ad_table as $add) {
            $sum_box += $add->box_qty;
//            echo  $add->id."<br>";
//            echo  $add->box_qty."<br>";
        }
        $sum_box += $ad->box_qty;



//        if ($sum_box > 48)
//            return json_encode(['flag' => -1, 'eer' => array(1 => 'فضای کافی برای چاپ آگهی شما نسیت' . $sum_box)]);
        // return json_encode(['sum'=>$sum_box]);

        $date_pub = $_POST['date_publish'];
        if ($date_pub)
            $date_pub = Persian::convert_date_to_en(Persian::persian_digit_replace($date_pub));
        $iddd = $_POST['id'];
        if ($iddd != null) {
            // echo "*";
            // exit();
            $ad_id = $iddd;
        } else {
            $ad_id = $ad->id;
        }
//        echo $ad_id."<br>";
//        echo $ad->in_amount."<br>";
        $transition_table = new \common\models\Transition();
        $transition_table->user_id = $user_online;
        $transition_table->date = date('Y-m-d');
        $transition_table->type = User::transition_list['new ad'];
        $transition_table->ad_id = $ad_id;
        //   echo $transition_table->ad_id."*";
        $transition_table->amount = $ad->in_amount;
        $transition_table->save(false);

        $model_ad = Ad::find()->where(['id' => $ad_id])->one();




        $model_ad->scenario = "create_final";
        $model_ad->info = $_POST['body'];
        $model_ad->date = date('Y-m-d');
        //$model_ad->date_publish = $date_pub;  
        //$model_ad->title = $_POST['title'];
        //$model_ad->customer_id = $_POST['customer_id'];
        $model_ad->box_id = $_POST['box_id'];
//      $model_ad->pub_qty = $_POST['pub_qty'];
        $model_ad->frame = $_POST['frame'];
        //$model_ad->tejari = $_POST['tejari'];
        $model_ad->ad_type = $_POST['ad_type'];
        $model_ad->code_namayandegi = $_POST['code_namayandegi'];
        if ($model_ad->status_change == 2) {
            $model_ad->status = 2;
        } elseif ($model_ad->status_change == 1) {
            $model_ad->status = 1;
        }
//        $model_ad->status = 2;
        $model_ad->benefit = 1;
        //$model_ad->resseler_id = Yii::$app->user->identity->id;
        $doc->file = $location;
        $doc->file_doc = $location1;
        $doc->ad_id = $ad_id;
        $doc->customer_id = $model_ad->customer_id;
        $doc->save(false);


        if ($model_ad->status_change == 2 and $model_ad->paziresh_id) {
            $task_table = new Task();
            $task_table->user_id = $model_ad->paziresh_id;
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
//            echo  $model_ad->title."*";
//            print_r($model_ad->getErrors());
//           
//            exit();
            Yii::$app->session->setFlash('success', "آگهی ثبت شد منتظر تایید بمانید...");
            return json_encode(array('flag' => 1));
        } else {
            Yii::$app->session->setFlash('erroro', " خطایی پسش آمد در فرصتی دیگر  تلاش کنید");
            return json_encode(['flag' => -1, 'eer' => $model_ad->getErrors()]);
        }

        return json_encode($model_ad->id);

//        $all = $_POST;
//
//        return;

        if (!$_GET['id']) {
            return $this->render('site/new_order', [
                        '$model_ad' => $model_ad,
            ]);
        } else {
            Yii::setAlias('@example', Url::to('https://hamshahriads.ir/backend/web/index.php?r=ad%2Fview&id=' . $_GET['id']));

            return $this->render('@example');
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
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
                        ->andWhere(['owner_id' => Yii::$app->user->identity->id])
                        ->andWhere(['status' => 1]);
            } elseif ($id == 0) {


                $query
                        ->select(['CONCAT(customer.name) AS text', 'customer.id',])
                        //->select(['cities.name AS text', 'cities.id',])
                        ->from('customer')
                        ->andWhere(['like', 'customer.name', $q])
                        ->andWhere(['status' => 1])
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
