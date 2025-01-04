jQuery(function ($) {


    $(document).ready(function () {
        
        
    var sahm = [];
     var sahm3 = [];
$(function () {
    /* ChartJS
     * -------
     * Data and config for chartjs
     */
    
    
    'use strict';
    $.ajax({
        url: 'https://ham.avishost.com/backend/web/index.php?r=ad/sahm',
        type: 'get',
        dataType: 'json',
    }).done(function (response) {
//          console.log("sahm*");
       // console.log(response);
       sahm3[0]=response[0];
        sahm3[1]=response[1];
         sahm3[2]=response[2];
          sahm3[3]=response[3];
           sahm3[4]=response[4];
//           console.log(sahm3);
           
           
           
            var doughnutPieData = {
        datasets: [{
                data: sahm3,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            'مجموع سهم شهرداری',
            'مجموع سهم دولتی',
            'مجموع سهم نفتی',
            'مجموع سهم پیام',
            'مجموع سهم خصوصی',
        ]
    };
    var doughnutPieOptions = {
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };




    if ($("#pieChart").length) {
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: doughnutPieData,
            options: doughnutPieOptions
        });
    }
           
        
//        console.log(sahm);
    });



   


});

});
        });