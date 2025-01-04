<?php

namespace frontend\controllers;

use Yii;
use common\models\Customer;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Ad;
use common\models\Post;
use common\models\DiscountItem;
use yii\data\Pagination;
use common\models\Address;
use common\models\CreditTransition;
use common\models\Sitesetting;
use DateTime;
use common\models\Persian;
use common\models\User;
use yii\helpers\Url;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public $site_object;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['asuser', 'error', 'date','new_order', 'contract', 'contractprice', 'menu', 'about', 'find_city', 'about2', 'online', 'paidmali', 'tasvie', 'about_1', 'option', 'edit'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'clear', 'paid', 'notpaid', 'new_order_copy', 'order_list', 'submit', 'get_customer_discount', 'getseason', 'cal_data', 'profile', 'remove_order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionCal_data($box_id = null, $qty = null, $income = null, $ad_in_page = null, $num_full_page = null,
            $num_box_qty = null, $num_pub_qty = null, $arr1 = null, $arr2 = null, $cid = null, $edit_id = null, $custid = null,
            $resid = null, $confirm = null, $free = null, $type = null, $cer = null, $iddd_ad = null, $mim = null, $contract = null,
            $contractprice = null, $titlee = null, $pub_date = null, $tej = null, $pay = null, $box_id_ad = null,
            $naghdi_etebari = null, $ad_typee = null, $agahi = null, $cash_discount = null, $arr3 = null,
            $steps_discount = null, $fix_discount = null,$code_kargah=null,$date_publish2=null,$vat = null) {



        //echo $type."*";
        //print_r($dis_2);
        //exit();



        $customer_discount = Customer::find()->where(['id' => $custid])->one();
        if (!empty($arr1) or $customer_discount->discount_type != null) {
//array_push($arr,$_POST['selected_discount_all']);

            $dis_1 = explode(",", $arr1);
            $dis_2 = explode(",", $arr2);
            $dis_3 = explode(",", $arr3);

            foreach ((array) $dis_1 as $disc) {


                if (!is_numeric($disc)) {

                    if (preg_match("/[0-9]+%/", $disc, $matches)) {

                        $discount_arr[23] = [str_replace("%", "", $matches[0]), 1];
                    }
                } else {

                    $disc_item = \common\models\DiscountItem::findOne($disc);

                    $discount_arr[$disc_item->id] = [$disc_item->discount, 1,$disc_item->just_discount ];
                }
            }
            foreach ((array) $dis_2 as $disc) {


                if (!is_numeric($disc)) {

                    if (preg_match("/[0-9]+%/", $disc, $matches)) {




                        $discount_arr[23] = [str_replace("%", "", $matches[0]), 2, $disc];
                    }
                } else {
                    $disc_item = \common\models\DiscountItem::findOne($disc);

                    $discount_arr[$disc_item->id] = [$disc_item->discount, 2];
                }
            }


            foreach ((array) $dis_3 as $disc) {


                if (!is_numeric($disc)) {

                    if (preg_match("/[0-9]+%/", $disc, $matches)) {




                        $discount_arr[103] = [str_replace("%", "", $matches[0]), 3, $disc];
                    }
                } else {
                    $disc_item = \common\models\DiscountItem::findOne($disc);

                    $discount_arr[$disc_item->id] = [$disc_item->discount, 3];
                }
            }
        } else {
            $discount_arr = [];
            $benefitt = 25;
        }


        if ($_GET['tarhim_tasliyat'] == 1) {

            $this_dis = 0;
            if ($num_box_qty < 8)
                $this_dis = 10;
            if ($num_box_qty >= 8)
                $this_dis = 20;

            $discount_arr[130] = [$this_dis, 2];
        }



        $one_pub = ($num_box_qty + $ad_in_page);
        $all_pub = $one_pub * $num_pub_qty;

        //$benefitt = 0;

        $ad_type = \common\models\AdType::findOne($type);
        foreach ((array) json_decode($ad_type->discount_json) as $disc_i) {
            $disc_item = DiscountItem::findOne($disc_i);
            $discount_arr[$disc_i] = [$disc_item->discount, 1];
        }
        foreach ((array) json_decode($ad_type->benefit_json) as $disc_i) {
            $disc_item = DiscountItem::findOne($disc_i);
            $discount_arr[$disc_i] = [$disc_item->discount, 3];
        }
        $ad_typee = $type;

        //echo $ad_type;
        //echo $ad_typee."*1";



        $price = Ad::get_type_price($ad_typee, $box_id, $pub_date, $_GET['in_kh']) * $all_pub;

        if ($_GET['disc_addi_moshtari_kargozar']) {
            if ($_GET['disc_addi_moshtari_kargozar'] == 1) {
                $discount_arr[121] = [10, 2];
            }
            if ($_GET['disc_addi_moshtari_kargozar'] == 2) {

                $discount_arr[122] = [10, 3];
            }
            if ($_GET['disc_addi_moshtari_kargozar'] == 3) {
                $discount_arr[123] = [5, 2];
                $discount_arr[124] = [5, 3];
            }
        }




        // cash_discount
        //echo $benefitt;
        //exit();

        echo \common\models\Ad::cal_price__($in_amount = $income, $price, $discount_arr = $discount_arr, $one_pub = $one_pub, $all_pub = $all_pub,
                $num_pub_qty = $num_pub_qty, $benefitt = $benefitt, $edit_id = $edit_id, $custid = $custid, $arr, $resid, $confirm, $free,
                $cer, $iddd_ad, $mim, $contract, $contractprice, $titlee, $pub_date, $tej, $pay, $box_id_ad, $ad_in_page, $naghdi_etebari,
                $ad_typee, $agahi, $_GET['in_kh'], $_GET['date'], $steps_discount, $vat,$fix_discount,$code_kargah,$date_publish2);
    }

    // به دست آوردن الن تو چه فصلی هستیم


    public function actionAsuser($id) {

        $u = User::findOne($id);
        Yii::$app->user->login($u, 3900000);

        return $this->redirect(['site/new_order', 'p_id' => $_GET['p_id']]);

        return $this->goBack();
    }

    public function actionGet_customer_discount($id) {

        return Ad::get_customer_discount($id);
    }

    public function actionFind_city($id) {

        return Ad::find_city($id);
    }

    /**
     * @inheritdoc
     */
    public function actionContract($id = 0) {

        $loc1 = \common\models\Contract::find()
                ->where('customer_id=' . $id)
                ->andWhere('status=' . 1)
                ->all();

        $arr = array();
        foreach ($loc1 as $city) {
            //echo $city->name."<br>";
            $arr[$city->id] = $city->contract_number . " " . "(" . "قیمت: " . number_format($city->price) . ")"
                    . "";
        }
        //print_r($arr);
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionContractprice($id = 0) {

        $loc1 = \common\models\Contract::find()
                ->where('id=' . $id)
                ->one();

        $arr = $loc1->price;

        //print_r($arr);
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionProfile() {



        $user = \common\models\User::findOne(Yii::$app->user->identity->id);
        if ($_POST) {
            if ($_POST['User']['password_hash']) {

                // echo $user->id;
                //  echo "pass".$_POST['User']['password_hash'];
                //  exit();
                $user->setPassword($_POST['User']['password_hash']);
                $user->generateAuthKey();
            }
            $user->username = $_POST['User']['username'];
//            echo $_POST['User']['username']."<br>";
//            echo $user->username."<br>";
//             echo $_POST['User']['password_hash']."<br>";
//            echo $user->password_hash."<br>";
            $user->save(false);
//            echo $user->password_hash ."<br>";
//             echo $_POST['User']['password_hash'] ."<br>";
            if ($user->save(false))
                Yii::$app->session->setFlash('success', "ذخیره شد ");
//            
            // print_r($user->getErrors());
//            exit();
        }

        return $this->render('profile', [
                    'user' => $user,
        ]);
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        
    header("Location: https://hamshahriads.ir/backend/web/index.php");
    die();


        $searchModel = new \common\models\AdSearch();
        $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams, true, null, null, null, 1);

        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams, true, null, null, null, 2);
        $dataProvider3 = $searchModel->search(Yii::$app->request->queryParams, true, null, null, null, 3);

        $searchModel_s = new \common\models\AdSearch();
        $dataProvider_s = $searchModel_s->search(Yii::$app->request->queryParams, false, $id);

        $searchModel_mah = new \common\models\AdSearch();
        $dataProvider_mah = $searchModel_mah->search(Yii::$app->request->queryParams, false, false, null, null, null, false, true);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'searchModel_s' => $searchModel_s,
                    'dataProvider_s' => $dataProvider_s,
                    'searchModel_mah' => $searchModel_mah,
                    'dataProvider_mah' => $dataProvider_mah,
        ]);
    }

    public function actionTasvie() {


        return $this->render('tasvie', [
        ]);
    }

    public function actionOnline() {
        $transition_table = new \common\models\Transition();
        $user_online = Yii::$app->user->identity->id;
        if ($transition_table->load(Yii::$app->request->post())) {
            $transition_table->date = date('Y-m-d H:i:s');
            $transition_table->user_id = $user_online;
            $transition_table->type = 'online';
            $user_table = User::find()->where(['id' => $user_online])->one();
            $user_table->credit += $transition_table->amount;
            $user_table->save(false);

            if ($transition_table->save(false)) {
                Yii::$app->session->setFlash('success', ' ثبت شد');
                return $this->render('online');
            } else {
                return $this->render('online');
            }
        }

        return $this->render('online');
    }

    public function actionPaid() {

        $searchModel = new \common\models\AdSearch();
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams, true, null, null, null, null, null, null, null, null, null, 1);
        return $this->render('paid', [
                    'searchModel' => $searchModel,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionNotpaid() {

        $searchModel = new \common\models\AdSearch();
        $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams, true, null, null, null, null, null, null, null, null, null, 0);
        return $this->render('notpaid', [
                    'searchModel' => $searchModel,
                    'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionPaidmali() {

        $searchModel = new \common\models\AdSearch();
        $dataProvider3 = $searchModel->search(Yii::$app->request->queryParams, true, null, null, null, 3);
        return $this->render('paidmali', [
                    'searchModel' => $searchModel,
                    'dataProvider3' => $dataProvider3,
        ]);
    }

    public function actionColor() {

        return $this->render('color');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->redirect(['site/index']);
    }

    public function actionLogin() {
        
        
     header("Location: https://hamshahriads.ir/backend/web/index.php");
die();



        if (!Yii::$app->user->isGuest) {
            return $this->render('index');
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->login()) {




                return $this->redirect(['site/index']);
            } else {

                return $this->render('login', [
                            'model' => $model,
                ]);
            }
        } else {

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {

        return $this->render('about');
    }

    public function actionAbout2() {

//          $this_persin = \common\models\Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
//   // echo $this_persin[0].$this_persin[1].$this_persin[2];
//          print_r(date('y-m-d')) ."<br>";
//        $start_miladi = \common\models\Persian::jalali_to_gregorian($this_persin[0], $this_persin[1] - 3,$this_persin [2]);
//          //echo $start_miladi[0].$start_miladi[1].$start_miladi[2]."<br>";
//          print_r($start_miladi) ."<br>";
//          echo var_dump($start_miladi<$this_persin)."<br>";
//          $date=$start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
//          echo "dattttteeeeeee: ".$date;
//        $customer_d = \common\models\CustomerDuration::find()->where(['<','date',$date])->all();
//        //echo $customer_d->createCommand()->getRawSql();
//        print_r($customer_d) ;
//     // echo count($customer_d);
//       // echo date('y-m-d');
//        if($customer_d){
//        foreach($customer_d as $c){
//            //echo $c->date;
//            $c->kargozar_id='';
//          //  $c->save(false); 
//        } 
//        
//    }


        return $this->render('about2');
    }

    public function actionAbout_1($date_publish = null, $box_id = null) {
        $ad = Ad::find()->where(['date_publish' => $date_publish, 'box_id' => $box_id])->all();
        return $this->render('about_1', [
                    'ad' => $ad,
                    'date_publish' => $date_publish,
                    'box_id' => $box_id,
        ]);
    }

    public function actionOption($id) {
        
    }

    public function actionNew_order($id = null) {


        $model = Ad::check_new_order($id);

        //cho $model->custom_id;

        $u = User::findOne($model->resseler_id);
        Yii::$app->user->login($u, 3900000);
        if(!Yii::$app->user->id){
                
     header("Location: https://hamshahriads.ir/backend/web/index.php");
     die();
     
        }


        $model->pub_qty = 1;
        if(!$model->vat)
            $model->vat = 0;
        if(!$model->pelekani)
        $model->pelekani = 0;
        
        
        if (!$model->naghdi_etebari)
        //$model->naghdi_etebari = 1;
        //$model->box_qty = 1;
            $id = $_GET['id'];
        if (!$_GET['id']) {
            return $this->render('new_order', [
                        'model' => $model
                            ]
            );
        } else {
            return $this->render('new_order', [
                        'model' => $model,
                        'id' => $id
                            ]
            );
        }
    }

    public function actionEdit($id) {


        $model = Ad::find()->where(['id' => $id])->one();
        return $this->render('edit', [
                    'model' => $model,
                    'id' => $id,
                        ]
        );
    }

    public function actionNew_order_copy($id = null) {


        $model = Ad::check_new_order($id);
        $model->pub_qty = 1;
        $model->box_qty = 1;

        return $this->render('new_order_copy', [
                    'model' => $model
                        ]
        );
    }

    public function actionOrder_list() {


        //$model = Order::check_new_order();
        $searchModel = new Orders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order_list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSubmit() {


        $model = Order::check_new_order(0, TRUE);

        $model->price = Order::get_total_price();
        $model->sale_benefit = (Order::get_total_price() * (Yii::$app->user->identity->benefit_value / 100)) - Order::get_sum_discount();
        $model->producer_benefit = Order::get_producer_benefit();
        $model->price_final = Order::get_final_total();

        $model->status = 1;
        $model->save();
        Yii::$app->session->setFlash('success', 'سفارش ثبت شد');

        return $this->redirect(['/site/order_list']);
    }

    public function actionSub_menu() {
        return $this->render('sub_menu');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        if (!Yii::$app->user->isGuest) {
            return $this->render('index');
        }

        $model = new SignupForm();
        $login_model = new LoginForm();
        if ($login_model->load(Yii::$app->request->post())) {

            if ($login_model->login()) {



                Order::guest_order();

                //return $this->redirect(['site/index']);
                if ($_POST['back'] == 1) {
                    return $this->redirect('submit_order');
                }
                if ($_GET['back_to_cart'] == 1) {

                    return $this->redirect('cart');
                }
                if ($_GET['CRT'] == 1) {

                    return $this->redirect(['/site/address']);
                }
                //echo "X";

                return $this->redirect('index');
            } else {


                return $this->render('signup', [
                            'login_model' => $login_model,
                            'model' => $model,
                ]);
            }
        } else {


            ///////////////////////////////////////////////////////////////
            if (\Yii::$app->params['site_setting']->sms_check_signup == 1) {

                if ($model->load(Yii::$app->request->post())) {



                    if ($user = $model->signup()) {
                        //if (Yii::$app->getUser()->login($user)) {
                        $rand = rand(1000, 9999);

                        $body = 'کد تایید شما برابر است با:';
                        $body .= $rand;

                        // $user = new User();
                        //  $user->username = $this->username;
                        $user->status = 0;
                        $user->sms_token = $rand;
                        $user->save();
                        Sitesetting::send_sms($user->username, $body);
                        return $this->redirect(['/site/sms', 'id' => $user->id]);
                        //}
                    }
                }
            } else {


                if ($model->load(Yii::$app->request->post())) {
                    if ($user = $model->signup()) {
                        if (Yii::$app->getUser()->login($user)) {

                            $user_credit = \common\models\User::findone(yii::$app->user->identity->id);

                            $sitesetting = \common\models\Sitesetting::findone(1);
                            Order::guest_order();

                            if ($_GET['CRT'] == 1) {

                                return $this->redirect(['/site/address']);
                            }
                            return $this->redirect(['site/index']);
                        } else {
                            return $this->render('signup', [
                                        'model' => $model,
                                        'login_model' => $login_model,
                            ]);
                        }
                    }
                }
            }

            return $this->render('signup', [
                        'model' => $model,
                        'login_model' => $login_model,
            ]);
        }
    }

    public function actionSms($id) {

        //echo Yii::$app->user->identity->id;

        $user = \common\models\User::FindOne($id);

        if ($_POST['sms_token'] && $_POST['sms_token'] == $user->sms_token) {
            //    echo "xx";
            //  exit();
            if (Yii::$app->getUser()->login($user)) {
                $user->status = 10;
                $user->save();
                Yii::$app->session->setFlash('success', 'حساب کاربری شما تایید شد');
                return $this->redirect(['index']);
            }
        } else {
            if ($_POST) {
                //     echo "xxx";
                // exit();
                Yii::$app->session->setFlash('danger', 'کد اشتباه  است');
            }
            return $this->render('sms');
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($_POST) {

            $_POST['number'] = \common\models\Persian::persian_digit_replace($_POST['number']);

            $user = \common\models\User::findOne(['username' => $_POST['number']]);
            if ($user->id) {



                $pass_word = rand(100000, 999999);
                $user->setPassword($pass_word);
                $user->generateAuthKey();
                $user->save();
                Sitesetting::send_sms($_POST['number'], 'رمزجدی شما:' . $pass_word);
            }
            Yii::$app->session->setFlash('success', 'در صورت که شماره ارسال شده صحت داشته باشد رمز عبور برای شما ارسال شده است..');
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionAdd_to_card_ajax($product_id, $qty) {
        return Order::add_to_card($product_id, $qty);
    }

    public function actionCart() {

        $_order_items = Order::get_cart_items();
        return $this->render('cart', [
                    'order_items' => $_order_items
        ]);
    }

    public function actionAddress() {






        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/signup', 'CRT' => 1]);
        }


        if (Order::check_order_is_digital()) {
            return $this->redirect(['site/payment', 'digi' => 1]);
        }


        $order = Order::check_order(0, TRUE);
        $address_object = new \common\models\Address();

        if ($_GET['new_address']) {
            $address_object->scenario = 'new_address';
        }



        $order->scenario = 'check_address';

        if ($order->load(Yii::$app->request->post()) and $order->address_id) {




            $order->date = date("Y-m-d h:i:s");

            if ($order->address_id > 0) {
                if ($order->save()) {
                    return $this->redirect(['site/send',
                                'order_id' => $order->id,
                    ]);
                }
            } else {

                $address_object->load(Yii::$app->request->post());

                $address_object->user_id = Yii::$app->user->identity->id;

                if ($address_object->save() and $address_object->address) {
                    $order->address_id = $address_object->id;

                    $order->save();
                    return $this->redirect(['site/send',
                                'order_id' => $order->id,
                                    ]
                    );
                } else {
                    if (!$address_object->address) {

                        $address_object->addError('address', 'آدرس نمی تواند خالی باشد');
                    }
                    return $this->render('address', [
                                'address_object' => $address_object,
                                'order' => $order,
                                'open_address' => TRUE
                    ]);
                }
            }
        } else {

            return $this->render('address', [
                        'address_object' => $address_object,
                        'order' => $order,
            ]);
        }
    }

    public function actionErsal($shipmethod) {


        echo \common\models\Order::get_Shipping_method_price($shipmethod);
    }

    public function actionSend() {


        Order::cal_order_sum();
        $order = Order::find()->innerJoinWith('address')->where(['product_order.id' => Order::check_order(0)])->one();

        $location_id = Address::find()->where(['id' => $order->address->id])->one()->city_id;

        $ship_m = \common\models\Product_shipping_has_location::find()
                ->innerjoinWith('shippingMethod')
                ->where(['location_id' => $location_id])
                ->all();

        return $this->render('send', [
                    'ship_m' => $ship_m,
        ]);
    }

    public function actionPayment() {

        if ($_POST['shipping_radio']) {

            \common\models\Order::get_Shipping_method_price($_POST['shipping_radio'], 1);
        }

        if ($_GET['digi'] == 1) {

            \common\models\Order::get_Shipping_method_price(-1, 1);
        }

        $order = Order::check_order(0, TRUE);
        $is_credit = $_GET['is_credit'];
        if ($is_credit == 1) {

            $credit = \common\models\User::findone(Yii::$app->user->identity->id)->credit;

            $order->price_final = $order->price_final - $credit;

            $order->save();

            $credit_log = new CreditTransition();
            $credit_log->user_id = Yii::$app->user->identity->id;
            $credit_log->order_id = $order->id;
            $credit_log->date = date("Y-m-d h:i:sa");
            $credit_log->amount = $order->price_final; //enqad kam shode azash
            $credit_log->description = 1;

            if ($credit_log->save()) {
                
            }

            $user_credit = \common\models\User::findone(yii::$app->user->identity->id);
            $user_credit->credit = $user_credit->credit - $credit_log->amount;
            if ($user_credit->credit < 0) {
                $user_credit->credit = 0;
            }
            $user_credit->save();
        }
        return $this->render('payment', [
                    'order' => Post::arabic_w2e(number_format($order->price_final)),
        ]);
    }

    public function actionTracking() {



        if ($_POST['payment']) {

            $_order = Order::check_order(0, TRUE);
            if ($_order) {
                $_order->payment_id = $_POST['payment'];
                $_order->status = 2;
                $_order->date = date("Y-m-d h:i:sa");
                $_order->payment_method_id = $_POST['payment'];
                if ($_order->price_final == 0) {
                    $_order->price_final = $_order->price;
                }
                $_order->save();

                if ($_order->payment_method_id == 1) {

                    if (\Yii::$app->params['site_setting']->sms_order_submit) {
                        Sitesetting::send_sms(Yii::$app->user->identity->username, Order::replace_order_sms_parameter(\Yii::$app->params['site_setting']->sms_order_submit, $_order));
                    }
                    return $this->redirect(['payment_req', 'id' => $_order->id]);
                } else {

                    if (\Yii::$app->params['site_setting']->sms_order_submit_offline) {

                        Sitesetting::send_sms(Yii::$app->user->identity->username, Order::replace_order_sms_parameter(\Yii::$app->params['site_setting']->sms_order_submit_offline, $_order));
                    }
                }




                /*
                 * To change this license header, choose License Headers in Project Properties.
                 * To change this template file, choose Tools | Templates
                 * and open the template in the editor.
                 */




                return $this->render('tracking', [
                            'order' => $_order->id,
                            'msg' => 1,
                ]);
            } else {
                $this->redirect('index');
            }
        } else {
            return $this->redirect(['site/payment']);
        }
    }

    public function actionState($id = 0) {
        $loc1 = \common\models\location::find()
                ->where('state_id=' . $id)
                ->orderBy(['name' => SORT_DESC])
                ->all();

        $arr = array();
        foreach ($loc1 as $city) {
            //echo $city->name."<br>";
            $arr[$city->id] = $city->name;
        }
        //print_r($arr);
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionRemove($item) {
        //echo $item_id;
        $order_id = \common\models\ProductItem::findOne($item);
        if ($order_id->id) {
            $order_id->delete();
            $count = \common\models\Order::get_order_count();
            $arr['count'] = $count;
            // $arr['carthtml'] = \common\models\Order::get_cart_items_html();
            return json_encode($arr, JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionOrder() {
        $searchModel = new \common\models\Orders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity->id);

        $query = Order::find()
                ->where('user_id=' . Yii::$app->user->identity->id)
                ->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $ord = $query->offset($pages->offset)
                ->limit(10)
                ->all();

        return $this->render('order', [
                    'ord' => $ord,
                    'pages' => $pages,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetails($id) {

        $order_d = \common\models\ProductItem::find()
                ->where('order_id=' . $id)
                ->all()
        ;
        return $this->render('details', [
                    'order_d' => $order_d,
                    'model' => Order::findOne($id)
        ]);
    }

    public function actionAccount() {

        return $this->render('account');
    }

    public function actionAddinfo($id) {

        $model = \common\models\User::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $msg = 'اطلاعات شما با موفقیت ثبت شد';
            }


            return $this->render('addinfo', [
                        'model' => $model,
                        'msg' => $msg,
            ]);
        } else {
            return $this->render('addinfo', [
                        'model' => $model,
            ]);
        }
    }

    public function actionGsearch($s) { // g algoritm avis
        $s = str_replace(" ", "%", $s);
        $s = "%" . $s . "%";

        $query_post = \common\models\Post::find()
                        ->orWhere(['like', 'title', $s, FALSE])
                        ->orWhere(['like', 'body', $s, FALSE])->all();

        $query_product = \common\models\Product::find()
                ->orWhere(['like', 'name', $s, FALSE])
                ->orWhere(['like', 'summery', $s, FALSE])
                ->orWhere(['like', 'english_name', $s, FALSE])
                ->orWhere(['like', 'code', $s, FALSE])
                ->orWhere(['like', 'body', $s, FALSE]);

        $query_product = $query_product->all();

        return $this->render('search', [
                    'postS' => $query_post,
                    'productS' => $query_product,
                    'query' => $s,
        ]);
    }

    public function actionTrack_order() {
        $model = new \common\models\OrderCheck();
        if ($model->load(Yii::$app->request->post())) {
            $user_id = \common\models\User::find()->where(['email' => $model->order_email])->one()->id;

            $check_order = Order::find()->where(['id' => $user_id, 'user_id' => $user_id])->one();
            if (!$check_order) {

                Yii::$app->session->setFlash('error', ' سفارشی پیدا نشد');
                return $this->render('track_order', [
                            'model' => $model,
                ]);
            }

            return $this->render('tracking_process', [
                        'order_id' => $model->order_id,
            ]);
        } else {


            return $this->render('track_order', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUser_order_history() {
        $id = Yii::$app->user->identity->id;
        $searchModel = new \common\models\Orders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('user_order_history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTracking_process($order_id) {
        return $this->render('tracking_process', [
                    'order_id' => $order_id,
        ]);
    }

    public function actionPayment_verify() {



        $LoginAccount = 'bpt1R8w7Wk4Q7fG82mQg';

        if (isset($_POST['status']) && $_POST['status'] == 0 && isset($_POST['Token']) && $_POST['Token'] != "") {
            $client = new \nusoap_client('https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';

            $result = $client->call('ConfirmPayment', array("requestData" =>
                array(
                    'LoginAccount' => $LoginAccount,
                    'Token' => $_POST['Token']
                ),
            ));

            $orderId = $_POST ["OrderId"];

            if (isset($result['ConfirmPaymentResult']) && $result['ConfirmPaymentResult'] != "") {
                $result = $result['ConfirmPaymentResult'];

                if (isset($result['Status']) && $result['Status'] == 0 && isset($result['RRN']) && $result['RRN'] > 0) {
                    $bankReference = (isset($result['RRN']) && $result['RRN'] > 0) ? $result['RRN'] : "";
                    $cardNumberMasked = (isset($result['CardNumberMasked']) && $result['CardNumberMasked'] != "") ? $result['CardNumberMasked'] : "";

                    $order_ = Order::findOne($orderId);
                    $order_->status = 3;
                    $order_->save();

                    if (Yii::$app->params['site_setting']->sms_order_paid) {
                        Sitesetting::send_sms(Yii::$app->user->identity->username, Order::replace_order_sms_parameter(Yii::$app->params['site_setting']->sms_order_paid, $_order));
                    }




                    $items = \common\models\ProductItem::find()->where('order_id=' . $order_->id)->all();
                    foreach ($items as $item) {

                        $product_ = \common\models\Product::findOne($item->product_id);
                        $product_->qty -= $item->qty;
                        $product_->save();
                    }




                    return $this->render('tracking', [
                                'order' => $orderId,
                                'msg' => 1,
                    ]);

                    //echo "Payment Successfully - bank Payment Reference Number : {$bankReference}";
                } else {
                    echo "Error : {$result['Status']}";
                }
            } else {
                echo "No response from the bank";
            }
        } else {

            return $this->render('tracking', [
                        'order' => $orderId,
                        'msg' => 17,
            ]);

            echo "Transaction canceled by user";
        }
    }

    public function actionPayment_req($id) {

        $order = Order::findOne($id);

        $amount = $order->price_final;
        if (\Yii::$app->params['site_setting']->currency == 1) {
            $amount *= 10;
        }

        $LoginAccount = 'bpt1R8w7Wk4Q7fG82mQg';
        $Amount = $amount; // Rial
        $OrderId = $id;
        $CallBackUrl = "https://irscooter.com/site/payment_verify";

        $client = new \nusoap_client('https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';

        $result = $client->call('SalePaymentRequest', array("requestData" =>
            array(
                'LoginAccount' => $LoginAccount,
                'Amount' => $Amount,
                'OrderId' => $OrderId,
                'CallBackUrl' => $CallBackUrl,
                'AdditionalData' => ''
            ),
        ));

        if (isset($result['SalePaymentRequestResult']) && $result['SalePaymentRequestResult'] != "") {
            $result = $result['SalePaymentRequestResult'];

            if (isset($result['Status']) && $result['Status'] == 0 && isset($result['Token']) && $result['Token'] != "") {
                $token = $result['Token'];
                //echo "x1";
                $this->redirect('https://pec.shaparak.ir/NewIPG/?Token=' . $token);

                //header("Location:");
            } else {
                echo "Error : {$result['Status']}";
            }
        } else {
            echo "No response from the bank";
        }
    }

}
