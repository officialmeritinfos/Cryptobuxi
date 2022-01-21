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
                                            <h2>Supported Crypto Assets</h2>
                                            <p></p>
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
                                                        <li><i class="fa fa-check-circle"></i>Network: <b>{{strtoupper($coin->urlCode)}}</b> </li>
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
