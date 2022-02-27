@include('dashboard.templates.header')
<!-- Row -->
                <div class="row">
                    @isset($crypto_loans)
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-dark" href="{{url('account/loans/lended')}}" style="margin-bottom: 4px;">
                                    View Lended Asset
                                </a>
                                @if ($user->canBorrow ==1)
                                    <a class="btn btn-primary" href="{{url('account/loan_center')}}" style="margin-bottom: 4px;">
                                        Loan Center
                                    </a>
                                @endif
                                <a class="btn btn-info" href="{{url('account/loans/fiat')}}" style="margin-bottom: 4px;">
                                    Fiat Loan
                                </a>
                            </div>
                            <br><br>
                            <!--div-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{$pageName}}</div>
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
                                                        <th class="border-bottom-0">Resale Rate</th>
                                                        <th class="border-bottom-0">Time Received</th>
                                                        <th class="border-bottom-0">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($crypto_loans as $loan)
                                                        <tr>
                                                            <td>
                                                                <span class="badge badge-info break-text">
                                                                    <a href="{{url('account/loans/collected/'.$loan->reference)}}" target="_blank">
                                                                        {{$loan->reference}}
                                                                    </a>
                                                                </span>
                                                            </td>
                                                            <td>{{$loan->asset}}</td>
                                                            <td>{{$loan->amount}}</td>
                                                            <td>{{$loan->apr}}%</td>
                                                            <td>{{$loan->created_at}}</td>
                                                            <td>
                                                                @switch($loan->status)
                                                                    @case(1)
                                                                        <span class="badge badge-success">Completed</span>
                                                                        @break
                                                                    @case(2)
                                                                        <span class="badge badge-primary">Active</span>
                                                                        @break
                                                                    @default
                                                                        <span class="badge badge-danger">Cancelled</span>
                                                                @endswitch
                                                            </td>
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
                    @endisset

                    @isset($lended_crypto)
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-dark" href="{{url('account/loans')}}" style="margin-bottom: 4px;">
                                    View Borrowed Asset
                                </a>
                                @if ($user->canBorrow ==1)
                                    <a class="btn btn-primary" href="{{url('account/loan_center')}}" style="margin-bottom: 4px;">
                                        Loan Center
                                    </a>
                                @endif
                                <a class="btn btn-info" href="{{url('account/loans/fiat')}}" style="margin-bottom: 4px;">
                                    Fiat Loan
                                </a>
                            </div>
                            <br><br>
                            <!--div-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{$pageName}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <div class="table-responsive">
                                            @isset($lended_crypto)
                                                <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                    <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">Reference</th>
                                                        <th class="border-bottom-0">Asset</th>
                                                        <th class="border-bottom-0">Amount</th>
                                                        <th class="border-bottom-0">Resale Rate</th>
                                                        <th class="border-bottom-0">Time Sent</th>
                                                        <th class="border-bottom-0">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($lended_crypto as $loan)
                                                        <tr>
                                                            <td>
                                                                <span class="badge badge-info break-text">
                                                                    <a href="{{url('account/loans/sent/'.$loan->reference)}}" target="_blank">
                                                                        {{$loan->reference}}
                                                                    </a>
                                                                </span>
                                                            </td>
                                                            <td>{{$loan->asset}}</td>
                                                            <td>{{$loan->amount}}</td>
                                                            <td>{{$loan->apr}}%</td>
                                                            <td>{{$loan->created_at}}</td>
                                                            <td>
                                                                @switch($loan->status)
                                                                    @case(1)
                                                                        <span class="badge badge-success">Completed</span>
                                                                        @break
                                                                    @case(2)
                                                                        <span class="badge badge-primary">Active</span>
                                                                        @break
                                                                    @default
                                                                        <span class="badge badge-danger">Cancelled</span>
                                                                @endswitch
                                                            </td>
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
                    @endisset

                    @isset($fiat_loans)
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-dark" href="{{url('account/loans/fiat_lended')}}" style="margin-bottom: 4px;">
                                    View Lended Fiats
                                </a>
                                @if ($user->canBorrow ==1)
                                    <a class="btn btn-primary" href="{{url('account/loan_center')}}" style="margin-bottom: 4px;">
                                        Loan Center
                                    </a>
                                @endif
                                <a class="btn btn-info" href="{{url('account/loans')}}" style="margin-bottom: 4px;">
                                    Crypto Loan
                                </a>
                            </div>
                            <br><br>
                            <!--div-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{$pageName}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <div class="table-responsive">
                                            @isset($fiat_loans)
                                                <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                    <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">Reference</th>
                                                        <th class="border-bottom-0">Asset</th>
                                                        <th class="border-bottom-0">Amount</th>
                                                        <th class="border-bottom-0">Crypto Asset</th>
                                                        <th class="border-bottom-0">Crypto Amount</th>
                                                        <th class="border-bottom-0">APR</th>
                                                        <th class="border-bottom-0">Duration</th>
                                                        <th class="border-bottom-0">Time Received</th>
                                                        <th class="border-bottom-0">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($fiat_loans as $loan)
                                                        <tr>
                                                            <td>
                                                                <span class="badge badge-info break-text">
                                                                    <a href="{{url('account/loans/fiat/collected/'.$loan->reference)}}" target="_blank">
                                                                        {{$loan->reference}}
                                                                    </a>
                                                                </span>
                                                            </td>
                                                            <td>{{$loan->fiat}}</td>
                                                            <td>{{$loan->fiatAmount}}</td>
                                                            <td>{{$loan->asset}}</td>
                                                            <td>{{$loan->cryptoAmount}}</td>
                                                            <td>{{$loan->apr}}%</td>
                                                            <td>{{$loan->duration}}</td>
                                                            <td>{{$loan->created_at}}</td>
                                                            <td>
                                                                @switch($loan->status)
                                                                    @case(1)
                                                                        <span class="badge badge-success">Completed</span>
                                                                        @break
                                                                    @case(2)
                                                                        <span class="badge badge-primary">Active</span>
                                                                        @break
                                                                    @default
                                                                        <span class="badge badge-danger">Cancelled</span>
                                                                @endswitch
                                                            </td>
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
                    @endisset

                    @isset($lended_fiat)
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-dark" href="{{url('account/loans/fiat')}}" style="margin-bottom: 4px;">
                                    View Fiats Loans
                                </a>
                                @if ($user->canBorrow ==1)
                                    <a class="btn btn-primary" href="{{url('account/loan_center')}}" style="margin-bottom: 4px;">
                                        Loan Center
                                    </a>
                                @endif
                                <a class="btn btn-info" href="{{url('account/loans')}}" style="margin-bottom: 4px;">
                                    Crypto Loan
                                </a>
                            </div>
                            <br><br>
                            <!--div-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{$pageName}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <div class="table-responsive">
                                            @isset($lended_fiat)
                                                <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                    <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">Reference</th>
                                                        <th class="border-bottom-0">Asset</th>
                                                        <th class="border-bottom-0">Amount</th>
                                                        <th class="border-bottom-0">Crypto Asset</th>
                                                        <th class="border-bottom-0">Crypto Amount</th>
                                                        <th class="border-bottom-0">APR</th>
                                                        <th class="border-bottom-0">Duration</th>
                                                        <th class="border-bottom-0">Time Sent</th>
                                                        <th class="border-bottom-0">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($lended_fiat as $loan)
                                                        <tr>
                                                            <td>
                                                                <span class="badge badge-info break-text">
                                                                    <a href="{{url('account/loans/fiat/sent/'.$loan->reference)}}" target="_blank">
                                                                        {{$loan->reference}}
                                                                    </a>
                                                                </span>
                                                            </td>
                                                            <td>{{$loan->fiat}}</td>
                                                            <td>{{$loan->fiatAmount}}</td>
                                                            <td>{{$loan->asset}}</td>
                                                            <td>{{$loan->cryptoAmount}}</td>
                                                            <td>{{$loan->apr}}%</td>
                                                            <td>{{$loan->duration}}</td>
                                                            <td>{{$loan->created_at}}</td>
                                                            <td>
                                                                @switch($loan->status)
                                                                    @case(1)
                                                                        <span class="badge badge-success">Completed</span>
                                                                        @break
                                                                    @case(2)
                                                                        <span class="badge badge-primary">Active</span>
                                                                        @break
                                                                    @default
                                                                        <span class="badge badge-danger">Cancelled</span>
                                                                @endswitch
                                                            </td>
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
                    @endisset
                </div>
                <!-- /Row -->
            </div>
        </div><!-- end app-content-->
    </div>

@include('dashboard.templates.footer')
