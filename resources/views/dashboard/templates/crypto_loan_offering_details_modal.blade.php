
 @if($user->id == $offering->user)
        <!-- Topup Crypto Loan Offer-->
        <div class="modal" id="topupCryptoLoan">
            <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Top Up Loan Offering</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-left p-4" >
                        <form method="POST" id="create_offer_form" action="{{url('account/loans/top_up_crypto_loan_offering')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Amount To Add
                                        <sup class="text-danger" id="amount_curr">*</sup>
                                    </label>
                                    <input type="txt" class="form-control form-control-lg input-amount" name="amount"
                                    value="0" id="amount">
                                    <span class="text-warning text-center">
                                        This amount will be debited from your {{$offering->asset}} Balance to fund this offering
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

        <!-- Cancel Crypto Loan Offer-->
        <div class="modal" id="cancelCryptoLoanOffer">
            <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Cancel Loan Offering</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-left p-4" >
                        <form method="POST" id="cancel_crypto_offer_form" action="{{url('account/loans/cancel_crypto_loan_offering')}}">
                            @csrf
                            <p style="font-size:15px;"
                                class="text-warning text-center"> Are you sure you want to cancel this Offer? <br> Once cancelled,
                                it cannot be reactivated. If there is any active loan associated with this offer, it will still
                                complete.
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
    <!-- Accept Crypto Loan Offer-->
    <div class="modal" id="acceptCryptoLoanOffer">
        <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header">
                    <h1 class="modal-title">Accept Loan Offering</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-left p-4" >
                    <form method="POST" id="cancel_crypto_offer_form" action="{{url('account/loans/accept_crypto_loan_offering')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1" class="form-label">
                                   Amount
                                </label>
                                <input type="text" class="form-control form-control-lg input-amount"
                                name="amount">
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
                            <div class="form-group col-md-12">
                                <small class="text-primary">
                                    By clicking the Accept button below, you agree to the resale terms of the trader, and to
                                    the {{$siteName}} terms of operation.
                                </small>
                            </div>
                        </div>
                        <div class="text-center">
                            @if ($user->setPin == 1)
                                <button type="submit" class="btn btn-success text-center mt-4 mb-0"
                                id="submit_cancel_crypto_offer">
                                <i class="fa fa-check-circle"></i> Accept</button>
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
