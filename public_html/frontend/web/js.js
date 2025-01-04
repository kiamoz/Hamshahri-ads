jQuery(function ($) {


    $(document).ready(function () {
//        var ggggg=parseFloat("10");
//        alert(typeof ggggg);



////var makeRadiosDeselectableByName = function(name){

        $('input[type=radio]').click(function () {

            ///  console.log("radio____"+$(this).attr('previousValue'));
            var checked = $(this).attr("checked");
            if (!checked) {
                $(this).attr("checked", true);
            } else {
                $(this).removeAttr("checked");
                $(this).prop("checked", false);
            }
        });
///};

        var onlinee = $('#user_online').val();

        document.getElementById("mimm").style.display = 'none';
        document.getElementById("add").style.display = 'none';
        document.getElementById("ad-mim").style.display = 'none';
        document.getElementById("certificate").style.display = 'none';
        document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
        var ttt;
        var response__needed;
        var response__benefit;
        var response__sum_box_qty;
        var response__benefit_rate;
        var response__discount = 0;
        var sub_type;
        var in_page;
        var pt = [];
        var level;
        var tej;
        var cccc;
        var titlee;
        var pub_date;
        var changed;
        var free;
        var type;
        var iddd_ad;
        var code_nama;
        var iddd_cer;
        var mim;
        var city;
        var contract;
        var contract_price;
        var innn;
        var pay;
        var result;
        var ss;
        ///pardakht
        sub_type = $('#sub_type').val();
        if (sub_type == 1) {
            $('.field-ad_type #ad_type input[value=10]').hide();
            $('.field-ad_type #ad_type input[value=10]').parent().hide();

            $('.field-ad_type #ad_type input[value=2]').hide();
            $('.field-ad_type #ad_type input[value=2]').parent().hide();

            $('.field-ad_type #ad_type input[value=13]').hide();
            $('.field-ad_type #ad_type input[value=13]').parent().hide();

            $('.field-ad_type #ad_type input[value=3]').hide();
            $('.field-ad_type #ad_type input[value=3]').parent().hide();

            $('.field-ad_type #ad_type input[value=12]').hide();
            $('.field-ad_type #ad_type input[value=12]').parent().hide();

            $('.field-ad_type #ad_type input[value=4]').hide();
            $('.field-ad_type #ad_type input[value=4]').parent().hide();

            $('.field-ad_type #ad_type input[value=5]').hide();
            $('.field-ad_type #ad_type input[value=5]').parent().hide();

            $('.field-ad_type #ad_type input[value=6]').hide();
            $('.field-ad_type #ad_type input[value=6]').parent().hide();

            $('.field-ad_type #ad_type input[value=9]').hide();
            $('.field-ad_type #ad_type input[value=9]').parent().hide();

            $('.field-ad_type #ad_type input[value=8]').hide();
            $('.field-ad_type #ad_type input[value=8]').parent().hide();

            $('.field-ad_type #ad_type input[value=7]').hide();
            $('.field-ad_type #ad_type input[value=7]').parent().hide();
        }

        ////pardakht


        console.log('hoda');
        ss = document.getElementById("edit").innerHTML;
        console.log(ss);


        $('#ad_type input[type=radio]').change(function () {

            $('#ad_type input:radio:checked').each(function () {

                if ($(this).attr('value') == 1) {
                    document.getElementById("ad-id_ad").style.display = 'block';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'block';
                    document.getElementById("ad-mim").style.display = 'block';
                    document.getElementById("add").style.display = 'block';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 1;
                } else if ($(this).attr('value') == 11) {
                    document.getElementById("ad-id_ad").style.display = 'block';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'block';
                    document.getElementById("ad-mim").style.display = 'block';
                    document.getElementById("add").style.display = 'block';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 11;
                } else if ($(this).attr('value') == 2) {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'block';
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'block';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
//                     $(".field-ad-resseler_id").hide();
                    type = 2;
                } else if ($(this).attr('value') == 13) {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'block';
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'block';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
//                     $(".field-ad-resseler_id").hide();
                    type = 13;
                } else if ($(this).attr('value') == 3) {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("ad-id_ad").style.display = 'block';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("add").style.display = 'block';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';

                    type = 3;
                } else if ($(this).attr('value') == 12) {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("ad-id_ad").style.display = 'block';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("add").style.display = 'block';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';

                    type = 12;
                } else if ($(this).attr('value') == 4) {

                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
//                     $(".field-ad-resseler_id").hide();
                    type = 4;
                } else if ($(this).attr('value') == 5) {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
//                     $(".field-ad-resseler_id").hide();
                    type = 5;
                } else if ($(this).attr('value') == 6) {
                    //alert($(this).attr('value'));
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'none';
//                    $(".field-ad-resseler_id").hide();
                    type = 6;
                } else if ($(this).attr('value') == 7) {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    //document.getElementsByClassName("field-ad-resseler_id")[0].style.display = 'block';
//                      $(".field-ad-resseler_id").show();

                    type = 7;
                } else if ($(this).attr('value') == 8) {
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 8;
                } else if ($(this).attr('value') == 9) {

                    document.getElementById("ad-id_ad").style.display = 'none';

                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 9;
                } else if ($(this).attr('value') == 10) {
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 10;
                } else if ($(this).attr('value') == 15) {
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 15;
                } else if ($(this).attr('value') == 16) {
                    document.getElementById("ad-id_ad").style.display = 'none';
                    document.getElementById("ad-cer_no").style.display = 'none';
                    document.getElementById("mimm").style.display = 'none';
                    document.getElementById("ad-mim").style.display = 'none';
                    document.getElementById("add").style.display = 'none';
                    document.getElementById("certificate").style.display = 'none';
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 16;
                } else {
                    document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'none';
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    type = 0;
                }


                if ($(this).attr('value') == 9) {

                    //$('#inc_khareji').show();
                } else {
                    //$('#inc_khareji').hide();
                }



                if ($(this).attr('value') == 3 || $(this).attr('value') == 4) {

                    // $(".form-group.field-cash_discount").hide();

                } else {
                    // $(".form-group.field-cash_discount").show();
                }


                console.log('typeeeeeeee');
                console.log(type);
            });
        });



        $('#ad-title').change(function () {
            titlee = document.getElementById('ad-title').value;
        });
        $('.table-days').change(function () {
            pub_date = $(this).val();
            console.log('date');
            console.log(pub_date);
        });
        $('input[id=ad-cer_no]').change(function () {

            iddd_cer = document.getElementById("ad-cer_no").value;
            console.log('ceeeeeeeeeeeeeeeeeeeeeeeeeerrrrrrrrrrr');
            console.log(iddd_cer);

        });
        $('input[id=ad-mim]').change(function () {

            mim = document.getElementById("ad-mim").value;
            console.log('miiiiiiiiiiiiiiiiiiiim');
            console.log(mim);

        });
        $('input[id=ad-id_ad]').change(function () {

            iddd_ad = document.getElementById("ad-id_ad").value;
            console.log('adddddddddddddddddddddddddddddddddddddd');
            console.log(iddd_ad);

        });



        $("#ad-date_publish2").persianDatepicker({
            initialValue: false,
            initialValueType: "persian",
            calendarType: "persian",
            format: 'YYYY/MM/DD',
            persianDigit: false,
            autoClose: true,

            // minDate: new persianDate().valueOf(),
        }
        );

        var to = $("#ad-date").persianDatepicker({
            initialValue: false,
            initialValueType: "persian",
            calendarType: "persian",
            format: 'YYYY/MM/DD',
            persianDigit: false,
            autoClose: true,

            // minDate: new persianDate().valueOf(),
        }
        );


   



        $("#ad-date_publish").persianDatepicker({
            initialValue: false,
            initialValueType: "persian",
            calendarType: "persian",
            format: 'YYYY/MM/DD',
            persianDigit: false,
            autoClose: true,
            onSelect: function (unix) {
                console.log('datepicker select : ' + unix);

                to.setDate(unix);
            }
            // minDate: new persianDate().valueOf(),
        }
        );




        $('#plotId table').click(function () {
            $('#plotId').hide();
        })
        $("#ad-date_publish").click(function () {
            $('#plotId').show();
        })
        var selected_discount = [];
        var selected_discount_all = [];
        var dat_idd;
        var idd = [];
        var iddt = [];
        var iddtt = [];
        var iddk = [];
        var sid;
        var values_arr = [];
        function select_resseler_do(id) {

            console.log('select_resseler_do' + id);
            // iddk.pop();
            // iddk.push(id);
            // console.log('resssssssssssss'+iddk);

            //   var idd=evt.params.data.id;
            // alert (idd);
            //console.log( evt.params.data.id);

        }



        $('#ad-resseler_id').on('select2:select', function (evt) {
            console.log('resselerrrrrrrrrr' + evt.params.data.id);
            //  (evt.params.data.id)
            iddk.pop();
            iddk.push(evt.params.data.id);
            console.log('resssssvariable' + iddk)
            select_customer_do(evt.params.data.id)

        });
        function select_customer_do(id) {

            console.log('select_customer_do' + id);
            iddt.pop();
            iddt.push(id);
            //   var idd=evt.params.data.id;
            // alert (idd);
            //console.log( evt.params.data.id);
            $.ajax({
                url: '/site/get_customer_discount?id=' + id,
                type: 'get',
                dataType: 'json',
            }).done(function (response) {
                // show_discount(response);
            });
        }

//        function find_city(id) {
//
//            //console.log('select_customer_do' + id);
//            iddtt.pop();
//            iddtt.push(id);
//            //   var idd=evt.params.data.id;
//            // alert (idd);
//            //console.log( evt.params.data.id);
//            $.ajax({
//                url: '/site/find_city?id=' + id,
//                type: 'get',
//                dataType: 'json',
//            }).done(function (response) {
//                show_code(response);
//            });
//        }
//
//        $('#ad-customer_id').on('select2:select', function (evt) {
//            console.log('/site/get_customer_discount?id=' + evt.params.data.id);
//            //  (evt.params.data.id)
//
//            select_customer_do(evt.params.data.id)
////            find_city(evt.params.data.id)
//        });
//
//        $('#ad-contract_id').on('select2:select', function (evt) {
//            contract = evt.params.data.id;
//            console.log('contraaaaaaaaaaaact');
//            console.log(contract);
//
//            $.ajax({
//                type: 'GET',
//                url: '/site/contractprice?id=' + contract, // آیدی رو می فرسته به این اکشن تا اسم شهرارو پیدا کنه
//
//                crossDomain: true,
//                success: function (output) { // اضافه کردن اسم شهر ها به  select2 دوم با شرط sateid
//
//
//
//                    console.log('output contract');
//
//                    console.log('contract price');
//                    contract_price = output;
//                    console.log(contract_price);
//
//                },
//                error: function (xhr, status, error) {
//
//
//                    //alert(error);
//                },
//                contentType: 'application/json; charset=utf-8',
//                dataType: 'json'
//            });
//        });
        ////////////////////////////////////////
        $('#ad-customer_id').on('select2:select', function (evt) {


            // اضافه کردن به select2 city
            console.log('contract');



            var cust_con = evt.params.data.id; // id اون استانی که انتخاب شده
//alert(sid);
            console.log(cust_con);
            $.ajax({
                type: 'GET',
                url: '/site/contract?id=' + cust_con, // آیدی رو می فرسته به این اکشن تا اسم شهرارو پیدا کنه

                crossDomain: true,
                success: function (output) { // اضافه کردن اسم شهر ها به  select2 دوم با شرط sateid



                    //console.log(output);
                    n = "<option value=''>" + 'شماره قراردادرا انتخاب کنید' + "</option>";
                    ;

                    $.each(output, function (key, value) {

                        n += "<option value='" + key + "'>" + value + "</option>";
                    });

                    $('#ad-contract_id').find('option').remove();
                    $('#ad-contract_id').append(n);
                    if (type == 4)
                        document.getElementsByClassName("field-ad-contract_id")[0].style.display = 'block';

                },
                error: function (xhr, status, error) {


                    //alert(error);
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });

        });

        ///////////////////////
        /////////////////
//        $("#ad_preview").on('click',function () {
//           var num_cadr = parseInt($('#ad-box_qty').val());
//           console.log(num_cadr);
//           //preview_ad(num_cadr)
//        });

/////////////////////
//$('#customerstatus input').change(function () {
//    alert(this.value);
//});

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };
        var url_id = getUrlParameter('id');
        console.log("testxx" + url_id);
        if (!url_id) {

            load_customer(0);
        } else {
            select_customer_do(url_id)
        }


        $('#customerstatus input').change(function () {

            sid = this.value; // id اون استانی که انتخاب شده


            console.log('/site/option?id=' + sid);
            load_customer(sid);
        });


        function check_all_radio() {

            selected_discount_all = [];
            $('#discount_list_all input:radio:checked').each(function () {
                if ($(this).attr('value') == 1) {
                    console.log("Y");
                    changed = 1;
                    console.log('change' + changed);
                    //console.log($(this).attr('data-id'));
                    selected_discount_all.push($(this).attr('data-id'));
                } else if ($(this).attr('value') == 2) {
                    changed = 0;
                    var index = selected_discount_all.indexOf($(this).attr('data-id'));
                    if (index > -1) {
                        removeElement(selected_discount_all, index);
                    }
                    console.log("deleted" + selected_discount_all);
                }

            });
            console.log('selected1:');
            console.log(selected_discount_all);

        }


        function load_customer(id) {
            $.ajax({
                type: 'GET',
                url: '/site/option?id=' + id, // آیدی رو می فرسته به این اکشن تا اسم شهرارو پیدا کنه
                crossDomain: true,
                success: function (output) { // اضافه کردن اسم شهر ها بهselect2 دوم با شرط sateid
                    n = "";
                    $.each(output, function (key, value) {
                        n += "<option value='" + key + "'>" + value + "</option>";
                    });
                    $('#ad-customer_id').find('option').remove();
                    $('#ad-customer_id').append(n);
                },
                error: function (xhr, status, error) {
                },
                contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });
        }


        var all_selected_arr = [];
        $('#discount_list_all input[type=radio]').change(function () {
//$('#discount_list_all input').trigger('change');

            check_all_radio();

        });
        $('#discount_free input').trigger('change');
/////free

        function check_free_radio() {
            $('#discount_free input:radio:checked').each(function () {
                if ($(this).attr('value') == 1) {
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'none';

                    free = 1;
                    changed = 1;
                    console.log('free' + free);
                    //console.log($(this).attr('data-id'));
                    //selected_discount_all.push($(this).attr('data-id'));
                } else if ($(this).attr('value') == 2) {
                    document.getElementsByClassName("field-naghdi_etebari")[0].style.display = 'block';
                    free = 0;
                    changed = 0;
                    console.log('free' + free);
//                    var index = selected_free.indexOf($(this).attr('data-id'));
//                    if (index > -1) {
//                        removeElement(selected_free, index);
//                    }
//                    console.log("deleted" + selected_free);
                }

            });
        }
        $('#discount_free input[type=radio]').change(function () {
//$('#discount_list_all input').trigger('change');
            check_free_radio();


        });
        $('#discount_free input').trigger('change');



//        $('input[id=code_namayandegi]').change(function () {
//
//            code_nama = document.getElementById("code_namayandegi").value;
//            console.log('code_nama');
//            console.log(code_nama);
//
//        });


        function show_code(response) {
            $('#show_code div').remove();
            for (var k in response) {
                console.log('cityyyyyyyyyyyyyyyyyyyyyy::::::::::::');
                console.log(response[k]);
                city = response[k];
                console.log(type);
//                if (type == 2 || type == 1) {
//                    if (response[k] != '10511133') {
//                        var add = '<div id="hhhh"><div id="namayandegi">کدنمایندگی</div><input style="width:150px;display:inline;" type="input" id="code_namayandegi" class="form-control" name="" placeholder="کد نمایندگی را وارد کنید"></div>'
//                        $('#show_code').append(add);
//                    } else {
//                        $('#show_code').find('#hhhh').remove();
//                    }
//                }
            }




        }


        function show_discount(response) {
            $('#discount_list div').remove();
            for (var k in response) {

                console.log(response[k]);
                var add = '<div id=' + response[k]['id'] + '"><div>' + response[k]['text'] + '<br><span class="bs-label label-success">' + response[k]['value'] + '%</span></div>  <label><input type="radio" name="ad-discount_' + response[k]['id'] + '"  value="1" data-id="' + response[k]['id'] + '" > بله</label><label><input type="radio" name="ad-discount_' + response[k]['id'] + '" value="2" data-id="' + response[k]['id'] + '"> خیر</label></div>'
                $('#discount_list').append(add);
            }



            $('#discount_list input[type=radio]').change(function () {




                selected_discount = [];
                $('#discount_list input:radio:checked').each(function () {
                    if ($(this).attr('value') == 1) {

                        //console.log($(this).attr('data-id'));
                        selected_discount.push($(this).attr('data-id'));
                    } else if ($(this).attr('value') == 2) {
                        var index1 = selected_discount.indexOf($(this).attr('data-id'));
                        if (index1 > -1) {

                            selected_discount.splice(index1, 1);
                            // removeElement(selected_discount, index1);
                        }


                        console.log('selected2:');
                        console.log(selected_discount);
                    }

                });
                console.log(selected_discount);
            });
        }

        var edittt = document.getElementById('edit').innerHTML;
        console.log("edit");
        console.log(edittt);

        //titlee= document.getElementById('ad-title').value;
        pub_date = document.getElementById('ad-date_publish').value;
        console.log("ti+da");
        console.log(pub_date);



///////////filessss 
        $(function () {
//ققق
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
                    url: "/ad/uploadx",
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

                        pt.push(data.path);
//                        console.log(pt);
                        var pathx = "/frontend/web/" + data.path;
                        $('#gallery_area').val($('#gallery_area').val() + "\n" + pathx);

                        // console.log($('#gallery_area').val($('#gallery_area').val() + "\n" + pathx));

                        var extension = data.path.split('.').pop();
                        console.log('extension');
                        console.log(extension);
                        if (extension == 'jpg' || extension == 'jpeg' || extension == 'png') {
                            var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><img src='" + pathx + "' class='kv-preview-data file-preview-image'  style='width:auto;height:160px;'><a href='" + pathx + "' target='_blank' class='kv-preview-data file-preview-image'  style='width:auto;height:50px;color:black;font-size:20px;'>دانلود فایل</a></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'>حذف</button></div></div></div></div>";
                        } else {
                            var strm = "<div class='file-preview-frame file-preview-success'><div class='kv-file-content' ><a href='" + pathx + "' target='_blank' class='kv-preview-data file-preview-image'  style='width:auto;height:50px;color:black;font-size:20px;'>دانلود فایل</a></div><div class='file-thumbnail-footer'><div class='file-actions'><div class='file-footer-buttons'> <button type='button' class='kv-file-remove btn btn-xs btn-default removex' title='" + pathx + "'>حذف</button></div></div></div></div>";
                        }


                        $('#gallery-box').append(strm);
                        //alert(strm);



                        $('.removex').click(function () {
                            remove_from_gallery($(this).attr('title'));
                            $(this).parent().parent().parent().parent().hide();
                        });



//                     console.log(data.path);
                        // A file was successfully uploaded



                        ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
                        ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
                        ui_multi_update_file_status(id, 'success', 'Upload Complete');
                        ui_multi_update_file_progress(id, 100, 'success', false);
                    },
                    onUploadError: function (id, xhr, status, message) {
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




//////////end of files





        $('#btn_cal').click(function () {



            console.log('btnn' + $('#ad-discount_2').val());
            console.log(type + " type==");
            console.log(onlinee);



            if (!$('#naghdi_etebari input:checked').val()) {


                alert('نحوه پرداخت را انتخاب نمایید.');
                return 0;
            }
            
            if (!$('#ad-date_publish').val()) {


                alert('تاریخ انتشار را مشخص کنید');
                return 0;
            }
            
            if (!$('#ad-customer_id').val()) {


                alert('مشتری را مشخص کنید..');
                return 0;
            }




            /*         if ((type == 1 || type == 11) && !iddd_ad) {
             alert('شناسه آگهی نمیتواند خالی باشد');
             if (!mim) {
             alert('میم/الف نمیتواند خالی باشد');
             }
             } else if ((type == 2 || type == 13) && !iddd_cer) {
             alert('شماره مجوز نمیتواند خالی باشد');
             } else if ((type == 3 || type == 12) && !iddd_ad) {
             alert('شناسه آگهی نمیتواند خالی باشد');
             } else if (sub_type != '1' && ((!$('#naghdi_etebari input:checked').val() && $('#ad_type input:checked').val() != '6') &&
             (!$('#naghdi_etebari input:checked').val() && $('#discount_free input:checked').val() != 1)
             )) {
             
             alert('نحوه پرداخت را انتخاب نمایید.');
             
             } else if ((sub_type == '1' && type != 1 && !$('#naghdi_etebari input:checked').val()) && (sub_type == '1' && type != 11 && !$('#naghdi_etebari input:checked').val())) {
             
             
             alert('نحوه پرداخت را انتخاب نمایید ساب');
             
             } else if (!$('#ad-pub_qty').val()) {
             alert('فیلد نوبت را پر کنید. ');
             } else { */

            var box_id = document.getElementById("ad-box_id").value;

            var edittt = $('#ad_ID').html();
            console.log(edittt + "(editid)");
            
            console.log($('#vat input:checked').val());
            console.log($('#ad-date_publish2').val());

            var url = '/site/cal_data?box_id=' + box_id +
                    '&qty=' + parseInt($('#ad-box_qty').val()) * parseInt($('#ad-pub_qty').val()) +
                    '&income=' + parseInt($('#ad-in_amount').val()) +
                    '&ad_in_page=' + parseInt($('#ad-ad_in_page').val()) +
                    '&num_full_page=' + parseInt($('#ad-num_full_page').val()) +
                    '&num_box_qty=' + parseInt($('#ad-box_qty').val()) +
                    '&num_pub_qty=' + parseInt($('#ad-pub_qty').val()) +
                    '&arr1=' + $('#ad-discount_1').val() +
                    '&arr2=' + $('#ad-discount_2').val() +
                    '&arr3=' + $('#ad-discount_3').val() +
                    '&cid=' + idd +
                    '&edit_id=' + edittt +
                    '&custid=' + $('#ad-customer_id').val() +
                    '&resid=' + iddk +
                    '&confirm=' + $('#customerconfirmation input:checked').val() +
                    '&free=' + free +
                    '&type=' + $('#sel_2').val() +
                    '&cer=' + iddd_cer +
                    '&iddd_ad=' + iddd_ad +
                    '&mim=' + mim +
                    '&contract=' + contract +
                    '&contractprice=' + contract_price +
                    '&titlee=' + $('#ad-title').val() +
                    '&pub_date=' + $('#ad-date_publish').val() +
                    '&date=' + $('#ad-date').val() +
                    '&tej=' + sid +
                    '&pay=' + $('#naghdi_etebari input:checked').val() +
                    '&box_id_ad=' + ($('#ad-box_id')).val() +
                    '&naghdi_etebari=' + ($('#naghdi_etebari input:checked').val()) +
                    '&ad_typee=' + $('#ad_type input:checked').val() +
                    '&agahi=' + ($('#ad-ad_in_page').val()) +
                    '&cash_discount=' + $('#cash_discount input:checked').val() +
                    '&tejari=' + $('#customerstatus input:checked').val() +
                    '&disc_addi_moshtari_kargozar=' + $('#takhfif_avalin_h_adi input:checked').val() +
                    '&tarhim_tasliyat=' + $('#takhfif_tarhim_tasliyat input:checked').val() +
                    '&in_kh=' + $('#inc_khareji input:checked').val()+
                    '&steps_discount=' + $('#pelekani input:checked').val()+
                    '&fix_discount=' + $('#ad-fix_discount').val()+
                    '&code_kargah=' + $('#ad-code_kargah').val()+
                    '&date_publish2=' + $('#ad-date_publish2').val()+
                    
                    '&vat=' + $('#vat input:checked').val()+"&";
                    




            console.log("URL:" + url);
            //return;



            var url_id = getUrlParameter('id');
            if (url_id) {
                url += '&delete_all'
            }

//            

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
            }).done(function (response) {

                console.log(response);
                //$("#ad_ID").html(response.ad_id);
                // $("#ad_ID").hide();
                show_result(response);
            });
            var num_frame = parseInt($('#ad-box_qty').val());
            ad_preview(num_frame);

        });
        function show_result(response) {
            if ($('#result_list tbody tr').remove()) {

            } else {

            }


//            values_arr = response;
            ttt = '<tr ><td>' + ' نام تخفیف استفاده شده' + '</td><td>' + 'درصد افزایش اعتبار' + '</td><td>' + 'درصد تخفیف' + '</td><td>' + 'قیمت(ریال)' + '</td></tr>';
            for (var m in response.discount) {

                console.log(response__discount);
                var myStr = response.discount[m].discount_price;
                var newStr = myStr.replace(/,/g, '');


                response__discount += parseFloat(newStr);



                if (response.discount[m].type == 1) {

                    console.log("1 is ok");
                    result += '<tr  id="discount-id_' + response.discount[m].discount_id + '"><td>' + response.discount[m].discount_name + '</td><td>' + response.discount[m].discount_inc + '</td><td>' + response.discount[m].discount_rate + '</td><td>' + response.discount[m].discount_price + '</td></tr>';


                }

            }


            result += '<tr colspan="3" ><td>جمع تخفیف افزایش اعتبار::</td><td>' + response.sum_discount_1_rate + '</td><td>' + response.sum_discount_1_price + '</td></tr>';


            for (var m in response.discount) {

                console.log(response__discount);
                var myStr = response.discount[m].discount_price;
                var newStr = myStr.replace(/,/g, '');


                response__discount += parseFloat(newStr);



                if (response.discount[m].type == 2) {


                    console.log("2 is ok");
                    result += '<tr  id="discount-id_' + response.discount[m].discount_id + '"><td>' + response.discount[m].discount_name + '</td><td>' + response.discount[m].discount_inc + '</td><td>' + response.discount[m].discount_rate + '</td><td>' + response.discount[m].discount_price + '</td></tr>';


                }

            }

            result += '<tr colspan="3" ><td>جمع تخفیف درصدی:</td><td>' + response.sum_discount_2_rate + '</td><td>' + response.sum_discount_2_price + '</td></tr>';



            if (!response.discount.length) {





//                console.log('salaaaammm');
                result = '<tr ><td>' + 'بدون تخفیف' + '</td><td>' + 0 + '</td><td>' + 0 + '</td><td>' + 0 + '</td></tr>';
//               
            }


            var pn = response.temp_p_n;
            if (response.temp_p_n == 1)
                pn = "-";
            else if (response.temp_p_n == 2)
                pn = "+";
            else {
                pn = "";
            }
            if (!response.takhfif) {
                response.takhfif = "";
            }
            console.log('pntakhfif>>>' + response.temp_p_n);
            var total = '<tr><td colspan="3" class=""> مبلغ تعرفه یک کادر بدون افزایش یا کاهش تعرفه</td><td colspan="3" id="price">' + response.price_orginal + '</td></tr>\n\
                         <tr><td colspan="3" class=""> مبلغ تعرفه</td><td colspan="3" id="price">' + response.price + '</td></tr>';//            console.log(total);

            var rest = '';
            if (response.temp_p_n > 0) {
                total += '<tr> <td colspan="3" class=""> تعرفه افزایش/کاهش:</td><td colspan="3" id="takhfif">' + pn + response.temp_p_n + "%" + '</td></tr>';
            }

            rest += '<tr> <td colspan="3" class="text-left"> تعداد کل کادر ها:</td><td id="sum_discount">' + response.sum_box_qty + '</td></tr>\n\
                        <tr><td colspan="3" class="text-left">درصد افزایش اعتبار:</td><td colspan="3" id="sum_inc">' + response.sum_inc + '</td>';
            var rema = '<tr> <td colspan="3" class="text-left"> جمع درصد تخفیف:</td><td id="sum_discount_rate">' + response.sum_discount_rate + '</td></tr>\n\<tr> <td colspan="3" class="text-left"> جمع تخفیف:</td><td id="sum_discount">' + response.sum_discount + '</td></tr>\n\
\n\                     <tr><td colspan="3" class="text-left">مبلغ  ارزش افزوده :</td><td colspan="3" id="sum_in">' + response.vat + '</td></tr>\n\
                        <tr><td colspan="3" class="text-left">مبلغ مورد نیاز با ارزش افزوده :</td><td colspan="3" id="sum_in">' + response.needed + '</td></tr>\n\
                        <tr><td colspan="3" class="text-left" > درصد کارمزد:</td><td colspan="3" id="benefit_rate">' + response.benefit_rate + '</td></tr>\n\
                        <tr><td colspan="3" class="text-left"> مبلغ کارمزد:</td><td colspan="3" id="benefit_price">' + response.benefit_price + '</td></tr>\n\
                        <tr> <td colspan="3" class="text-left"> مبلغ خالص پس از کسر کارمزد و ارزش افزوده:</td><td id="sum_discount_rate">' + response.khales + '</td></tr>';


            $('#result_list').append(total);
            $('#result_list').append(ttt);
            $('#result_list').append(result);
            $('#result_list').append(rest);
            $('#result_list').append(rema);
            response__needed = response.needed;
            response__sum_box_qty = response.sum_box_qty;
            response__benefit = response.benefit_price;
            response__benefit_rate = response.benefit_rate;
            //response__discount = response.sum_discount;
            result = '';
//            $('#my_ajax_data').html(response.sum_discount);
//            console.log(response);
            var res = response.needed.replace(/,/g, "");

            innn = res;


        }
        var isSquare = function (n) {
            return n > 0 && Math.sqrt(n) % 1 === 0;
        };
        function draw_regtangle(i_r, j_r) {

//            console.log(i_r + '|' + j_r);

            if (i_r > 6 || j_r > 4 || !Number.isInteger(i_r) || !Number.isInteger(j_r)) {
                return;
            }
//            console.log(i_r + '|' + j_r + "after");

            tr = "";
            for (i = 0; i < i_r; i++) {
                td = "";
                for (j = 0; j < j_r; j++) {
                    td += '<td>&nbsp;</td>';
                }
                tr += '<tr>' + td + '</tr>';
            }
            return '<label class="control-label" > حالت نمایش کادر ها</label><div class="div_preview"> <table>' + tr + '</table> <label><input type="radio"  class = "r_ij" name="ij"  value="' + i_r + ',' + j_r + '" data-i_r="' + i_r + '" data-j_r="' + j_r + '"> این کادر مورد قبول است</label> <div>';
        }



        function ad_preview(num_frame) {

            var tr, td;
            //  console.log(num_frame);
            $('#table_e_v').html(" ");
            /*if (isSquare(num_frame)) {
             sq = Math.sqrt(num_frame);
             $('#table_e_v').append(draw_regtangle(sq, sq));
             } */

            if (num_frame == 1) {
                $('#table_e_v').append(draw_regtangle(1, 1));
            }

            var varient_tbale = [];
            var temp = [];
            if (num_frame > 1) {
                if (num_frame % 2 == 1) {

                    temp[0] = 1;
                    temp[1] = num_frame;
                    varient_tbale.push(temp);
                    temp = [];
                    temp[0] = num_frame;
                    temp[1] = 1;
                    varient_tbale.push(temp);
                } else if (num_frame % 2 == 0) {

                    console.log("cond3");
                    console.log(draw_regtangle(num_frame / 2, 2));
                    temp = [];
                    temp[0] = num_frame / 2;
                    temp[1] = 2;
                    varient_tbale.push(temp);
                    temp = [];
                    temp[1] = num_frame / 2;
                    temp[0] = 2;
                    varient_tbale.push(temp);
                    temp = [];
                    temp[0] = num_frame / 4;
                    temp[1] = 4;
                    varient_tbale.push(temp);
                    temp = [];
                    temp[1] = num_frame / 4;
                    temp[0] = 4;
                    varient_tbale.push(temp);
                    temp = [];
                    temp[0] = num_frame;
                    temp[1] = 1;
                    varient_tbale.push(temp);
                    temp = [];
                    temp[0] = 1;
                    temp[1] = num_frame;
                    varient_tbale.push(temp);
                }


//                console.log(varient_tbale);
                varient_tbale = varient_tbale.map(JSON.stringify).reverse().filter(function (e, i, a) {
                    return a.indexOf(e, i + 1) === -1;
                }).reverse().map(JSON.parse) // [[7,3], [3,8], [1,2]]




                for (var m in varient_tbale) {

                    $('#table_e_v').append(draw_regtangle(varient_tbale[m][0], varient_tbale[m][1]));
                }

                // $('#table_e_v').append(draw_regtangle(num_frame, 1));

            }


        }

        $('#ad-ad_in_page').on('select2:select', function (evt) {
            if (evt.params.data.id == 48) {
                document.getElementById("div_ad-num_full_page").style.display = 'block';
                in_page = 48;
            } else if (evt.params.data.id == 24) {
                in_page = 24;
                document.getElementById("div_ad-num_full_page").style.display = 'none';
            } else if (evt.params.data.id == 12) {
                in_page = 12;
                document.getElementById("div_ad-num_full_page").style.display = 'none';
            }
            console.log('in_page');
            console.log(in_page);
        });



        $('#btn_cal').trigger('click');
        //console.log("edit");
        //console.log(editt);
        console.log(("tejari", $('#customerstatus input').val()));
        ////////////////////////////////////////////////////////////////send data to new ad
        var url_idd = getUrlParameter('id');
        console.log('redirect' + url_idd);
        console.log('contractpriceeeeeeeeeeee' + contract_price + 'inamount' + innn);
        $('#new_ad').click(function () {
//alert(response__needed);
            if (type == 4 && contract_price < innn) {
                alert('مبلغ تهاتر کمتر از مبلغ آگهی است');

            } else {

                // var file_data = $('#file_id').prop('files')[0];
                // var file_data1 = $('#file_id1').prop('files')[0];
                console.log('dovomiiiiiiiiiiiiiiiiiii');
                //console.log(file_data);
                console.log('avaliiiiiiiiiiiiiiiii');
                // console.log(file_data1);
                var form_data = new FormData();
                //form_data.append('file', file_data);
                // form_data.append('file_doc', file_data1);
                form_data.append("ad_id", $("#ad_ID").html());
                form_data.append("ad_type", $('#ad_type input:checked').val());
                console.log("iddddddddd:");
                form_data.append("edit_id", ss);
                form_data.append("customer_id", $('#ad-customer_id').val());
                form_data.append("body", CKEDITOR.instances['editor1'].getData());
                //form_data.append("data_pic", pt);
                form_data.append("title", $('#ad-title').val());
                form_data.append("fani", $('#fani').val());
                form_data.append("box_id", $('#ad-box_id').val());
                form_data.append("all_qty", response__sum_box_qty);
                form_data.append("pub_qty", $('#ad-pub_qty').val());
                form_data.append("frame", $('input[class=r_ij]:checked').val());
                form_data.append("date_publish", $('#ad-date_publish').val());
                form_data.append("tejari", $('#customerstatus input:checked').val());
                form_data.append("logo", $('#logo input:checked').val());
                form_data.append("first_page", $('#first_page input:checked').val());
                form_data.append("gallery", $('#gallery_area').val());
                form_data.append("customer_confirmation", $('#customerconfirmation input:checked').val());
                form_data.append("ad_type", type);

                form_data.append("benefit_price", response__benefit);
                form_data.append("benefit_rate", response__benefit_rate);
                form_data.append("discount_price", response__discount);
                form_data.append("in_amount", response__needed);
                form_data.append("naghdi_etebari", $('#naghdi_etebari input:checked').val());


                // form_data.append("code_namayandegi", $('#code_namayandegi').val());
                console.log('مشتری دارد');
                console.log($('#customerconfirmation input:checked').val());
//            var idd=document.getElementById('ad-id').value;
//            
//            console.log(idd);
//             var ad_id = document.getElementById("ad-ad_id").value;
//            var customer_id = document.getElementById("ad-customer_id").value;
//            var title = document.getElementById("ad-title").value;
//            var box_id = document.getElementById("ad-box_id").value;
//            // var in_amount = document.getElementById("ad-in_amount").value;
//            var pub_qty = document.getElementById("ad-pub_qty").value;
//            var frame = $('input[class=r_ij]:checked').val();
//            var date_publish = document.getElementById("ad-date_publish").value;


//            console.log(customer_id);
                //console.log(date_publish);


                //  ?sum_discount=' + $('#result_list #sum_discount').text() + '&r_ij=' + $('input[class=r_ij]:checked').val() + '&ad_id=' + ad_id + '&customer_id=' + customer_id + '&title=' + title + '&in_amount=' + in_amount + '&box_qty=' + box_qty + '&pub_qty=' + pub_qty + '&box_id=' + box_id +'&values_arr='+values_arr +'&discount_arr=' + encodeURIComponent(JSON.stringify(discount_arr));
//alert($('#ad-pub_qty').val());
//alert(url_idd);
                var url = '/ad/neworder'
                $.ajax({
                    url: url,
                    type: 'post',
                    crossDomain: true,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    data: form_data,
                    dataType: 'json',
                }).done(function (response) {
                    console.log('flaaaag');
//                    alert(response);
                    console.log(response.flag);
                    console.log(response);

                    // return ;


                    console.log("hi b");

                    if (response.flag === 1 && !url_idd && $('#ad-pub_qty').val() == 1) {
//                         alert('1');
                        document.location = '/ad';
                    } else if (response.flag === 1 && !url_idd && $('#ad-pub_qty').val() > 1) {
//                         alert('2');
                        document.location = '/ad/date?id=' + $("#ad_ID").html();
                    } else if (url_idd && response.flag === 1) {
//                         alert('3');


                        document.location = '/ad/view?id=' + url_idd;
                    } else if (url_idd && url_idd == response) {
//                        alert('ok');
                        document.location = '/ad/view?id=' + url_idd;
                    } else if (url_idd && response.flag == 5) {
//                         alert('bozorgtar');
//alert(response);
//alert(response.flag);
                        console.log(response);
                        console.log(response.flag);
                        console.log(response.eer);
                        document.location = '/ad/dateedit?id=' + $("#ad_ID").html() + '&qty=' + response.eer;
                    } else if (response.flag === -1) {
// alert('4');
                        for (var kk in response.eer) {
                            alert(response.eer[kk]);
                            //console.log(response.eer[kk]);
                        }

                        //console.log(response.eer);
                    }




                });
            }
        });

        // $('#ad-customer_id').trigger("change");













        check_all_radio();
        check_free_radio();


    });
});


