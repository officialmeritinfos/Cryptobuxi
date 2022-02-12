@include('dashboard.templates.header')

@if ($user->setPin !=1)
    <!--Row-->
    <div class="row" align="center">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-5 mb-4 introduction">
            <div class="card ">
                <div class="card-body">
                    <h4 class="font-weight-bolder text-danger font-40">
                        Hi, {{$user->name}} — Welcome to {{config('app.name')}}!
                    </h4>
                    <p class="text-danger">
                        Before you can proceed to trading your cryptocurrency assets on {{config('app.name')}}, you need
                        to configure your transaction Pin. This pin is essential for the system to authenticate such requests
                        as withdrawal, trades, tagname transfers, loaning and fiat conversion. <br>
                        As at the moment, your account is vulnerable; please set your pin to proceed. <br><br>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#set_pin">
                           <i class="fa fa-shield"></i> Protect Your Account
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
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
    @foreach($fiatBalances as $fiat_bal)
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-success"></i></span>
                    <p class=" mb-1 ">Available Balance </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">{{$fiat_bal->currency}} {{number_format($fiat_bal->availableBalance,2)}}</h2>
                    <small class="mb-1 text-muted">
                        <button class="btn btn-outline-primary btn-sm" data-backdrop="static" data-keyboard="false"
                                data-toggle="modal" data-target="#add_money">Add Money
                        </button>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-danger"></i></span>
                    <p class=" mb-1 ">Held Balance </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">{{$fiat_bal->currency}} {{number_format($fiat_bal->frozenBalance,2)}}</h2>
                </div>
            </div>
        </div>
    @endforeach
</div>


@include('dashboard.templates.footer')
