    @include('templates.header')

        <div class="intro">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="intro-content">
                            <h1>Trade with <strong class="text-primary">{{$web->siteName}}</strong>. <br> Buy and sell
                                cryptocurrency
                            </h1>
                            <p>Fast and secure way to purchase and exchange 8+ popular cryptocurrencies and tokens.</p>
                        </div>

                        <div class="intro-btn d-none d-md-block">
                            <a href="{{url('register')}}" class="btn btn-primary btn-sm">Get Started</a>
                            <a href="{{url('price')}}" class="btn btn-outline-primary">Browse Now</a>
                        </div>
                        <div class="intro-btn d-block d-sm-none ">
                            <a href="{{url('register')}}" class="btn btn-primary btn-sm">Get Started</a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-12">
                        <div class="intro-form-exchange">
                            <form method="post" action="{{url('buy')}}" class="currency_validate">
                                <div class="form-group">
                                    <label class="mr-sm-2">Buy</label>
                                    <div class="input-group mb-3">
                                        <select name='crypto' class="form-control" id="crypto">
                                            @foreach ($pairs as $pair)
                                                <option data-display="{{$pair->name}}" value="{{$pair->asset}}">{{$pair->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="crypto_amount" class="form-control input-amount" value="0"
                                        id="crypto_amount">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="mr-sm-2r" style="font-size:25px;">&#x2243;</label>
                                    <div class="input-group mb-3">
                                        <select name='currency' class="form-control" id="fiat">
                                            @foreach ($fiats as $fiat)
                                                <option data-display="{{$fiat->currency}}" value="{{$fiat->code}}">{{$fiat->currency}}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="usd_amount" class="form-control fiat-amount" value="0"
                                        id="fiat_amount">
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-success btn-block" id="exchange">
                                    Exchange Now
                                    <i class="la la-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="price-grid section-padding">
            <div class="container">
                <div class="row">
                    @foreach ($coins as $asset)
                    @inject('rate','App\Custom\Regular')
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <div class="media">
                                        <span>
                                            <img src="{{asset('cryptocoins/'.strtolower($asset->icon).'.svg')}}"
                                            style="width:20px;margin-right:10px;">
                                        </span>
                                        <div class="media-body">
                                            {{$asset->name}}
                                        </div>
                                    </div>
                                    <p class="mb-0"> Now</p>
                                </div>
                                <div class="card-body">
                                    <h3>

                                        @php
                                            $rate = $rate->getCryptoExchange($asset->asset)
                                        @endphp
                                        &#36;{{number_format($rate,$asset->fiatPreceision)}}
                                    </h3>
                                    <span class="text-success">+2.05%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>


        <div class="portfolio section-padding" data-scroll-index="2">
            <div class="container">
                <div class="row py-lg-5 justify-content-center">
                    <div class="col-xl-7">
                        <div class="section-title text-center">
                            <h2>Create your cryptocurrency portfolio today</h2>
                            <p>{{$web->siteName}} has a variety of features that make it the best place to start trading</p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-7 col-lg-6">
                        <div class="portfolio_list">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="media">
                                        <span class="port-icon"> <i class="la la-bar-chart"></i></span>
                                        <div class="media-body">
                                            <h4>Manage your portfolio</h4>
                                            <p>Buy and sell popular digital currencies, keep track of them in the one
                                                place.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="media">
                                        <span class="port-icon"> <i class="la la-calendar-check-o"></i></span>
                                        <div class="media-body">
                                            <h4>Recurring buys</h4>
                                            <p>Invest in cryptocurrency slowly over time by scheduling buys daily,
                                                weekly,
                                                or monthly.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="media">
                                        <span class="port-icon"> <i class="la la-lock"></i></span>
                                        <div class="media-body">
                                            <h4>Vault protection</h4>
                                            <p>For added security, store your funds in a vault with time delayed
                                                withdrawals.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="media">
                                        <span class="port-icon"> <i class="la la-mobile"></i></span>
                                        <div class="media-body">
                                            <h4>Mobile apps</h4>
                                            <p>Stay on top of the markets with the {{$web->siteName}} app for <a
                                                    href="{{$web->androidLink}}">Android</a>
                                                or
                                                <a href="{{$web->iphoneLink}}">iOS</a>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="portfolio_img">
                            <img src="{{asset('home/images/portfolio.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="trade-app section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="section-title text-center">
                            <h2>Trade Anywhere</h2>
                            <p> All of our products are ready to go, easy to use and offer great value to any kind of
                                business
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <div class="card trade-app-content">
                            <div class="card-body">
                                <span><i class="la la-mobile"></i></span>
                                <h4 class="card-title">Mobile</h4>
                                <p>All the power of {{$web->siteName}}'s cryptocurrency exchange, in the palm of your hand. Download
                                    the
                                    {{$web->siteName}} mobile crypto trading app today</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <div class="card trade-app-content">
                            <div class="card-body">
                                <span><i class="la la-desktop"></i></span>
                                <h4 class="card-title">Desktop</h4>
                                <p>Powerful crypto trading platform for those who mean business. The {{$web->siteName}} crypto
                                    trading
                                    experience, tailor-made for your Windows or MacOS device.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <div class="card trade-app-content">
                            <div class="card-body">
                                <span><i class="la la-connectdevelop"></i></span>
                                <h4 class="card-title">API</h4>
                                <p>The {{$web->siteName}} API is designed to provide an easy and efficient way to
                                    integrate your
                                    trading
                                    application into our platform.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="promo section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title text-center">
                            <h2>The most trusted cryptocurrency platform</h2>
                            <p> Here are a few reasons why you should choose {{$web->siteName}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center py-5">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="promo-content">
                            <div class="promo-content-img">
                                <img class="img-fluid" src="{{asset('home/images/svg/protect.svg')}}" alt="">
                            </div>
                            <h3>Secure storage </h3>
                            <p>We store the vast majority of the digital assets in secure offline storage.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="promo-content">
                            <div class="promo-content-img">
                                <img class="img-fluid" src="{{asset('home/images/svg/cyber.svg')}}" alt="">
                            </div>
                            <h3>Privacy</h3>
                            <p>We don’t keep transaction details after the payment is complete</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="promo-content">
                            <div class="promo-content-img">
                                <img class="img-fluid" src="{{asset('home/images/svg/finance.svg')}}" alt="">
                            </div>
                            <h3>Industry best practices</h3>
                            <p>{{$web->siteName}} supports a variety of the most popular digital currencies.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="appss section-padding">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-7 col-lg-6 col-md-6">
                        <div class="appss-content">
                            <h2>The secure app to buy and sell crypto yourself</h2>
                            <ul>
                                <li><i class="la la-check"></i> All your digital assets in one place</li>
                                <li><i class="la la-check"></i> Uniquely Decentralized</li>
                                <li><i class="la la-check"></i> Cost efficient</li>
                                <li><i class="la la-check"></i> Inapp transfers</li>
                            </ul>
                            <div class="mt-4">
                                <a href="{{$web->androidLink}}" class="btn btn-primary my-1 waves-effect">
                                    <img src="{{asset('home/images/android.svg')}}" alt="">
                                </a>
                                <a href="{{$web->iphoneLink}}" class="btn btn-primary my-1 waves-effect">
                                    <img src="{{asset('home/images/apple.svg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-6">
                        <div class="appss-img">
                            <img class="img-fluid" src="{{asset('home/images/app.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="getstart section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title">
                            <h2>Get started in a few minutes</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <div class="getstart-content">
                            <span><i class="la la-user-plus"></i></span>
                            <h3>Create an account</h3>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <div class="getstart-content">
                            <span><i class="la la-bank"></i></span>
                            <h3>Link your bank account</h3>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <div class="getstart-content">
                            <span><i class="la la-exchange"></i></span>
                            <h3>Start buying & selling</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="get-touch section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="section-title">
                            <h2>Get in touch. Stay in touch.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="get-touch-content">
                            <div class="media">
                                <span><i class="fa fa-shield"></i></span>
                                <div class="media-body">
                                    <h4>24 / 7 Support</h4>
                                    <p>Got a problem? Just get in touch. Our support team is available 24/7.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="get-touch-content">
                            <div class="media">
                                <span><i class="fa fa-cubes"></i></span>
                                <div class="media-body">
                                    <h4>{{$web->siteName}} Blog</h4>
                                    <p>News and updates from the world’s leading cryptocurrency exchange.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="get-touch-content">
                            <div class="media">
                                <span><i class="fa fa-certificate"></i></span>
                                <div class="media-body">
                                    <h4>Careers</h4>
                                    <p>Help build the future of technology. Start your new career at {{$web->siteName}}.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="get-touch-content">
                            <div class="media">
                                <span><i class="fa fa-life-ring"></i></span>
                                <div class="media-body">
                                    <h4>Community</h4>
                                    <p>{{$web->siteName}} is global. Join the discussion in our worldwide communities.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('templates.footer')
