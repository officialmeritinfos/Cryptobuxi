
@inject('wallets','App\Custom\Regular' )
<!-- Create Loan Offer-->
<div class="modal" id="create_trade_offer">
    <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Create a List</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="create_offer_form" action="{{url('account/trades/create_trade_offering')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Asset</label>
                            <select  class="form-control form-control-lg select2-show-search" name="asset">
                                <option value="">Select Asset To List</option>
                                @foreach ($trading_balances as $wallet)
                                    <option value="{{$wallet->asset}}">{{$wallet->asset}} ({{$wallet->availableBalance}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Amount
                                <sup class="text-danger" id="amount_curr">*</sup>
                            </label>
                            <input type="txt" class="form-control form-control-md input-amount" name="amount"
                                   value="0" id="amount">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Fiat
                            </label>
                            <select  class="form-control form-control-lg select2-show-search" name="fiat">
                                <option value="">Select Fiat to Trade Against</option>
                                @foreach ($fiats as $fiat)
                                    <option value="{{$fiat->code}}">{{$fiat->currency}} -
                                        (<sup>{{$fiat->signs}}</sup>{{$fiat->rateUsd}}/$)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">
                                Rate
                            </label>
                            <input type="number" class="form-control form-control-md input-amount"
                                   name="percent" placeholder="Your rate">
                            <small class="text-danger text-center" style="font-size:10px;">Leave this empty to use the system rate. Any Amount you
                            input here will be used to calculate the rate of your sales. This will be adjusted
                            against the rate for each trading day.</small>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">
                                Account Pin
                            </label>
                            <input type="password" class="form-control form-control-md input-amount"
                                   name="pin" maxlength="6" minlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        @if ($user->setPin == 1)
                            <button type="submit" class="btn btn-primary text-center mt-4 mb-0" id="submit_create_crypto_offer">
                                <i class="fa fa-check-circle"></i> Create</button>
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
