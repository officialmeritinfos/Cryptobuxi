@if($user->id == $offering->user)
<!-- Topup Trade Offer-->
<div class="modal" id="topupTradeOffer">
    <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Top Up Trade Listing</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="create_offer_form" action="{{url('account/trades/top_up_offering')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Amount To Add
                                <sup class="text-danger" id="amount_curr">*</sup>
                            </label>
                            <input type="text" class="form-control form-control-lg input-amount" name="amount"
                                   value="0" id="amount">
                            <span class="text-warning text-center">
                                 This amount will be debited from your {{$offering->asset}} Trading Balance to fund this action
                             </span>
                        </div>
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">
                                Reference
                            </label>
                            <input type="text" class="form-control form-control-lg"
                                   name="id" value="{{$offering->reference}}">
                        </div>
                        <div class="form-group col-md-12 mx-auto">
                            <label for="exampleInputEmail1" class="form-label">
                                Account Pin
                            </label>
                            <input type="password" class="form-control form-control-lg"
                                   name="pin" maxlength="6" minlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        @if ($user->setPin == 1)
                            <button type="submit" class="btn btn-primary text-center mt-4 mb-0" id="submit_create_crypto_offer">
                                <i class="fa fa-check-circle"></i> Top up</button>
                        @else
                            <br>
                            <p class="text-danger">
                                You need to set your account pin first before you can initiate this
                                transaction.
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Trade Offer-->
<div class="modal" id="cancelTradeOffer">
    <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Cancel Trade Listing</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="cancel_crypto_offer_form" action="{{url('account/trades/cancel_offering')}}">
                    @csrf
                    <p style="font-size:15px;"
                       class="text-warning text-center"> Are you sure you want to cancel this Offer? <br> Once cancelled,
                        it cannot be reactivated. All pending sales associated with it will be cancelled.
                    </p>
                    <div class="row">
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">
                                Reference
                            </label>
                            <input type="text" class="form-control form-control-lg"
                                   name="id" value="{{$offering->reference}}">
                        </div>
                        <div class="form-group col-md-12 mx-auto">
                            <label for="exampleInputEmail1" class="form-label">
                                Account Pin
                            </label>
                            <input type="password" class="form-control form-control-lg"
                                   name="pin" maxlength="6" minlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        @if ($user->setPin == 1)
                            <button type="submit" class="btn btn-danger text-center mt-4 mb-0"
                                    id="submit_cancel_crypto_offer">
                                <i class="fa fa-ban"></i> Cancel</button>
                        @else
                            <br>
                            <p class="text-danger">
                                You need to set your account pin first before you can initiate this
                                transaction.
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@if ($user->id != $offering->user)
    @inject('wallets','App\Custom\Regular' )
    <!-- Accept Fiat Loan Offer-->
    <div class="modal" id="acceptTradeOffer">
        <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header">
                    <h1 class="modal-title">Buy {{$coin->name}}</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-left p-4" >
                    <form method="POST" id="accept_fiat_offer_forms" action="{{url('account/trades/buy')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6" style="display:none;">
                                <label for="exampleInputEmail1" class="form-label">Asset
                                    <sup class="text-danger" id="asset">*</sup>
                                </label>
                                <input type="text" class="form-control form-control-lg" name="amount"
                                       value="{{$offering->asset}}" id="asset">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Amount
                                    <sup class="text-danger" id="amount_curr">{{$currency->signs}} *</sup>
                                </label>
                                <input type="text" class="form-control form-control-lg input-amount" name="amount"
                                       value="0" id="amounts">
                            </div>
                            <div class="form-group col-md-6" id="equi">
                                <label for="exampleInputEmail1" class="form-label">Equivalent
                                    <sup class="text-success" id="curr_rate">{{$coin->asset}}</sup>
                                </label>
                                <input type="text" class="form-control form-control-lg input-amount"
                                       name="rates" readonly>
                            </div>
                            <div class="form-group col-md-12" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">
                                    Reference
                                </label>
                                <input type="text" class="form-control form-control-lg"
                                       name="id" value="{{$offering->reference}}">
                            </div>
                            <div class="form-group col-md-12" id="dest_detail">
                                <label for="exampleInputEmail1" class="form-label">
                                    To
                                </label>
                                <input type="text" class="form-control form-control-lg" name="details"
                                       placeholder="wallet address">
                                <small class="text-primary">
                                    Leave empty if you want the purchased asset to be sent into your {{$siteName}}
                                    wallet.
                                </small>
                            </div>
                            <div class="form-group col-md-12 mx-auto">
                                <label for="exampleInputEmail1" class="form-label">
                                    Account Pin
                                </label>
                                <input type="password" class="form-control form-control-lg"
                                       name="pin" maxlength="6" minlength="6">
                            </div>
                        </div>
                        <div class="form-group col-md-12" id="balanceRow">
                            <span class="pull-left" id="bal_texts"> Fee</span>
                            <span class="pull-right">
                                =
                                <span class="text-success">{{$currency->signs}}</span><span id="fee"> </span>
                            </span>
                            <br><br>
                            <span class="pull-left" id="bal_texts"> Amount To Pay</span>
                            <span class="pull-right">
                                =
                                <span class="text-success">{{$currency->signs}}</span><span id="fees"> </span>
                            </span>
                        </div><br><br>
                        <div class="text-center">
                            @if ($user->setPin == 1)
                                <button type="submit" class="btn btn-success text-center mt-4 mb-0"
                                        id="submit_accept_crypto_offer">
                                    <i class="fa fa-credit-card"></i> Purchase</button>
                            @else
                                <br>
                                <p class="text-danger">
                                    You need to set your account pin first before you can initiate this
                                    transaction.
                                </p>
                            @endif
                        </div><br>
                        <div class="form-group col-md-12">
                            <small class="text-primary">
                                By clicking the Purchase button above, you agree to the trading terms of the trader,
                                and to the {{$siteName}} terms of operation.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
