@include('dashboard.templates.header')

@if ($user->canLend !=1)
    <!--Row-->
    <div class="row" align="center">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-5 mb-4 introduction">
            <div class="card ">
                <div class="card-body">
                    <h4 class="font-weight-bolder text-danger font-40">
                        Hi, {{$user->name}} — Welcome to {{config('app.name')}} Loan Center
                    </h4>
                    <p class="text-danger">
                        We are sorry but you are not eligble to create a Loan offer. Please contact support for help.
                    </p>
                </div>
            </div>
        </div>
    </div>
@else

    <div class="text-center">
        <h4 class="page-title">Your Loan Offerings </h4>
    </div>
    <br>
    <p class="text-primary text-center">
        <a class="btn btn-info btn-sm" href="{{url('account/loan_center')}}">
            Visit Crypto Loan Center
        </a>
    </p>
    @if ($user_fiat_loan_offerings->count() >0)
        <p class="text-primary text-center">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_crypto_offer">
                Create New Offer
            </button>
        </p>
    <!--Row-->
        <div class="row">
            @inject('options','App\Custom\Regular')
            @foreach ($user_fiat_loan_offerings as $offering)
                <div class="col-xl-4 col-md-6 col-lg-6 mx-auto">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <p class=" mb-1 text-muted fs-12">{{$offering->currency}}</p>
                                    <h3 class="mb-0 font-weight-bold">
                                        {{$offering->currency}} {{number_format($offering->amount,2)}}
                                    </h3>
                                    <p class=" mb-1 text-muted fs-12">Ref: <b>{{$offering->reference}}</b></p><br><br>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class=" mb-0">
                                    <a href="{{url('account/fiat_loan_center/'.$offering->reference.'/details')}}"
                                    class="btn btn-primary" data-toggle="tooltip" title="Offer Details"><i class="fa fa-eye"></i></a>
                                    </p><br>
                                    <p>
                                        @switch($offering->status)
                                            @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break

                                            @default
                                                <span class="badge badge-danger">Cancelled</span>
                                        @endswitch
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
            {{$user_fiat_loan_offerings->links()}}
        </div>
    @else
        <!--Row-->
        <div class="row" align="center">
            <div class="col-md-2"></div>
            <div class="col-md-8 mt-5 mb-4 introduction">
                <div class="card ">
                    <div class="card-body">
                        <h4 class="font-weight-bolder text-primary font-40">
                            Hi, {{$user->name}} — Welcome to {{config('app.name')}} Fiat Loan Center
                        </h4>
                        <p class="text-primary">
                            You do not have any fiat loan offering. You can create an offering using the button below.<br><br>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_crypto_offer">
                                Create New Offer
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->
    @endif
@endif
<br><br>
<!--Row-->
@if ($fiat_loan_offerings->count() >0)
    <div class="text-center">
        <h4 class="page-title">Available Loan Offers </h4>
    </div>
    <br>
    <div class="row">
        @inject('options','App\Custom\Regular')
        @foreach ($fiat_loan_offerings as $offerings)

            <div class="col-xl-4 col-md-6 col-lg-6 mx-auto">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <p class=" mb-1 text-muted fs-12">{{$offerings->currency}}</p>
                                <h3 class="mb-0 font-weight-bold">
                                    {{$offerings->currency}} {{number_format($offerings->amount,2)}}
                                </h3>
                                <p class=" mb-1 text-muted fs-12">Ref: <b>{{$offerings->reference}}</b></p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class=" mb-0">
                                <a href="{{url('account/fiat_loan_center/'.$offerings->reference.'/details')}}"
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
        {{$fiat_loan_offerings->links()}}
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
                        Welcome to {{config('app.name')}} Fiat Loan Center
                    </h4>
                    <p class="text-danger">
                        There are no Fiat Loan offers to show at the moment, please try again later.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
@endif
@include('dashboard.templates.fiat_loan_center_modal')
@include('dashboard.templates.footer')
