<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\models\User;
use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Category;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <!--  date picker-->


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> همشهری | <?= Html::encode($this->title) ?></title>


    <!--image editor-->
    <link rel="stylesheet" href="assets/layout.css">
    <link rel="stylesheet" href="dist/taggd.css">
    <link rel="stylesheet" href="themes/taggd-classic.css">


    <!-- plugins:css -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
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
    <link rel="shortcut icon" href="/hamlogo.jpg">
    <link rel="stylesheet" href="datejs/persian-datepicker.css" />
    <link rel="stylesheet" href="css/aviscss.css?ver=<?= rand(1, 9999) ?>">
    <link rel="stylesheet" href="css/bootstrapfix.css?ver=<?= rand(1, 9999) ?>">



    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/accordion-ui/accordion.css">

    <style>
        .alert {
            opacity: 1 !important;
        }

        span.menu-title {
            text-align: right;
            width: 100%;
        }

        element.style {}

        ul#w0-cols-list input[type="checkbox"] {
            float: right !important;
            display: block;
        }
    </style>

    <?php $this->head() ?>
</head>

<body class="dd">
    <?php // echo Yii::$app->user->identity->id;
    ?>
    <?php //print_r (json_decode(Yii::$app->user->identity->level_id));
    ?>
    <?php $this->beginBody() ?>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">


                </ul>
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="/backend/web/"><img src="images/logo.jpg" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="/backeend/web/"><img src="images/logo-mini.svg" alt="logo" /></a>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                    <?php
                    $user_id = Yii::$app->user->identity->id;
                    // echo $user_id;
                    // $task1=\common\models\Task::find()->where(['user_id' => $user_id])->andwhere(['status' => 0])->all();
                    // $adt=\common\models\Ad::find()->where(['active_user_id' => $user_id])->all();
                    $adt = \common\models\Task::find()->where(['user_id' => $user_id, 'status' => 0])->orderBy(['id' => SORT_DESC])->all();
                    //  $count = count ( $task1 );

                    $count = count($adt);
                    ?>
                    <!--<li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-bell-outline mx-0"></i>
                                <span class="count"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" style="overflow:scroll" aria-labelledby="notificationDropdown">
                                <a class="dropdown-item">
                                    <p class="mb-0 font-weight-normal float-left">شما <?php echo $count ?> اعلان دارید
                                    </p>
                                    <span class="badge badge-pill badge-warning float-right">مشاهده همه</span>
                                </a>
                        <?php // foreach($task1 as $t){   
                        ?> <?php foreach ($adt as $t) { ?>

                                                                                                                                                                                                                                                                                                <div class="dropdown-divider"></div>
                                                                                                                                                                                                                                                                                                <a class="dropdown-item preview-item" href="<?= Url::to(['/ad/view', 'id' => $t->model_id]) ?>">
                                                                                                                                                                                                                                                                                                    <div class="preview-thumbnail">
                                                                                                                                                                                                                                                                                                        <div class="preview-icon bg-success">

                                                                                                                                                                                                                                                                                                            <i class="mdi mdi-information mx-0"></i>
                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <div class="preview-item-content">
                                                                                                                                                                                                                                                                                                        <h6 class="preview-subject font-weight-medium">
                            <?php $this_ad = \common\models\Ad::findOne($t->model_id); ?> 
                            <?= \common\models\Ad::status_text[$this_ad->status]; ?>
                                                                                                                                                                                                                                                                                                        </h6>
                                                                                                                                                                                                                                                                                                        <p class="font-weight-light small-text mb-0">
                            <?= $this_ad->title; ?>
                                                                                                                                                                                                                                                                                                        </p>
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                <div class="dropdown-divider"></div>
                        <?php } ?>
                            </div>
                        </li>   -->



                    <?php if (!Yii::$app->user->isGuest) { ?>


                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                <?php
                                $userr = Yii::$app->user->identity->id;
                                $find = common\models\User::find()->where(['id' => $userr])->one();
                                ?>
                                <span class="nav-profile-name"><?= $find->name_and_fam; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                                <a class="dropdown-item" href="<?= Url::to(['/site/editprofile', 'id' => Yii::$app->user->identity->id]) ?>"><i class="mdi mdi-settings text-primary"></i>تغییر کلمه عبور</a>


                                <div class="dropdown-divider"></div>
                                <!-- <a class="dropdown-item">
                                      <i class="mdi mdi-logout text-primary"></i>-->
                                <a class="dropdown-item" href="<?= Url::to(['/site/logout']) ?>"><i class="mdi mdi-logout text-primary"></i>خروج</a>
                                </a>
                            </div>
                        </li>



                        <li class="nav-item nav-toggler-item">
                            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                                <span class="mdi mdi-menu"></span>
                            </button>
                        </li>
                    <?php } ?>
                    <li class="nav-item nav-toggler-item-right d-lg-none">
                        <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">


            </div>

            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <div class="main-panel">
                <div class="content-wrapper">


                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
            <?php if (!Yii::$app->user->isGuest) {

                $today = \common\models\Persian::convert_date_to_fa(date("Y-m-d"));

            ?>
                <nav class="sidebar sidebar-offcanvas" id="sidebar" style="display:block !important;direction: rtl;">
                    <ul class="nav" style="display:block !important;padding-inline-end: 0 !important;padding-inline-start: 0 !important;">

                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
                                <i class="fa fa-window-restore" style="margin-left:7px;"></i>
                                <span class="menu-title">تنظیمات</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-advanced">
                                <ul class="nav flex-column sub-menu">


                                    <?php if (in_array(1, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/invoice-type']) ?>">لیست مدل فاکتور ها</a></li>


                                    <?php if (in_array(1, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/vat-year']) ?>">VAT</a></li>


                                    <?php if (in_array(4, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>

                                    <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/box']) ?>">لیست تعرفه ها</a></li>
                                    <?php if (in_array(8, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/ad-type']) ?>">لیست درآمد ها</a></li>
                                    <?php if (in_array(12, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/discount-item']) ?>">لیست تخفیف و کارمزد</a></li>


                                </ul>
                            </div>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#form-elements1" aria-expanded="false" aria-controls="ui-advanced">
                                <i class="fas fa-user-tie" style="font-size: 15px; margin-left:7px;"></i>
                                <span class="menu-title">کاربران</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="form-elements1">
                                <ul class="nav flex-column sub-menu">

                                    <?php if (in_array(13, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/user/index_user', 'type' => 2]) ?>">لیست کاربران سیستم</a></li>
                                    <?php if (in_array(16, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/user/index', 'type' => 1]) ?>">لیست کارگزاران </a></li>
                                    <?php if (in_array(20, (array) json_decode(Yii::$app->user->identity->level_id)))  ?>
                                    <li class="nav-item"> <a class="nav-link" href="<?php echo Url::to(['/customer', 'lvl' => 8]) ?>">لیست مشتریان</a></li>



                                </ul>
                            </div>
                        </li>












                        <?php if (in_array(100, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#editors5" aria-expanded="false" aria-controls="editors">
                                    <i class="fas fa-exchange-alt" style="font-size: 15px; margin-left:7px;"></i>
                                    <span class="menu-title">بخش مالی</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="editors5">
                                    <ul class="nav flex-column sub-menu">



                                        <?php if (22 > 33) { ?>
                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/ad/resseler_index']) ?>">گزارش کارگزاران</a></li>

                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/ad/debt_index']) ?>">گزارش بدهی و درآمد</a></li>
                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/ad/main_index']) ?>">گزارش اصلی</a></li>
                                        <?php } ?>


                                        <?php if (in_array(101, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
                                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['transition/index']) ?>">لیست گردش های مالی </a></li>
                                        <?php } ?>
                                        <?php if (in_array(102, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
                                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['transition/create']) ?>">ثبت گردش مالی</a></li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </li>
                        <?php } ?>


                        <?php if (in_array(23, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/ad/index1']) ?>">تمام آگهی ها</a></li>
                        <?php }


                        ?>
                        <?php if (in_array(104, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/ad/index2', 'AdSearch[date1]' => $today, 'AdSearch[date2]' => $today]) ?>">روکش روز</a></li>
                        <?php } ?>
                        <?php if (in_array(105, (array) json_decode(Yii::$app->user->identity->level_id))) { ?>
                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/ad/index3']) ?>">گزارش فصلی</a></li>
                        <?php } ?>


                    </ul>
                </nav>

            <?php } ?>
            <!-- partial -->

        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
        </div>
    </footer>
    <!-- partial -->

    <!-- container-scroller -->
    <!--  date picker-->

    <?php $this->endBody() ?>

    <link rel="stylesheet" href="../web/datejs/persian-datepicker.css" />
    <script src="../web/datejs/persian-date.js"></script>
    <script src="../web/datejs/persian-datepicker.js"></script>
    <script src="vendors/js/vendor.bundle.base.js?ver=2"></script>
    <!-- plugins:js -->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>

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

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/nouislider/nouislider.min.css">
    <link rel="stylesheet" href="vendors/ion-rangeslider/css/ion.rangeSlider.css">
    <!-- End plugin css for this page -->

    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <script type="text/javascript" src="/jquery.maskMoney.min.js?ver=2"></script>
    <script type="text/javascript" src="/js.js?ver=<?= rand(1, 22222999999) ?>"></script>
    <script type="text/javascript" src="/chart.js?ver=<?= rand(1, 222999999) ?>"></script>
    <script>
        $('.maskm').maskMoney({
            precision: '0',
            allowNegative: true
        });
    </script>
    <!--jquery-->


    <script>
        jQuery("document").ready(function() {
            setTimeout(function() {
                $('.collapse').removeClass('show');

            }, 50);
        });



        var old_href = ''

        $('input[type=radio][name=cond]').change(function() {

            var that = $(this);

            $(".reject_btn").each(function(index) {

                var _href = $(this).attr("href");



                if (!$(this).attr('data-old')) {
                    $(this).attr('data-old', _href);
                }



                $(this).attr("href", $(this).attr('data-old') + '&' + that.val());


            });





        });




        $(document).ready(function() {
            $("#user-tarikh_gharardad,.dd-date").persianDatepicker({
                calendar: {
                    persian: {
                        leapYearMode: 'astronomical'
                    }
                },


                initialValue: false,
                initialValueType: "persian",
                calendarType: "persian",
                format: 'YYYY/MM/DD',
                persianDigit: false,
                autoClose: true
                // minDate: new persianDate().valueOf(),
            });
        });
    </script>
    <?php $patchx = Yii::$app->controller->id . "/" . Yii::$app->controller->action->id; ?>

    <script>
        <?php if ($patchx == 'ad/index1' or $patchx == 'ad/index2' or $patchx == 'ad/index3') { ?>
            var date2 = '<?= $_GET['AdSearch']['date2'] ?>';

            $('.first_date').after($('<input value="' + date2 + '" name="' + $('.first_date').attr('data-name') + '" class="example1 form-control"  autocomplete="off" />')).ready(function() {

                $('.example1').persianDatepicker({
                    calendar: {
                        persian: {
                            leapYearMode: 'astronomical'
                        }
                    },


                    initialValue: false,
                    initialValueType: "persian",
                    calendarType: "persian",
                    format: 'YYYY/MM/DD',
                    persianDigit: false,
                    autoClose: true,
                });
            });

        <?php } ?>
        <?php if ($patchx == 'transition/index') { ?>
            var date2 = '<?= $_GET['Transitionsearch']['date2'] ?>';

            $('.first_date').after($('<input value="' + date2 + '" name="' + $('.first_date').attr('data-name') + '" class="example1 form-control"  autocomplete="off" />')).ready(function() {

                $('.example1').persianDatepicker({
                    calendar: {
                        persian: {
                            leapYearMode: 'astronomical'
                        }
                    },


                    initialValue: false,
                    initialValueType: "persian",
                    calendarType: "persian",
                    format: 'YYYY/MM/DD',
                    persianDigit: false,
                    autoClose: true,
                });
            });

        <?php } ?>


        $('#transition-user_id').on('select2:select', function(evt) {


            // اضافه کردن به select2 city
            console.log("hi1");


            var sid = evt.params.data.id; // id اون استانی که انتخاب شده
            //alert(sid);

            $.ajax({
                type: 'GET',
                url: 'index.php?r=transition/unpaid&id=' + sid, // آیدی رو می فرسته به این اکشن تا اسم شهرارو پیدا کنه

                crossDomain: true,
                success: function(output) { // اضافه کردن اسم شهر ها به  select2 دوم با شرط sateid



                    //console.log(output);
                    n = "";

                    $.each(output, function(key, value) {

                        n += "<option value='" + key + "'>" + value + "</option>";
                    });

                    console.log(n);


                    $('#transition-priority_id').find('option').remove();
                    $('#transition-priority_id').append(n);


                },
                error: function(xhr, status, error) {


                    //alert(error);
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });

        });
    </script>

    <script src="/backend/web/upload_js/jquery.dm-uploader.min.js"></script>
    <script src="/backend/web/upload_js/demo-ui.js"></script>
    <script>
        jQuery(function($) {


            $(document).ready(function() {
                var ptt = [];
                $(function() {

                    if ($('#drag-and-drop-zone-update').length > 0) {


                        function remove_from_gallery(content) {
                            var gall = $('#gallery_area_update').val();
                            gall = gall.replace(content, '');
                            $('#gallery_area_update').val(gall);
                        }


                        $('.removex').click(function() {
                            remove_from_gallery($(this).attr('title'));
                            $(this).parent().parent().parent().parent().hide();
                        });



                        $('#drag-and-drop-zone-update').dmUploader({ //
                            url: "https://hamshahriads.ir/backend/web/index.php?r=ad/uploadx",
                            maxFileSize: 30000000, // 3 Megs 
                            onDragEnter: function() {
                                // Happens when dragging something over the DnD area
                                this.addClass('active');
                            },
                            onDragLeave: function() {
                                // Happens when dragging something OUT of the DnD area
                                this.removeClass('active');
                            },
                            onInit: function() {
                                // Plugin is ready to use
                                ui_add_log('Penguin initialized :)', 'info');
                            },
                            onComplete: function() {
                                // All files in the queue are processed (success or error)
                                ui_add_log('All pending tranfers finished');
                            },
                            onNewFile: function(id, file) {
                                // When a new file is added using the file selector or the DnD area
                                ui_add_log('New file added #' + id);
                                ui_multi_add_file(id, file);
                            },
                            onBeforeUpload: function(id) {
                                // about tho start uploading a file
                                ui_add_log('Starting the upload of #' + id);
                                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                                ui_multi_update_file_progress(id, 0, '', true);
                            },
                            onUploadCanceled: function(id) {
                                // Happens when a file is directly canceled by the user.
                                ui_multi_update_file_status(id, 'warning', 'Canceled by User');
                                ui_multi_update_file_progress(id, 0, 'warning', false);
                            },
                            onUploadProgress: function(id, percent) {
                                // Updating file progress
                                ui_multi_update_file_progress(id, percent);
                            },
                            onUploadSuccess: function(id, data) {

                                ptt.push(data.path);
                                //                            console.log(ptt);
                                var pathx = "/backend/web/" + data.path;
                                $('#dataa').append(data.path + ',');
                                $('#gallery_area_update').val($('#gallery_area_update').val() + "\n" + pathx);

                                console.log(data.path);
                                var extension = data.path.split('.').pop();
                                console.log(extension);
                                if (extension == 'jpg' || extension == 'jpeg' || extension == 'png') {
                                    var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + pathx + "' class='kv-preview-data file-preview-image'  style='width:auto;height:160px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";
                                } else if (extension == 'xlsx') {
                                    var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + '/backend/web/upload_js/xlxxx.png' + "' class='kv-preview-data file-preview-image'  style='width:auto;height:50px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";
                                } else if (extension == 'doc' || extension == 'docx') {
                                    var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + '/backend/web/upload_js/worddd.png' + "' class='kv-preview-data file-preview-image'  style='width:auto;height:50px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";
                                } else if (extension == 'pdf') {
                                    var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + '/backend/web/upload_js/pdfs.png' + "' class='kv-preview-data file-preview-image'  style='width:auto;height:50px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";
                                } else if (extension == 'tif' || extension == 'TIF' || extension == 'Tif' || extension == 'Tiff' || extension == 'tiff') {
                                    var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + pathx + "' type='image/tiff' negative=yes class='kv-preview-data file-preview-image'  style='width:auto;height:160px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";
                                }
                                $('#gallery-box-update').append(strm);
                                //alert(strm);
                                console.log(strm);


                                $('.removex').click(function() {
                                    remove_from_gallery($(this).attr('title'));
                                    $(this).parent().parent().parent().parent().hide();
                                });



                                //                            console.log(data.path);
                                // A file was successfully uploaded



                                ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
                                ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
                                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                                ui_multi_update_file_progress(id, 100, 'success', false);
                            },
                            onUploadError: function(id, xhr, status, message) {
                                ui_multi_update_file_status(id, 'danger', message);
                                ui_multi_update_file_progress(id, 0, 'danger', false);
                            },
                            onFallbackMode: function() {
                                // When the browser doesn't support this plugin :(
                                ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
                            },
                            onFileSizeError: function(file) {
                                ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
                            }
                        });

                    }
                });







            });
        });
    </script>



    <link rel="stylesheet" href="vendors/nouislider/nouislider.min.css">
    <link rel="stylesheet" href="vendors/ion-rangeslider/css/ion.rangeSlider.css">
    <script src="vendors/nouislider/nouislider.min.js"></script>
    <script src="vendors/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

    <!-- End custom js for this page-->
</body>

</html>
<?php $this->endPage() ?>


<script>
    $(function() {



        $('.div1').css('width', $("#w0-container")[0].scrollWidth + "px");

        $(".wrapper1").scroll(function() {
            $("#w0-container")
                .scrollLeft($(".wrapper1").scrollLeft());
        });
        $("#w0-container").scroll(function() {
            $(".wrapper1")
                .scrollLeft($("#w0-container").scrollLeft());
        });
    });
</script>