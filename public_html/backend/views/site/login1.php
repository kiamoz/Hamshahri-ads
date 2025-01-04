<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>








  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="../web/images/logo.jpg" alt="logo">
              </div>
            
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin']]); ?>
               <h3 class="text-center pad25B font-gray text-transform-upr font-size-23">HAMSHAHRI <span class="opacity-80">v1.0</span></h3>
                <div class="form-group">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="form-group">
                 <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="mt-3">
                 <button type="submit" class="btn btn-block btn-primary">ورود</button>
                </div>
              
              
               
                <?php ActiveForm::end(); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
 

  
  
  
  

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>




  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
               <img src="../web/images/logo.jpg" alt="logo">
              </div>
              <h4>Welcome back!</h4>
              <h6 class="font-weight-light">Happy to see you again!</h6>
              <form class="pt-3">
                <div class="form-group">
                  <label for="exampleInputEmail">Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Username">
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password">                        
                  </div>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="my-3">
                  <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">LOGIN</a>
                </div>
                <div class="mb-2 d-flex">
                  <button type="button" class="btn btn-facebook auth-form-btn flex-grow mr-1">
                    <i class="mdi mdi-facebook mr-2"></i>Facebook
                  </button>
                  <button type="button" class="btn btn-google auth-form-btn flex-grow ml-1">
                    <i class="mdi mdi-google mr-2"></i>Google
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register-2.html" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
 
  
  
  
  <?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<div id="loading">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<style type="text/css">

    html,body {
        height: 100%;
        background: #fff;
    }


</style>
<style>
    div#page-sidebar,#page-header {
        display: none;
    }
    #page-content {
        margin-left: 0 !important;
    }
    div#page-content {
        width: 100%;
    }
</style>




<div class="center-vertical">
    <div class="center-content row">


<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'col-md-4 col-sm-5 col-xs-11 col-lg-3 center-margin']]); ?>
        <h3 class="text-center pad25B font-gray text-transform-upr font-size-23">HAMSHAHRI <span class="opacity-80">v1.0</span></h3>
        <div id="login-form" class="content-box bg-default">
            <div class="content-box-wrapper pad20A">
                <img class="mrg25B center-margin  display-block" src="/backend/web/logo3.png" alt="">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon addon-inside bg-gray">
                            <i class="glyph-icon icon-envelope-o"></i>
                        </span>


<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>





                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon addon-inside bg-gray">
                            <i class="glyph-icon icon-unlock-alt"></i>
                        </span>
<?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Login</button>
                </div>
                <div class="row">
                    <div class="checkbox-primary col-md-6" style="height: 20px;">


                    </div>

                </div>
            </div>
        </div>



<?php ActiveForm::end(); ?>

    </div>
</div>