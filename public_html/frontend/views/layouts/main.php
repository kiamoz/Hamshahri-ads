<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use common\models\Category;
use common\models\Post;
use common\models\Sitesetting;
use common\models\Order;
use common\models\User;

//$sitesetting = Sitesetting::findone(1);
$site_base = dirname(dirname(dirname(dirname(__FILE__)))) . "/backend/web/";
?>
<!DOCTYPE html>
<?php
$this->beginPage();
$patchx = Yii::$app->controller->id . "/" . Yii::$app->controller->action->id;
?>
<?php //echo Yii::$app->user->identity->lvl?>
<head>
    <style>


        .dropbtn {
            /*background-color: #4CAF50;*/
            color: white;
            padding: 5.5px;

            border: none;
            border-radius:3px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
            margin-right:1%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;
                                           float: left;
        }

        .dropdown:hover .dropbtn {/*background-color: #3e8e41;*/}

    </style>


    <!--  date picker-->




    <link href="../../backend/web/upload_js/jquery.dm-uploader.min.css" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/iconfonts/mdi/font/css/materialdesignicons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?= $sitesetting->title . " آگهی همشهری | " . Html::encode($this->title) ?></title>


    <?php
    if ($this->params['desc']) {
        $desc = $this->params['desc'];
    } else {
        $desc = $sitesetting->description;
    }
    ?>

    <meta content="<?= strip_tags($desc) ?>" name="description"/>



    <link rel="shortcut icon" href="/hamlogo.jpg">



    <!-- HELPERS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/animate.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/backgrounds.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/boilerplate.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/border-radius.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/grid.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/page-transitions.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/spacing.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/typography.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/utils.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/colors.css">

    <!-- ELEMENTS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/badges.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/buttons.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/content-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/dashboard-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/forms.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/images.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/info-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/invoice.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/loading-indicators.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/menus.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/panel-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/response-messages.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/responsive-tables.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/ribbon.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/social-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/tables.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/tile-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/elements/timeline.css">

    <!-- FRONTEND ELEMENTS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/blog.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/cta-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/feature-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/footer.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/hero-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/icon-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/portfolio-navigation.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/pricing-table.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/sliders.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/frontend-elements/testimonial-box.css">

    <!-- ICONS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/icons/fontawesome/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/icons/linecons/linecons.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/icons/spinnericon/spinnericon.css">

    <!-- WIDGETS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/accordion-ui/accordion.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/calendar/calendar.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/carousel/carousel.css">

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/charts/justgage/justgage.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/charts/morris/morris.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/charts/piegage/piegage.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/charts/xcharts/xcharts.css">

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/chosen/chosen.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/colorpicker/colorpicker.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/datatable/datatable.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/datepicker/datepicker.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/datepicker-ui/datepicker.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/dialog/dialog.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/dropdown/dropdown.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/dropzone/dropzone.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/file-input/fileinput.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/input-switch/inputswitch.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/input-switch/inputswitch-alt.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/ionrangeslider/ionrangeslider.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/jcrop/jcrop.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/jgrowl-notifications/jgrowl.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/loading-bar/loadingbar.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/maps/vector-maps/vectormaps.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/markdown/markdown.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/modal/modal.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/multi-select/multiselect.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/multi-upload/fileupload.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/nestable/nestable.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/noty-notifications/noty.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/popover/popover.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/pretty-photo/prettyphoto.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/progressbar/progressbar.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/range-slider/rangeslider.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/slider-ui/slider.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/summernote-wysiwyg/summernote-wysiwyg.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/tabs-ui/tabs.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/theme-switcher/themeswitcher.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/timepicker/timepicker.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/tocify/tocify.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/tooltip/tooltip.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/touchspin/touchspin.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/uniform/uniform.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/wizard/wizard.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/xeditable/xeditable.css">

    <!-- FRONTEND WIDGETS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/layerslider/layerslider.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/owlcarousel/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/widgets/fullpage/fullpage.css">

    <!-- SNIPPETS -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/chat.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/files-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/login-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/notification-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/progress-box.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/todo.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/user-profile.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/snippets/mobile-navigation.css">

    <!-- Frontend theme -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/themes/frontend/layout.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/themes/frontend/color-schemes/default.css">

    <!-- Components theme -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/themes/components/default.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/themes/components/border-radius.css">

    <!-- Frontend responsive -->

    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/responsive-elements.css">
    <link rel="stylesheet" type="text/css" href="../../backend/web/theme/helpers/frontend-responsive.css">

    <!-- JS Core --> 

    <script type="text/javascript" src="../../backend/web/theme/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/transition.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/modernizr.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-core/jquery-cookie.js"></script>


    <link rel="stylesheet" type="text/css" href="/css/rtl.css?ver=<?= rand(1, 2000); ?>">

    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>

<style>

    .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11{
        float: right;
    }

    #page-container {  position: relative;  min-height: 100vh;}
    #page-wrapper {  padding-bottom: 20.5rem;    /* Footer height */}

    #footer {  position: absolute !important;  bottom: 0;  width: 100%;  height: 20.5rem;            /* Footer height */}







    /******* select2 RTL  by kiamoz  ***********/

    input.select2-search__field, li.select2-search.select2-search--inline {
        width: 100% !important;
    }

    ul#select2-user-tahsilat-results,.span#select2-user-tahsilat-container {
        text-align: right;
    }
    span.select2-selection__clear {
        left: 13px;
        right: unset !important;
        position: absolute;
    }
    .select2-selection span ,.select2-results__options li,.select2-search__field{
        font-family: tahoma;
        direction: rtl;
    }
    .select2-container{
        text-align: right;
    }
    .select2-container .select2-search--inline {
        float: right;
    }
    li.select2-selection__choice {
        direction: rtl;
    }
    .select2-selection__clear {
        color: red !important;
        opacity: 1 !important;
    }
    #attach_x + span {
        display: none;
    }
    .select2-container--krajee .select2-search--dropdown .select2-search__field{
        padding-right: 30px;
    }
    /******* select2 RTL  by kiamoz  ***********/

    th, td {
        text-align: right !important;
        direction: rtl;
    }



</style>

<body>

    <div id="page-container">

        <div id="page-wrapper"><div class="top-bar bg-topbar">
                <div class="container">

                    <div class="float-left">

                        <a href="<?= Url::to(['/site/logout']) ?>" title=" " class="btn btn-sm float-left btn-alt btn-hover mrg10R btn-default">
                            <span>خروج <?= Yii::$app->user->identity->name_and_fam . " " . Yii::$app->user->identity->code_kargozar ?></span>
                            <i class="glyph-icon icon-arrow-right"></i>
                             <?= " <span> " . User::findOne($_GET['p_id'])->name_and_fam . "</span>"; ?> 
                        </a>
                       
                    </div>
                    <a href="<?= Url::to(['site/new_order', 'force_new' => 1]) ?>" title=" " class="hide-h btn btn-sm float-right btn-alt mrg10R btn-default">
                        <span>ثبت آگهی جدید </span>
                    </a>
                    <div class="float-right user-account-btn dropdown">



                        <a href="#" title="My Account" class="user-profile clearfix hide-h" data-toggle="dropdown" aria-expanded="false">
                            <img style="display: block; height: 25px; width: 25px; margin-top: 2px;" src="/hamlogo.jpg"  />

                        </a>




                    </div>
                    <?php
//                    $user_id = Yii::$app->user->identity->id;
//                    $model_ad = \common\models\Ad::find()->where(['resseler_id' => $user_id])->andwhere(['status' => 8])->andWhere(['is', 'document', null])->all();
//                      $count = count($model_ad);
                    // echo  $model_ad->createCommand()->getRawSql();

                    $user_id = Yii::$app->user->identity->id;
                    $model_task = \common\models\Task::find()->where(['user_id' => $user_id])->andwhere(['status' => 0])->orderBy(['id' => SORT_DESC])->all();
                    $count = count($model_task);

                    ///// temp code
//                    $tmp = common\models\Ad::find()->where(['active_user_id' => $user_id])->andwhere(['status' => 8])->all();                   
                    ?>

                    <div class="dropdown hide-h">
                        <button style="background-color:rgb(210,35,42); text-align:center;" class="dropbtn p-0"><i class=""><span style="text-align:center; font-weight:bold;"><?php echo $count ?></span></i></button>
                        <div class="dropdown-content">
                            <p class="" style="text-align: center; padding-top:4px; padding-bottom:4px;">شما <?php echo $count ?> اعلان دارید
                            </p>
                            <?php
                            foreach ($model_task as $task) {
                                $get_customer = common\models\Ad::find()->where(['id' => $task->model_id])->one();

                                if ($task->model == 'customer') {
                                    ?>
                                    <a style="background-color:rgb(52,152,219);color:black;border-bottom: 1px solid gray;" href="<?= Url::to(['/customer/view', 'id' => $get_customer->customer_id, 'task_id' => $task->id]) ?>" >  <?= \common\models\Ad::findOne($task->model_id)->title . ' (' . \common\models\Task::limitword($task->subject, 14) . '..)' ?></a>

                                <?php } if ($task->model == 'ad') { ?>
                                    <a style="background-color:rgb(210,35,42); color:black; border-bottom: 1px solid gray;" href="<?= Url::to(['/ad/view', 'id' => $task->model_id, 'task_id' => $task->id]) ?>" >       <?= \common\models\Ad::findOne($task->model_id)->title . ' (' . \common\models\Task::limitword($task->subject, 14) . '..)' ?> </a> 

                                <?php }if ($task->model == 'dabiri') {
                                    ?>
                                    <a style="background-color:rgba(163,73,164,.4); color:black; border-bottom: 1px solid gray;" href="<?= Url::to(['/ad/rej', 'id' => $task->model_id, 'task_id' => $task->id]) ?>" >       <?= \common\models\Ad::findOne($task->model_id)->title . ' (' . \common\models\Task::limitword($task->subject, 14) . '..)' ?> </a> 
                                <?php }
                                ?>                           




                            <?php } ?>
                        </div>
                    </div> 
                    <a href="<?= Url::to(['site/index']) ?>" title=" " class="btn btn-sm float-right btn-alt mrg10R btn-default hide-h">
                        <span>صفحه اول </span>
                    </a>
                </div><!-- .container -->


            </div><!-- .top-bar -->




            <div id="page-content" class="col-md-12 center-margin frontend-components mrg25T">
                <div class="row">
                    <div class="col-md-2" id="menu" style="display: none;">
                        <div id="accordion" class="panel-group">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" class="display-block" href="#Elements">
                                            آگهی ها
                                            <i class="glyph-icon icon-angle-left float-left"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="Elements" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav">
                                            <li><a href="<?= Url::to(['/ad']) ?>"title="Buttons"><span>لیست آگهی ها </span></a></li>
                                            <li><a href="<?= Url::to(['site/new_order', 'force_new' => 1]) ?>" title="Labels &amp; Badges"><span>ثبت آگهی جدید</span></a></li>



                                            <?php
                                            $user_online = Yii::$app->user->identity->id;
                                            $userr = User::findOne($user_online);
                                            if ($userr->lvl == 8)
                                                
                                                ?>
<!--                                            <li><a href="<?= Url::to(['customer/create']) ?>" title="Labels &amp; Badges"><span>ثبت مشتری</span></a></li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" class="display-block" href="#Elements2">
                                            مالی
                                            <i class="glyph-icon icon-angle-left float-left"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="Elements2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav">

                                            <li><a href="<?= Url::to(['site/notpaid']) ?>" title="Labels &amp; Badges"><span>کارمزد های وصول نشده</span></a></li>
<!--                                            <li><a href="<?= Url::to(['site/paid']) ?>" title="Buttons"><span>کارمزد های وصول شده</span></a></li>-->
<!--                                            <li><a href="<?= Url::to(['site/paidmali']) ?>" title="Labels &amp; Badges"><span>کارمزد های تسویه شده</span></a></li>-->
                                          
<!--                                            <li><a href="<?= Url::to(['transition/create']) ?>" title="Labels &amp; Badges"><span>افزودن وجه آنلاین</span></a></li>-->
<!--                                            <li><a href="<?= Url::to(['discountrequest/create']) ?>" title="Labels &amp; Badges"><span>درخواست تخفیف</span></a></li>-->
                                            <li><a href="<?= Url::to(['ad/request']) ?>" title="Labels &amp; Badges"><span>لیست درخواست ها </span></a></li>  
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" class="display-block" href="#Elements3">
                                            پروفایل
                                            <i class="glyph-icon icon-angle-left float-left"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="Elements3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav">

                                            <li><a href="<?= Url::to(['site/profile']) ?>" title="Labels &amp; Badges"><span>ویرایش پروفایل</span></a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">

                        <?= Alert::widget() ?>
                        <?= $content ?> 
                    </div>
                </div>

                <div class="clearfix"></div>

            </div>





            <div id="footer" class="main-footer bg-gradient-8 clearfix" style="position: fixed ; width: 100% ; bottom:  0;">
                <div class=" clearfix">
                    <div class="col-md-9 pad25R">
                        <div class="header">درباره سیستم</div>
                        <p class="about-us">
                            sollicitudin eu erat. Pellentesque ornare mi vitae sem consequat ac bibendum neque adipiscing.
                        </p>
                        <div class="divider"></div>


                    </div>

                    <div class="col-md-3">

                        <h3 class="header">تماس با ما</h3>
                        <ul class="footer-contact">
                            <li>
                                <i class="glyph-icon icon-home"></i>
                                آدزس
                            </li>
                            <li>
                                <i class="glyph-icon icon-phone"></i>
                                021 -66888888
                            </li>
                            <li>
                                <i class="glyph-icon icon-envelope-o"></i>
                                <a href="#" title="">info@.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-pane">
                    <div class="container clearfix">
                        <div class="logo">&copy; <?= date("Y") ?> hamshahri. All Rights Reserved.</div>
                        <div class="footer-nav-bottom">
                            <a href="#" title="Portfolio">درخواست اکانت</a>
                            <a href="#" title="Layout">شرایط و مقررات</a>
                            <a href="#" title="Elements">حریم خصوصی</a>

                        </div>
                    </div>
                </div>
            </div></div>

    </div>







    <?php $this->endBody() ?>

    <?php $this->endPage() ?>

    <!--  date picker-->
    <link rel="stylesheet" href="/datejs/persian-datepicker.css"/>
    <script src="/datejs/persian-date.js"></script>
    <script src="/datejs/persian-datepicker.js"></script>


    <!-- FRONTEND ELEMENTS -->
    <script type="text/javascript" src="../../backend/web/theme/tether/js/tether.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/bootstrap/js/bootstrap.js"></script>
    <!-- Skrollr -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/skrollr/skrollr.js"></script>

    <!-- Owl carousel -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/owlcarousel/owlcarousel.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/widgets/owlcarousel/owlcarousel-demo.js"></script>

    <!-- HG sticky -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/sticky/sticky.js"></script>

    <!-- WOW -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/wow/wow.js"></script>

    <!-- VideoBG -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/videobg/videobg.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/widgets/videobg/videobg-demo.js"></script>

    <!-- Mixitup -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/mixitup/mixitup.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/widgets/mixitup/isotope.js"></script>

    <!-- Superclick -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/superclick/superclick.js"></script>

    <!-- Input switch alternate -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/input-switch/inputswitch-alt.js"></script>

    <!-- Slim scroll -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/slimscroll/slimscroll.js"></script>

    <!-- Content box -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/content-box/contentbox.js"></script>

    <!-- Overlay -->

    <script type="text/javascript" src="../../backend/web/theme/widgets/overlay/overlay.js"></script>

    <!-- Widgets init for demo -->

    <script type="text/javascript" src="../../backend/web/theme/js-init/widgets-init.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/js-init/frontend-init.js"></script>

    <!-- Theme layout -->

    <script type="text/javascript" src="../../backend/web/theme/themes/frontend/layout.js"></script>
    <script type="text/javascript" src="../../backend/web/jquery.maskMoney.min.js?ver=2"></script>
    <!-- Theme switcher -->
    <script src="../../backend/web/upload_js/demo-ui.js"></script>
    <script type="text/javascript" src="../../backend/web/theme/widgets/theme-switcher/themeswitcher.js"></script>
    <script type="text/javascript" src="/js.js?ver=31"></script>
    <script src="/shop/shopjs.js?ver=333"></script>
    <script>
        $('.maskm').maskMoney({precision: '0'});
    </script>
    <?= Yii::$app->params['site_setting']->js_code; ?>

</body>
</html>


<script src="/backend/web/upload_js/jquery.dm-uploader.min.js"></script>
<script src="/backend/web/upload_js/demo-ui.js"></script>

<link href="/select2totree.css" rel="stylesheet">

<script src="/select2totree.js"></script>


<script>

        if ($("#sel_2").length) {
            $("#sel_2").select2ToTree();
        }
// $('.clone_date').persianDatepicker({
//
//                initialValue: false,
//                initialValueType: "persian",
//                calendarType: "persian",
//                format: 'YYYY/MM/DD',
//                persianDigit: false,
//            }
//            );
        $(".clone_date").persianDatepicker({
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
            minDate: new persianDate().valueOf(),
            autoClose: true,
        }
        );
</script>


