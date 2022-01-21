
@include('templates.header')

        <div class="appss section-padding">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-5 col-lg-6 col-md-12">
                        <div class="appss-img">
                            <img class="img-fluid" src="{{asset('home/images/sent.svg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="appss-content">
                            <h3>{{$web->siteName}} Wallet</h3>
                            <p>Your key to the world of crypto</p>
                            <ul>
                                <li><i class="la la-check"></i> Store all of your crypto and NFTs in one place</li>
                                <li><i class="la la-check"></i> Support for over 10+ assets and a whole world of dapps</li>
                                <li><i class="la la-check"></i> Explore the decentralized web on your phone or browser</li>
                                <li><i class="la la-check"></i> Protect your digital assets with industry-leading security</li>
                                <li><i class="la la-check"></i> Buy bitcoin | buy crypto with NGN,USD, EUR or GBP</li>
                            </ul>
                            <div class="mt-4">
                                <a href="{{$web->androidLink}}" target="_blank" class="btn btn-primary my-1 waves-effect">
                                    <img src="{{asset('home/images/android.svg')}}" alt="">
                                </a>
                                <a href="{{$web->iphoneLink}}" target="_blank" class="btn btn-primary my-1 waves-effect">
                                    <img src="{{asset('home/images/apple.svg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wallet-feature section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title">
                            <h2>{{$web->siteName}} for wallets</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="wallet-feature-content">
                            <span><i class="la la-user-plus"></i></span>
                            <h4>Built-in white-label instant exchange</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="wallet-feature-content">
                            <span><i class="la la-bank"></i></span>
                            <h4>Dedicated support line</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="wallet-feature-content">
                            <span><i class="la la-exchange"></i></span>
                            <h4>Top-up the wallet with 140+ cryptos</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="wallet-feature-content">
                            <span><i class="la la-exchange"></i></span>
                            <h4>Vast cross-marketing opportunities</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="wallet-feature-content">
                            <span><i class="la la-exchange"></i></span>
                            <h4>Revenue share from every transaction</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="wallet-feature-content">
                            <span><i class="la la-exchange"></i></span>
                            <h4>Revenue share from every transaction</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="all-coin section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title text-center">
                            <h2>All your digital assets in one place</h2>
                            <p>Take full control of your tokens and collectibles by storing them on your own device.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="all-coins">
                            @foreach ($coins as $coin)
                                <span><img src="{{asset('cryptocoins/'.strtolower($coin->icon).'.svg')}}"
                                    style="width:80px;" title="{{$coin->name}}"></span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="all-coin-content">
                            <h3>Multi-Coin Support</h3>
                            <p>Manage BTC, BCH, ETH, ETC, LTC,TRX, and all your ERC-20 and TRC-20 tokens.
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="all-coin-content">
                            <h3>Digital collectibles</h3>
                            <p>Cats, monsters, art - store all your ERC721 collectibles in a single beautiful gallery.
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="all-coin-content">
                            <h3>Secure storage</h3>
                            <p>Your keys are protected with Secure Enclave and biometric authentication technology.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="all-coin section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title text-center">
                            <h2>Easily send and receive crypto</h2>
                            <p>Pay anyone in the world with just their {{$web->siteName}} Wallet username</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wallet-map">
                            <img src="{{asset('home/images/map.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>

@include('templates.footer')
