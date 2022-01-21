@include('templates.header')
@include('templates.pricing_table')
<div class="terms_condition">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-12">
                        <div class="terms_condition-content">

                            <div class="terms_condition-text">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div class="section-title text-center">
                                            <h2>Low Fees, Better Prices</h2>
                                            <p>Enjoy affordable fees with swift transaction time on {{$web->siteName}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="pricing-table-3 basic">
                                            <div class="pricing-table-header">
                                                <h4 style="color: #fff;"><strong>WITHDRAWALS</strong></h4>
                                                <p></p>
                                            </div>
                                            <div class="price"><strong>{{$web->withdrawalCharge}}</strong>% Charge</div>
                                            <div class="pricing-body">
                                                <ul class="pricing-table-ul">
                                                    <li><i class="fa fa-check-circle"></i> Instant Crediting</li>
                                                    <li><i class="fa fa-check-circle"></i> Any Local Bank</li>
                                                    <li class="not-avail"><i class="fa fa-envelope"></i> 24/7 Support</li>
                                                    <li class="not-avail"><i class="fa fa-envelope"></i> Email Support</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="pricing-table-3 premium">
                                            <div class="pricing-table-header">
                                                <h4 style="color: #fff;"><strong>LOAN</strong></h4>
                                                <p>Only charged during payback</p>
                                            </div>
                                            <div class="price"><strong>{{$web->loanCharge}}</strong>% Charge</div>
                                            <div class="pricing-body">
                                                <ul class="pricing-table-ul">
                                                    <li><i class="fa fa-check-circle"></i>Minimum Term of {{$web->loanPeriodMin}}</li>
                                                    <li><i class="fa fa-check-circle"></i>Maximum Term of  {{$web->loanPeriodMax}}</li>
                                                    <li><i class="fa fa-check-circle"></i>Minimum Interest of  {{$web->loanRoiMin}}%</li>
                                                    <li><i class="fa fa-check-circle"></i>Maximum Interest of  {{$web->loanRoiMin}}%</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="pricing-table-3 business">
                                            <div class="pricing-table-header">
                                                <h4 style="color: #fff;"><strong>TRADES</strong></h4>
                                                <p>Only charged upon successful sales</p>
                                            </div>
                                            <div class="price"><strong>{{$web->tradeFee}}</strong>% Charge</div>
                                            <div class="pricing-body">
                                                <ul class="pricing-table-ul">
                                                    <li><i class="fa fa-check-circle"></i> AI powered Sales</li>
                                                    <li class="not-avail"><i class="fa fa-check-circle"></i> {{$web->internalCharge}}% on Tagname Transfers</li>
                                                    <li><i class="fa fa-shield"></i> Secured Trade System</li>
                                                    <li class="not-avail"><i class="fa fa-envelope"></i> Email Support</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="terms_condition-content">
                            <div class="terms_condition-text">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div class="section-title text-center">
                                            <h2>Card Payments & Fiat Account Funding</h2>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($fiats as $fiat)
                                        <div class="col-md-4 col-sm-6 mx-auto">
                                            <div class="pricing-table-3 basic">
                                                <div class="pricing-table-header">
                                                    <h4 style="color: #fff;"><strong>{{$fiat->code}}</strong></h4>
                                                    <p>Processor Fee is collected by the payment channels you choose</p>
                                                </div>
                                                <div class="price"><strong>{{$fiat->processingFee}}</strong>% Fee</div>
                                                <div class="pricing-body">
                                                    <ul class="pricing-table-ul">
                                                        <li><i class="fa fa-check-circle"></i> {{$fiat->processingFee}}% Processor Fee </li>
                                                        <li><i class="fa fa-check-circle"></i> {{$fiat->fundingFee}}%  Funding Fee</li>
                                                        <li><i class="fa fa-check-circle"></i>Minimum Loanable: <b>{{$fiat->code}}{{number_format($fiat->minimumLoanable,2)}}</b> </li>
                                                        <li><i class="fa fa-check-circle"></i> Visa/Master/Verve Card</li>
                                                        <li class="not-avail"><i class="fa fa-check-circle"></i> Instant Deposit</li>
                                                        <li class="not-avail"><i class="fa fa-check-circle"></i> No Hidden Charges</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="terms_condition-content">
                            <div class="terms_condition-text">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div class="section-title text-center">
                                            <h2>Other Fees</h2>
                                            <p>These fees includes sending crypto, receiving crypto and the
                                                 minimums for these actions.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($coins as $coin)
                                        <div class="col-md-4 col-sm-6 mx-auto">
                                            <div class="pricing-table-3 business">
                                                <div class="pricing-table-header">
                                                    <h4 style="color: #fff;"><strong>{{$coin->name}}</strong></h4>
                                                    <p></p>
                                                </div>
                                                <div class="price"><strong>{{$coin->asset}}</strong></div>
                                                <div class="pricing-body">
                                                    <ul class="pricing-table-ul">
                                                        <li><i class="fa fa-check-circle"></i>Minimum Transferable: <b>{{$coin->minSend}}{{$coin->icon}}</b> </li>
                                                        <li><i class="fa fa-check-circle"></i>Minimum Receivable: <b>{{$coin->minReceive}}{{$coin->icon}}</b> </li>
                                                        <li><i class="fa fa-check-circle"></i>Minimum Loanable: <b>{{$coin->minimumLoanable}}{{$coin->icon}}</b> </li>
                                                        <li class="not-avail"><i class="fa fa-check-circle"></i> Instant Deposit</li>
                                                        <li class="not-avail"><i class="fa fa-check-circle"></i> No Hidden Charges</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('templates.footer')
