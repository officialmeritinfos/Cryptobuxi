@include('dashboard.templates.header')

<div class="text-center">
    <a class="btn btn-purple btn-pill btn-md" href="{{url('account/trades/center')}}" style="margin-bottom: 4px;">
        Go To Marketplace
    </a>
</div>
<br><br>
<div class="text-center">
    <h4 class="page-title">Trading Balance </h4>
</div>
<br>
@inject('options','App\Custom\Regular' )
<!--Row-->
<div class="row">
    @foreach ($balances as $balance)
        <div class="col-xl-4 col-md-6 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($balance->asset)).'.svg')}}" class="w-7 h-7 mr-2" alt="img">
                        <div>
                            <p class=" mb-1 text-muted fs-12">{{$balance->asset}}/{{$user->majorCurrency}}</p>
                            <h3 class="mb-0 font-weight-bold">
                                {{number_format($balance->availableBalance,5)}} {{$balance->asset}}
                            </h3>
                        </div>
                        <div class="ml-auto text-right">
                            <p class=" mb-0">
                                @php
                                    $rate = $options->getCryptoExchange($balance->asset,$user->majorCurrency)
                                @endphp
                                {{$user->majorCurrency}} {{number_format($rate,4)}}
                            </p>
                            <p class=" mb-1">
                                @php
                                    $rate = $options->getCryptoExchange($balance->asset,$user->majorCurrency)
                                @endphp
                                {{$user->majorCurrency}} {{number_format($rate*$balance->availableBalance,2)}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!--End Row-->

<div class="row">
    @isset($sales)
        <div class="col-md-12">

            <!--div-->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Sales</div>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            @isset($sales)
                                <table id="example" class="table table-bordered text-nowrap key-buttons">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom-0">Reference</th>
                                        <th class="border-bottom-0">Asset</th>
                                        <th class="border-bottom-0">Amount</th>
                                        <th class="border-bottom-0">Currency</th>
                                        <th class="border-bottom-0">Fiat Amount</th>
                                        <th class="border-bottom-0">Time Initiated</th>
                                        <th class="border-bottom-0">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>
                                                <span class="badge badge-info break-text">
                                                    <a href="{{url('account/trades/sale/'.$sale->reference)}}" >
                                                        {{$sale->reference}}
                                                    </a>
                                                </span>
                                            </td>
                                            <td>{{$sale->asset}}</td>
                                            <td>{{$sale->amount}}</td>
                                            <td>{{$sale->currency}}</td>
                                            <td>{{number_format($sale->fiatAmount,2)}}</td>
                                            <td>{{$sale->created_at}}</td>
                                            <td>
                                                @switch($sale->status)
                                                    @case(1)
                                                    <span class="badge badge-success">Completed</span>
                                                    @break
                                                    @case(2)
                                                    <span class="badge badge-primary">Pending Payment</span>
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
        @isset($purchases)
            <div class="col-md-12">
                <!--div-->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Purchases</div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="table-responsive">
                                @isset($purchases)
                                    <table id="example" class="table table-bordered text-nowrap key-buttons">
                                        <thead>
                                        <tr>
                                            <th class="border-bottom-0">Reference</th>
                                            <th class="border-bottom-0">Asset</th>
                                            <th class="border-bottom-0">Amount</th>
                                            <th class="border-bottom-0">Currency</th>
                                            <th class="border-bottom-0">Fiat Amount</th>
                                            <th class="border-bottom-0">Time Initiated</th>
                                            <th class="border-bottom-0">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($purchases as $purchase)
                                            <tr>
                                                <td>
                                                <span class="badge badge-info break-text">
                                                    <a href="{{url('account/trades/purchases/'.$purchase->reference)}}" >
                                                        {{$purchase->reference}}
                                                    </a>
                                                </span>
                                                </td>
                                                <td>{{$purchase->asset}}</td>
                                                <td>{{$purchase->amount}}</td>
                                                <td>{{$purchase->currency}}</td>
                                                <td>{{number_format($purchase->fiatAmount,2)}}</td>
                                                <td>{{$purchase->created_at}}</td>
                                                <td>
                                                    @switch($purchase->status)
                                                        @case(1)
                                                        <span class="badge badge-success">Completed</span>
                                                        @break
                                                        @case(2)
                                                        <span class="badge badge-primary">Pending Payment</span>
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
                            {{$purchases->links()}}
                        </div>
                    </div>
                </div>
                <!--/div-->
            </div>
        @endisset
</div>
@include('dashboard.templates.footer')
