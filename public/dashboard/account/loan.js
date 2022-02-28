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
    var calculateFiatLoanData = function (){
        $('#acceptFiatLoanOffer').on('show.bs.modal', function (event) {
            var amount = $("input[name='amount']").val();
            var duration = $("input[name='duration']").val();
            var reference = $("input[name='id']").val();
            baseUrl = '';
            var url = baseUrl+'/get_fiat_loan_computation/'+reference+'/'+duration+'/'+amount;
             //send request to get the loan's details
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
                    $('input[name="payback"]').LoadingOverlay("show",{
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
                            $('input[name="payback"]').LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('input[name="payback"]').val(data.data.payback);
                        //return to natural stage
                        $('#submit_send').attr('disabled', false);
                        $('input[name="payback"]').LoadingOverlay("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                    //return to natural stage
                    $('input[name="payback"]').LoadingOverlay("hide");
                    $('#submit_send').attr('disabled', false);
                }

            });
            //if the amount is changed
            $('#amounts').on('keyup',(function() {
                var amount = $(this).val();
                var duration = $("input[name='duration']").val();
                baseUrl = '';
                var url = baseUrl+'/get_fiat_loan_computation/'+reference+'/'+duration+'/'+amount;
                //send request to get the loan's details
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
                        $('input[name="payback"]').LoadingOverlay("show",{
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
                                $('input[name="payback"]').LoadingOverlay("hide");
                            }, 3000);
                        }
                        if(data.success)
                        {
                            $('input[name="payback"]').val(data.data.payback);
                            //return to natural stage
                            $('#submit_send').attr('disabled', false);
                            $('input[name="payback"]').LoadingOverlay("hide");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown);
                        //return to natural stage
                        $('input[name="payback"]').LoadingOverlay("hide");
                        $('#submit_send').attr('disabled', false);
                    }

                });
            }));
            //if the duration is changed
            $('#durations').on('keyup',(function() {
                var duration = $(this).val();
                var amount = $("input[name='amount']").val();
                baseUrl = '';
                var url = baseUrl+'/get_fiat_loan_computation/'+reference+'/'+duration+'/'+amount;
                //send request to get the loan's details
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
                        $('input[name="payback"]').LoadingOverlay("show",{
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
                                $('input[name="payback"]').LoadingOverlay("hide");
                            }, 3000);
                        }
                        if(data.success)
                        {
                            $('input[name="payback"]').val(data.data.payback);
                            //return to natural stage
                            $('#submit_send').attr('disabled', false);
                            $('input[name="payback"]').LoadingOverlay("hide");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown);
                        //return to natural stage
                        $('input[name="payback"]').LoadingOverlay("hide");
                        $('#submit_send').attr('disabled', false);
                    }

                });
            }));
        });
    }
    var acceptFiatLoan = function (){
        $('#accept_fiat_offer_form').on('submit',(function(e) {
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
                    $('#submit_accept_crypto_offer').attr('disabled', true);
                    $("#accept_fiat_offer_form :input").prop("readonly", true);
                    $("#submit_accept_crypto_offer").LoadingOverlay("show",{
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
                            $('#submit_accept_crypto_offer').attr('disabled', false);
                            $("#submit_accept_crypto_offer").LoadingOverlay("hide");
                            $("#accept_fiat_offer_form :input").prop("readonly", false);
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
                            $('#submit_accept_crypto_offer').attr('disabled', false);
                            $("#submit_accept_crypto_offer").LoadingOverlay("hide");
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
                        $('#submit_accept_crypto_offer').attr('disabled', false);
                        $("#submit_accept_crypto_offer").LoadingOverlay("hide");
                        $("#accept_fiat_offer_form :input").prop("readonly", false);
                    }, 3000);
                }
            });
        }));
    }
    return {
        init: function() {
            cryptoLoanOffering();
            cancelCryptoLoanOffering();
            calculateFiatLoanData();
            acceptFiatLoan();
        }
    };
}();
jQuery(document).ready(function() {
    loanRequests.init();
});
