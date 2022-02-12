@include('dashboard.templates.header')
<!-- Row -->
                <div class="row">
                    <div class="col-md-6">
                        <!--div-->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Deposits</div>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="table-responsive">
                                        @isset($deposits)
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Asset</th>
                                                    <th class="border-bottom-0">Amount</th>
                                                    <th class="border-bottom-0">Receiving Address</th>
                                                    <th class="border-bottom-0">Transaction Hash</th>
                                                    <th class="border-bottom-0">Time Received</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($deposits as $deposit)
                                                    <tr>
                                                        <td>{{$deposit->asset}}</td>
                                                        <td>{{$deposit->amount}}</td>
                                                        <td>
                                                            <span class="badge badge-primary break-text">
                                                                <a href="{{url($coin->walletExplorer.$deposit->addressTo)}}" target="_blank">
                                                                    {{$deposit->addressTo}}
                                                                </a>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info break-text">
                                                                <a href="{{url($coin->transactionExplorer.$deposit->transHash)}}" target="_blank">
                                                                    {{$deposit->transHash}}
                                                                </a>
                                                            </span>
                                                        </td>
                                                        <td>{{$deposit->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                    </div>
                    <div class="col-md-6">
                        <!--div-->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Withdrawals</div>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="table-responsive">
                                        @isset($withdrawals)
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Reference</th>
                                                    <th class="border-bottom-0">Asset</th>
                                                    <th class="border-bottom-0">Amount</th>
                                                    <th class="border-bottom-0">Destination</th>
                                                    <th class="border-bottom-0">Time Created</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($withdrawals as $withdrawal)
                                                    <tr>
                                                        <td>
                                                            <a href="{{url('account/withdrawals/'.$withdrawal->reference.'/details')}}" class="badge badge-dark">
                                                                {{$withdrawal->reference}}
                                                            </a>
                                                        </td>
                                                        <td>{{$withdrawal->asset}}</td>
                                                        <td>{{$withdrawal->amount}}</td>
                                                        <td>
                                                            @switch($withdrawal->destination)
                                                                @case(1)
                                                                    <span class="badge badge-info">Trading Account</span>
                                                                    @break
                                                                @case(2)
                                                                    <span class="badge badge-warning">{{config('app.name')}} User </span>
                                                                    @break
                                                                @default
                                                                    <span class="badge badge-primary break-text"> {{$withdrawal->addressTo}} </span>
                                                            @endswitch
                                                        </td>
                                                        <td>{{$withdrawal->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            {{$withdrawals->links()}}
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                    </div>

                    <div class="col-md-6">
                        <!--div-->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Crypto Loans</div>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="table-responsive">
                                        @isset($crypto_loans)
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Reference</th>
                                                    <th class="border-bottom-0">Asset</th>
                                                    <th class="border-bottom-0">Amount</th>
                                                    <th class="border-bottom-0">Status</th>
                                                    <th class="border-bottom-0">Time Created</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($crypto_loans as $crypto_loan)
                                                    <tr>
                                                        <td>
                                                            <a href="{{url('account/loans/crypto/'.$crypto_loan->reference.'/details')}}" class="badge badge-primary">
                                                                {{$crypto_loan->reference}}
                                                            </a>
                                                        </td>
                                                        <td>{{$crypto_loan->asset}}</td>
                                                        <td>{{$crypto_loan->amount}}</td>
                                                        <td>
                                                            @switch($crypto_loan->status)
                                                                @case(1)
                                                                    <span class="badge badge-success">Completed</span>
                                                                    @break
                                                                @case(4)
                                                                    <span class="badge badge-warning">On Hold</span>
                                                                    @break
                                                                @case(3)
                                                                    <span class="badge badge-danger">Cancelled</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge badge-primary"> Pending Repayment </span>
                                                            @endswitch
                                                        </td>
                                                        <td>{{$crypto_loan->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            {{$crypto_loans->links()}}
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                    </div>

                    <div class="col-md-6">
                        <!--div-->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Fiat Loans</div>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="table-responsive">
                                        @isset($fiat_loans)
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Reference</th>
                                                    <th class="border-bottom-0">Currency</th>
                                                    <th class="border-bottom-0">Amount</th>
                                                    <th class="border-bottom-0">Status</th>
                                                    <th class="border-bottom-0">Time Created</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($fiat_loans as $fiat_loan)
                                                    <tr>
                                                        <td>
                                                            <a href="{{url('account/loans/fiat/'.$fiat_loan->reference.'/details')}}" class="badge badge-primary">
                                                                {{$fiat_loan->reference}}
                                                            </a>
                                                        </td>
                                                        <td>{{$fiat_loan->fiat}}</td>
                                                        <td>{{$fiat_loan->amount}}</td>
                                                        <td>
                                                            @switch($fiat_loan->status)
                                                                @case(1)
                                                                    <span class="badge badge-success">Completed</span>
                                                                    @break
                                                                @case(4)
                                                                    <span class="badge badge-warning">On Hold</span>
                                                                    @break
                                                                @case(3)
                                                                    <span class="badge badge-danger">Cancelled</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge badge-primary"> Pending Repayment </span>
                                                            @endswitch
                                                        </td>
                                                        <td>{{$fiat_loan->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            {{$fiat_loans->links()}}
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                    </div>

                </div>
                <!-- /Row -->
            </div>
        </div><!-- end app-content-->
    </div>

@include('dashboard.templates.footer')
