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
                               <a href="{{url('account/account_wallet/'.$balance->customId.'/details')}}"
                               class="btn btn-primary" data-toggle="tooltip" title="Transaction Details"><i class="fa fa-eye"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!--End Row-->
@include('dashboard.templates.footer')
