@include('dashboard.templates.header')

    <div class="text-center">
        <h4 class="page-title">Your Listing </h4>
    </div>
    <br>

    @if ($personalOfferings->count() >0)
        <p class="text-primary text-center">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_trade_offer">
                Create New Offer
            </button>
        </p>
        <!--Row-->
        <div class="row">
            @inject('options','App\Custom\Regular')
            @foreach ($personalOfferings as $offering)
                <div class="col-xl-4 col-md-6 col-lg-6 mx-auto">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex">
                                <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($offering->asset)).'.svg')}}"
                                     class="w-7 h-7 mr-2" alt="img">
                                <div>
                                    <p class=" mb-1 text-muted fs-12">
                                        {{$offering->asset}}/{{$offering->currency}}
                                        @switch($offering->status)
                                            @case(1)
                                            <sup class="fa fa-check-circle text-success"></sup>
                                            @break

                                            @default
                                            <sup class="fa fa-times-circle text-danger"></sup>
                                        @endswitch
                                    </p>
                                    <h3 class="mb-0 font-weight-bold">
                                        {{number_format($offering->availableBalance,5)}} {{$offering->asset}}
                                    </h3><br>
                                    <p class="mb-1 text-muted fs-12 row">
                                        <span class="col-md-6 text-primary">Id: <b>{{$offering->reference}}</b></span><br>
                                        <span class="col-md-6 text-secondary">Rate:
                                            <b>{{$offering->currency}}{{number_format($options->getTradeOfferrate($offering->id),2)}}/$</b>
                                        </span>
                                    </p>

                                </div>
                                <div class="ml-auto text-right">
                                    <p class=" mb-0">
                                        <a href="{{url('account/trades/center/'.$offering->reference.'/details')}}"
                                           class="btn btn-primary" data-toggle="tooltip" title="Offer Details"><i class="fa fa-eye"></i></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div><br>
        <!--End Row-->
        <div class="pull-left">
            {{$personalOfferings->links()}}
        </div>
    @else


        <!--Row-->
        <div class="row" align="center">
            <div class="col-md-2"></div>
            <div class="col-md-8 mt-5 mb-4 introduction">
                <div class="card ">
                    <div class="card-body">
                        <h4 class="font-weight-bolder text-primary font-40">
                            Hi, {{$user->name}} — Welcome to {{config('app.name')}} Marketplace
                        </h4>
                        <p class="text-primary">
                            You do not have any listing. You can create a listing using the button below.<br><br>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_trade_offer">
                                Create New Offer
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->
    @endif
<br><br>
<div class="text-center">
    <h4 class="page-title">Available Listings </h4>
</div>
<br>
<!--Row-->
@if ($offerings->count() >0)

    <div class="row">
        @inject('options','App\Custom\Regular')
        @foreach ($offerings as $offer)

            <div class="col-xl-4 col-md-6 col-lg-6 mx-auto">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($offer->asset)).'.svg')}}" class="w-7 h-7 mr-2" alt="img">
                            <div>
                                <p class=" mb-1 text-muted fs-12">{{$offer->asset}}/{{$offer->currency}}</p>
                                <h3 class="mb-0 font-weight-bold">
                                    {{number_format($offer->availableBalance,5)}} {{$offer->asset}}
                                </h3><br>
                                <p class="mb-1 text-muted fs-12 row">
                                    <span class="col-md-6 text-primary">Id: <b>{{$offer->reference}}</b></span><br>
                                    <span class="col-md-6 text-success">Rate:
                                            <b>{{$offer->currency}}{{number_format($options->getTradeOfferrate($offer->id),2)}}/$</b>
                                        </span>
                                </p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class=" mb-0">
                                    <a href="{{url('account/trades/center/'.$offer->reference.'/details')}}"
                                       class="btn btn-primary" data-toggle="tooltip" title="Offer Details"><i class="fa fa-eye"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div><br>
    <div class="pull-left">
        {{$offerings->links()}}
    </div>
    <!--End Row-->
@else
    <!--Row-->
    <div class="row" align="center">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-5 mb-4 introduction">
            <div class="card ">
                <div class="card-body">
                    <h4 class="font-weight-bolder text-primary font-40">
                        Welcome to {{config('app.name')}} Marketplace
                    </h4>
                    <p class="text-danger">
                        There are no offers to show at the moment, please try again later.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
@endif
@include('dashboard.templates.trade_center_modal')
@include('dashboard.templates.footer')
