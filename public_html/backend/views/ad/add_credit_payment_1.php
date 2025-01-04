<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Url;
?>

<div class="main-panel">          
    <div class="content-wrapper">
        <div class="row">

            <div class="card" style="margin-bottom:30px;">

                <div class="card-body">


                    <h2>ثبت پرداخت اعتباری برای آگهی <?= $id ?></h2>





                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>مبلغ قابل هزنیه</th>
                                <th class="text-right">مبلغ مورد نیاز</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>

                                <td><div class="badge badge-outline-success"><?= number_format($credit_naghdi) ?></div></td>
                                <td><div class="badge badge-outline-danger"><?= number_format($max_need) ?></div></td>
                            </tr>

                        </tbody>
                    </table>

                    <form method="post">

                        <div class="template-green">
                            <div class="slider-wrap">

                                <input type="text" id="range_02" name="range_02" value="" />
                            </div>  

                        </div>

                        <input type="submit" class="btn btn-success" value="ثبت پرداخت">

                    </form>

                    <style>

                        .slider-wrap {
                            margin-top: 50px;
                        }
                        .card{
                            width: 100%;
                        }
                        .irs-from:after, .irs-to:after, .irs-single:after{
                            border-top-color: green !important;//Replace With Your color code
                        }
                        .irs--flat .irs-from, .irs--flat .irs-to, .irs--flat .irs-single,.irs--flat .irs-bar{
                            background-color: green !important;//Replace With Your color code

                        }

                        .badge {

                            color: #797979;

                            background-color: #7770;

                        }
                    </style>
                    <script>

                        window.onload = function () {






                            $(document).ready(function () {

                                if ($("#range_02").length) {
                                    $("#range_02").ionRangeSlider({
                                        min: 0,
                                        max: <?= $max_need_avl ?>,
                                        from: <?= $max_need_avl / 2 ?>
                                    });
                                }


                            });

                        }


                    </script>

                </div>

            </div>

        </div>

    </div>

</div>

