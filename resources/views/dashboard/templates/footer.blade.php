</div>
</div>
            @if($user->setPin!=1)
            <!-- Show pin setting form-->
            <div class="modal" id="set_pin">
                <div class="modal-dialog modal-dialog-centered text-center " role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header">
                            <h1 class="modal-title">Protect Account from Intruders</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-left p-4" >
                            <form method="POST" id="set_trans_pin" action="{{url('account/dashboard/set_pin')}}">
                                @csrf
                                <div >
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">New Pin</label>
                                        <input type="password" class="form-control form-control-lg" id="pins" name="pin" maxlength="6" minlength="6">
                                        <small class="text-info">This cannot be recovered if lost; therefore, ensure to keep it in a secured place.</small>
                                    </div>
                                    <div class="form-group" >
                                        <label for="exampleInputEmail1" class="form-label">Confirm Pin</label>
                                        <input type="password" class="form-control form-control-lg" id="pin1s" name="confirm_pin" maxlength="6" minlength="6">
                                    </div>
                                    <div class="form-group" >
                                        <label for="exampleInputEmail1" class="form-label">Password</label>
                                        <input type="password" class="form-control form-control-lg" id="exampleInputEmail1" name="password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="submit_pin">
                                        <i class="fa fa-check-circle"></i> Protect</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Show Buy and Sell form-->
        <div class="modal" id="buy_sell">
            <div class="modal-dialog modal-dialog-centered text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Buy and Sell safely on {{config('app.name')}}</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center" >
                                <div class="panel panel-primary tabs-style-3">
                                    <div class="tab-menu-heading">
                                        <div class="card-pay" align="center">
                                            <ul class="tabs-menu nav">
                                                <li class=""><a href="#tab20" class="active" data-toggle="tab">
                                                    <i class="fa fa-credit-card"></i> Buy</a></li>
                                                <li><a href="#tab21" data-toggle="tab" class="">
                                                    <i class="fa fa-bank"></i>  Sell </a></li>
                                                <li><a href="#tab22" data-toggle="tab" class="">
                                                    <i class="fas fa-hand-holding-usd"></i>  Borrow </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tab20">
                                            @if ($user->isVerified ==2)
                                                <div class="text-center">
                                                    <div class="text-danger px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                        <i class="fa fa-info-circle fa-10x"></i>
                                                    </div>
                                                    <h3 class="text-bolder">Identity Verification Required</h3>
                                                    <p class="text-bold">You're almost ready to trade. Please verify your personal information</p>
                                                    <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#verification">Verify Your ID</button>
                                                </div>
                                            @elseif ($user->isVerified ==4)
                                            <div class="text-center">
                                                <div class="text-primary px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                    <i class="fa fa-spinner fa-spin fa-4x"></i>
                                                </div>
                                                <h3 class="text-bolder">Identity Verification Request Received</h3>
                                                <p class="text-bold">You have submitted the necessary documents for account activation. Please wait while the system
                                                    verifies these documents.
                                                </p>

                                            </div>
                                            @elseif ($user->isVerified ==5)
                                                <div class="text-center">
                                                    <div class="text-warning px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                        <i class="fa fa-info-circle fa-10x"></i>
                                                    </div>
                                                    <h3 class="text-bolder">Documents Pending</h3>
                                                    <p class="text-bold">
                                                        We need few documents to confirm your submitted data. Please upload them here using the button below.
                                                    </p>
                                                    <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#verificationdoc">Upload Documents</button>
                                                </div>
                                            @else
                                                <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4" role="alert">Please Enter Valid Details</div>
                                                <div class="form-group">
                                                    <label class="form-label">CardHolder Name</label>
                                                    <input type="text" class="form-control" placeholder="First Name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Card number</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Search for...">
                                                        <span class="input-group-append">
                                                            <button class="btn btn-secondary box-shadow-0" type="button"><i class="fa fa-cc-visa"></i> &nbsp; <i class="fa fa-cc-amex"></i> &nbsp;
                                                            <i class="fa fa-cc-mastercard"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <label class="form-label">Expiration</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" placeholder="MM" name="Month">
                                                                <input type="number" class="form-control" placeholder="YY" name="Year">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">CVV <i class="fa fa-question-circle"></i></label>
                                                            <input type="number" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn  btn-lg btn-primary">Confirm</a>
                                            @endif
                                        </div>
                                        <div class="tab-pane" id="tab21">
                                            @if ($user->isVerified ==2)
                                                <div class="text-center">
                                                    <div class="text-danger px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                        <i class="fa fa-info-circle fa-10x"></i>
                                                    </div>
                                                    <h3 class="text-bolder">Identity Verification Required</h3>
                                                    <p class="text-bold">You're almost ready to trade. Please verify your personal information</p>
                                                    <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#verification">Verify Your ID</button>
                                                </div>
                                            @elseif ($user->isVerified ==4)
                                            <div class="text-center">
                                                <div class="text-primary px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                    <i class="fa fa-spinner fa-spin fa-4x"></i>
                                                </div>
                                                <h3 class="text-bolder">Identity Verification Request Received</h3>
                                                <p class="text-bold">You have submitted the necessary documents for account activation. Please wait while the system
                                                    verifies these documents.
                                                </p>

                                            </div>
                                            @elseif ($user->isVerified ==5)
                                                <div class="text-center">
                                                    <div class="text-warning px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                        <i class="fa fa-info-circle fa-10x"></i>
                                                    </div>
                                                    <h3 class="text-bolder">Documents Pending</h3>
                                                    <p class="text-bold">
                                                        We need few documents to confirm your submitted data. Please upload them here using the button below.
                                                    </p>
                                                    <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#verificationdoc">Upload Documents</button>
                                                </div>
                                            @else

                                            @endif
                                        </div>
                                        <div class="tab-pane" id="tab22">
                                            @if ($user->canBorrow !=1)
                                                <div class="text-center">
                                                    <div class="text-danger px-4 py-2 br-3 mb-4 text-center" role="alert">
                                                        <i class="fa fa-info-circle fa-10x"></i>
                                                    </div>
                                                    <h3 class="text-bolder">Transactions Need</h3>
                                                    <p class="text-bold">You need to have performed a number of successful trades on
                                                        {{config('app.name')}} before you are eligible for loans.
                                                    </p>
                                                    <a class="btn btn-lg btn-primary" href="{{url('account/trade')}}">
                                                        Start Trading
                                                    </a>
                                                </div>
                                            @else

                                            @endif
                                        </div>

                                    </div>
                                </div>

                    </div>
                </div>
            </div>
        </div>
        @if($user->isVerified ==2)
        <!-- Show ID verification form-->
        @inject('options','App\Custom\Regular' )
        <div class="modal" id="verification">
            <div class="modal-dialog modal-dialog-centered modal-lg text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Verify Your Identity</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-left p-4" >
                        <form method="POST" id="verificationForm" action="{{url('account/dashboard/identity_verification')}}"
                        enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Name<sup class="text-danger">*</sup> </label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="exampleInputEmail1" class="form-label">Phone<sup class="text-danger">*</sup></label>
                                    <input type="txt" class="form-control" name="phone"
                                    value="{{$user->phone}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Date of Birth<sup class="text-danger">*</sup></label>
                                    <input type="date" class="form-control" name="dob">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Gender<sup class="text-danger">*</sup></label>
                                    <select class="form-control form-control-lg select2-show-search" name="gender">
                                        <option value="">Select an Option</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="transgender">Transgender</option>
                                        <option value="binary">Binary</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Country<sup class="text-danger">*</sup></label>
                                    <select class="form-control form-control-lg select2-show-search" name="country">
                                            <option value="">Select an Option</option>
                                        @foreach ($options->countries() as $country)
                                            <option value="{{$country->iso3}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">State<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="state">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">City<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="city">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Street Address<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="address" placeholder="Address Line 1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" name="address2" placeholder="Address Line 2">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Postal Code<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control " name="zip">
                                </div>
                            </div>
                            <div class="card-header">
                                <h3 class="card-title">Usage Information</h3>
                            </div><br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">What will you use {{$siteName}} for?<sup class="text-danger">*</sup></label>
                                    <select  class="form-control form-control-lg select2-show-search" name="useFor">
                                        <option>Trading on {{$siteName}}</option>
                                        <option>Trading on other Exchanges</option>
                                        <option>Online Purchases</option>
                                        <option>Loan</option>
                                        <option>Payment to Friends</option>
                                        <option>Online Payments</option>
                                        <option>Business</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Source of Funds<sup class="text-danger">*</sup></label>
                                    <select  class="form-control form-control-lg select2-show-search" name="fundSource">
                                        <option>Occupation</option>
                                        <option>Savings</option>
                                        <option>Inheritance</option>
                                        <option>Credit/Loan</option>
                                        <option>Family/Friends</option>
                                        <option>Cryptocurrency Mining</option>
                                        <option>Business</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Employment Status<sup class="text-danger">*</sup></label>
                                    <select  class="form-control form-control-lg select2-show-search" name="employmentStatus">
                                        <option>Employed</option>
                                        <option>Unemployed</option>
                                        <option>Retired</option>
                                        <option>Student</option>
                                        <option>Self Employed</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Occupation<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control " name="occupation">
                                </div>
                                <div class="form-group col-md-6 mx-auto" >
                                    <label for="exampleInputEmail1" class="form-label">ID Number<sup class="text-danger">*</sup></label>
                                    <input type="txt" class="form-control" name="idNo">
                                </div>
                                @if (strtolower($user->country) =='ng')
                                    <div class="form-group col-md-6 mx-auto" >
                                        <label for="exampleInputEmail1" class="form-label">Bank Verification Number<sup class="text-danger">*</sup></label>
                                        <input type="txt" class="form-control " name="bvn">
                                    </div>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg text-center mt-4 mb-0" id="submit_verify">
                                    <i class="fa fa-check-circle"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($user->isVerified ==5)
        <!-- Show ID verification Document form-->
        <div class="modal" id="verificationdoc">
            <div class="modal-dialog modal-dialog-centered text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Upload Verification Documents</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-left p-4" >
                        <form id="verificationFormDoc" action="{{url('account/dashboard/identity_verification_doc')}}"
                        enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Photo<sup class="text-danger">*</sup>(A selfie)
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="photo">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">
                                        ID Card<sup class="text-danger">*</sup>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="idPhoto">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg text-center mt-4 mb-0" id="submit_verifys">
                                    <i class="fa fa-check-circle"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @inject('wallets','App\Custom\Regular' )
        <!-- Show Send and Receive Coin form-->
        <div class="modal" id="send_receive">
            <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h1 class="modal-title">Send and Receive Coin on {{config('app.name')}}</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center" >
                                <div class="panel panel-primary tabs-style-3">
                                        <div class="card-pay" align="center">
                                            <ul class="tabs-menu nav">
                                                <li class="flex-fill"><a href="#tab32" class="active" data-toggle="tab">
                                                    <i class="fa fa-credit-card"></i> Receive</a></li>
                                                <li class="flex-fill"><a href="#tab33" data-toggle="tab" class="">
                                                    <i class="fa fa-bank"></i>  Send </a></li>
                                            </ul>
                                        </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tab32">
                                            <div class="tab-menu-heading">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <div class="text-danger px-1 py-2 br-3 mb-4" role="alert" id="qrcodes">
                                                            <span id="qrcode"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="exampleInputEmail1" class="form-label">Asset</label>
                                                        <select  class="form-control form-control-lg select2-show-search" name="receiveasset">

                                                            @foreach ($wallets->getUserWallet($user->id) as $wallet)
                                                            <option value="{{$wallet->asset}}">{{$wallet->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12" id="wallet" style="display: none;">
                                                        <div class="text-right">
                                                            <i class="fa fa-copy clipboard-icons text-primary"
                                                            data-clipboard-target="#wallets"></i>
                                                        </div>
                                                        <div class="bg-primary-transparent-2 px-4 py-2 br-3 mb-4 text-primary px-1 py-2 br-3 mb-4" role="alert">
                                                            <span id="wallets" class="break-text"> </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4  px-1 py-2 br-3 mb-4" role="alert">
                                                        <b><i class="fa fa-info-circle"></i></b>
                                                        <span id="notes" class="break-text"> </span>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="form-group col-md-12" id="balanceRow" style="display: none;">
                                                <span class="pull-left" id="bal_text"> Balance</span>
                                                <span class="pull-right">
                                                    <span id="balance"> </span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab33">

                                        </div>

                                    </div>
                                </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Footer-->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-sm-6 col-md-6">
                        <li class="list-group-item">
                            Change Theme
                            <div class="material-switch pull-right">
                                <input id="someSwitchOptionPrimary" name="dark" type="checkbox"/>
                                <label for="someSwitchOptionPrimary" class="label-primary"></label>
                            </div>
                        </li>
                    </div>
                    <div class="col-md-6 col-sm-6 mt-3 mt-lg-0 text-center">
                        <small>Copyright © {{date('Y')}} <a href="#">{{$web->siteName}}</a>.
                            {{config('app.name')}} is a product of <a href="https://meritinfos.co" target="_blank">Meritinfos LLC</a>.
                            All rights reserved.</small>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer-->

    </div>

    <!-- Back to top -->
    <a href="#top" id="back-to-top">
        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
    </a>

    <!-- Jquery js-->
    <script src="{{ asset('dashboard/assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <!-- Bootstrap4 js-->
    <script src="{{ asset('dashboard/assets/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--Othercharts js-->
    <script src="{{ asset('dashboard/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

    <!-- Circle-progress js-->
    <script src="{{ asset('dashboard/assets/js/vendors/circle-progress.min.js') }}"></script>

    <!-- Jquery-rating js-->
    <script src="{{ asset('dashboard/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

    <!--Sidemenu js-->
    <!--<script src="{{ asset('dashboard/assets/plugins/sidemenu/sidemenu.js') }}"></script>-->
        <script src="{{ asset('dashboard/assets/plugins/sidemenu/sidemenu1.js') }}"></script>

    <!-- P-scroll js-->
    <script src="{{ asset('dashboard/assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/p-scrollbar/p-scroll1.js') }}"></script>

    <!-- Custom js-->
    <script src="{{ asset('dashboard/assets/js/custom.js') }}"></script>

    <!-- Switcher js -->
    <script src="{{ asset('dashboard/assets/switcher/js/switcher.js') }}"></script>


    <!-- INTERNAL JS INDEX2 START -->
    <!--Moment js-->
    <script src="{{ asset('dashboard/assets/plugins/moment/moment.js') }}"></script>

    <!-- Daterangepicker js-->
    <script src="{{ asset('dashboard/assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/daterange.js') }}"></script>

    <!--Chart js -->
    <script src="{{ asset('dashboard/assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/chart/chart.extension.js') }}"></script>

    <!-- ECharts js-->
    <script src="{{ asset('dashboard/assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/index2.js') }}"></script>
    <!-- popover js -->
    <script src="{{ asset('dashboard/assets/js/popover.js')}}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.qrcode.min.js')}}"></script>
        <!-- Clipboard js -->
        <script src="{{ asset('dashboard/assets/plugins/clipboard/clipboard.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/clipboard/clipboard.js')}}"></script>
        @include('templates.noti_js')
    <!-- INTERNAL JS INDEX2 END -->
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/jszip.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.html5.min.j')}}s"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/js/datatables.js')}}"></script>
        <!--Select2 js -->
        <script src="{{ asset('dashboard/assets/plugins/select2/select2.full.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/js/select2.js')}}"></script>
        <script src="{{ asset('dashboard/bootstrap-pincode-input.js')}}"></script>

        <!-- File uploads js -->
        <script src="{{ asset('dashboard/assets/plugins/fileupload/js/dropify.js')}}"></script>
        <script src="{{ asset('dashboard/assets/js/filupload.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
        <!--<script src="https://checkout.flutterwave.com/v3.js"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.5.3/dist/cleave.min.js"></script>
        <script src="{{ asset('dashboard/account/dashboard.js')}}"></script>
		<script src="{{asset('dashboard/auth/password.js')}}"></script>
        <script src="https://kit.fontawesome.com/6b3c5ea29e.js" crossorigin="anonymous"></script>
        <!--<script>
            $(document).ready(() => {
                $(document.body).on('click', '.card[data-clickable=true]', (e) => {
                    window.location = $(e.currentTarget).data('href');
                    $.LoadingOverlay("show", {
                        text        : "please wait ..",
                        textAnimation:"pulse",
                        size    : "10"
                    });
                });
            });
        </script>

        <script>
            $(function(){
                $("a").on("click",function(){
                    $.LoadingOverlay("show", {
                        text        : "please wait ..",
                        textAnimation:"pulse",
                        size    : "10"
                    });
                    setTimeout(function(){
                        $.LoadingOverlay("hide", true);
                    }, 2000);
                });
            });
        </script>-->
        <script>
            var clipboard = new ClipboardJS('.clipboard-icons');
        </script>
</body>
</html>
