<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserS;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Persian;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
//            [
//                'class' => 'yii\filters\PageCache',
//                'only' => ['view'],
//                'duration' => 600000,
//                'variations' => [
//                  //  Yii::$app->request->get('page')
//                ]
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [ 'unlock', 'lvl', 'index2', 'f1', 'bulk', 'bulk2', 'save', 'drafts', 'urldl', 'slug', 'logout'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'index_user','kar','delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(16, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {

                            if (in_array(18, (array) json_decode(\Yii::$app->user->identity->level_id))) {
                                return true;
                            }
                        }
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        if ($action->id == 'delete')
            $this->enableCsrfValidation = false;



        if (!parent::beforeAction($action)) {
            return false;
        }



        // other custom code here



        return true; // or false to not run the action
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex($type) {
        $searchModel = new UserS();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $type);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex_user($type) {
        $searchModel = new UserS();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $type);


        return $this->render('index_user', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $searchModel_ad = new \common\models\AdSearch();
        $dataProvider_ad = $searchModel_ad->search(Yii::$app->request->queryParams, false, false, null, null, null, $id);

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchModel_ad' => $searchModel_ad,
                    'dataProvider_ad' => $dataProvider_ad,
                    'id' => $id
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();
        $model->type = 2;
        if ($model->load(Yii::$app->request->post())) {


            $model->setPassword($model->password);
            $model->generateAuthKey();


            if ($model->save()) {
                Yii::$app->session->setFlash('success', "ذخیره شد ");
                //echo $model->id;
                $level = array();
                if ($model->lvl == 2) {
                    array_push($level, 10, 15, 20, 26, 24, 19, 21);
                    $model->level_id = json_encode($level);
                }
                if ($model->lvl == 1) {
                    array_push($level, 10, 11, 13, 14, 15, 16, 17, 18, 20, 22, 23, 25, 26, 24, 19, 21, 30);
                    $model->level_id = json_encode($level);
                }
                if ($model->lvl == 3) {
                    array_push($level, 10, 15, 20, 26, 24, 19, 21);
                    $model->level_id = json_encode($level);
                }
                if ($model->lvl == 4) {
                    array_push($level, 10, 15, 20, 26, 24, 19, 21);
                    $model->level_id = json_encode($level);
                }
                if ($model->lvl == 5) {
                    array_push($level, 10, 15, 20, 26, 24, 19, 21);
                    $model->level_id = json_encode($level);
                }
                if ($model->lvl == 6) {
                    array_push($level, 10, 15, 20, 26, 24, 19, 21);
                    $model->level_id = json_encode($level);
                }
                if ($model->lvl == 9) {
                    array_push($level, 10, 15, 20, 26, 24, 19, 21, 28, 29, 31);
                    $model->level_id = json_encode($level);
                }

                $model->save(false);

                return $this->redirect(['index', 'type' => 2]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionKar() {
        $model = new User();
        $model->type = 8;
        $model->scenario = "kar";

        if ($model->load(Yii::$app->request->post())) {
            
            
            
            
           //print_r($model);
            //exit();


            $model->tarikh_gharardad = Persian::convert_date_to_en(Persian::persian_digit_replace($model->tarikh_gharardad));
            // echo $model->tarikh_gharardad;


            if ($model->password) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }


            $model->code_kargozar = $model->username;

            if ($model->save()) {

//                $model->code_kargozar = $model->username;
//                $model->save();
                Yii::$app->session->setFlash('success', "ذخیره شد ");
                //echo $model->id;

                return $this->redirect(['index', 'type' => 1]);
            } else {
                if ($model->getErrors()) {
                    foreach ($model->getErrors() as $error) {
                        $msg = $msg . $error[0];
                    }
                    Yii::$app->session->setFlash('error', $msg);


                    return $this->render('kar', [
                                'model' => $model,
                    ]);
                }

//               print_r($model->getErrors());
//                exit();
            }
        } else {
            return $this->render('kar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        //print_r($_POST);



        $model = $this->findModel($id);







        $old_credit = $model->credit;
        $old_saghf_etebar = $model->saghf_etebar;
        $old_saghf_etebar_naghdi = $model->saghf_etebar_naghdi;


//       
        //echo "old: ". $old_credit;
        $model->tarikh_gharardad = Persian::convert_date_to_fa($model->tarikh_gharardad);

        if ($model->load(Yii::$app->request->post())) {
            

            if ($model->password) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }

            if ($model->tarikh_gharardad) {
                $tarikh_gharardad = $model->tarikh_gharardad;
                $tarikh_gharardad = Persian::convert_date_to_en(Persian::persian_digit_replace($tarikh_gharardad));

                $model->tarikh_gharardad = $tarikh_gharardad;
            }


//            echo $_POST['tarikh_gharardad'];
//            echo $tarikh_gharardad."<br>";
//            echo $model->tarikh_gharardad;
            $model->level_id = json_encode($model->level_id);
            $model->save(false);
//            print_r($model->getErrors());
//            exit();
            if (!$model->save(FALSE)) {
//                print_r($model->getErrors());
//                
            }
            Yii::$app->session->setFlash('success', "ذخیره شد ");
            if ($model->code_kargozar)
                return $this->redirect(['user/index', 'UserS[code_kargozar]' => $_GET['code_kargozar'], 'type' => 1]);

            return $this->redirect(['index', 'type' => 2]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'type' => 1]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIndex2() {
        $searchModel = new UserS();
        $dataProvider = $searchModel->search2();

        return $this->render('index2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
