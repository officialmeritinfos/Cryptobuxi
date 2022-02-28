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
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Loan Offer Details</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            {{-- <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Asset </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->asset}} </td>
                            </tr> --}}
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Amount listed </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->currency}}{{number_format($offering->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Collateral Asset </span>
                                </td>
                                <td class="py-2 px-0">
                                    @if ($offering->acceptsAll ==1)
                                        @foreach ($coins as $coin)
                                            <span class="badge badge-primary" style="margin-bottom:4px;">{{$coin->name}}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-primary">{{$offering->asset}}</span>
                                     @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Annual Percentage Rate(APR) </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->apr}}% </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Available Amount </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->currency}} {{number_format($balance->availableBalance,2)}}</td>
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
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TIMELINE</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Loan Term </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->duration}} {{$offering->durationType}}(s)</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Minimum Loan Term </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->minimumDuration}} {{$offering->durationType}}(s)</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Maximum Loan Term </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->maximumDuration}} {{$offering->durationType}}(s)</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Minimum Loan Amount </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->currency}} {{number_format($offering->minimumAmount,2)}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Maximum Loan Amount </span>
                                </td>
                                <td class="py-2 px-0">{{$offering->currency}} {{number_format($offering->maximumAmount,2)}}</td>
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
                <h4 class="card-title text-center">Loan Offer Actions</h4><hr>
                <div class="text-center">
                    @if ($user->id != $offering->user)
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptFiatLoanOffer"
                        >Accept Offer</button>
                    @endif
                    @if ($user->id == $offering->user)
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#topupCryptoLoan"
                        >Top Up</button>
                        @if ($offering->status ==1)
                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#cancelCryptoLoanOffer">Cancel</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@include('dashboard.templates.fiat_loan_offering_details_modal')
@include('dashboard.templates.footer')
