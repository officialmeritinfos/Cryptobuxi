/**
 *  Class Definition for authentication into the app
 *  This class houses dashboard requests for
 *  set pin, send , receive,
 *  buy, sell etc
 */
 var dashboardRequests = function (){
    //set account Pin
    var setPin = function () {
        $('#set_trans_pin').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#set_trans_pin').attr('action');
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
                    $('#submit_pin').attr('disabled', true);
                    $("#set_trans_pin :input").prop("readonly", true);
                    $("#submit_pin").LoadingOverlay("show",{
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
                            $('#submit_pin').attr('disabled', false);
                            $("#set_trans_pin :input").prop("readonly", false);
                            $("#submit_pin").LoadingOverlay("hide");
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
                            $('#submit_pin').attr('disabled', false);
                            $("#set_trans_pin :input").prop("readonly", false);
                            $("#submit_pin").LoadingOverlay("hide");
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
                        $('#set_trans_pin :input').prop('readonly', false);
                        $("#submit_pin").LoadingOverlay("hide");
                        $('#submit_pin').attr('disabled', false);
                    }, 3000);
                }

            });
        });
    }
    var updateTheme = function (){
        $('input[name="dark"]').change(function() {
            var theme = Cookies.get('theme');
            if(this.checked) {
                if (theme ==='dark-mode'){
                    $('body').removeClass('dark-mode dark-sidebar');
                    $('body').addClass('light-mode light-sidebar');
                    Cookies.set('theme','light-mode');
                }else{
                    $('body').addClass('dark-mode dark-sidebar');
                    $('body').removeClass('light-mode light-sidebar');
                    Cookies.set('theme','dark-mode');
                }
            }else{
                if (theme ==='dark-mode'){
                    $('body').removeClass('dark-mode dark-sidebar');
                    $('body').addClass('light-mode light-sidebar');
                    Cookies.set('theme','light-mode');
                }else{
                    $('body').addClass('dark-mode dark-sidebar');
                    $('body').removeClass('light-mode light-sidebar');
                    Cookies.set('theme','dark-mode');
                }
            }
        });
    }
    /*var updateTheme = function (){
        $("#theme").click(function() {
            var theme = Cookies.get('theme');
            if (theme === 'dark-mode') {
                $("body").toggleClass("light-mode light-sidebar");
                Cookies.set('theme','light-mode');
            } else {
                $("body").toggleClass("dark-mode dark-sidebar");
                Cookies.set('theme','dark-mode');
            }
        });
    }*/
    var webTheme = function (){
        $(document).ready(function () {
            var theme = Cookies.get('theme');
            if (theme === 'dark-mode'){
                $('body').removeClass('light-mode light-sidebar');
                $('body').addClass('dark-mode dark-sidebar');
            }else{
                $('body').removeClass('dark-mode dark-sidebar');
                $('body').addClass('light-mode light-sidebar');
            }
        });
    }
    var submitVerification = function (){
        $('#verificationForm').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: $(this).attr('action'),
                type:'POST',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('#submit_verify').attr('disabled', true);
                    $("#verificationForm :input").prop("readonly", true);
                    $("#submit_verify").LoadingOverlay("show",{
                        text        : "please wait",
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
                            $('#submit_verify').attr('disabled', false);
                            $("#submit_verify").LoadingOverlay("hide");
                            $("#verificationForm :input").prop("readonly", false);
                            $("#submit_verify")[0].reset();
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
                            $('#submit_verify').attr('disabled', false);
                            $("#submit_verify").LoadingOverlay("hide");
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
                        $('#submit_verify').attr('disabled', false);
                        $("#submit_verify").LoadingOverlay("hide");
                        $("#verificationForm :input").prop("readonly", false);
                        $("#submit_verify")[0].reset();
                    }, 3000);
                }
            });
        }));
    }
    var submitVerificationDoc = function (){
        $('#verificationFormDoc').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: $(this).attr('action'),
                type:'POST',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('#submit_verifys').attr('disabled', true);
                    $("#verificationFormDoc :input").prop("readonly", true);
                    $("#submit_verifys").LoadingOverlay("show",{
                        text        : "please wait",
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
                            $('#submit_verifys').attr('disabled', false);
                            $("#submit_verifys").LoadingOverlay("hide");
                            $("#verificationFormDoc :input").prop("readonly", false);
                            $("#submit_verifys")[0].reset();
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
                            $('#submit_verifys').attr('disabled', false);
                            $("#submit_verifys").LoadingOverlay("hide");
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
                        $('#submit_verifys').attr('disabled', false);
                        $("#submit_verifys").LoadingOverlay("hide");
                        $("#verificationFormDoc :input").prop("readonly", false);
                        $("#submit_verifys")[0].reset();
                    }, 3000);
                }
            });
        }));
    }
    var closeModal = function (){
        $('#verificationdoc').on('show.bs.modal', function (event) {
            $('#buy_sell').modal('hide');
        });
        $('#verificationdoc').on('hide.bs.modal', function (event) {
            $('#buy_sell').modal('show');
        });
    }
    var getUserReceiveWallet = function(){
        $('select[name="receiveasset"]').on('change',(function(e) {
            var coin = $(this).val();
            $('#qrcode').empty();
            $('#wallets').empty();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/get_receive_wallet/'+coin,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('select[name="receiveasset"]').attr('disabled', true);
                    $("#qrcodes").LoadingOverlay("show",{
                        text        : "please wait",
                        size        : "30"
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
                            $('select[name="receiveasset"]').attr('disabled', false);
                            $("#qrcodes").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        $('#qrcode').qrcode(data.data.address);
                        $('#wallets').text(data.data.address);
                        $('#notes').text(data.data.note);
                        $('#bal_text').text(coin+' Balance ');
                        $('#balance').text(data.data.balance+' '+coin);
                        $('#fiat').text(data.data.exRate+' '+data.data.fiat);
                        $('#balanceRow').show();
                        $('#wallet').show();
                        //return to natural stage
                        $('select[name="receiveasset"]').attr('disabled', false);
                        $("#qrcodes").LoadingOverlay("hide");
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
                        $("#qrcodes").LoadingOverlay("hide");
                        $('select[name="receiveasset"]').attr('disabled', false);
                    }, 3000);
                }

            });
        }));
    }
    var getUserReadyReceiveWallet = function(){
        $(document).ready(function () {
            var coin = $('select[name="receiveasset"]').val();
            $('#qrcode').empty();
            $('#wallets').empty();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/get_receive_wallet/'+coin,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('select[name="receiveasset"]').attr('disabled', true);
                    $("#qrcodes").LoadingOverlay("show",{
                        text        : "please wait",
                        size        : "30"
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
                            $('select[name="receiveasset"]').attr('disabled', false);
                            $("#qrcodes").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        $('#qrcode').qrcode(data.data.address);
                        $('#wallets').text(data.data.address);
                        $('#notes').text(data.data.note);
                        $('#bal_text').text(coin+' Balance ');
                        $('#balance').text(data.data.balance+' '+coin);
                        $('#fiat').text(data.data.exRate+' '+data.data.fiat);
                        $('#balanceRow').show();
                        $('#wallet').show();
                        //return to natural stage
                        $('select[name="receiveasset"]').attr('disabled', false);
                        $("#qrcodes").LoadingOverlay("hide");
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
                        $("#qrcodes").LoadingOverlay("hide");
                        $('select[name="receiveasset"]').attr('disabled', false);
                    }, 3000);
                }

            });
        });
    }
    return {
        init: function() {
            setPin();
            updateTheme();
            webTheme();
            submitVerification();
            submitVerificationDoc();
            closeModal();
            getUserReceiveWallet();
            getUserReadyReceiveWallet();
        }
    };
}();

jQuery(document).ready(function() {
    dashboardRequests.init();
});
