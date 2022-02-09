var settingsRequests = function (){
    var updateProfilePhoto = function (){
        $('#update_profile_pic').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('#update_profile_pic').attr('disabled', true);
                    $("#update_profile_pic :input").prop("readonly", true);
                    $("#update_profile_pic").LoadingOverlay("show",{
                        text        : "uploading",
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
                            $('#update_profile_pic').attr('disabled', false);
                            $("#update_profile_pic").LoadingOverlay("hide");
                            $("#update_profile_pic :input").prop("readonly", false);
                            $("#update_profile_pic")[0].reset();
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
                            $('#update_profile_pic').attr('disabled', false);
                            $("#update_profile_pic").LoadingOverlay("hide");
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
                        $('#update_profile_pic').attr('disabled', false);
                        $("#update_profile_pic").LoadingOverlay("hide");
                        $("#update_profile_pic :input").prop("readonly", false);
                        $("#update_profile_pic")[0].reset();
                    }, 3000);
                }
            });
        }));
        $("#update_profile_pic").on("change", function() {
            $("#update_profile_pic").submit();
        });
    }
    var updatePassword = function (){
        $('#change_password').on('submit',(function(e) {
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
                    $('#update_password').attr('disabled', true);
                    $("#change_password :input").prop("readonly", true);
                    $("#update_password").LoadingOverlay("show",{
                        text        : "updating",
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
                            $('#update_password').attr('disabled', false);
                            $("#update_password").LoadingOverlay("hide");
                            $("#change_password :input").prop("readonly", false);
                            $("#change_password")[0].reset();
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
                            $('#update_password').attr('disabled', false);
                            $("#update_password").LoadingOverlay("hide");
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
                        $('#update_password').attr('disabled', false);
                        $("#update_password").LoadingOverlay("hide");
                        $("#change_password :input").prop("readonly", false);
                        $("#change_password")[0].reset();
                    }, 3000);
                }
            });
        }));
    }
    var updateProfile = function (){
        $('#updateProfile').on('submit',(function(e) {
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
                    $('#update_profile').attr('disabled', true);
                    $("#updateProfile :input").prop("readonly", true);
                    $("#update_profile").LoadingOverlay("show",{
                        text        : "updating",
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
                            $('#update_profile').attr('disabled', false);
                            $("#update_profile").LoadingOverlay("hide");
                            $("#updateProfile :input").prop("readonly", false);
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
                            $('#update_profile').attr('disabled', false);
                            $("#update_profile").LoadingOverlay("hide");
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
                        $('#update_profile').attr('disabled', false);
                        $("#update_profile").LoadingOverlay("hide");
                        $("#updateProfile :input").prop("readonly", false);
                    }, 3000);
                }
            });
        }));
    }
    var updateSecurity = function (){
        $('#updateSecurity').on('submit',(function(e) {
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
                    $('#update_security').attr('disabled', true);
                    $("#updateSecurity :input").prop("readonly", true);
                    $("#update_security").LoadingOverlay("show",{
                        text        : "updating",
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
                            $('#update_security').attr('disabled', false);
                            $("#update_security").LoadingOverlay("hide");
                            $("#updateSecurity :input").prop("readonly", false);
                            $("#updateSecurity")[0].reset();
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
                            $('#update_security').attr('disabled', false);
                            $("#update_security").LoadingOverlay("hide");
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
                        $('#update_security').attr('disabled', false);
                        $("#update_security").LoadingOverlay("hide");
                        $("#updateSecurity :input").prop("readonly", false);
                        $("#updateSecurity")[0].reset();
                    }, 3000);
                }
            });
        }));
    }
    return {
        init: function() {
            updateProfilePhoto();
            updatePassword();
            updateProfile();
            updateSecurity();
        }
    };
}();
jQuery(document).ready(function() {
    settingsRequests.init();
});
