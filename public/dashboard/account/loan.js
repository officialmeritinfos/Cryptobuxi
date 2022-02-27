var loanRequests = function (){
    var cryptoLoanOffering = function (){
        $('#create_offer_form').on('submit',(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit_create_crypto_offer').attr('disabled', true);
                    $("#create_offer_form :input").prop("readonly", true);
                    $("#submit_create_crypto_offer").LoadingOverlay("show",{
                        text        : "initializing",
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
                            $('#submit_create_crypto_offer').attr('disabled', false);
                            $("#submit_create_crypto_offer").LoadingOverlay("hide");
                            $("#create_offer_form :input").prop("readonly", false);
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
                            $('#submit_create_crypto_offer').attr('disabled', false);
                            $("#submit_create_crypto_offer").LoadingOverlay("hide");
                            location.reload();
                        }, 6000);
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
                        $('#submit_create_crypto_offer').attr('disabled', false);
                        $("#submit_create_crypto_offer").LoadingOverlay("hide");
                        $("#create_offer_form :input").prop("readonly", false);
                    }, 3000);
                }
            });
        }));
    }
    var cancelCryptoLoanOffering = function (){
        $('#cancel_crypto_offer_form').on('submit',(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit_cancel_crypto_offer').attr('disabled', true);
                    $("#cancel_crypto_offer_form :input").prop("readonly", true);
                    $("#submit_cancel_crypto_offer").LoadingOverlay("show",{
                        text        : "cancelling",
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
                            $('#submit_cancel_crypto_offer').attr('disabled', false);
                            $("#submit_cancel_crypto_offer").LoadingOverlay("hide");
                            $("#cancel_crypto_offer_form :input").prop("readonly", false);
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
                            $('#submit_cancel_crypto_offer').attr('disabled', false);
                            $("#submit_cancel_crypto_offer").LoadingOverlay("hide");
                            location.reload();
                        }, 6000);
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
                        $('#submit_cancel_crypto_offer').attr('disabled', false);
                        $("#submit_create_crypto_offer").LoadingOverlay("hide");
                        $("#submit_cancel_crypto_offer :input").prop("readonly", false);
                    }, 3000);
                }
            });
        }));
    }
    return {
        init: function() {
            cryptoLoanOffering();
            cancelCryptoLoanOffering();
        }
    };
}();
jQuery(document).ready(function() {
    loanRequests.init();
});
