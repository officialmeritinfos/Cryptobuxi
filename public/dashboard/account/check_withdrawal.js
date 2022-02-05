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
                var base_curr = $("input[name='base_curr']").val();
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
    return {
        init: function() {
            checkBaseCurrency();
            getWithdrawalRate();
        }
    };
}();

jQuery(document).ready(function() {
    withdrawalRequests.init();
});
