
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
$this->context->layout = 'main_logout';


$this->title = 'ورود';
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
                <h4>خوش آمدید</h4>
            
             
             <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="form-group">
                  <label for="exampleInputEmail">نام کاربری </label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                      <?= Html::activeTextInput($model, 'username', ['placeholder' => 'username', 'class' => 'form-control form-control-lg border-left-0']); ?>
                     
                 
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">رمز عبور</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <?= Html::activePasswordInput($model, 'password', ['placeholder' => 'username', 'class' => 'form-control form-control-lg border-left-0']); ?>                 
                  </div>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">                   
                      <?= $form->field($model, 'rememberMe')->checkbox(); ?>                     
                    </label>
                  </div>
                
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">ورود</button>
                </div>
               
             
              <?php ActiveForm::end(); ?>
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
 