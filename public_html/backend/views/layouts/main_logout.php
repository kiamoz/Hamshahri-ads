


<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>



<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    
   
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CalmUI Admin</title>
  <!-- plugins:css -->
  
 <link rel="stylesheet" href="vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
 <link rel="stylesheet" href="vendors/iconfonts/mdi/font/css/materialdesignicons.min.css">
<link rel="stylesheet" href="vendors/iconfonts/mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="vendors/iconfonts/ti-icons/css/themify-icons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <link rel="stylesheet" href="datejs/persian-datepicker.css"/>
   <link rel="stylesheet" href="css/aviscss.css?ver=<?= rand(1,9999) ?>">
    <link rel="stylesheet" href="css/bootstrapfix.css?ver=<?= rand(1,9999) ?>">
   <style>
        .alert {
    opacity: 1 !important;
}
        </style>
   <?php $this->head() ?>
</head>
<body class="sidebar-icon-only">
      <?php $this->beginBody() ?>


   
            <?= Alert::widget() ?>
                                  <?= $content ?>
                
           
  <!-- container-scroller -->
  <!-- plugins:js -->
   <script src="vendors/js/vendor.bundle.base.js"></script>



  
  
  <!-- plugins:js -->

  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php $this->endPage() ?>
