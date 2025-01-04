<?php

namespace backend\controllers;

use common\models\Maket;
use Yii;
use yii\filters\AccessControl;
use common\models\Ad;
use common\models\Design;
use common\models\AdMsg;
use common\models\Customer;
use common\models\AdSearch;
use common\models\Documentsearch;
use common\models\AdMsgsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Task;
use common\models\Tasksearch;
use common\models\Designsearch;
use common\models\User;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\UploadedFile;
use app\web\Uploads;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends Controller {

    public $name = array();

    //rug

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //  'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'insret_direct',
                            'index', 'refund', 'add_credit_payment', 'list4', 'addpage', 'report', 'edit_ad', 'index1', 'create', 'view1', 'uploadx', 'update', 'view', 'sahm', 'finance_index', 'resseler_index', 'debt_index', 'main_index', 'indextask', 'verify',  'cancel', 'document', 'verifymali'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(24, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['index1','listr','list', 'list2','index2','index3'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(23, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['paz'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(30, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['statusmali', 'request'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(28, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['saveexcel2'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['uploadx'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['savetakhfif'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['onvan'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['customer'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['saveexcel3'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['saveexcel4'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['savecustomer'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['yeki'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['haghighi'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(25, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['pic'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(26, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionInsret_direct() {

        $id = [19323,
        ];
        $kar = [2766,
        ];

        foreach ($id as $key => $id_) {
            $m = new Ad();
            $m->id = $id_;
            $m->resseler_id = $kar[$key];
            $m->save();
            echo $m->getErrors();
        }
    }

    /**
     * Lists all Ad models.
     * @return mixed
     */
    public function actionRefund($id) {


        $ad__ = Ad::findOne($id);
        $ad__->user->wallet += $ad__->cash;
        $ad__->pay_status = 0;
        $ad__->cash = 0;
        $ad__->save();
        $ad__->user->save();

        Yii::$app->session->setFlash('success', 'فاکتور برگشت خورد..');

        $this->redirect(['view', 'id' => $id]);
    }

    public function actionIndex1() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//$dataProvider->pagination->pageSize=50;
        return $this->render('index1', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//$dataProvider->pagination->pageSize=50;
        return $this->render('index2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex3() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//$dataProvider->pagination->pageSize=50;
        return $this->render('index3', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndextask() {
        $searchModel = new Tasksearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
        return $this->render('indextask', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReport() {
        $searchModel_t = new Tasksearch();
        $dataProvider_t = $searchModel_t->search(Yii::$app->request->queryParams, false, false, true);
        return $this->render('report', [
                    'searchModel_t' => $searchModel_t,
                    'dataProvider_t' => $dataProvider_t,
        ]);
    }

    public function actionFinance_index() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('finance_index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionResseler_index() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false, false, null, null, null, false, false, true);

        return $this->render('resseler_index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMain_index() {
        //exit()
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false, false, null, null, null, false, false, false);

        return $this->render('main_index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDebt_index() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false, false, null, null, null, false, false, false);
        $searchModel_day = new AdSearch();
        $dataProvider_day = $searchModel_day->search(Yii::$app->request->queryParams, false, false, null, null, null, false, false, false, true);
        $searchModel_month = new AdSearch();
        $dataProvider_month = $searchModel_month->search(Yii::$app->request->queryParams, false, false, null, null, null, false, false, false, false, true);
        return $this->render('debt_index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModel_day' => $searchModel_day,
                    'dataProvider_day' => $dataProvider_day,
                    'searchModel_month' => $searchModel_month,
                    'dataProvider_month' => $dataProvider_month,
        ]);
    }

    public function actionIndex() {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequest() {
        $searchModel_r = new \common\models\Requestsearch();
        $dataProvider_r = $searchModel_r->search(Yii::$app->request->queryParams);

        return $this->render('request', [
                    'searchModel_r' => $searchModel_r,
                    'dataProvider_r' => $dataProvider_r,
        ]);
    }

    public function actionIndexinbox() {
        $searchModel = new AdSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Ad::find()->
                    where(['user_id' => Yii::$app->user->identity->id]),
        ]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUp() {
        $model = new Task;

        if ($model->load(Yii::$app->request->post())) {
            // zakhire password hash   
            //$user->generateEmailVerificationToken();
            ////// zakhire file
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file->basename) {

                $basfname = "uploads/" . $this->generateRandomString(15);

                $model->file->saveAs($basfname . '.' . $model->file->extension);

                $model->file = $basfname . '.' . $model->file->extension;
            }
            if ($model->save()) {

                return $this->redirect(['/ad/view/']);
                Yii::$app->session->getFlash('success');
            }
        }

//        return $this->render('ad', [
//                    'model' => $model,
//        ]);
    }

    public function actionView1($id) {

        return $this->render('view1', [
                    'model' => $model,
                    'id' => $id,
        ]);
    }

    public function actionAdd_credit_payment($id) {

        $model = Ad::findOne($id);

        $max_need = $model->in_amount - $model->cash;
        $u = \common\models\User::findOne($model->resseler_id);

        if ($u->credit_naghdi >= $max_need) {
            $max_need_avl = $max_need;
        } else {
            $max_need_avl = $u->credit_naghdi;
        }


        $max_need_avl = round($max_need_avl);

        //echo $_POST['range_02'] ." ".$max_need_avl;
        // exit();

        if ($_POST['range_02'] and ($_POST['range_02'] <= $max_need_avl)) {

            //echo $_POST['range_02'];

            $model->cash += $_POST['range_02'];
            if ($model->cash >= $model->in_amount) {
                $model->pay_status = 1;
            }
            $model->save();

            $u->credit_naghdi -= $_POST['range_02'];
            $u->save();

            $transition_table = new \common\models\Transition();
            $transition_table->type = 10;
            $transition_table->actor_id = Yii::$app->user->identity->id;
            $transition_table->amount = $_POST['range_02'];
            $transition_table->ad_id = $id;
            $transition_table->date = date('Y-m-d H:i:s');
            $transition_table->save(false);

            $transition_table = new \common\models\Transition();
            $transition_table->type = 9;
            $transition_table->actor_id = Yii::$app->user->identity->id;
            $transition_table->amount = $_POST['range_02'];
            $transition_table->ad_id = $id;
            $transition_table->date = date('Y-m-d H:i:s');
            $transition_table->save(false);

            // print_r($transition_table->getErrors());




            $max_need = $model->in_amount - $model->cash;
            $u = \common\models\User::findOne($model->resseler_id);

            if ($u->credit_naghdi >= $max_need) {
                $max_need_avl = $max_need;
            } else {
                $max_need_avl = $u->credit_naghdi;
            }

            $max_need_avl = round($max_need_avl);
        }




        return $this->render('add_credit_payment', [
                    'model' => $model,
                    'id' => $id,
                    'max_need_avl' => $max_need_avl,
                    'credit_naghdi' => $u->credit_naghdi,
                    'max_need' => $max_need,
        ]);
    }

    public function actionListr($q = null, $id = null) {


        $q = str_replace(array('ي', 'ك'), array('ی', 'ک'), $q);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;

            $query
                    ->select(['CONCAT(user.name_and_fam," ",user.code_kargozar) AS text', 'user.id',])
                    ->from('user')
                    ->andwhere(['user.type' => 8])
                    ->andwhere(['or', ['like', 'user.name_and_fam', $q], ['code_kargozar' => $q]]);

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
        if (!is_null($q)) {
            $query = new Query;

            $query->select('id, name')
                    ->from('customer')
                    ->orwhere(['like', 'customer.name', $q]);

            $query
                    ->select(['CONCAT(customer.name,"(",customer.id,")") AS text', 'customer.id',])
                    //->select(['cities.name AS text', 'cities.id',])
                    ->from('customer')
                    ->orwhere(['like', 'customer.name', $q])->orwhere(['like', 'customer.id', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    public function actionList2($q = null, $id = null) {

        $q = str_replace(array('ي', 'ك'), array('ی', 'ک'), $q);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name_and_fam')
                    ->from('user')
                    ->orwhere(['like', 'user.name_and_fam', $q]);
            $query
                    ->select(['CONCAT(user.name_and_fam) AS text', 'user.id',])
                    //->select(['cities.name AS text', 'cities.id',])
                    ->from('user')
                    ->orwhere(['like', 'user.name_and_fam', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    /**
     * Displays a single Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        $searchModel = new Tasksearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, FALSE, $id);

        $searchModel_1 = new Designsearch();
        $dataProvider_1 = $searchModel_1->search(Yii::$app->request->queryParams, $id);

        $searchModel_rej = new \common\models\Rejectsearch();
        $dataProvider_rej = $searchModel_rej->search(Yii::$app->request->queryParams, $id);

        $searchModel_doc = new Documentsearch();
        $dataProvider_doc = $searchModel_doc->search(Yii::$app->request->queryParams, FALSE, $id);

        $searchModel_adm = new AdMsgsearch();
        $dataProvider_adm = $searchModel_adm->search(Yii::$app->request->queryParams, $id);

        $searchModel_rez = new \common\models\Rezvansearch();
        $dataProvider_rez = $searchModel_rez->search(Yii::$app->request->queryParams, $id);

        $searchModel_s = new AdSearch();
        $dataProvider_s = $searchModel_s->search(Yii::$app->request->queryParams, $id);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModel_1' => $searchModel_1,
                    'dataProvider_1' => $dataProvider_1,
                    'searchModel_doc' => $searchModel_doc,
                    'dataProvider_doc' => $dataProvider_doc,
                    'searchModel_ad' => $searchModel_ad,
                    'dataProvider_ad' => $dataProvider_ad,
                    'searchModel_adm' => $searchModel_adm,
                    'dataProvider_adm' => $dataProvider_adm,
                    'searchModel_s' => $searchModel_s,
                    'dataProvider_s' => $dataProvider_s,
                    'searchModel_tag' => $searchModel_tag,
                    'dataProvider_tag' => $dataProvider_tag,
                    'searchModel_rez' => $searchModel_rez,
                    'dataProvider_rez' => $dataProvider_rez,
                    'searchModel_rej' => $searchModel_rej,
                    'dataProvider_rej' => $dataProvider_rej,
        ]);
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {


        $model = new Ad();
        $model->scenario = "create";
        $model->date = date('Y-m-d');

        $task = new Task;
        $user_id = Yii::$app->user->identity->id;
        //$model->scenario = "insret";

        if ($model->load(Yii::$app->request->post())) {
            $model->date_publish = \common\models\Persian::convert_date_to_en($model->date_publish);
            $model->status = -2;
            if (!is_numeric($model->customer_id)) {
                $m = new \common\models\Customer();
                $m->name = $model->customer_id;
                $m->save(FALSE);
                $model->customer_id = $m->id;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'آگهی ثبت شد' . $model->id);
                $task->model_id = $model->id;
                $task->status = 0;
                $task->user_id = $user_id;
                $task->start_time = date('Y-m-d H:i:s');
                $task->save(false);
                $model->save(false);
            } else {
                return $this->render('create', [
                            'model' => $model,
                            'task' => $task,
                ]);
            }
            return $this->redirect(['create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionStatusmali() {
        $action = Yii::$app->request->post('action');
        $selection = (array) Yii::$app->request->post('selection'); //typecasting
        foreach ($selection as $id) {
            $req = \common\models\Request::findOne((int) $id); //make a typecasting
            $req->status = 1;
            $req->save(false);
        }
        if ($req->save()) {
            Yii::$app->session->setFlash('success', 'انجام شد');
            return $this->redirect(['ad/request']);
        }
    }

    public function actionCopy($id) {

        $model = $this->findModel($id);

        $docc = new \common\models\Document;
        $doc_ad = \common\models\Document::find()->where(['ad_id' => $id]);

        $ad_table = new Ad();
        $ad_table->title = $model->title;
        $ad_table->date_publish = $model->date_publish;
        $ad_table->box_id = $model->box_id;
        $ad_table->box_qty = $model->box_qty;
        $ad_table->frame = $model->frame;
        $ad_table->resseler_id = $model->resseler_id;
        $ad_table->box_price = $model->box_price;
        $ad_table->serial = $model->serial;
//           echo $ad_table->serial ."<br>";
//           echo $model->serial ."<br>";

        $ad_table->customer_id = $model->customer_id;
//              echo  $model->customer_id ."<br>";
//            echo $ad_table->customer_id ."*";
        $ad_table->total_price = $model->total_price;
        $ad_table->in_amount = $model->in_amount;
        $ad_table->discount_price = $model->discount_price;
        $ad_table->info = $model->info;
        $ad_table->status = -3;
        //$docc->ad_id = $ad_table->id;
        // $docc->file = $doc_ad->file;
        $ad_table->save(false);
        //$docc->save(false);
        // print_r($ad_table->getErrors());
//            print_r( $docc->getErrors());
//            
        $task->model_id = $ad_id;
        $task->user_id = $model->resseler_id;
        $task->start_time = date('Y-m-d H:i:s');
        $task->model = "copy";
        $task->status = 0;
        $task->save(false);

        if ($ad_table->save() and $task->save()) {
            echo $ad_table->id . "*" . "<br>";
            Yii::$app->session->setFlash('success', 'آگهی کپی شد' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('danger', 'خطایی رخ داد زمان دیگری سعی کنید' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionVerifymali($ad_id) {
        $adv = Ad::findOne($ad_id);
        $user_online = Yii::$app->user->identity->id;
        $task_t = Task::find()->where(['model_id' => $ad_id, 'user_id' => $user_online, 'status' => 0])->orderBy(['id' => SORT_DESC])->one();
        if ($task_t) {
            $task_t->status = 1;
            $task_t->end_time = date('Y-m-d H:i:s');
            $task_t->save(false);
        }
        if ($adv->if_changed == 1) {
            $adv->status = 1;
            $adv->mali_id = $user_online;
            if (!$adv->supervisor_id) {
                $user_p = User::find()->where(['lvl' => 1])->all();
                $array_list = array();
                foreach ($user_p as $a) {
                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
                $keys = array_column($array_list, 'count');
                array_multisort($keys, SORT_ASC, $array_list);
                $next_user_id = $array_list[0]['user_id'];
                $adv->active_user_id = $next_user_id;
                $adv->supervisor_id = $next_user_id;
                $adv->status = 1;
            } else {
                $adv->active_user_id = $adv->supervisor_id;
            }

            $task_tt = new Task();
            $task_tt->status = 0;
            $task_tt->start_time = date('Y-m-d H:i:s');
            $task_tt->user_id = $adv->active_user_id;
            $task_tt->model_id = $adv->id;
            $task_tt->save(false);
        } else {

            $adv->status = 11;
        }

//        $task_table = Task::find()->where(['model_id' => $ad_id, 'status' => 0])->all();
//        if ($task_table) {
//            foreach ($task_table as $t) {
//                $t->status = 1;
//            }
//            $t->save(false);
//        }
//           echo $task_t->status ."&";
//           exit();









        $adv->save(false);
        if ($adv->save()) {
            Yii::$app->session->setFlash('success', 'آگهی تایید شد' . $model->id);
            return $this->redirect(['view', 'id' => $ad_id]);
        } Yii::$app->session->setFlash('danger', 'مشکلی پیش آمد زمان دیگری تلاش کنید' . $model->id);
    }

    public function actionPaz($ad_id) {
        $ad_table = Ad::findOne($ad_id);
        $user_online = Yii::$app->user->identity->id;
        $ad_table->status = 2;
        $ad_table->status_change = 0;
        $ad_table->supervisor_id = $user_online;

        $task = new Task;
        $task->status = 1;
        $task->end_time = date('Y-m-d H:i:s');
        $task->model_id = $ad_id;
        $task->user_id = $user_online;
        $task->save(false);

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
        $ad_table->paziresh_id = $next_user_id;
        $ad_table->active_user_id = $next_user_id;

        $task_table = new Task();
        $task_table->user_id = $next_user_id;
        $task_table->start_time = date('Y-m-d H:i:s');
        $task_table->status = 0;
        $task_table->model_id = $ad_id;
        $task_table->save(false);
        $ad_table->save(false);

        return $this->redirect(['view', 'id' => $ad_id]);
    }

    public function actionVerify($ad_id, $next_user = null, $acc_status, $msg = false) {


        $ad = Ad::findOne($ad_id);
        $ad_current_status = $ad->status;
        if ($ad_current_status == 1 and $acc_status == 3) {
            $ad->sarparast_first = 1;
        }
        if ($ad_current_status == 6 and $acc_status == 3) {
            $ad->sarparast_first = 2;
        }
        if ($ad_current_status == 3 and $ad->sarparast_first == 2 and $ad->customer_confirmation != 1 and!$_GET['msg'] and!$_GET['doc']) {
            $next_user = 9;
            $acc_status = 9;
        } elseif ($ad_current_status == 3 and $ad->sarparast_first == 2 and $ad->customer_confirmation == 1 and!$_GET['msg'] and!$_GET['doc']) {
            $next_user = 2;
            $acc_status = 2;
        }
        if ($ad_current_status == 2 and $ad->customer_confirmation == 1 and $ad->sarparast_first == 2) {
//            echo 'in';
            $next_user = 8;
            $acc_status = 8;
        }
        if ($msg != false or $_GET['doc']) {
            $ad->if_rejected = 1;
        } else {
            $ad->if_rejected = 0;
        }



        $user_online = Yii::$app->user->identity->id;
        if ($ad->mali_id and $ad->status == 1 and $ad->if_changed == 1 and Yii::$app->user->identity->lvl == 1) {
            // echo "1"."<br>";
            $acc_status = 11;
            $ad->status = 11;
            $ad->active_user_id = '';
            $ad->save(false);
            $task1 = Task:: find()->where(['user_id' => $user_online, 'status' => 0, 'model_id' => $ad_id])->orderBy(['id' => SORT_DESC])->One();

            if ($task1) {
                $task1->status = 1;
                $task1->end_time = date('Y-m-d H:i:s');
                $task1->save(false);
            }
//            echo \common\models\Ad::finish();
        }
        $usss = User::findOne($user_online);
        if ($usss->lvl == 6) {
//         echo 'lvl 6';
            $uuuu = User::find()->where(['lvl' => 6])->all();
            foreach ($uuuu as $u) {
                $task1 = Task:: find()->where(['user_id' => $u->id, 'model_id' => $ad_id, 'status' => 0])->all();
                if ($task1) {
                    foreach ($task1 as $tt) {
                        $tt->status = 1;
                        $tt->end_time = date('Y-m-d H:i:s');
                        $tt->save(false);
                    }
                }
            }
        } else {
//             echo 'lvl not 6';
            $task1 = Task:: find()->where(['user_id' => $user_online, 'status' => 0, 'model_id' => $ad_id])->orderBy(['id' => SORT_DESC])->One();
            if ($task1) {
                // echo "2"."<br>";
                $task1->status = 1;
                $task1->end_time = date('Y-m-d H:i:s');
//              echo "t2";
                $task1->save(false);
            }
        }
        $ad->status = $acc_status;
        if ($task1->id and $ad_current_status != $ad->status) {
            //   echo "3"."<br>";
            $task1->status = 1;
            $task1->end_time = date('Y-m-d H:i:s');

//            echo "t1";
            // echo $task1->id;
            //  echo $task1->user_id ." ".$task1->model_id;
            // exit();
            $task1->save();
            //echo $task1->status;
        }
        if ($acc_status == 3 and $ad->paziresh_id == null) {
            $ad->paziresh_id = $user_online;
        }
//        if ($ad->status == 2 and $ad->paziresh_id == null)
//            $ad->supervisor_id = $user_online;
        if ($ad->status <= 7) {
            if ($acc_status == 6 and!$_GET['msg'] and!$_GET['doc']) {
                $user_p = User::find()->where(['lvl' => 6])->all();
                $array_list = array();
                foreach ($user_p as $a) {
                    $task = new Task;
                    $task->model_id = $ad_id;
                    $task->user_id = $a->id;
                    $task->start_time = date('Y-m-d H:i:s');
                    $task->status = 0;
                    $task->save(false);
                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
                $keys = array_column($array_list, 'count');
                array_multisort($keys, SORT_ASC, $array_list);
                $next_user_id = $array_list[0]['user_id'];
                $ad->{Ad::ad_order[$ad->status]} = $next_user_id;
//                echo "<br>". $next_user_id." 1<br>";
            } else {
                $next_user_id = $ad->{Ad::ad_order[$ad->status]};
            }
        }
//         echo "<br>". $next_user_id." 2<br>";
//            if ($ad->status == 9)
//            $next_user_id = $ad->{Ad::ad_order[$ad->status]};
        if ($ad->status == 8) {

            if ($next_user == 1) {
                $next_user_id = $ad->supervisor_id;
            }
            if ($next_user == 8 and!$_GET['doc'] and $msg == false) {
                // echo "4"."<br>";
                $next_user_id = $ad->resseler_id;
                $task = new Task;
                $task->model_id = $ad_id;
                $task->user_id = $next_user_id;
                $task->start_time = date('Y-m-d H:i:s');
                $task->model = "ad";
                $task->status = 0;
                $task->save(false);
//                  echo "t3";
//                
//                echo $task->user_id ." ".$task->model_id;
                //exit();
//                $task->save(false);
            }
        }
//       echo "<br>". $next_user_id."<br>";
        if (!$next_user_id and $acc_status != 11) {
// echo 'create 0';
            if ($next_user == 6) {
// echo 'next user  6';
                $user_p = User::find()->where(['lvl' => $next_user])->all();

                $array_list = array();
                foreach ($user_p as $a) {
                    $task = new Task;
                    $task->model_id = $ad_id;
                    $task->user_id = $a->id;
                    $task->start_time = date('Y-m-d H:i:s');
                    $task->status = 0;
                    $task->save(false);
                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
                $keys = array_column($array_list, 'count');
                array_multisort($keys, SORT_ASC, $array_list);
                $next_user_id = $array_list[0]['user_id'];
                $ad->{Ad::ad_order[$ad->status]} = $next_user_id;
            } else {
//              echo 'next user not 6';
                $user_p = User::find()->where(['lvl' => $next_user, 'status_p' => 1])->all();
                $array_list = array();
                foreach ($user_p as $a) {
                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
                $keys = array_column($array_list, 'count');
                array_multisort($keys, SORT_ASC, $array_list);
                $next_user_id = $array_list[0]['user_id'];
                $ad->{Ad::ad_order[$ad->status]} = $next_user_id;
//                 $task = new Task;
//                    $task->model_id = $ad_id;
//                    $task->user_id = $next_user_id;
//                    $task->start_time = date('Y-m-d H:i:s');
//                    $task->status = 0;
//                    $task->save(false);
//                echo $next_user_id;
            }
        }
        $ad->active_user_id = $next_user_id;

//        if ($ad->status < 7)
//            $ad->{Ad::ad_order[$ad->status]} = $next_user_id;


        if ($msg == false and!$_GET['doc'] and $acc_status != 11 and $next_user != 6 and $next_user != 8) {
//            echo "*1";
//         echo "5"   ."<br>";
            $task = new Task;
            $task->model_id = $ad_id;
            $task->user_id = $next_user_id;
            $task->start_time = date('Y-m-d H:i:s');
            $task->status = 0;
            $task->save(false);
        }

//        echo  $task->user_id." ".$task->model_id;
        $ad->save(false);

        if ($acc_status == 11) {
            $tassk = Task::find()->where(['model_id' => $ad_id])->all();
            if ($tassk) {
                foreach ($tassk as $t) {
                    $t->status = 1;
                    $t->end_time = date('Y-m-d H:i:s');

                    $t->save(false);
                }
            }
        }

        if ($_GET['msg'] or $ad_current_status == 6 and $acc_status == 5) {
            return $this->redirect(['cancel', 'id' => $ad_id, 'next_user' => $next_user]);
        }
        if ($_GET['doc']) {
            return $this->redirect(['document', 'id' => $ad_id, 'next_user' => $next_user, 'acc_status' => $acc_status]);
        }
        if ($ad->status > $ad_current_status) {
            Yii::$app->session->setFlash('success', 'آگهی تایید شد' . $model->id);
        }

        return $this->redirect(['site/index']);

        //  Ad::assign_task($id);
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

    public function actionCancel($id, $next_user) {
        $admsg = new AdMsg;
        $my_task = new Task;
        $taskrad = Task ::find()->where(['model_id' => $id, 'status' => 1])->orderby(['id' => SORT_DESC])->One();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            //$model->status = 2;

            $model->error = $_POST['Ad']['error'];
            if ($next_user == 2) {
                $model->active_user_id = $model->paziresh_id;
                $model->status = 2;
                $my_task->model_id = $id;
                $my_task->start_time = date('Y-m-d H:i:s');
                $my_task->status = 0;
                $my_task->user_id = $model->active_user_id;
                $my_task->subject = $model->document;
                $my_task->save(false);
            } elseif ($next_user == 5) {
                $model->active_user_id = $model->tarahi_id;
                $model->status = 5;
                $my_task->model_id = $id;
                $my_task->start_time = date('Y-m-d H:i:s');
                $my_task->status = 0;
                $my_task->user_id = $model->active_user_id;
                $my_task->subject = $model->document;
                $my_task->save(false);
            } elseif ($next_user == 8) {
                $model->active_user_id = $model->resseler_id;
                $model->status = 2;
                $my_task->user_id = $model->active_user_id;
                $my_task->model = 'ad';
                $my_task->model_id = $id;
                $my_task->start_time = date('Y-m-d H:i:s');
                $my_task->status = 0;
                $my_task->user_id = $model->active_user_id;
                $my_task->subject = $model->document;
                $my_task->save(false);
            } elseif ($next_user == 6) {

                $model->active_user_id = $model->dabiri_id;
                $model->status = 6;

                $user_p = User::find()->where(['lvl' => 6])->all();
                $array_list = array();
                foreach ($user_p as $a) {
                    $task = new Task;
                    $task->model_id = $model->id;
                    $task->user_id = $a->id;
                    $task->start_time = date('Y-m-d H:i:s');
                    $task->status = 0;
                    $task->subject = $model->document;
                    $task->save(false);
                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }
            }
            $model->save(false);

            //$ff = Task::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->One();
            // $ff->status = 1;
            // $ff->end_time = date('Y-m-d H:i:s');
            // $ff->save(false);


            $admsg->msg = $model->error;
            $admsg->date = date('Y-m-d H:i:s');
            $admsg->ad_id = $id;

            $admsg->user_id = Yii::$app->user->identity->id;

            $admsg->doc_cancel = "cancel_paziresh";
            if ($model->status == 2) {
                $admsg->doc_cancel = "cancel_kargozar";
            }
            $admsg->task_id = $taskrad->id;
            $model->save(false);
            $admsg->save(false);
            if ($model->error == null) {
                Yii::$app->session->setFlash('danger', 'دلیل رد آگهی را وارد نمایید' . $model->id);
                return $this->render('cancel', [
                            'model' => $model,
                ]);
            }
            $model->error = $_POST['Ad']['error'];

            $model->save(false);

            Yii::$app->session->setFlash('success', 'آگهی رد شد' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        }return $this->render('cancel', [
                    'model' => $model,
        ]);
    }

    public function actionCanceltarahi($id) {
        $uu = Yii::$app->user->identity->id;
        $design = new Design;
        $design = Design::find()->where(['ad_id' => $id])->one();
        $model = $this->findModel($id);
        if ($design->load(Yii::$app->request->post())) {
            $model->status = 5;
            $design->why_reject = $_POST['Design']['why_reject'];
            $design->date = date('Y-m-d H:i:s');
            $design->status = -1;
            $design->dabiri_id = $uu;
            $model->active_user_id = $model->tarahi_id;
            $model->save(false);
            $design->save(false);
            if ($design->why_reject == null) {
                Yii::$app->session->setFlash('danger', 'دلیل رد آگهی را وارد نمایید' . $model->id);

                return $this->render('canceltarahi', [
                            'model' => $model,
                            'design' => $design,
                ]);
            }
            $model->save(false);
            $design->save(false);
            Yii::$app->session->setFlash('success', 'آگهی رد شد' . $model->id);
        }return $this->render('canceltarahi', [
                    'model' => $model,
                    'design' => $design,
        ]);
    }

    public function actionCancelsarparast($id) {
        //$uu = Yii::$app->user->identity->id;


        $model = $this->findModel($id);

        $model->status = -5;
        $model->active_user_id = 0;
        $model->save(false);
        $ttt = Task::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->one();
        $ttt->status = 1;
        $ttt->save(false);
        if ($model->save() and $ttt->save()) {

            Yii::$app->session->setFlash('success', 'آگهی به طور کامل رد شد' . $model->id);

            return $this->redirect(['view', 'id' => $ad_id]);
        } else
            Yii::$app->session->setFlash('danger', 'مشکلی پیش آمد دوباره سعی کنید' . $model->id);
        return $this->redirect(['view', 'id' => $ad_id]);
    }

    public function actionDocument($id, $next_user, $acc_status) {


        $my_task = new Task;
        $next_user_id = $next_user;
        $taskdoc = Task ::find()->where(['model_id' => $id, 'status' => 1])->orderby(['id' => SORT_DESC])->One();
        $taskdoc1 = Task ::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->One();
        $model = $this->findModel($id);
        $admsg = new AdMsg;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->document == null) {
                Yii::$app->session->setFlash('danger', 'مدارک مورد نیاز را وارد نمایید' . $model->id);
                return $this->render('document', [
                            'model' => $model,
                ]);
            }

            $model->document = $_POST['Ad']['document'];

            $model->status = $acc_status;
            $next_user_id = $model->{Ad::ad_order[$next_user]};
            $model->active_user_id = $next_user_id;

//            echo $next_user_id;
//            exit();
            $model->save(false);

            if (Yii::$app->user->identity->lvl == 6) {
                $useee = User::find()->where(['lvl' => 6])->all();
                if ($useee) {
                    foreach ($useee as $u) {
                        $ff = Task::find()->where(['model_id' => $id, 'status' => 0, 'user_id' => $u->id])->One();
                        if ($ff) {
                            $ff->status = 1;
                            $ff->end_time = date('Y-m-d H:i:s');
                            $ff->save(false);
                        }
                    }
                }
                $ttas = new Task();
                $ttas->status = 0;
                $ttas->model_id = $id;
                $ttas->start_time = date('Y-m-d H:i:s');
                $ttas->user_id = $next_user_id;
                $ttas->save();
            }
            // if ($model->active_user_id == $model->resseler_id) {
            if ($next_user == 8 and $acc_status == 2) {
                $model->active_user_id = $model->resseler_id;
                $my_task->user_id = $model->active_user_id;
                $my_task->model = 'customer';
                $my_task->model_id = $id;
                $my_task->start_time = date('Y-m-d H:i:s');
                $my_task->status = 0;
                $my_task->subject = $model->document;

                $ff = Task::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->One();
                if ($ff) {
//                    $ff->status = 1;
//                    $ff->end_time = date('Y-m-d H:i:s');
//                    $ff->save(false);
                }
                $my_task->save(false);
                $model->save(false);
            }
            if ($next_user == 8 and $acc_status == 8) {
                $model->active_user_id = $model->resseler_id;
                $my_task->user_id = $model->active_user_id;
                $my_task->model = 'customer';
                $my_task->model_id = $id;
                $my_task->start_time = date('Y-m-d H:i:s');
                $my_task->status = 0;
                $my_task->subject = $model->document;

                $ff = Task::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->One();
                if ($ff) {
//                    $ff->status = 1;
//                    $ff->end_time = date('Y-m-d H:i:s');
//                    $ff->save(false);
                }
                $my_task->save(false);
                $model->save(false);
            }
            if ($next_user == 2 and $acc_status == 2) {
                $model->active_user_id = $model->paziresh_id;
                $my_task->user_id = $model->active_user_id;

                $my_task->model_id = $id;
                $my_task->start_time = date('Y-m-d H:i:s');
                $my_task->status = 0;
                $my_task->subject = $model->document;

                $ff = Task::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->One();
                if ($ff) {
                    $ff->status = 1;
                    $ff->end_time = date('Y-m-d H:i:s');
                    $ff->save(false);
                }
                $my_task->save(false);
                $model->save(false);
            }
            if ($next_user == 6 and $acc_status == 6) {
                $model->active_user_id = $model->dabiri_id;
                $model->status = 6;
                $ff = Task::find()->where(['model_id' => $id, 'status' => 0])->orderby(['id' => SORT_DESC])->One();
                if ($ff) {
                    $ff->status = 1;
                    $ff->end_time = date('Y-m-d H:i:s');
                    $ff->save(false);
                }

                $user_p = User::find()->where(['lvl' => 6])->all();
                $array_list = array();
                foreach ($user_p as $a) {
                    $task = new Task;
                    $task->model_id = $id;
                    $task->user_id = $a->id;
                    $task->start_time = date('Y-m-d H:i:s');
                    $task->status = 0;
                    $task->subject = $model->document;
                    $task->save(false);
                    $c = 0;
                    $c = Task::find()->where(['user_id' => $a->id])->count();
                    array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
                }




                $model->save(false);
            }
            $admsg->msg = $_POST['Ad']['document'];
            $admsg->user_id = Yii::$app->user->identity->id;
            $admsg->date = date('Y-m-d H:i:s');
            $admsg->ad_id = $id;
            $admsg->task_id = $taskdoc->id;

            $admsg->doc_cancel = "document";
            $admsg->save(false);

            //$taskdoc1->save(false);
            //$my_task->save(false);

            Yii::$app->session->setFlash('success', 'ثبت شد' . $model->id);
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('document', [
                    'model' => $model,
        ]);
    }

    public function actionPic($file) {

        return $this->render('pic', [
                    'model' => $model,
                    'file' => $file,
        ]);
    }

    public function actionEdit_ad($id) {
        $model = $this->findModel($id);

        return $this->render('edit_ad', [
                    'model' => $model,
                    'id' => $model->id
                        ]
        );
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


            $name = $_FILES["file"]["name"];
            $ext = end((explode(".", $name)));

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

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

//           


            if ($model->save()) {




                Yii::$app->session->setFlash('success', 'آگهی ویرایش شد' . $model->id);
//                exit();
            } else {
                //  print_r($model->rrors());
                return $this->render('update', [
                            'model' => $model,
                            'design' => $design,
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'design' => $design,
            ]);
        }
    }

    public function actionList4($q = null, $id = 1) {

        $q = str_replace(array('ي', 'ك'), array('ی', 'ک'), $q);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        // \common\models\Customer::check_new_city($q);
//echo $id."**************";

        if (!is_null($q)) {
            $query = new Query;
            if ($id == 1) {


                $query->select(['CONCAT(location.name) AS text', 'location.id',])
                        //->select(['cities.name AS text', 'cities.id',])
                        ->from('location')
                        ->andwhere(['like', 'location.name', $q]);
            } elseif ($id == 0) {


                $query
                        ->select(['CONCAT(location.name) AS text', 'location.id',])
                        //->select(['cities.name AS text', 'cities.id',])
                        ->from('location')
                        ->andWhere(['like', 'location.name', $q]);

                // ->orWhere(['is', 'owner_id', new \yii\db\Expression('null')])
                //->OrWhere(['owner_id' => 0])
            }


            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }

        return $out;
    }

    /**
     * Deletes an existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {


        $old = $this->findModel($id);

        $old_one = \common\models\Transition::find()->where(['ad_id' => $id, 'type' => [1, 2, 3]])->one();
        $user = User::findOne($old->resseler_id);
        if ($old_one) {

            \common\models\Transition::revert_nghadi_etebari_user($user, $old_one->amount, $old_one->type);
            $old_one->delete();
        }

        $user->wallet += $old->cash;
        $old->cash = 0;
        $old->pay_status = 0;

        $old->status = -10;
        $old->save(false);
        $user->save();

        //print_r($old->getErrors());
        //exit();
        //$old->delete();

        return $this->redirect(['index1']);
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

    public function actionSahm() {
        $shahrdari = 0;
        $dolati = 0;
        $nafti = 0;
        $payam = 0;
        $khososi = 0;
        $ret = array();
        $date = \common\models\Persian::get_from_beggining_year(1);
        //echo $date;
        $now_date = date('Y-m-d');
        $ad = Ad::find()->where(['between', 'date_publish', $date, $now_date])->all();
//        echo $ad->createCommand()->rawSql;
//        print_r($ad);
        foreach ($ad as $a) {
//            echo $a->in_amount;
            if ($a->ad_type == 7) {
                $shahrdari += $a->in_amount;
            } elseif ($a->ad_type == 1 or $a->ad_type == 11) {
                $dolati += $a->in_amount;
            } elseif ($a->ad_type == 2 or $a->ad_type == 13) {
                $nafti += $a->in_amount;
            } elseif ($a->resseler_id == 480) {
                $payam += $a->in_amount;
            } elseif ($a->ad_type == 10) {
                $khososi += $a->in_amount;
            }
        }
        $total = $khososi + $payam + $nafti + $dolati + $shahrdari;
//            array_push($ret, $shahrdari, $dolati, $nafti, $payam, $khososi);
//            print_r($ret);
//            echo $total;
        if ($total > 0) {
            $sh = ($shahrdari * 100) / $total;
            $sh = round($sh);
            array_push($ret, $sh);

            $do = ($dolati * 100) / $total;
            $do = round($do);
            array_push($ret, $do);

            $na = ($nafti * 100) / $total;
            $na = round($na);
            array_push($ret, $na);

            $pa = ($payam * 100) / $total;
            $pa = round($pa);
            array_push($ret, $pa);

            $kh = ($khososi * 100) / $total;
            $kh = round($kh);
            array_push($ret, $kh);
        }
        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionOnvan() {
        //return "*".$_POST['faktor'].$_POST['onvan'];
        //return $_POST['hoghoghi'];
        if ($_POST['faktor']) {
            $faktor = $_POST['faktor'];
        }
        if ($_POST['onvan']) {
            $onvan = $_POST['onvan'];
        }

        $ad_table = Ad::find()->where(['serial' => $faktor])->one();
        $ad_table->title = $onvan;
        $ad_table->save(false);
    }

    public function actionCustomer() {
        // return "*".$_POST['hoghoghi'].$_POST['customer_id'];
        //return $_POST['hoghoghi'];
        if ($_POST['last_date']) {
            $last_date = $_POST['last_date'];
            //$last_date=str_replace("/","-",(string)$last_date);
            $last_date = str_replace('98', '1398', $last_date);
            // $last_date= \common\models\Persian::convert_date_to_en(\common\models\Persian::persian_digit_replace($last_date),TRUE);
            //$last_date =\common\models\Persian::convert_date_to_en($last_date);
        }
        if ($_POST['moshtari_name']) {
            $moshtari_name = $_POST['moshtari_name'];
        }
        if ($_POST['kargozar_code']) {
            $kargozar_code = $_POST['kargozar_code'];
        }
        if ($_POST['moshtari_code']) {
            $moshtari_code = $_POST['moshtari_code'];
        }
        $customer_duration = \common\models\CustomerDuration::find()->where(['customer_id' => $moshtari_code])->one();
        if (!$customer_duration) {
            $customer_d = new \common\models\CustomerDuration();
            $customer_d->name_customer = $moshtari_name;
            $customer_d->date = \common\models\Persian::convert_date_to_en(\common\models\Persian::persian_digit_replace($last_date), TRUE);
            $customer_d->customer_id = $moshtari_code;
            $customer_d->kargozar_id = $kargozar_code;
            $customer_d->save(false);
            if ($customer_d->save()) {
                echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@saved@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@";
            } else {
                echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@nope@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@";
            }
        }
    }

    public function actionSavetakhfif() {

        if ($_POST['customer_name']) {
            $customer_name = $_POST['customer_name'];
        }
        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
        }

        if ($_POST['fasli']) {
            $fasli = $_POST['fasli'];
        }

        if ($_POST['group']) {
            $group = $_POST['group'];
        }
        if ($_POST['gardeshgari']) {
            $gardeshgari = $_POST['gardeshgari'];
        }
        if ($_POST['mostamar_1']) {
            $mostamar_1 = $_POST['mostamar_1'];
        }
        if ($_POST['mostamar_2']) {
            $mostamar_2 = $_POST['mostamar_2'];
        }

        if ($_POST['mostamar_3']) {
            $mostamar_3 = $_POST['mostamar_3'];
        }

        if ($_POST['mostamar_4']) {
            $mostamar_4 = $_POST['mostamar_4'];
        }
        if ($_POST['after_1']) {
            $after_1 = $_POST['after_1'];
        }
        if ($_POST['after_3']) {
            $after_3 = $_POST['after_3'];
        }
        if ($_POST['after_5']) {
            $after_5 = $_POST['after_5'];
        }

        if ($_POST['farhangi']) {
            $farhangi = $_POST['farhangi'];
        }

        if ($_POST['khareji']) {
            $khareji = $_POST['khareji'];
        }
        if ($_POST['danesh']) {
            $danesh = $_POST['danesh'];
        }
        if ($_POST['hand']) {
            $hand = $_POST['hand'];
        }
        if ($_POST['t']) {
            $t = $_POST['t'];
        }

        if ($_POST['khareji_100']) {
            $khareji_100 = $_POST['khareji_100'];
        }

        if ($_POST['nafti']) {
            $nafti = $_POST['nafti'];
        }
        if ($_POST['dolati']) {
            $dolati = $_POST['dolati'];
        }
        if ($_POST['sabti']) {
            $sabti = $_POST['sabti'];
        }

        if ($_POST['takh_vije']) {
            $takh_vije = $_POST['takh_vije'];
        }

        if ($_POST['gardeshgari_2']) {
            $gardeshgari_2 = $_POST['gardeshgari_2'];
        }
        $arr = array();
        array_push($arr, $fasli, $group, $gardeshgari, $mostamar_1, $mostamar_2, $mostamar_3, $mostamar_4, $after_1, $after_3, $after_5, $farhangi, $khareji, $danesh, $hand, $khareji_100, $t, $nafti, $dolati, $sabti, $takh_vije, $gardeshgari_2);

        if ($customer_id) {
            $customer_table = Customer::find()->where(['id' => $customer_id])->one();
            if ($customer_table) {
                $customer_table->takhfifat = json_encode($arr);
                $customer_table->save(false);
                echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@" . "saved" . "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@";
            } else {
                echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@" . "customaer not found" . "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@";
            }
        }
    }

    public function actionYeki() {
        // return "*".$_POST['hoghoghi'].$_POST['customer_id'];
        //return $_POST['hoghoghi'];
        $yeki = array();
        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
            if (strpos($customer_id, '-') !== false) {
                $yeki = (explode("-", $customer_id));
                $customer_id = $yeki[0];
                for ($i = 1; $i <= count($yeki) - 1; $i++) {
                    \Yii::$app
                            ->db
                            ->createCommand()
                            ->delete('customer', ['id' => $yeki[$i]])
                            ->execute();

                    $ad = Ad::find()->where(['customer_id' => $yeki[$i]])->all();
                    if ($ad) {
                        foreach ($ad as $a) {
                            $a->customer_id = $yeki[0];
                            $a->save(false);
                        }
                    }
                }
            }
        }
    }

    public function actionHaghighi() {
        // return "*".$_POST['hoghoghi'].$_POST['customer_id'];
        //return $_POST['hoghoghi'];
        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
        }
        if ($_POST['hoghoghi']) {
            $hoghoghi = $_POST['hoghoghi'];
            $hoghoghi = str_replace('ي', 'ی', $hoghoghi);
        }
        if ($customer_id != null) {
            if (strpos($customer_id, "-")) {
                $y = array();
                $y = (explode("-", $customer_id));
                $customer_id = $y[0];
            }
            $customer_table = Customer::find()->where(['id' => $customer_id])->one();
            $customer_table->type_h = $hoghoghi;
            $customer_table->save(false);
        }
    }

    public function actionSavecustomer() {
        // return "****shomareee faktoooor: ".$_POST['name_saheb_agahi'];

        if ($_POST['name_saheb_agahi']) {
            $name_saheb_agahi = $_POST['name_saheb_agahi'];
        }
        $c_t = Customer::find()->where(['name' => $name_saheb_agahi])->one();
        if (!$c_t) {
            //  array_push($name,$name_saheb_agahi);
            if ($_POST['hoghoghi']) {
                $hoghoghi = $_POST['hoghoghi'];
                $hoghoghi = str_replace('ي', 'ی', $hoghoghi);
            }

            if ($_POST['ostan']) {
                $ostan = $_POST['ostan'];
                $ostan = str_replace('ي', 'ی', $ostan);
                $ostan = str_replace('ك', 'ک', $ostan);
                $ostan = trim(preg_replace('/\s+/', ' ', $ostan));
            }
            if ($_POST['shahrestan']) {
                $shahrestan = $_POST['shahrestan'];
                $shahrestan = str_replace('ي', 'ی', $shahrestan);
                $shahrestan = str_replace('ك', 'ک', $shahrestan);
                $shahrestan = trim(preg_replace('/\s+/', ' ', $shahrestan));
            }
            if ($_POST['shahr']) {
                $shahr = $_POST['shahr'];
                $shahr = str_replace('ي', 'ی', $shahr);
                $shahr = str_replace('ك', 'ک', $shahr);
                $shahr = trim(preg_replace('/\s+/', ' ', $shahr));
            }
            $province_table = \common\models\Province::find()->where(['name' => $ostan])->one();
            if ($province_table) {
                //$customer_table->province = $province_table->id;
                $ostan_final = $province_table->id;
            } else {

                if ($ostan != null) {
                    $province_table_new = new \common\models\Province();
                    $province_table_new->name = $ostan;
                    //$province_table_new+=1;
                    //$customer_table->province = $province_table_new->id;
                    $province_table_new->save(false);
                    $ostan_final = $province_table_new->id;
                }
            }

            $city_table = \common\models\City::find()->where(['name' => $shahr])->one();
            if ($city_table) {
                //$customer_table->city = $city_table->id;
                $shahr_final = $city_table->id;
            } else {
                if ($shahr != null) {
                    $city_table_new = new \common\models\City();
                    $city_table_new->name = $shahr;
                    // $customer_table->city = $city_table_new->id;
                    $city_table_new->save(false);
                    $shahr_final = $city_table_new->id;
                }
            }
            echo "<br>city result" . $city_table->id;
            echo "<br>citytablenew******************************:" . $city_table_new->name . "<br>";
            echo $customer_table->city . "<br>";
            echo "city excel" . $shahr;

            if ($_POST['sh_eghtesadi']) {
                $sh_eghtesadi = $_POST['sh_eghtesadi'];
            }
            if ($_POST['sh_melli']) {
                $sh_melli = $_POST['sh_melli'];
            }

            if ($_POST['code_posti']) {
                $code_posti = $_POST['code_posti'];
            }

            if ($_POST['neshani']) {
                $neshani = $_POST['neshani'];
            }
            if ($_POST['tell']) {
                $tell = $_POST['tell'];
            }

            if ($_POST['customer_type']) {
                $customer_type = $_POST['customer_type'];
                if ($customer_type == 'ك') {
                    $customer_type = 1;
                } elseif ($customer_type == 'پ') {
                    $customer_type = 2;
                } elseif ($customer_type == 'م') {
                    $customer_type = 3;
                } elseif ($customer_type == 'ش') {
                    $customer_type = 4;
                } elseif ($customer_type == 'د') {
                    $customer_type = 5;
                } elseif ($customer_type == 'ر') {
                    $customer_type = 6;
                }
            }
            if ($_POST['code_kargozar']) {
                $code_kargozar = $_POST['code_kargozar'];
                $user_tt = User::find()->where(['username' => $code_kargozar])->one();
                if ($user_tt) {
                    $code_kargozar = $user_tt->id;
                }
            }
            $cust_table = new Customer();
            $cust_table->name = $name_saheb_agahi;
            $cust_table->owner_id = $code_kargozar;
            $cust_table->type = $customer_type;
            $cust_table->type_h = $hoghoghi;
            $cust_table->postal_code = $code_posti;
            $cust_table->social_code = $sh_melli;
            $cust_table->economical_code = $sh_eghtesadi;
            $cust_table->phone = $tell;
            $cust_table->addres = $neshani;
            $cust_table->city = $shahr_final;
            $cust_table->province = $ostan_final;
            $cust_table->save(false);
        }
    }

    public function actionSaveexcel4() {
        if ($_POST['sh_faktor']) {
            $sh_faktor = $_POST['sh_faktor'];
        }
        if ($_POST['code_kargozar']) {
            $code_kargozar = $_POST['code_kargozar'];
        }
        /* if ($code_kargozar == 500) {
          $find = Ad::find()->where(['serial' => $sh_faktor])->one();
          // $find->resseler_id = 561;
          if ($find->save(false))
          echo "saved";
          } */
    }

    public function actionSaveexcel3() {
//return "*".$_POST['hoghoghi'];
        // return $_POST['customer_id'];


        $new_discount = new \common\models\AdHasDiscount();

        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
        }
        if ($_POST['hoghoghi']) {
            $hoghoghi = $_POST['hoghoghi'];
            $hoghoghi = str_replace('ي', 'ی', $hoghoghi);
        }
        ////////shahr ina




        if ($_POST['ostan']) {
            $ostan = $_POST['ostan'];
            $ostan = str_replace('ي', 'ی', $ostan);
            $ostan = str_replace('ك', 'ک', $ostan);
            $ostan = trim(preg_replace('/\s+/', ' ', $ostan));
        }
        if ($_POST['shahrestan']) {
            $shahrestan = $_POST['shahrestan'];
            $shahrestan = str_replace('ي', 'ی', $shahrestan);
            $shahrestan = str_replace('ك', 'ک', $shahrestan);
            $shahrestan = trim(preg_replace('/\s+/', ' ', $shahrestan));
        }
        if ($_POST['shahr']) {
            $shahr = $_POST['shahr'];
            $shahr = str_replace('ي', 'ی', $shahr);
            $shahr = str_replace('ك', 'ک', $shahr);
            $shahr = trim(preg_replace('/\s+/', ' ', $shahr));
        }
        $province_table = \common\models\Province::find()->where(['name' => $ostan])->one();
        if ($province_table) {
            //$customer_table->province = $province_table->id;
            $ostan_final = $province_table->id;
        } else {

            if ($ostan != null) {
                $province_table_new = new \common\models\Province();
                $province_table_new->name = $ostan;
                //$province_table_new+=1;
                //$customer_table->province = $province_table_new->id;
                $province_table_new->save(false);
                $ostan_final = $province_table_new->id;
            }
        }

        $city_table = \common\models\City::find()->where(['name' => $shahr])->one();
        if ($city_table) {
            //$customer_table->city = $city_table->id;
            $shahr_final = $city_table->id;
        } else {
            if ($shahr != null) {
                $city_table_new = new \common\models\City();
                $city_table_new->name = $shahr;
                // $customer_table->city = $city_table_new->id;
                $city_table_new->save(false);
                $shahr_final = $city_table_new->id;
            }
        }
        echo "<br>city result" . $city_table->id;
        echo "<br>citytablenew******************************:" . $city_table_new->name . "<br>";
        echo $customer_table->city . "<br>";
        echo "city excel" . $shahr;

        ////customer

        if ($_POST['name_saheb_agahi']) {
            $name_saheb_agahi = $_POST['name_saheb_agahi'];
        }

        if ($_POST['sh_eghtesadi']) {
            $sh_eghtesadi = $_POST['sh_eghtesadi'];
        }
        if ($_POST['sh_melli']) {
            $sh_melli = $_POST['sh_melli'];
        }

        if ($_POST['code_posti']) {
            $code_posti = $_POST['code_posti'];
        }

        if ($_POST['neshani']) {
            $neshani = $_POST['neshani'];
        }
        if ($_POST['tell']) {
            $tell = $_POST['tell'];
        }
////user


        if ($_POST['sh_faktor']) {
            $sh_faktor = $_POST['sh_faktor'];
        }
        if ($_POST['tarikh_faktor']) {
            $tarikh_faktor = $_POST['tarikh_faktor'];
        }
        if ($_POST['code_kargozar']) {
            $code_kargozar = $_POST['code_kargozar'];
        }

        if ($_POST['page']) {
            $page = $_POST['page'];
        }
        if ($_POST['nobat']) {
            $nobat = $_POST['nobat'];
        }
        if ($_POST['date_publish']) {
            $date_publish = $_POST['date_publish'];
        }
        if ($_POST['sharh_kala']) {
            $sharh_kala = $_POST['sharh_kala'];
        }
/////////////////////////////////////

        if ($_POST['customer_type']) {
            $customer_type = $_POST['customer_type'];
            if ($customer_type == 'ك') {
                $customer_type = 1;
            } elseif ($customer_type == 'پ') {
                $customer_type = 2;
            } elseif ($customer_type == 'م') {
                $customer_type = 3;
            } elseif ($customer_type == 'ش') {
                $customer_type = 4;
            } elseif ($customer_type == 'د') {
                $customer_type = 5;
            } elseif ($customer_type == 'ر') {
                $customer_type = 6;
            }
        }
//        $yeki = array();
        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
        }



        if ($customer_id == null) {
            $cus = \common\models\Customer::find()->where(['name' => $name_saheb_agahi])->one();
            if ($cus) {
                $custom_id = $cus->id;
                $cus->type = $customer_type;
                $cus->type_h = $hoghoghi;
                $cus->economical_code = $sh_eghtesadi;
                $cus->owner_id = $code_kargozar;
                $cus->social_code = $sh_melli;
                $cus->postal_code = $code_posti;
                $cus->addres = $neshani;
                $cus->phone = $tell;
                $cus->city = $shahr_final;
                $cus->province = $ostan_final;
                $cus->save(false);
            } elseif (!$cus) {

                $customer_table_new = new Customer();
                $customer_table_new->type = $customer_type;

                $customer_table_new->name = $name_saheb_agahi;
                $customer_table_new->economical_code = $sh_eghtesadi;
                $customer_table_new->owner_id = $code_kargozar;
                $customer_table_new->social_code = $sh_melli;
                $customer_table_new->postal_code = $code_posti;
                $customer_table_new->addres = $neshani;
                $customer_table_new->phone = $tell;
                $customer_table_new->city = $shahr_final;
                $customer_table_new->province = $ostan_final;
                $customer_table_new->type_h = $hoghoghi;
                $customer_table_new->save(false);
                //$new_ad->customer_id = $customer_table_new->id;
                $custom_id = $customer_table_new->id;
            }
        }
        //$stt=(string)$customer_id;


        if ($_POST['sharh_karmozd']) {
            $sharh_karmozd = $_POST['sharh_karmozd'];
            $sharh_karmozd = str_replace('كارمزد', '', $sharh_karmozd);
            $sharh_karmozd = str_replace('%', '', $sharh_karmozd);
            $sharh_karmozd = trim(preg_replace('/\s+/', ' ', $sharh_karmozd));
        }
        if ($_POST['total_price']) {
            $total_price = $_POST['total_price'];
        }
        if ($_POST['mablaghe_takhfif_1']) {
            $mablaghe_takhfif_1 = $_POST['mablaghe_takhfif_1'];
        }
        if ($_POST['mablaghe_takhfif_2']) {
            $mablaghe_takhfif_1 += $_POST['mablaghe_takhfif_2'];
        }
        if ($_POST['mablaghe_takhfif_3']) {
            $mablaghe_takhfif_1 += $_POST['mablaghe_takhfif_3'];
        }
        if ($_POST['mablaghe_takhfif_4']) {
            $mablaghe_takhfif_1 += $_POST['mablaghe_takhfif_4'];
        }
        if ($_POST['after_discount']) {
            $after_discount = $_POST['after_discount'];
        }
        if ($_POST['benefit_price']) {
            $benefit_price = $_POST['benefit_price'];
        }
        if ($_POST['in_amount']) {
            $in_amount = $_POST['in_amount'];
        }

        if ($_POST['page']) {
            $page = $_POST['page'];
            $page = str_replace('ي', 'ی', $page);
            $page = str_replace(' (11) ', '', $page);
            $page = str_replace('(11)', '', $page);
            $page = str_replace('(15)', '', $page);
            $page = str_replace(' (15) ', '', $page);
            $page = str_replace('( 7 )', '', $page);
            $page = str_replace(' ( 7 ) ', '', $page);
            $page = str_replace('( 12 )', '', $page);
            $page = str_replace(' ( 12 ) ', '', $page);
            $page = str_replace('( 13 )', '', $page);
            $page = str_replace(' ( 13 ) ', '', $page);
            $page = str_replace('(13)', '', $page);
            $page = str_replace(' (13) ', '', $page);
            $page = str_replace('(8 )', '', $page);
            $page = str_replace(' (8 ) ', '', $page);
            $page = str_replace('(8)', '', $page);
            $page = str_replace(' (8) ', '', $page);
            $page = str_replace('( 9 )', '', $page);
            $page = str_replace(' ( 9 ) ', '', $page);
            $page = str_replace('(10 )', '', $page);
            $page = str_replace(' (10 ) ', '', $page);
            $page = str_replace('(19 )', '', $page);
            $page = str_replace(' (19 ) ', '', $page);
            $page = str_replace('(19)', '', $page);
            $page = str_replace(' (19) ', '', $page);
            $page = str_replace('(10)', '', $page);
            $page = str_replace(' (10) ', '', $page);
            $page = str_replace('(11 )', '', $page);
            $page = str_replace(' (11 ) ', '', $page);
            $page = str_replace('(11)', '', $page);
            $page = str_replace(' (11) ', '', $page);
            $page = str_replace('(7)', '', $page);
            $page = str_replace('(7) ', '', $page);
            $page = str_replace(' (7)', '', $page);
            $page = str_replace(' (7) ', '', $page);
            $page = str_replace('(13.14.15)', '', $page);
            $page = str_replace(' (13.14.15) ', '', $page);
            $page = str_replace('(8) ', '', $page);
            $page = str_replace(' (8)', '', $page);

            $page = trim(preg_replace('/\s+/', ' ', $page));

            $page = ltrim($page);
            echo "********************************************:page: " . $page;
        }

        $box_table = \common\models\Box::find()->where(['name' => $page])->one();
        echo "table box******************************************:" . $box_table->id;
//        if ($box_table and !$add) {
//            
//        } elseif ($box_table and $add) {
//           
//        }


        $add = Ad::find()->where(['serial' => $sh_faktor])->one();
        if (!$add) {
            // return $_POST['page'];
            $new_ad = new Ad();
            $new_ad->box_id = $box_table->id;
            $new_ad->serial = $sh_faktor;
            $new_ad->date = \common\models\Persian::convert_date_to_en($tarikh_faktor);
            $new_ad->resseler_id = $code_kargozar;
            //$new_ad->box_id = $page;
            $new_ad->pub_qty = $nobat;
            $new_ad->date_publish = \common\models\Persian::convert_date_to_en($date_publish);
            $new_ad->title = $sharh_kala;
            $new_ad->benefit_rate = $sharh_karmozd;
            $new_ad->total_price = $total_price;
            $new_ad->discount_price = $mablaghe_takhfif_1;
            $new_ad->price_after_discount = $after_discount;
            $new_ad->benefit_price = $benefit_price;
            $new_ad->in_amount = $in_amount;
            $new_ad->customer_id = $custom_id;
            $new_ad->pub_qty = 1;
//            if ($customer_id == null)
//                $new_ad->customer_id = $custom_id;
//            else {
//                $new_ad->customer_id = $customer_id;
//            }
            $new_ad->save(false);
            //$customer_table->save(false);
        } else {
            $add->serial = $sh_faktor;
            $add->date = \common\models\Persian::convert_date_to_en($tarikh_faktor);
            $add->resseler_id = $code_kargozar;
            //$new_ad->box_id = $page;
            $add->pub_qty = $nobat;
            $add->date_publish = \common\models\Persian::convert_date_to_en($date_publish);
            $add->title = $sharh_kala;
            $add->benefit_rate = $sharh_karmozd;
            $add->total_price = $total_price;
            $add->discount_price = $mablaghe_takhfif_1;
            $add->price_after_discount = $after_discount;
            $add->benefit_price = $benefit_price;
            $add->in_amount = $in_amount;
            $add->customer_id = $custom_id;
            $add->box_id = $box_table->id;
            $add->pub_qty = 1;
//            if ($customer_id == null)
//                $add->customer_id = $custom_id;
//            else {
//                $add->customer_id = $customer_id;
//            }
            $add->save(false);
        }
        if ($_POST['sharh_takhfife_1']) {
            $sharh_takhfife_1 = $_POST['sharh_takhfife_1'];
            $sharh_takhfife_1 = str_replace('ي', 'ی', $sharh_takhfife_1);
            $sharh_takhfife_1 = str_replace('تخفیف ', '', $sharh_takhfife_1);
            $sharh_takhfife_1 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_1));
        }
        if ($_POST['sharh_takhfife_2']) {
            $sharh_takhfife_2 = $_POST['sharh_takhfife_2'];
            $sharh_takhfife_2 = str_replace('ي', 'ی', $sharh_takhfife_2);
            $sharh_takhfife_2 = str_replace('تخفیف ', '', $sharh_takhfife_2);
            $sharh_takhfife_2 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_2));
        }
        if ($_POST['sharh_takhfife_3']) {
            $sharh_takhfife_3 = $_POST['sharh_takhfife_3'];
            $sharh_takhfife_3 = str_replace('ي', 'ی', $sharh_takhfife_3);
            $sharh_takhfife_3 = str_replace('تخفیف ', '', $sharh_takhfife_3);

            $sharh_takhfife_3 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_3));
        }
        if ($_POST['sharh_takhfife_4']) {
            $sharh_takhfife_4 = $_POST['sharh_takhfife_4'];
            $sharh_takhfife_4 = str_replace('ي', 'ی', $sharh_takhfife_4);
            $sharh_takhfife_4 = str_replace('تخفیف ', '', $sharh_takhfife_4);
            $sharh_takhfife_4 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_4));
        }
        $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_1])->one();
        if ($dicount_item_table) {
            $ad_has_d = new \common\models\AdHasDiscount();
            if (!$idd) {
                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;
            } else {
                $ad_has_d->ad_id = $idd->id;
                $ad_has_d->discount_price = $idd->discount_price;
            }

            $ad_has_d->discount_id = $dicount_item_table->id;
            $ad_has_d->inc_rate = $dicount_item_table->discount;

            $ad_has_d->save(false);
        }
        $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_2])->one();
        if ($dicount_item_table) {
            $ad_has_d = new \common\models\AdHasDiscount();
            if (!$idd) {
                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;
            } else {
                $ad_has_d->ad_id = $idd->id;
                $ad_has_d->discount_price = $idd->discount_price;
            }
            $ad_has_d->discount_id = $dicount_item_table->id;
            $ad_has_d->inc_rate = $dicount_item_table->discount;

            $ad_has_d->save(false);
        }
        $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_3])->one();
        if ($dicount_item_table) {
            $ad_has_d = new \common\models\AdHasDiscount();
            if (!$idd) {
                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;
            } else {
                $ad_has_d->ad_id = $idd->id;
                $ad_has_d->discount_price = $idd->discount_price;
            }
            $ad_has_d->discount_id = $dicount_item_table->id;
            $ad_has_d->inc_rate = $dicount_item_table->discount;

            $ad_has_d->save(false);
        }
        $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_4])->one();
        if ($dicount_item_table) {
            $ad_has_d = new \common\models\AdHasDiscount();
            if (!$idd) {
                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;
            } else {
                $ad_has_d->ad_id = $idd->id;
                $ad_has_d->discount_price = $idd->discount_price;
            }
            $ad_has_d->discount_id = $dicount_item_table->id;
            $ad_has_d->inc_rate = $dicount_item_table->discount;

            $ad_has_d->save(false);
        }






        if ($_POST['name_kargozar']) {
            $name_kargozar = $_POST['name_kargozar'];
        }
        $user_table = User::find()->where(['username' => $code_kargozar])->one();
        if ($user_table) {
            $user_table->name_and_fam = $name_kargozar;
            $user_table->save(false);
        }
    }

    public function actionSaveexcel2() {

        //  return "shomaaaaaaaaaaaaareeeee: ".$_POST;


        $new_discount = new \common\models\AdHasDiscount();

        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
        }
        if ($_POST['hoghoghi']) {
            $hoghoghi = $_POST['hoghoghi'];
            $hoghoghi = str_replace('ي', 'ی', $hoghoghi);
        }





        if ($_POST['ostan']) {
            $ostan = $_POST['ostan'];
            $ostan = str_replace('ي', 'ی', $ostan);
            $ostan = str_replace('ك', 'ک', $ostan);
            $ostan = trim(preg_replace('/\s+/', ' ', $ostan));
        }
        if ($_POST['shahrestan']) {
            $shahrestan = $_POST['shahrestan'];
            $shahrestan = str_replace('ي', 'ی', $shahrestan);
            $shahrestan = str_replace('ك', 'ک', $shahrestan);
            $shahrestan = trim(preg_replace('/\s+/', ' ', $shahrestan));
        }
        if ($_POST['shahr']) {
            $shahr = $_POST['shahr'];
            $shahr = str_replace('ي', 'ی', $shahr);
            $shahr = str_replace('ك', 'ک', $shahr);
            $shahr = trim(preg_replace('/\s+/', ' ', $shahr));
        }
        $province_table = \common\models\Province::find()->where(['name' => $ostan])->one();
        if ($province_table) {
            //$customer_table->province = $province_table->id;
            $ostan_final = $province_table->id;
        } else {

            if ($ostan != null) {
                $province_table_new = new \common\models\Province();
                $province_table_new->name = $ostan;
                //$province_table_new+=1;
                //$customer_table->province = $province_table_new->id;
                $province_table_new->save(false);
                $ostan_final = $province_table_new->id;
            }
        }

        $city_table = \common\models\City::find()->where(['name' => $shahr])->one();
        if ($city_table) {
            //$customer_table->city = $city_table->id;
            $shahr_final = $city_table->id;
        } else {
            if ($shahr != null) {
                $city_table_new = new \common\models\City();
                $city_table_new->name = $shahr;
                // $customer_table->city = $city_table_new->id;
                $city_table_new->save(false);
                $shahr_final = $city_table_new->id;
            }
        }
        echo "<br>city result" . $city_table->id;
        echo "<br>citytablenew******************************:" . $city_table_new->name . "<br>";
        echo $customer_table->city . "<br>";
        echo "city excel" . $shahr;

        ////customer

        if ($_POST['name_saheb_agahi']) {
            $name_saheb_agahi = $_POST['name_saheb_agahi'];
        }

        if ($_POST['sh_eghtesadi']) {
            $sh_eghtesadi = $_POST['sh_eghtesadi'];
        }
        if ($_POST['sh_melli']) {
            $sh_melli = $_POST['sh_melli'];
        }

        if ($_POST['code_posti']) {
            $code_posti = $_POST['code_posti'];
        }

        if ($_POST['neshani']) {
            $neshani = $_POST['neshani'];
        }
        if ($_POST['tell']) {
            $tell = $_POST['tell'];
        }
////user


        if ($_POST['sh_faktor']) {
            $sh_faktor = $_POST['sh_faktor'];
        }
        if ($_POST['tarikh_faktor']) {
            $tarikh_faktor = $_POST['tarikh_faktor'];
            $tarikh_faktor = str_replace('98', '1398', $tarikh_faktor);
        }
        if ($_POST['code_kargozar']) {
            $code_kargozar = $_POST['code_kargozar'];
            $user_tt = User::find()->where(['username' => $code_kargozar])->one();
            if ($user_tt) {
                $code_kargozar = $user_tt->id;
            }
        }

        if ($_POST['page']) {
            $page = $_POST['page'];
        }
        if ($_POST['nobat']) {
            $nobat = $_POST['nobat'];
        }
        if ($_POST['date_publish']) {
            $date_publish = $_POST['date_publish'];
            $date_publish = str_replace('98', '1398', $date_publish);
        }
        if ($_POST['sharh_kala']) {
            $sharh_kala = $_POST['sharh_kala'];
        }
/////////////////////////////////////

        if ($_POST['customer_type']) {
            $customer_type = $_POST['customer_type'];
            if ($customer_type == 'ك') {
                $customer_type = 1;
            } elseif ($customer_type == 'پ') {
                $customer_type = 2;
            } elseif ($customer_type == 'م') {
                $customer_type = 3;
            } elseif ($customer_type == 'ش') {
                $customer_type = 4;
            } elseif ($customer_type == 'د') {
                $customer_type = 5;
            } elseif ($customer_type == 'ر') {
                $customer_type = 6;
            }
        }

        echo "customer_id" . $_POST['customer_id'];
        //  $yeki = array();
        if ($_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
//            if (strpos($customer_id, '-') !== false) {
//                $yeki = (explode("-", $customer_id));
//                $customer_id = $yeki[0];
//                for ($i = 1; $i <= count($yeki) - 1; $i++) {
//                    \Yii::$app
//                            ->db
//                            ->createCommand()
//                            ->delete('customer', ['id' => $yeki[$i]])
//                            ->execute();
//
//                    $ad = Ad::find()->where(['customer_id' => $yeki[$i]])->all();
//                    if ($ad) {
//                        foreach ($ad as $a) {
//                            $a->customer_id = $yeki[0];
//                            $a->save(false);
//                        }
//                    }
//                }
//                $cuu = Customer::find()->where(['id' => $yeki[0]])->one();
//                if ($cuu) {
//                    $cuu->type = $customer_type;
//                    $cuu->type_h = $hoghoghi;
//                    $cuu->name = $name_saheb_agahi;
//                    $cuu->economical_code = $sh_eghtesadi;
//                    $cuu->owner_id = $code_kargozar;
//                    $cuu->social_code = $sh_melli;
//                    $cuu->postal_code = $code_posti;
//                    $cuu->addres = $neshani;
//                    $cuu->phone = $tell;
//                    $cuu->city = $shahr_final;
//                    $cuu->province = $ostan_final;
//
//                    $cuu->save(false);
//                }
//            }
//            if ($customer_id == null) {
//                $customer_table_new = new Customer();
//                $customer_table_new->type = $customer_type;
//                $customer_table_new->type_h = $hoghoghi;
//                $customer_table_new->name = $name_saheb_agahi;
//                $customer_table_new->economical_code = $sh_eghtesadi;
//                $customer_table_new->owner_id = $code_kargozar;
//                $customer_table_new->social_code = $sh_melli;
//                $customer_table_new->postal_code = $code_posti;
//                $customer_table_new->addres = $neshani;
//                $customer_table_new->phone = $tell;
//                $customer_table_new->city = $shahr_final;
//                $customer_table_new->province = $ostan_final;
//                $customer_table_new->type_h = $hoghoghi;
//                $customer_table_new->save(false);
//                //$new_ad->customer_id = $customer_table_new->id;
//                $custom_id = $customer_table_new->id;
//            } elseif ($customer_id == null and $name_saheb_agahi != null) {
//                $c_table = Customer::find()->where(['name' => $name_saheb_agahi])->one();
//                if ($c_table) {
//                    $c_table->type = $customer_type;
//                    $c_table->name = $name_saheb_agahi;
//                    $c_table->type_h = $hoghoghi;
//                    $c_table->economical_code = $sh_eghtesadi;
//                    $c_table->owner_id = $code_kargozar;
//                    $c_table->social_code = $sh_melli;
//                    $c_table->postal_code = $code_posti;
//                    $c_table->addres = $neshani;
//                    $c_table->phone = $tell;
//                    $c_table->city = $shahr_final;
//                    $c_table->province = $ostan_final;
//                    $c_table->type_h = $hoghoghi;
//                    $c_table->save(false);
//                } else {
//                    $c_table1 = new Customer();
//                    $c_table1->type = $customer_type;
//                    $c_table1->name = $name_saheb_agahi;
//                    $c_table1->type_h = $hoghoghi;
//                    $c_table1->economical_code = $sh_eghtesadi;
//                    $c_table1->owner_id = $code_kargozar;
//                    $c_table1->social_code = $sh_melli;
//                    $c_table1->postal_code = $code_posti;
//                    $c_table1->addres = $neshani;
//                    $c_table1->phone = $tell;
//                    $c_table1->city = $shahr_final;
//                    $c_table1->province = $ostan_final;
//                    $c_table1->type_h = $hoghoghi;
//                    $c_table1->save(false);
//                }
//                //$stt=(string)$customer_id;
//            }

            echo "x1";
            if ($customer_id) {

                $customer_table = Customer::find()->where(['id' => $customer_id])->one();
                if ($customer_table) {
                    $customer_table->name = $name_saheb_agahi;
                    $customer_table->type_h = $hoghoghi;
                    $customer_table->economical_code = $sh_eghtesadi;
                    $customer_table->social_code = $sh_melli;
                    $customer_table->owner_id = $code_kargozar;
                    $customer_table->postal_code = $code_posti;
                    $customer_table->addres = $neshani;
                    $customer_table->phone = $tell;
                    $customer_table->type = $customer_type;
                    $customer_table->city = $shahr_final;
                    $customer_table->province = $ostan_final;
                    $custom_id = $customer_table->id;
                }
                //   $customer_table->save(false);
            }


            if ($_POST['sharh_karmozd']) {
                $sharh_karmozd = $_POST['sharh_karmozd'];
                $sharh_karmozd = str_replace('كارمزد', '', $sharh_karmozd);
                $sharh_karmozd = str_replace('%', '', $sharh_karmozd);
                $sharh_karmozd = trim(preg_replace('/\s+/', ' ', $sharh_karmozd));
            }
            if ($_POST['total_price']) {
                $total_price = $_POST['total_price'];
            }
            if ($_POST['mablaghe_takhfif_1']) {
                $mablaghe_takhfif_1 = $_POST['mablaghe_takhfif_1'];
            }
            if ($_POST['mablaghe_takhfif_2']) {
                $mablaghe_takhfif_1 += $_POST['mablaghe_takhfif_2'];
            }
            if ($_POST['mablaghe_takhfif_3']) {
                $mablaghe_takhfif_1 += $_POST['mablaghe_takhfif_3'];
            }
            if ($_POST['mablaghe_takhfif_4']) {
                $mablaghe_takhfif_1 += $_POST['mablaghe_takhfif_4'];
            }
            if ($_POST['after_discount']) {
                $after_discount = $_POST['after_discount'];
            }
            if ($_POST['benefit_price']) {
                $benefit_price = $_POST['benefit_price'];
            }
            if ($_POST['in_amount']) {
                $in_amount = $_POST['in_amount'];
            }

            if ($_POST['page']) {
                $page = $_POST['page'];
                $page = str_replace('ي', 'ی', $page);
                $page = str_replace('صفحه', '', $page);
                $page = str_replace('صفحه ', '', $page);

                $page = str_replace(' (11) ', '', $page);
                $page = str_replace('(11)', '', $page);
                $page = str_replace('(15)', '', $page);
                $page = str_replace(' (15) ', '', $page);
                $page = str_replace('( 7 )', '', $page);
                $page = str_replace(' ( 7 ) ', '', $page);
                $page = str_replace('( 12 )', '', $page);
                $page = str_replace(' ( 12 ) ', '', $page);
                $page = str_replace('( 13 )', '', $page);
                $page = str_replace(' ( 13 ) ', '', $page);
                $page = str_replace('(13)', '', $page);
                $page = str_replace(' (13) ', '', $page);
                $page = str_replace('(8 )', '', $page);
                $page = str_replace(' (8 ) ', '', $page);
                $page = str_replace('(8)', '', $page);
                $page = str_replace(' (8) ', '', $page);
                $page = str_replace('( 9 )', '', $page);
                $page = str_replace(' ( 9 ) ', '', $page);
                $page = str_replace('(10 )', '', $page);
                $page = str_replace(' (10 ) ', '', $page);
                $page = str_replace('(19 )', '', $page);
                $page = str_replace(' (19 ) ', '', $page);
                $page = str_replace('(19)', '', $page);
                $page = str_replace(' (19) ', '', $page);
                $page = str_replace('(10)', '', $page);
                $page = str_replace(' (10) ', '', $page);
                $page = str_replace('(11 )', '', $page);
                $page = str_replace(' (11 ) ', '', $page);
                $page = str_replace('(11)', '', $page);
                $page = str_replace(' (11) ', '', $page);
                $page = str_replace('(7)', '', $page);
                $page = str_replace('(7) ', '', $page);
                $page = str_replace(' (7)', '', $page);
                $page = str_replace(' (7) ', '', $page);
                $page = str_replace('(13.14.15)', '', $page);
                $page = str_replace(' (13.14.15) ', '', $page);
                $page = trim(preg_replace('/\s+/', ' ', $page));
                $page = ltrim($page);
                echo "********************************************:page: " . $page;
            }

            $box_table = \common\models\Box::find()->where(['name' => $page])->one();
            echo "table box******************************************:" . $box_table->id;
            if ($box_table) {
                $boxx = $box_table->id;
            }
            //  $new_ad->box_id = $box_table->id;
//            } elseif ($box_table and $add) {
//                $add->box_id = $box_table->id;
//            }
//            if (!$add) {
            $add = Ad::find()->where(['serial' => $sh_faktor])->one();
            echo $add->id . "test****";
            if (!$add) {
                $new_ad = new Ad();
                // return $_POST['page'];
                $new_ad->box_id = $boxx;
                $new_ad->serial = $sh_faktor;

                $new_ad->date = \common\models\Persian::convert_date_to_en(\common\models\Persian::persian_digit_replace($tarikh_faktor), TRUE);
                $new_ad->resseler_id = $code_kargozar;
                //$new_ad->box_id = $page;
                $new_ad->pub_qty = $nobat;

                $new_ad->date_publish = \common\models\Persian::convert_date_to_en(\common\models\Persian::persian_digit_replace($date_publish), TRUE);
                $new_ad->title = $sharh_kala;
                $new_ad->benefit_rate = $sharh_karmozd;
                $new_ad->total_price = $total_price;
                $new_ad->discount_price = $mablaghe_takhfif_1;
                $new_ad->price_after_discount = $after_discount;
                $new_ad->benefit_price = $benefit_price;
                $new_ad->in_amount = $in_amount;
                $new_ad->customer_id = $customer_id;
                $new_ad->pub_qty = 1;
//               
                $new_ad->customer_id = $customer_id;
//             
                $new_ad->save(false);
                print_r($new_ad->getErrors());
                echo "*********************saaaveeeeeeeeeeeeeeeeeeeeeeeed********************";
            }
//            } else {
//                $add->serial = $sh_faktor;
//                $add->box_id = $boxx;
//                $add->date = \common\models\Persian::convert_date_to_en($tarikh_faktor);
//                $add->resseler_id = $code_kargozar;
//                //$new_ad->box_id = $page;
//                $add->pub_qty = $nobat;
//                $add->date_publish = \common\models\Persian::convert_date_to_en($date_publish);
//                $add->title = $sharh_kala;
//                $add->benefit_rate = $sharh_karmozd;
//                $add->total_price = $total_price;
//                $add->discount_price = $mablaghe_takhfif_1;
//                $add->price_after_discount = $after_discount;
//                $add->benefit_price = $benefit_price;
//                $add->in_amount = $in_amount;
//                $add->customer_id = $customer_id;
//                $add->pub_qty = 1;
//                if ($customer_id == null)
//                    $add->customer_id = $custom_id;
//                else {
//                    $add->customer_id = $customer_id;
//                }
//                $add->save(false);
//            }
            //$customer_table->save(false);

            if ($_POST['sharh_takhfife_1']) {
                $sharh_takhfife_1 = $_POST['sharh_takhfife_1'];
                $sharh_takhfife_1 = str_replace('ي', 'ی', $sharh_takhfife_1);
                $sharh_takhfife_1 = str_replace('تخفیف ', '', $sharh_takhfife_1);
                $sharh_takhfife_1 = str_replace('%', '', $sharh_takhfife_1);
                $sharh_takhfife_1 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_1));
            }
            if ($_POST['sharh_takhfife_2']) {
                $sharh_takhfife_2 = $_POST['sharh_takhfife_2'];
                $sharh_takhfife_2 = str_replace('ي', 'ی', $sharh_takhfife_2);
                $sharh_takhfife_2 = str_replace('تخفیف ', '', $sharh_takhfife_2);
                $sharh_takhfife_2 = str_replace('%', '', $sharh_takhfife_2);
                $sharh_takhfife_2 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_2));
            }
            if ($_POST['sharh_takhfife_3']) {
                $sharh_takhfife_3 = $_POST['sharh_takhfife_3'];
                $sharh_takhfife_3 = str_replace('ي', 'ی', $sharh_takhfife_3);
                $sharh_takhfife_3 = str_replace('تخفیف ', '', $sharh_takhfife_3);
                $sharh_takhfife_3 = str_replace('%', '', $sharh_takhfife_3);
                $sharh_takhfife_3 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_3));
            }
            if ($_POST['sharh_takhfife_4']) {
                $sharh_takhfife_4 = $_POST['sharh_takhfife_4'];
                $sharh_takhfife_4 = str_replace('ي', 'ی', $sharh_takhfife_4);
                $sharh_takhfife_4 = str_replace('تخفیف ', '', $sharh_takhfife_4);
                $sharh_takhfife_4 = str_replace('%', '', $sharh_takhfife_4);
                $sharh_takhfife_4 = trim(preg_replace('/\s+/', ' ', $sharh_takhfife_4));
            }
            $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_1])->one();
            if ($dicount_item_table) {
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $dicount_item_table->id;
                $ad_has_d->inc_rate = $dicount_item_table->discount;
                $ad_has_d->save(false);
            } else {
                $discount_item_new = new \common\models\DiscountItem;
                $discount_item_new->name = $sharh_takhfife_1;
                $discount_item_new->discount = $sharh_takhfife_1;
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $discount_item_new->id;
                $ad_has_d->inc_rate = $discount_item_new->discount;
                $ad_has_d->save(false);
            }

            $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_2])->one();
            if ($dicount_item_table) {
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $dicount_item_table->id;
                $ad_has_d->inc_rate = $dicount_item_table->discount;
                $ad_has_d->save(false);
            } else {
                $discount_item_new = new \common\models\DiscountItem;
                $discount_item_new->name = $sharh_takhfife_2;
                $discount_item_new->discount = $sharh_takhfife_2;
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $discount_item_new->id;
                $ad_has_d->inc_rate = $discount_item_new->discount;
                $ad_has_d->save(false);
            }
            $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_3])->one();
            if ($dicount_item_table) {
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $dicount_item_table->id;
                $ad_has_d->inc_rate = $dicount_item_table->discount;

                $ad_has_d->save(false);
            } else {
                $discount_item_new = new \common\models\DiscountItem;
                $discount_item_new->name = $sharh_takhfife_3;
                $discount_item_new->discount = $sharh_takhfife_3;
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $discount_item_new->id;
                $ad_has_d->inc_rate = $discount_item_new->discount;
                $ad_has_d->save(false);
            }
            $dicount_item_table = \common\models\DiscountItem::find()->where(['name' => $sharh_takhfife_4])->one();
            if ($dicount_item_table) {
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $dicount_item_table->id;
                $ad_has_d->inc_rate = $dicount_item_table->discount;

                $ad_has_d->save(false);
            } else {
                $discount_item_new = new \common\models\DiscountItem;
                $discount_item_new->name = $sharh_takhfife_4;
                $discount_item_new->discount = $sharh_takhfife_4;
                $ad_has_d = new \common\models\AdHasDiscount();

                $ad_has_d->ad_id = $new_ad->id;
                $ad_has_d->discount_price = $new_ad->discount_price;

                $ad_has_d->discount_id = $discount_item_new->id;
                $ad_has_d->inc_rate = $discount_item_new->discount;
                $ad_has_d->save(false);
            }


            if ($_POST['name_kargozar']) {
                $name_kargozar = $_POST['name_kargozar'];
            }
            $user_table = User::find()->where(['username' => $code_kargozar])->one();
            if ($user_table) {
                $user_table->name_and_fam = $name_kargozar;
                $user_table->save(false);
            }



//        $country_table = \common\models\Country::find()->where(['name' => $shahrestan])->one();
//        if ($country_table) {
//            $country_table->country = $country_table->id;
//        } else {
//            if ($shahrestan != null) {
//                $country_table_new = new \common\models\Country();
//                $country_table_new->name = $shahrestan;
//                $customer_table->country = $country_table_new->id;
//                $country_table_new->save(false);
//            }
//        }
//        echo "<br>countrytablenew******************************:" . $country_table_new->name . "<br>";
//        echo $customer_table->country . "<br>";
//        echo "country excel" . $shahrestan;
            // $new_ad->save(false);
            // $customer_table->save(false);
            //$city_table->save(false);
        }
    }

    public function actionSaveexcel() {



        //$new_customer = new Customer();
        $new_ad = new Ad();

//      return $_POST['shakhs_haghighi'];
//        if ($_POST['shakhs_haghighi']) {
//            $customer_name = $_POST['shakhs_haghighi'];
//
//            $customer_name = str_replace('  نام شخص حقيقي / حقوقي :', '', $customer_name);
//            $customer_name = str_replace(' نام شخص حقيقي/حقوقي:', '', $customer_name);
//            $customer_name = str_replace(array('ي', 'ك'), array('ی', 'ک'), $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی / حقوقی:', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی / حقوقی : ', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی /حقوقی : ', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی / حقوقی :', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی/حقوقی:', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی /حقوقی :', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی /حقوقی :', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی/ حقوقی:', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقيقي :', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی / حقوق:', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی /', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی :', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی/حقوقی : ', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی/حقوقی :', '', $customer_name);
//            $customer_name = str_replace('نام شخص حقیقی :', '', $customer_name);
//        }
        if ($_POST['sh_faktor']) {
            $sh_faktor = $_POST['sh_faktor'];
        }
        if ($_POST['neshani']) {
            $address = $_POST['neshani'];
            $address = str_replace('نشاني :', '', $address);
            $address = str_replace('نشاني :', '', $address);
        }
        if ($_POST['code_posti']) {
            $postal_code = $_POST['code_posti'];
            $postal_code = str_replace('کد پستی : ', '', $postal_code);
        }
        if ($_POST['sh_meli']) {
            $social_code = $_POST['sh_meli'];
            $social_code = str_replace('شماره ثبت/شماره ملی :', '', $social_code);
        }
        if ($_POST['eghtesadi']) {
            $economical_code = $_POST['eghtesadi'];
            $economical_code = str_replace('شماره اقتصادی :', '', $economical_code);
        }
        $model_customer = Customer::find()->where(['name' => $customer_name])->one();

        if (!$model_customer) {

            $new_customer->name = $customer_name;
            $new_customer->social_code = $social_code;

            $new_customer->economical_code = $economical_code;
            $new_customer->addres = $address;
            $new_customer->postal_code = $postal_code;
            $new_customer->save();
            if ($new_customer->save()) {

                $customert_id = $new_customer->id;
            }
        } else {

            $customert_id = $model_customer->id;

            $model_customer->name = $customer_name;
            $model_customer->social_code = $social_code;

            $model_customer->economical_code = $economical_code;
            $model_customer->addres = $address;
            $model_customer->postal_code = $postal_code;
            $model_customer->save();
        }

        $serial_number = $_POST['sh_serial'];
        $serial_number = str_replace('.xlsx', '', $serial_number);

        if ($_POST['tarikhe_chap']) {
            $date_publish = $_POST['tarikhe_chap'];
            $date_publish = str_replace(' :تاريخ چاپ', '', $date_publish);
            $date_publish = str_replace(' ', '', $date_publish);
            $date_publish = str_replace('98', '1398', $date_publish);
            $date_publish = \common\models\Persian::convert_date_to_en($date_publish);
        }
        if ($_POST['city']) {
            $city = $_POST['city'];
            $city = str_replace('شهر :', '', $city);
            $city = str_replace(' شهر :', '', $city);
        }
        if ($_POST['ostan']) {
            $state = $_POST['ostan'];
            $state = str_replace('نشاني :  استان :', '', $state);
        }

        if ($_POST['tarikh']) {
            $date = $_POST['tarikh'];
            $date = str_replace('98', '1398', $date);
            $date = \common\models\Persian::convert_date_to_en($date);
        }
        if ($_POST['code_kargozar']) {

            $resseler_id = $_POST['code_kargozar'];
            $resseler_id = str_replace('كد شناسه:', '', $resseler_id);
            $resseler_id = str_replace('كد شناسه :', '', $resseler_id);
            $resseler_id = str_replace('\n', '', $resseler_id);
            $resseler_id = str_replace(array("\r\n", "\n", "\r"), ' ', $resseler_id);
        }

        $new_ad->serial = (int) $sh_faktor;
        $new_ad->customer_id = $customert_id;
        $new_ad->total_price = $_POST['mablaghe_kol'];
        $new_ad->discount_price = $_POST['takhfif'];
        $new_ad->benefit_price = $_POST['karmozd'];
        $new_ad->total_price_after_discount = $_POST['after_discount'];
        $new_ad->date = $date;
        $new_ad->date_publish = $date_publish;
        $new_ad->title = $_POST['sharhe_kala'];
        $new_ad->city = $city;
        $new_ad->resseler_id = $resseler_id;
        $new_ad->state = $state;

        $new_ad->save();
//        }

        if ($new_ad->id) {
            return $new_ad->id;
        } else {
            return json_encode($new_ad->getErrors(), JSON_UNESCAPED_UNICODE) . '@@@' . $_POST;
        }
        //return json_encode($new_ad->id());
    }

//    
//    public function actionSavetitle() {
//        $serial_number = $_POST['sh_serial'];
//        $serial_number = str_replace('.xlsx', '', $serial_number);
//
//        $model = Ad::find()->where(['serial' => $serial_number])->one();
//        $model->title = $_POST['sharhe_kala'];
//        $model->save();
//    }
//
//        public function actionFirstpresence($customer_id){
//       
//
//    }
}
