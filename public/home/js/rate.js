/**
 *  Class Definition for authentication into the app
 *  This class houses dashboard requests for
 *  exchange rates
 */
var rateRequests = function (){

    var getExchangeRateReady = function(){
        $(document).ready(function () {
            var coin = $('#crypto').val();
            var curr = $('#fiat').val();
            var cryptoAmout = $('#crypto_amount').val();
            var fiat_amount;
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'crypto_to_fiat/'+coin+'/'+curr+'/'+cryptoAmout,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('#crypto').attr('disabled', true);
                    $('#fiat').attr('disabled', true);
                    $("#exchange").LoadingOverlay("show",{
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
                            $('#crypto').attr('disabled', false);
                            $('#fiat').attr('disabled', false);
                            $("#exchange").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('#fiat_amount').val(data.data.rate);
                        //return to natural stage
                        $('#fiat').attr('disabled', false);
                        $('#crypto').attr('disabled', false);
                        $("#exchange").LoadingOverlay("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){

                    console.log(errorThrown);
                    //return to natural stage
                    setTimeout(function(){
                        $("#exchange").LoadingOverlay("hide");
                        $('#crypto').attr('disabled', false);
                        $('#fiat').attr('disabled', false);
                    }, 3000);
                }

            });
        });
    }
    var getExchangeRateCrypto = function(){

        $('#fiat').on('change',(function() {
            var curr = $(this).val();
        }));

        $('#crypto_amount').on('keyup',(function(e) {
            var cryptoAmout = $(this).val();
            var coin = $('#crypto').val();
            var curr = $('#fiat').val();
            var fiat_amount;
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'crypto_to_fiat/'+coin+'/'+curr+'/'+cryptoAmout,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('#crypto').attr('disabled', true);
                    $('#fiat').attr('disabled', true);
                    $("#exchange").LoadingOverlay("show",{
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
                            $('#crypto').attr('disabled', false);
                            $('#fiat').attr('disabled', false);
                            $("#exchange").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('#fiat_amount').val(data.data.rate);
                        //return to natural stage
                        $('#fiat').attr('disabled', false);
                        $('#crypto').attr('disabled', false);
                        $("#exchange").LoadingOverlay("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    // toastr.options = {
                    //     "closeButton" : true,
                    //     "progressBar" : true
                    // }
                    // toastr.error(errorThrown);
                    //return to natural stage
                    $("#exchange").LoadingOverlay("hide");
                    $('#crypto').attr('disabled', false);
                    $('#fiat').attr('disabled', false);
                    $('#fiat_amount').val('0');
                    $('#crypto_amount').val('0');
                }

            });
        }));
        $('#fiat_amount').on('keyup',(function(e) {
            var cryptoAmout;
            var fiat_amount= $(this).val();
            var coin = $('#crypto').val();
            var curr = $('#fiat').val();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'fiat_to_crypto/'+coin+'/'+curr+'/'+fiat_amount,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('#crypto').attr('disabled', true);
                    $('#fiat').attr('disabled', true);
                    $("#exchange").LoadingOverlay("show",{
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
                            $('#crypto').attr('disabled', false);
                            $('#fiat').attr('disabled', false);
                            $("#exchange").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('#crypto_amount').val(data.data.rate);
                        //return to natural stage
                        $('#fiat').attr('disabled', false);
                        $('#crypto').attr('disabled', false);
                        $("#exchange").LoadingOverlay("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    // toastr.options = {
                    //     "closeButton" : true,
                    //     "progressBar" : true
                    // }
                    // toastr.error(errorThrown);
                    //return to natural stage
                    $("#exchange").LoadingOverlay("hide");
                    $('#crypto').attr('disabled', false);
                    $('#fiat').attr('disabled', false);
                    $('#fiat_amount').val('0');
                    $('#crypto_amount').val('0');
                }

            });
        }));
    }
    var getCryptoRate = function(){
        $('#crypto').on('change',(function() {
            $('#crypto_amount').val('0');
            $('#fiat_amount').val('0');
        }));
        $('#fiat').on('change',(function() {
            $('#crypto_amount').val('0');
            $('#fiat_amount').val('0');
        }));
    }
    return {
        init: function() {
            getExchangeRateReady();
            getExchangeRateCrypto();
            getCryptoRate();
        }
    };
}();

jQuery(document).ready(function() {
    rateRequests.init();
});
