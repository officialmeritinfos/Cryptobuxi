var tradeRequests = function (){
    var calculateTradeRateFromOffering = function (){
        $('#acceptTradeOffer').on('show.bs.modal', function (event) {
            //if the amount is changed
            $('#amounts').on('keyup',(function() {
                var amount = $(this).val();
                var reference = $("input[name='id']").val();
                baseUrl = '';
                var url = baseUrl+'/get_trade_offer_rate/'+reference+'/'+amount;
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
                        $('input[name="rates"]').LoadingOverlay("show",{
                            text        : "calculating",
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
            }));
        });
    }
    var calculateTradeFee = function (){
        $('#acceptTradeOffer').on('show.bs.modal', function (event) {
            //if the amount is changed
            $('#amounts').on('keyup',(function() {
                var amount = $(this).val();
                baseUrl = '';
                var url = baseUrl+'/get_trade_fee/'+amount;
                //send request to get the trading fee
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
                        $('input[name="fee"]').LoadingOverlay("show",{
                            text        : "calculating",
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
                                $('input[name="fee"]').LoadingOverlay("hide");
                            }, 3000);
                        }
                        if(data.success)
                        {
                            $('#fee').html(data.data.charge);
                            $('#fees').html(data.data.amountToPay);
                            //return to natural stage
                            $('#submit_send').attr('disabled', false);
                            $('input[name="fee"]').LoadingOverlay("hide");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown);
                        //return to natural stage
                        $('input[name="fee"]').LoadingOverlay("hide");
                        $('#submit_send').attr('disabled', false);
                    }

                });
            }));
        });
    }

    return {
        init: function() {
            calculateTradeRateFromOffering();
            calculateTradeFee();
        }
    };
}();
jQuery(document).ready(function() {
    tradeRequests.init();
});
