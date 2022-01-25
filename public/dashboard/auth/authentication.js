/**
 *  Class Definition for authentication into the app
 *  This class houses authentication requests for
 *  login, registration, two factor authentication
 *  password reset, email verification etc
 */
var authenticationRequests = function (){
    //registration request
    var newRegistration = function (){
        $('#create_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#create_account').attr('action');
            var baseURLs='';
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
                    $('#submit').attr('disabled', true);
                    $("#create_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "creating account",
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
                            $('#submit').attr('disabled', false);
                            $("#submit").LoadingOverlay("hide");
                            $("#create_account :input").prop("readonly", false);
                            $("#create_account")[0].reset();
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.needVerification == true){
                            var pageTo = data.data.redirect_to;
                        }else{
                            var pageTo = data.data.redirect_to;
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#submit").LoadingOverlay("hide");
                            $("#create_account :input").prop("readonly", false);
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#create_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#submit").LoadingOverlay("hide");
                },
            });
        });
    }

    //login request
    var login = function (){
        $('#login_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#login_account').attr('action');
            var baseURLs='';
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
                    $('#submit').attr('disabled', true);
                    $("#login_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "logging in",
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
                            $('#submit').attr('disabled', false);
                            $("#login_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.needVerification == true){
                            var pageTo = data.data.redirect_to;
                        }else if (data.data.needAuth == true){
                            var pageTo = data.data.redirect_to;
                        }else{
                            var pageTo = data.data.redirect_to;
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#login_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#login_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //recover account request
    var recoverPassword = function (){
        $('#recover_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#recover_account').attr('action');
            var baseURLs='';
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
                    $('#submit').attr('disabled', true);
                    $("#recover_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "verifying",
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
                            $('#submit').attr('disabled', false);
                            $("#recover_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {

                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#recover_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                            location.reload();
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#recover_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#recover_account").LoadingOverlay("hide");
                    setTimeout(function(){
                        location.reload();
                    }, 5000);
                },
            });
        });
    }
    //change password request
    var changePassword = function (){
        $('#change_password').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#change_password').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#change_password :input").prop("readonly", true);
                    $("#change_password").LoadingOverlay("show",{
                        text        : "reseting",
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
                            $('#submit').attr('disabled', false);
                            $("#change_password :input").prop("readonly", false);
                            $("#change_password").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.reset == true){

                            var pageTo = data.data.redirect_to;
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#change_password :input").prop("readonly", false);
                            location.href='../../../login';
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#change_password :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#change_password").LoadingOverlay("hide");
                },
            });
        });
    }
    return {
        init: function() {
            newRegistration();
            login();
            recoverPassword();
            changePassword();
        }
    };
}();

jQuery(document).ready(function() {
    authenticationRequests.init();
});
