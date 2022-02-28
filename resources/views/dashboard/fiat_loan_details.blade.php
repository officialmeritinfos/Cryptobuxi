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
                <h4 class="card-title text-center">Loan Details</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            {{-- <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Asset </span>
                                </td>
                                <td class="py-2 px-0">{{$loan->asset}} </td>
                            </tr> --}}
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Amount Borrowed </span>
                                </td>
                                <td class="py-2 px-0"><b>{{$loan->fiat}}{{number_format($loan->fiatAmount,2)}}</b></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Collateral Asset </span>
                                </td>
                                <td class="py-2 px-0">
                                <span class="badge badge-primary">{{$loan->asset}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Collateral Amount </span>
                                </td>
                                <td class="py-2 px-0"><b>{{number_format($loan->cryptoAmount,5)}} {{$loan->asset}}</b></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Annual Percentage Rate(APR) </span>
                                </td>
                                <td class="py-2 px-0">{{$loan->apr}}% </td>
                            </tr>

                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Reference </span>
                                </td>
                                <td class="py-2 px-0"><span class="badge badge-info">{{$loan->reference}}</span></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Status </span>
                                </td>
                                <td class="py-2 px-0">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TIMELINE</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Amount To Payback</span>
                                </td>
                                <td class="py-2 px-0">
                                    <span class="badge badge-primary">
                                        {{$loan->fiat}} {{number_format($loan->amountToPayBack,2)}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Interest </span>
                                </td>
                                <td class="py-2 px-0">
                                    <span class="badge badge-info">
                                        {{$loan->fiat}} {{number_format($loan->interest,2)}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Amount Due Today </span>
                                </td>
                                <td class="py-2 px-0">
                                    <span class="badge badge-warning">
                                        {{$loan->fiat}}{{number_format($loan->fiatAmount+($loan->dailyAddition*$loan->currentRepeat),2)}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Time Approved </span>
                                </td>
                                <td class="py-2 px-0">{{date('d-m-Y h:i:s a',$loan->dateApproved)}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Payback Day </span>
                                </td>
                                <td class="py-2 px-0">{{date('d-m-Y h:i:s a',$loan->payBackDate)}}</td>
                            </tr>
                            @if ($loan->isPaid ==1)
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50"> Date Paid Back </span>
                                    </td>
                                    <td class="py-2 px-0">{{date('d-m-Y h:i:s a',$loan->datePaidBack)}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($user->id == $loan->user)
    <div class="col-xl-6 col-lg-6 col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Loan Actions</h4><hr>
                <div class="text-center">

                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payBackFiatLoan"
                        >Payback</button>

                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@include('dashboard.templates.fiat_loan_modal')
@include('dashboard.templates.footer')
