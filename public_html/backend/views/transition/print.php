<?php

//echo \common\models\Persian::get_last_day_of_month(12, 1403);
//echo  \common\models\Persian::get_prev_month_array();
////$date=(explode(" ",$date));
////print_r ($date);
//exit(); 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

if ($_GET['type'] == 2 or $_GET['type'] == 3)
    $show_benfit = true;
?>
<style>
    @media print { @page {size: auto !important} }

    body{
        direction:rtl;
        font-family: "B nazanin";
    }
    *{
        font-family: 'B nazanin' !important;  
    }
    td{

        padding-top: .3%;
        padding-bottom: .3%;
    }
    .mid{
        text-align:center;
    }
    table{
        margin-top:1%;
    }
    td {

    }
    .w-equal-30{
        width:30%;
    }
    .w-equal-15{
        width:15%;
    }
    .w-equal-10{
        width:10%;
    } 
    .w-equal-25{
        width:27.1%;
    }


    table p {
        font-size: 22px;
        text-align: center;
    }

</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<body>


    <div class="user-form container" style="margin-top: 100px;">

        <div class="row">
            <div class="col-4">
                <img src="../../backend/web/uploads/3.jpg" class="float-right" style="height: 61px;">

            </div>

            <div class="col-4">
                <div style="text-align: right;"> 
                    کد  تولید کننده:<?= ($model->user->code_kargozar) ?>
                    <br>
                    نام مشتری / کارگزار : <?= $model->user->name_and_fam; ?>
                    <br>

                </div>
            </div>

            <div class="col-4">
                <div style="text-align: right;"> 
                    رسید اسناد دریافتی
                    <br>
                    شماره رسید: <?= ($model->resid) ?>
                    <br>
                    تاریخ رسید: <?= common\models\Persian::convert_date_to_fa($model->date) ?>
                </div>
            </div>

            <div class="row">



            </div>


            <div class="col-lg-12">
                <style>
                    table, th, td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                    table {
                        width: 100%;
                    }
                </style>
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td valign="top">
                                <p>ردیف</p>
                            </td>
                            <td valign="top">
                                <p>تاریخ سند</p>
                            </td>
                            <td valign="top">
                                <p>نوع سند</p>
                            </td>
                            <td valign="top">
                                <p>شماره سند</p>
                            </td>
                            <td valign="top">
                                <p>عهده بانک</p>
                            </td>
                            <td valign="top">
                                <p>مبلغ به ریال</p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <p>۱</p>
                            </td>
                            <td valign="top">
                                <p><?= common\models\Persian::convert_date_to_fa($model->date) ?></p>
                            </td>
                            <td valign="top">
                                <p><?= \common\models\User::list_transition[$model->type] ?></p>
                            </td>
                            <td valign="top">

                                <?php
                                //echo $model->type;
                                //echo $model->type;

                                if ($model->type == 11)
                                    $model->sanad = 0;
                                ?>



                                <?php if ($model->type == 11) { ?>
                                    <p>۰</p>
                                    <?php
                                } elseif ($model->type == 13) {
                                    ?>
                                    <p>شماره چک:<?= $model->cheque_num ?></p>
                                <?php } else { ?>
                                    <p>شماره سند مالی :<?= $model->sanad; ?></p>
                                <?php } ?>
                            </td>
                            <td valign="top">
                                <p><?= $model->bank->name ?></p>
                            </td>
                            <td valign="top">
                                <p><?= number_format((int) $model->amount); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" valign="top">
                                <p style="text-align: right;">جمع مبلغ دریافتی به حروف : <?= \common\models\Transition::convert_number($model->amount); ?></p>
                            </td>
                            <td valign="top">
                                <p  ><?= number_format((int) $model->amount); ?></p>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="6" valign="top">
                                <p style="text-align: right;" >توضیحات: <?= $model->extra_info ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="p-5">
                    نام و امضا
                </p>



            </div>

        </div>


    </div>
</body>

<script>
    // window.print();
</script>
<?php exit(); ?>