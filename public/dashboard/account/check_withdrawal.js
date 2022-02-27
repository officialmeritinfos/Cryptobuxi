/**
 *  Class Definition for authentication into the app
 *  This class houses monitors all withdrawal requests
 *
 */
var withdrawalRequests = function (){
    var checkBaseCurrency = function(){
        $('#send_receive').on('show.bs.modal', function () {
            //get the base currency
            var base_curr = $("select[name='base_curr']").val();
            var fiat =$("input[name='fiat']").val();
            var crypto = $("select[name='asset']").val();

            if(base_curr == '1'){
                var equiv_curr = $("input[name='fiat']").val();
                $('#amount_curr').text(' '+crypto+' ');
            }else{
                var equiv_curr =  $("select[name='asset']").val();
                $('#amount_curr').text(' '+fiat+' ');
            }
            $('#curr_rate').text(' '+equiv_curr+' ');
            //check for a change
            $('select[name="base_curr"]').on('change',(function(e) {
                var base_curr = $(this).val();
                var fiat =$("input[name='fiat']").val();
                var crypto = $("select[name='asset']").val();

                if(base_curr == '1'){
                    var equiv_curr = $("input[name='fiat']").val();
                    $('#amount_curr').text(' '+crypto+' ');
                }else{
                    var equiv_curr =  $("select[name='asset']").val();
                    $('#amount_curr').text(' '+fiat+' ');
                }
                $('#curr_rate').text(' '+equiv_curr+' ');
                $('#amount').val('0');
                $('input[name="rate"]').val('0');
            }));
            $('select[name="asset"]').on('change',(function(e) {
                var base_curr = $("select[name='base_curr']").val();
                var fiat =$("input[name='fiat']").val();
                var crypto = $(this).val();

                if(base_curr == '1'){
                    var equiv_curr = $("input[name='fiat']").val();
                    $('#amount_curr').text(' '+crypto+' ');
                }else{
                    var equiv_curr =  $("select[name='asset']").val();
                    $('#amount_curr').text(' '+fiat+' ');
                }
                $('#curr_rate').text(' '+equiv_curr+' ');
                $('#amount').val('0');
                $('input[name="rate"]').val('0');

            }));
        });
    }
    var getWithdrawalRate =function(){
        $('#amount').on('keyup',(function() {
            var amount = $(this).val();
            baseUrl = '';
            var base_curr = $('select[name="base_curr"]').val();
            var fiat = $("input[name='fiat']").val();
            var crypto = $("select[name='asset']").val();
            if (base_curr == '1') {
                var url = baseUrl+'/crypto_to_fiat/'+crypto+'/'+fiat+'/'+amount
            } else {
                var url = baseUrl+'/fiat_to_crypto/'+crypto+'/'+fiat+'/'+amount
            }
            //send request to get user's balance
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('#submit_send').attr('disabled', true);
                    $('input[name="rate"]').LoadingOverlay("show",{
                        text        : "please wait",
                        size        : "30"
                    });
                },
                success:function(data)
                {
                    if(data.error)
                    {
                        console.log(data.data.error);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit_send').attr('disabled', false);
                            $('input[name="rate"]').LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('input[name="rate"]').val(data.data.rate);
                        //return to natural stage
                        $('#submit_send').attr('disabled', false);
                        $('input[name="rate"]').LoadingOverlay("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                    //return to natural stage
                    $('input[name="rate"]').LoadingOverlay("hide");
                    $('#submit_send').attr('disabled', false);
                }

            });
            //if the base currency is changed
            $('select[name="base_curr"]').on('change',(function(e) {
                baseUrl = '';
                var base_curr = $(this).val();
                var fiat = $("input[name='fiat']").val();
                var crypto = $("select[name='asset']").val();
                if (base_curr == '1') {
                    var url = baseUrl+'/crypto_to_fiat/'+crypto+'/'+fiat+'/'+amount
                } else {
                    var url = baseUrl+'/fiat_to_crypto/'+crypto+'/'+fiat+'/'+amount
                }
                //send request to get user's balance
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: "GET",
                    dataType:"json",
                    beforeSend:function(){
                        $('#submit_send').attr('disabled', true);
                        $('input[name="rate"]').LoadingOverlay("show",{
                            text        : "please wait",
                            size        : "30"
                        });
                    },
                    success:function(data)
                    {
                        if(data.error)
                        {
                            console.log(data.data.error);
                            //return to natural stage
                            setTimeout(function(){
                                $('#submit_send').attr('disabled', false);
                                $('input[name="rate"]').LoadingOverlay("hide");
                            }, 3000);
                        }
                        if(data.success)
                        {
                            $('input[name="rate"]').val(data.data.rate);
                            //return to natural stage
                            $('#submit_send').attr('disabled', false);
                            $('input[name="rate"]').LoadingOverlay("hide");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown);
                        //return to natural stage
                        $('input[name="rate"]').LoadingOverlay("hide");
                        $('#submit_send').attr('disabled', false);
                    }

                });
            }));
        }));
    }
    var showWithdrawalDestination = function(){
        $('select[name="destination"]').on('change',(function(e) {
            var destination = $(this).val();
            if (destination == 1) {
                $('#dest_detail').hide();
            } else {
                $('#dest_detail').show();
            }
        }));
    }
     //initiate transfer
     var initiateTransfer = function () {
        $('#withdraw').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#withdraw').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit_send').attr('disabled', true);
                    $("#withdraw :input").prop("readonly", true);
                    $("#submit_send").LoadingOverlay("show",{
                        text        : "initiating",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit_send').attr('disabled', false);
                            $("#withdraw :input").prop("readonly", false);
                            $("#submit_send").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit_send').attr('disabled', false);
                            $("#withdraw :input").prop("readonly", false);
                            $("#submit_send").LoadingOverlay("hide");
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    //return to natural stage
                    setTimeout(function(){
                        $('#withdraw :input').prop('readonly', false);
                        $("#submit_send").LoadingOverlay("hide");
                        $('#submit_send').attr('disabled', false);
                    }, 3000);
                }

            });
        });
    }
    var getCoinRate =function(){
        $('#amounts').on('keyup',(function() {
            var amount = $(this).val();
            baseUrl = '';
            var fiat = $("input[name='fiats']").val();
            var crypto = $("select[name='assets']").val();
            var url = baseUrl+'/fiat_to_crypto/'+crypto+'/'+fiat+'/'+amount;
            //send request to get user's balance
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('#submit_send').attr('disabled', true);
                    $('input[name="rates"]').LoadingOverlay("show",{
                        text        : "please wait while we calculate",
                        size        : "30"
                    });
                },
                success:function(data)
                {
                    if(data.error)
                    {
                        console.log(data.data.error);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit_accept').attr('disabled', false);
                            $('input[name="rates"]').LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('input[name="rates"]').val(data.data.rate);
                        //return to natural stage
                        $('#submit_send').attr('disabled', false);
                        $('input[name="rates"]').LoadingOverlay("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                    //return to natural stage
                    $('input[name="rates"]').LoadingOverlay("hide");
                    $('#submit_send').attr('disabled', false);
                }

            });
            //if the base currency is changed
            $('select[name="assets"]').on('change',(function(e) {
                baseUrl = '';
                var crypto = $(this).val();
                var fiat = $("input[name='fiat']").val();
                var url = baseUrl+'/fiat_to_crypto/'+crypto+'/'+fiat+'/'+amount;
                $('input[name="rates"]').val('0');
                //send request to get user's balance
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: "GET",
                    dataType:"json",
                    beforeSend:function(){
                        $('#submit_send').attr('disabled', true);
                        $('input[name="rates"]').LoadingOverlay("show",{
                            text        : "please wait while we calculate",
                            size        : "30"
                        });
                    },
                    success:function(data)
                    {
                        if(data.error)
                        {
                            console.log(data.data.error);
                            //return to natural stage
                            setTimeout(function(){
                                $('#submit_send').attr('disabled', false);
                                $('input[name="rates"]').LoadingOverlay("hide");
                            }, 3000);
                        }
                        if(data.success)
                        {
                            $('input[name="rates"]').val(data.data.rate);
                            //return to natural stage
                            $('#submit_send').attr('disabled', false);
                            $('input[name="rates"]').LoadingOverlay("hide");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown);
                        //return to natural stage
                        $('input[name="rates"]').LoadingOverlay("hide");
                        $('#submit_send').attr('disabled', false);
                    }

                });
            }));
        }));
    }
    return {
        init: function() {
            checkBaseCurrency();
            getWithdrawalRate();
            showWithdrawalDestination();
            initiateTransfer();
            getCoinRate();
        }
    };
}();

jQuery(document).ready(function() {
    withdrawalRequests.init();
});
