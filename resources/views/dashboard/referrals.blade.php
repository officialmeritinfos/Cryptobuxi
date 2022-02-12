@include('dashboard.templates.header')
<div class="row">
    @foreach($balances as $balance)
        <div class="col-xl-6 col-lg-6 col-md-12 mx-auto">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-success"></i></span>
                    <p class=" mb-1 ">{{$balance->currency}} Referral Account </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">{{$balance->currency}} {{number_format($balance->referralBalance,2)}}</h2>

                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-link icon-dropshadow-danger text-success"></i></span>
                    <p class=" mb-1 "> </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">Referral Link</h2>
                    <p>Refer new merchants with your referral
                        code and earn {{$web->referralBonus}}% on the revenue
                        {{config('app.name')}} makes from each transaction.</p>
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <input class="form-control form-control-lg" id="link" value="{{url('register?referrals='.$user->userRef)}}" readonly><br>
                            <p>
                                <a href="{{url('register?referrals='.$user->userRef)}}" target="_blank">
                                    Your Referral link
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="clipboard-icon" data-clipboard-target="#link">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none"/><path d="M14 7H8v14h11v-9h-5z" opacity=".3"/>
                            <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4H8c-1.1 0-1.99.9-1.99 2L6 21c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V11l-6-6zm4 16H8V7h6v5h5v9z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Row -->
<div class="row">
    <div class="col-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{$pageName}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($referrals)
                            <div class="text-center">
                                <a href="{{url('account/referrals/earnings')}}" class="btn btn-outline-success" style="margin-bottom: 5px;">
                                    <i class="fa fa-plus-square"></i> View Earnings
                                </a>
                            </div>
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Username</th>
                                    <th class="border-bottom-0">Country</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Joined</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($referrals as $referral)
                                    <tr>
                                        <td>{{$referral->name}}</td>
                                        <td>{{$referral->username}}</td>
                                        <td>{{$referral->country}}</td>
                                        <td>
                                            @switch($referral->status)
                                                @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break
                                                @default
                                                <span class="badge badge-dark">Inactive</span>
                                            @endswitch
                                        </td>
                                        <td>{{$referral->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">
                                <a href="{{url('account/referrals')}}" class="btn btn-outline-primary" style="margin-bottom: 5px;">
                                    <i class="fa fa-plus-square"></i> View Referrals
                                </a>
                            </div>
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Date Earned</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ref_trans as $ref_tran)
                                    <tr>
                                        <td>{{$ref_tran->name}}</td>
                                        <td>{{$ref_tran->currency}} {{$ref_tran->amount}}</td>
                                        <td>{{$ref_tran->created_at}}</td>
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
</div>
<!-- /Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.templates.footer')
