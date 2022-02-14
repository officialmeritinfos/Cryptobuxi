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
    @if ($user_crypto_loan_offerings->count() >0)
        <p class="text-primary text-center">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_crypto_offer">
                Create New Offer
            </button>
        </p>
    <!--Row-->
        <div class="row">
            @inject('options','App\Custom\Regular')
            @foreach ($user_crypto_loan_offerings as $offering)
                <div class="col-xl-4 col-md-6 col-lg-6 mx-auto">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex">
                                <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($offering->asset)).'.svg')}}" class="w-7 h-7 mr-2" alt="img">
                                <div>
                                    <p class=" mb-1 text-muted fs-12">{{$offering->asset}}/{{$offering->fiat}}</p>
                                    <h3 class="mb-0 font-weight-bold">
                                        {{number_format($offering->availableBalance,5)}} {{$offering->asset}}
                                    </h3>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class=" mb-0">
                                    <a href="{{url('loan/loan_center/'.$offering->reference.'/details')}}"
                                    class="btn btn-primary" data-toggle="tooltip" title="Offer Details"><i class="fa fa-eye"></i></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                            Hi, {{$user->name}} — Welcome to {{config('app.name')}} Loan Center
                        </h4>
                        <p class="text-primary">
                            You do not have any crypto offering. You can create an offering using the button below.<br><br>
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
@if ($crypto_loan_offerings->count() >0)
    <div class="text-center">
        <h4 class="page-title">Available Loan Offers </h4>
    </div>
    <br>
    <div class="row">
        @inject('options','App\Custom\Regular')
        @foreach ($crypto_loan_offerings as $offerings)

            <div class="col-xl-4 col-md-6 col-lg-6 mx-auto">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($offerings->asset)).'.svg')}}" class="w-7 h-7 mr-2" alt="img">
                            <div>
                                <p class=" mb-1 text-muted fs-12">{{$offerings->asset}}/{{$offerings->fiat}}</p>
                                <h3 class="mb-0 font-weight-bold">
                                    {{number_format($offerings->availableBalance,5)}} {{$offerings->asset}}
                                </h3>
                            </div>
                            <div class="ml-auto text-right">
                                <p class=" mb-0">
                                <a href="{{url('loan/loan_center/'.$offerings->reference.'/details')}}"
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
        {{$crypto_loan_offerings->links()}}
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
                        Welcome to {{config('app.name')}} Loan Center
                    </h4>
                    <p class="text-danger">
                        There are no Loan offers to show at the moment, please try again later.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
@endif
@include('dashboard.templates.loan_center_modal')
@include('dashboard.templates.footer')
