
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
$patchx = Yii::$app->controller->id . "/" . Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>


        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> اتوماسیون اداری  پایاب طرح | <?= Html::encode($this->title) ?></title>
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
        <link rel="shortcut icon" href="/favicon.png" />
        <link rel="stylesheet" href="datejs/persian-datepicker.min.css"/>
        <link rel="stylesheet" href="css/payab.css?ver=<?= rand(1, 9999) ?>">
        <style>
            .alert {
                opacity: 1 !important;
            }
        </style>
        <?php $this->head() ?>
    </head>


    <body class="sidebar-icon-only">


        <?php
        //echo common\models\Messages::find()->where([ 'status' => '0'])->createCommand()->getRawSql();

        $this->beginBody()
        ?>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                    <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">

                        <li class="nav-item nav-search d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="search">
                                        <i class="mdi mdi-magnify"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control"  >
                            </div>
                        </li>

                    </ul>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo" href="/"><img src="/logo-payab.png" alt="logo"/></a>

                    </div>
                    <ul class="navbar-nav navbar-nav-left">




                        <?php if (!Yii::$app->user->isGuest) { ?> 


                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">

                                    <span class="nav-profile-name"><?= Yii::$app->user->identity->name_and_fam ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                                    <a class="dropdown-item" href="<?php echo Url::to(['user/change_password']) ?>"><i class="mdi mdi-settings text-primary"></i>تغییر کلمه عبور</a>


                                    <div class="dropdown-divider"></div>
                                    <!--    <a class="dropdown-item">
                                       <!--  <i class="mdi mdi-logout text-primary"></i>-->
                                    <a class="dropdown-item" href="<?= Url::to(['/site/logout']) ?>"><i class="mdi mdi-logout text-primary"></i>خروج</a>
                                    <!--   </a>-->
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




                <?php if (!Yii::$app->user->isGuest) { ?>
                    <nav class="sidebar sidebar-offcanvas" id="sidebar">
                        <ul class="nav">








                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
                                    <i class="icon-layers"></i>
                                    <span class="menu-title">نامه ها</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="ui-advanced">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/inbox']) ?>"> کارتابل

                                                <div class="count_msg">
                                                    
                                                </div>

                                            </a></li>


                                        
                                            <li class="nav-item"> 
                                                <a class="nav-link" href="<?= Url::to(['/messagse', 'Messages_serach[status]' => 0]) ?>">نامه های پاراف نشده
                                                    
                                                </a>
                                            </li>


                                        <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/index']) ?>">لیست تمام نامه ها</a></li> 
                                        <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/my']) ?>">نامه های من</a></li>  

                                        <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/andy']) ?>">اندیکاتور امروز</a></li> 

                                        


                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/message-subscriptions/index']) ?>">پاراف</a></li>  



                                       

                                        <?php if (in_array(22, (array) unserialize(\Yii::$app->user->identity->id))) { ?>
                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/create', 'type' => 1]) ?>">ثبت نامه صادره</a></li>  

                                            <?php if (in_array(23, (array) unserialize(\Yii::$app->user->identity->id))) { ?>
                                                <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/create', 'type' => 2]) ?>">ثبت نامه وارده</a></li>
                                                <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse/reserve']) ?>">رزور نامه وارده</a></li>


                                                <?php $today = \common\models\Persian::convert_date_to_fa(date("Y-m-d")); ?>
                                                <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse', 'Messages_serach[date1]' => $today, 'Messages_serach[date2]' => $today]) ?>">نامه های امروز</a></li>

                                                <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/messagse', 'Messages_serach[status]' => 3]) ?>">نامه های چاپ نشده</a></li>

                                            <?php } ?>


                                        <?php } ?>








                                    </ul>
                                </div>
                            </li>




                            <?php if (in_array(20, (array) unserialize(\Yii::$app->user->identity->id))) { ?>




                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="collapse" href="#ui-advanced2" aria-expanded="false" aria-controls="ui-advanced">
                                        <i class="icon-chart"></i>
                                        <span class="menu-title">گزارشات</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse" id="ui-advanced2">
                                        <ul class="nav flex-column sub-menu">




                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= Url::to(['/message-has-sent/send', 'st' => 0]) ?>"> <span class="title">مراسلات  امروز</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= Url::to(['/message-has-sent/send2', 'st' => 2]) ?>"> <span class="title">مراسلات  دیجیتالی</span> 
                                                </a>
                                            </li> <li class="nav-item">
                                                <a class="nav-link" href="<?= Url::to(['/message-has-sent/send3', 'st' => 3]) ?>"> <span class="title">مراسلات  آرشیو شده</span> 
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= Url::to(['messagse/andy']) ?>"> <span class="title">دفتر اندی کاتور</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= Url::to(['messagse/index', 'Messages_serach[status]' => 3]) ?>"> <span class="title">نامه های امضا نشده</span> 
                                                </a>
                                            </li>



                                        </ul>
                                    </div>
                                </li>

                            <?php } ?>





                            <?php if (empty(array_diff(array(31), (array) unserialize(\Yii::$app->user->identity->id)))) { ?>





                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="collapse" href="#ui-advanced3" aria-expanded="false" aria-controls="ui-advanced">
                                        <i class="icon-people"></i>
                                        <span class="menu-title">افراد/سازمان/پروژه ها</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse" id="ui-advanced3">
                                        <ul class="nav flex-column sub-menu">





                                            <?php if (in_array(31, (array) unserialize(\Yii::$app->user->identity->id))) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="<?= Url::to(['contacts/index', 'page' => 1]) ?>"> <span class="title">سازمان و افراد خارجی</span> 
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" href="<?= Url::to(['/message-copy', 'page' => 1]) ?>"> <span class="title">رونوشت ها</span> 
                                                    </a>
                                                </li>
                                            <?php } ?>



                                            <?php if (in_array(41, (array) unserialize(\Yii::$app->user->identity->id))) { ?>

                                                <li class="nav-item">
                                                    <a class="nav-link" href="<?= Url::to(['/projects']) ?>"> <span class="title">پروژه ها</span> 
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="<?= Url::to(['/soennecken']) ?>"> <span class="title">بایگانی</span> 
                                                    </a>
                                                </li>



                                            <?php } ?>



                                        </ul>
                                    </div>
                                </li>





                            <?php } ?>


                            <?php if (in_array(10, (array) unserialize(\Yii::$app->user->identity->id))) { ?>




                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="collapse" href="#ui-advanced5" aria-expanded="false" aria-controls="ui-advanced">
                                        <i class=" icon-envelope-letter"></i>
                                        <span class="menu-title">ایمیل ها</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse" id="ui-advanced5">
                                        <ul class="nav flex-column sub-menu">




                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= Url::to(['/email']) ?>"> <span class="title">ایمیل اداری</span> 
                                                </a>
                                            </li>




                                        </ul>
                                    </div>
                                </li>

                            <?php } ?>




                            <?php if (in_array(27, (array) unserialize(\Yii::$app->user->identity->id))) { ?>


                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="collapse" href="#ui-advanced4" aria-expanded="false" aria-controls="ui-advanced">
                                        <i class="icon-user"></i>
                                        <span class="menu-title">کاربران</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse" id="ui-advanced4">
                                        <ul class="nav flex-column sub-menu">

                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/user/index']) ?>">کاربران سیستم</a></li>  
                                            <li class="nav-item"> <a class="nav-link" href="<?= Url::to(['/user/index_bot']) ?>">کاربران بات</a></li>  





                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>


                        </ul>
                    </nav>

                <?php } ?>
                <!-- partial -->

            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->

        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<?php $this->endBody() ?> 


<script src="vendors/js/vendor.bundle.base.js?ver=7"></script>

<!-- plugins:js -->

<script src="vendors/js/vendor.bundle.addons.js?ver=2139"></script>

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
<script src="js/dashboard.js?ver=<?= rand(1, 22222); ?>"></script>

<script src="/datejs/persian-date.min.js"></script>
<script src="/datejs/persian-datepicker.min.js"></script>
<script type='text/javascript' src='/js.js?ver=<?= rand(1, 22222); ?>'></script>
<script>



<?php if ($patchx == 'messagse/inbox' or $patchx == 'messagse/index') { ?>
        var date2 = '<?= $_GET['Messages_serach']['date2'] ?>';

        $('.example1').persianDatepicker({
 calendar:{
        persian: {
            leapYearMode: 'astronomical'
        }
    },


            initialValue: false,
            initialValueType: "persian",
            calendarType: "persian",
            format: 'YYYY/MM/DD',
            persianDigit: false,
        }
        );


        //$('.first_date').after($('<input value="' + date2 + '" name="' + $('.first_date').attr('data-name') + '" class="example1 form-control"  autocomplete="off" />')).ready(function () {


        //});


<?php } ?>


<?php if ($patchx == 'messagse/create' or $patchx == 'messagse/update') { ?>
        $('.example1').persianDatepicker({
 calendar:{
        persian: {
            leapYearMode: 'astronomical'
        }
    },

           
            initialValueType: "persian",
            calendarType: "persian",

            format: 'YYYY/MM/DD',

        }
        );
<?php } ?>


    $('.inline-example').persianDatepicker({
 calendar:{
        persian: {
            leapYearMode: 'astronomical'
        }
    },

        inline: true,
        altField: '#inlineExampleAlt',
        altFormat: 'LLLL',
        toolbox: {
            calendarSwitch: {
                enabled: true
            }
        },
        navigator: {
            scroll: {
                enabled: false
            }
        },
        //maxDate: new persianDate().add('month', 3).valueOf(),
        //minDate: new persianDate().subtract('month', 3).valueOf(),

    });
</script>



<script src="upload_js/jquery.dm-uploader.min.js"></script>
<script src="upload_js/demo-ui.js"></script>

<script>
    $(function () {

        if ($('#drag-and-drop-zone').length > 0) {


            function remove_from_gallery(content) {
                var gall = $('#gallery_area').val();
                gall = gall.replace(content, '');
                $('#gallery_area').val(gall);
            }


            $('.removex').click(function () {
                remove_from_gallery($(this).attr('title'));
                $(this).parent().parent().parent().parent().hide();
            });

            $('#drag-and-drop-zone').dmUploader({//
                url: 'new_storage/upload.php',
                maxFileSize: 30000000, // 3 Megs 
                onDragEnter: function () {
                    // Happens when dragging something over the DnD area
                    this.addClass('active');
                },
                onDragLeave: function () {
                    // Happens when dragging something OUT of the DnD area
                    this.removeClass('active');
                },
                onInit: function () {
                    // Plugin is ready to use
                    ui_add_log('Penguin initialized :)', 'info');
                },
                onComplete: function () {
                    // All files in the queue are processed (success or error)
                    ui_add_log('All pending tranfers finished');
                },
                onNewFile: function (id, file) {
                    // When a new file is added using the file selector or the DnD area
                    ui_add_log('New file added #' + id);
                    ui_multi_add_file(id, file);
                },
                onBeforeUpload: function (id) {
                    // about tho start uploading a file
                    console.log('Starting the upload of #' + id);
                    ui_add_log('Starting the upload of #' + id);
                    ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                    ui_multi_update_file_progress(id, 0, '', true);
                },
                onUploadCanceled: function (id) {
                    // Happens when a file is directly canceled by the user.
                    ui_multi_update_file_status(id, 'warning', 'Canceled by User');
                    ui_multi_update_file_progress(id, 0, 'warning', false);
                },
                onUploadProgress: function (id, percent) {
                    // Updating file progress
                    ui_multi_update_file_progress(id, percent);
                },
                onUploadSuccess: function (id, data) {


                    var pathx = "new_storage/" + data.path;
                    $('#gallery_area').val($('#gallery_area').val() + "\n" + pathx);


                    var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + pathx + "' class='kv-preview-data file-preview-image'  style='width:auto;height:160px;'></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'><i class='glyphicon glyphicon-trash text-danger'></i></button></div></div></div></div>";


                    $('#gallery-box').append(strm);
                    //alert(strm);

                    $('.removex').click(function () {
                        remove_from_gallery($(this).attr('title'));
                        $(this).parent().parent().parent().parent().hide();
                    });



                    console.log(data.path);
                    // A file was successfully uploaded



                    ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
                    ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
                    ui_multi_update_file_status(id, 'success', 'Upload Complete');
                    ui_multi_update_file_progress(id, 100, 'success', false);
                },
                onUploadError: function (id, xhr, status, message) {
                    console.log(message);
                    ui_multi_update_file_status(id, 'danger', message);
                    ui_multi_update_file_progress(id, 0, 'danger', false);
                },
                onFallbackMode: function () {
                    // When the browser doesn't support this plugin :(
                    ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
                },
                onFileSizeError: function (file) {
                    ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
                }
            });

        }
    });

</script>

</script>

<!-- End custom js for this page-->
</body>

</html>
<?php $this->endPage() ?>
