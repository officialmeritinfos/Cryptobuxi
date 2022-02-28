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
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Asset </span>
                                </td>
                                <td class="py-2 px-0">{{$loan->asset}} </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Amount Borrowed </span>
                                </td>
                                <td class="py-2 px-0">{{number_format($loan->amount,5)}}{{$loan->asset}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Currency Traded Against </span>
                                </td>
                                <td class="py-2 px-0">{{$loan->fiat}}</td>
                            </tr>
                            @if ($user->id == $loan->lender)
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">Rate You offered</span>
                                    </td>
                                    <td class="py-2 px-0">{{$loan->apr}}% Lower than Market price</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">Rate offered by Lender</span>
                                    </td>
                                    <td class="py-2 px-0">{{$loan->apr}}% Lower than Market price</td>
                                </tr>
                            @endif
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
                <h4 class="card-title text-center">Loan Actions</h4><hr>
                <div class="text-center">
                   <p>
                       You do not need to take any action for Cryptocurrency Loans. The System settles this upon
                        sales of these assets.
                   </p>
                </div>
            </div>
        </div>
    </div>

</div>

@include('dashboard.templates.footer')
