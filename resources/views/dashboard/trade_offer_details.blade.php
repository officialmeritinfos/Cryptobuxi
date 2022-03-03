@include('dashboard.templates.header')

<!-- Row -->
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card box-widget widget-user">
            <div class="widget-user-image mx-auto mt-5 text-center">
                <img alt="User Avatar" class="rounded-circle"
                     src="https://ui-avatars.com/api/?name={{$offerOwner->name}}&rounded=true&background=random">
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{$offerOwner->name}}</h4>
                    <h6 class="pro-user-desc text-muted">{{$offerOwner->occupation}}</h6>
                    <a href="{{url('account/trader/'.$offerOwner->userRef.'/details')}}" class="btn btn-primary btn-sm mt-3">View Portfolio</a>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold">{{$offerOwner->userLevel}}</h5>
                            <span class="text-muted">Trader Level</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="description-block text-center p-4">
                            <h5 class="description-header mb-1 font-weight-bold">{{$offerOwner->country}}</h5>
                            <span class="text-muted">Country</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @inject('options','App\Custom\Regular')
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Trade Offer Details</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Asset </span>
                            </td>
                            <td class="py-2 px-0">
                                <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($offering->asset)).'.svg')}}"
                                     class="w-5 h-5 mr-2" style="width:100px;" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Amount listed </span>
                            </td>
                            <td class="py-2 px-0">{{number_format($offering->amount,5)}}{{$offering->asset}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Currency Traded Against </span>
                            </td>
                            <td class="py-2 px-0">{{$offering->currency}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Rate </span>
                            </td>
                            <td class="py-2 px-0">
                                <b class="text-success">
                                    {{$offering->currency}} {{number_format($options->getTradeOfferrate($offering->id),2)}}/$
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Amount Left </span>
                            </td>
                            <td class="py-2 px-0">{{number_format($offering->availableBalance,5)}}{{$offering->asset}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Reference </span>
                            </td>
                            <td class="py-2 px-0"><span class="badge badge-info">{{$offering->reference}}</span></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Status </span>
                            </td>
                            <td class="py-2 px-0">
                                @switch($offering->status)
                                    @case(1)
                                    <span class="badge badge-success">Active</span>
                                    @break

                                    @default
                                    <span class="badge badge-danger">Cancelled</span>
                                @endswitch
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Trade List Actions</h4><hr>
                <div class="text-center">
                    @if ($user->id != $offering->user)
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptTradeOffer"
                        >Buy</button>
                    @endif
                    @if ($user->id == $offering->user)
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#topupTradeOffer"
                        >Top Up</button>
                        @if ($offering->status ==1)
                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#cancelTradeOffer">Cancel</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @isset($trades)
        <div class="col-md-12">

            <!--div-->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Sales</div>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            @isset($trades)
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
                                    @foreach($trades as $sale)
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
                                            <td>{{$sale->fiatAmount}}</td>
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
</div>
@include('dashboard.templates.trade_offer_details__modal')
@include('dashboard.templates.footer')
