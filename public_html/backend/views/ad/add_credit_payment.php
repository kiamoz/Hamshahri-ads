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

                                <input type="text"   name="range_02" value="" />
                            </div>  

                        </div>

                        <input type="submit" class="btn btn-success" value="ثبت پرداخت">

                    </form>

                   
                    <style>

                        
                        .card{
                            width: 100%;
                        }
                    </style>
                   

                </div>

            </div>

        </div>

    </div>

</div>

