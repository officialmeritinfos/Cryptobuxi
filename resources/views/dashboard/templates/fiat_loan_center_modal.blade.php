
        @inject('wallets','App\Custom\Regular' )
        <!-- Create Loan Offer-->
        <div class="modal" id="create_crypto_offer">
            <div class="modal-dialog modal-dialog-centered modal-lg text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Create a Fiat Loan Offer</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-left p-4" >
                        <form method="POST" id="create_offer_form" action="{{url('account/loans/create_fiat_loan_offering')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Currency</label>
                                    <select  class="form-control form-control-lg" name="currency">
                                        @foreach ($fiat_balances as $balance)
                                            <option value="{{$balance->currency}}">{{$balance->currency}} ({{$balance->availableBalance}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Amount
                                        <sup class="text-danger" id="amount_curr">*</sup>
                                    </label>
                                    <input type="txt" class="form-control form-control-lg input-amount" name="amount"
                                    value="0" id="amount">
                                    <span class="text-warning text-center"> This amount will be debited from your available Balance above to fund this offering</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">
                                        APR (%)
                                    </label>
                                    <input type="number" class="form-control form-control-lg"
                                    name="apr" placeholder="APR">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Minimum Amount Loanable
                                    </label>
                                    <input type="text" class="form-control form-control-lg input-amount"
                                    name="min_loan" placeholder="Minimum Loanable Amount">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Maximum Amount Loanable
                                    </label>
                                    <input type="text" class="form-control form-control-lg"
                                    name="max_loan" placeholder="Maximum Loanable Amount">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Duration Type</label>
                                    <select  class="form-control form-control-lg" name="duration_type">
                                        @foreach ($intervals as $interval)
                                            <option value="{{$interval->id}}">{{$interval->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Duration
                                    </label>
                                    <input type="number" class="form-control form-control-lg "
                                    name="duration" value="1">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Minimum Loan Duration
                                    </label>
                                    <input type="number" class="form-control form-control-lg"
                                    name="min_duration" value="1">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Maximum Loan Duration
                                    </label>
                                    <input type="number" class="form-control form-control-lg"
                                    name="max_duration" value="2">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Collateral Asset</label>
                                    <select  class="form-control form-control-lg" name="collateral">
                                        <option value="all">All</option>
                                        @foreach ($coins as $coin)
                                            <option value="{{$coin->asset}}">{{$coin->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mx-auto">
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
