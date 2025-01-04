<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\db\Query;
use common\models\Ad;
use common\models\User;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','menu','about','maket','main_maket','t'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','clear','list','editprofile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['asuser'],
                        'allow' => true,
                        'roles' => ['@'],
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
    public function beforeAction($action) {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        if ($action->id == 'login')
            $this->enableCsrfValidation = false;

 

 

 

        if (!parent::beforeAction($action)) {
            return false;
        }

 

 
        

 

        // other custom code here

 

 

 

        return true; // or false to not run the action
    }
      
    public function actionAsuser($id){
        
        $u = User::findOne($id);
        Yii::$app->user->login($u,0);
        
        return $this->redirect(['site/index']);
        
             
        
    }
    public function actionClear()
    {
        Yii::$app->cacheBackend->flush();
        Yii::$app->session->setFlash('success', 'کش با موفقت پاک شد و و در اولین رفرش توسط اولین کاربر مجدد کش ساخته خواهد شد از دیتای های جدید');
         return $this->goHome();
    }
    public function actionList($q = null, $id = null) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];


       


        if (!is_null($q)) {
            $query = new Query;
            $query
                    ->select(['CONCAT(customer.name,"(",customer.id,")") AS text', 'customer.id',])
                    //->select(['cities.name AS text', 'cities.id',])
                    ->from('customer')
                    ->Where(['like', 'customer.name', $q]);
 

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }


        return $out;
    }
    public function actionAbout($date_publish=null,$box_qty=null) {
        //$ad=new Ad;
       // echo $date_publish;
        $ad=Ad::find()->where(['date_publish'=>$date_publish,'box_qty'=>$box_qty])->all();
        //foreach ($ad as $dat){
           // echo $dat->id."<br>";
        //}
       // print_r($ad->getErrors());
       // exit();
        return $this->render('about', [
                        'ad'=>$ad,
                        'date_publish' => $date_publish,
                        'box_qty'=>$box_qty,
            ]);
                
    }
    public function actionMaket($date_publish=null,$box_id=null) {
        //$ad=new Ad;
//        echo "*";
//        exit();
//       echo $date_publish; 
//       exit();
        $ad=Ad::find()->where(['date_publish'=>$date_publish,'box_id'=>$box_id])->all();
//        foreach ($ad as $dat){
//            echo $dat->id."<br>";
//        }
//        print_r($ad->getErrors());
//        exit();
        return $this->render('maket', [
                        'ad'=>$ad,
                        'date_publish' => $date_publish,
                        'box_id'=>$box_id,  
            ]);
                
    } 
//      public function actionClear()
//    {
//          Yii::$app->cacheFrontend->flush();
//          return $this->goHome();
//    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionMain_maket()
    {
        return $this->render('main_maket');
    }
    
    
    public function actionT()
    {
        return $this->render('t');
    }
    
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    
     public function actionMenu(){
             if ($_POST) {
            $m = \common\models\Sitesetting::findOne(1);
            $m->option_value = $_POST['menu_items'];
            $m->save();
            //Yii::$app->cacheFrontend->flush();
        }

        return $this->render('menu');
     }
     
     
      public function actionRemove_from_menu($id) {

        $item_id = $id;
        if (substr($item_id, 0, 1) == "p") {

            $obj = \common\models\Post::findOne(substr($item_id, 2));
            $obj->menu_show = 0;
            $obj->save();
        } elseif (substr($item_id, 0, 1) == "c") {
            $obj = \common\models\Category::findOne(substr($item_id, 2));
            $obj->menu_show = 0;
            $obj->save();
        } else {
            $obj = \common\models\ProductCategory::findOne(substr($item_id, 2));
            $obj->menu_show = 0;
            $obj->save();
        }
    }
     
      public function actionSend(){
          $userexcel = new User;
          
      }
    
    
     public function actionEditprofile() {


        $user = \common\models\User::findOne(Yii::$app->user->identity->id);


        if ($user->load(Yii::$app->request->post())) {

            $user->setPassword($user->password);



            $user->save();
            Yii::$app->session->setFlash('success', "ذخیره شد ");
        }

        return $this->render('editprofile', [
                    'model' => $user,
        ]);
    }
    
    
    
}
