<div class="bottom section-padding" style="background-color:#0437F2;color:#fff;">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="bottom-logo">
                    <img class="pb-3" src="{{ asset('home/images/'.$web->logo) }}" style="width:150px;">
                    <p style="font-size:15px;">{{$web->siteName}} is a global cryptocurrency trading platform
                        where you can safely trade with millions of users,
                        using 300+ payment methods. Get a free account today.</p>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Company</h4>
                    <ul>
                        <li><a href="{{url('about')}}">About</a></li>
                        <li><a href="{{url('affiliate')}}">Affiliate</a></li>
                        <li><a href="{{url('legal')}}">Legal</a></li>
                        <li><a href="{{url('privacy')}}">Privacy</a></li>
                        <li><a href="{{url('aml')}}">AML</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Support</h4>
                    <ul>
                        <li><a href="{{$web->helpLink}}">Help Center</a></li>
                        <li><a href="{{$web->faqLink}}">FAQ</a></li>
                        <li><a href="{{url('contact')}}">Contact Us</a></li>
                        <li><a href="{{$web->blogLink}}">Blog</a></li>
                        <li><a href="{{url('supported_crypto')}}">Supported Crypto</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Individual</h4>
                    <ul>
                        <li><a href="{{url('wallet')}}">Wallet</a></li>
                        <li><a href="{{url('buy')}}">Buy and Sell</a></li>
                        <li><a href="{{url('earn')}}">Earn Free Cryptocurrency</a></li>
                        <li><a href="{{url('lending')}}">Lending</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Exchange Pairs</h4>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <ul>
                                @foreach ($trade_pairs as $pairs )
                                    <li><a href="#">{{$pairs->asset}}/{{$pairs->currency}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer" style="background-color:#000;color:#fff;">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="copyright">
                    <p>© Copyright {{date('Y')}} <a href="#">{{config('app.name')}}</a> I All Rights Reserved</p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="footer-social">
                    <ul>
                        <li><a href="https://facebook.com/cryptobuxi"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/cryptobuxi"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://instagram.com/cryptobuxi"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<script src="{{ asset('home/js/global.js') }}"></script>
<script src="{{ asset('home/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('home/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('home/js/plugins/owl-carousel-init.js') }}"></script>

<script src="{{ asset('home/vendor/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('home/vendor/apexchart/apexchart-init.js') }}"></script>

<script src="{{ asset('home/js/scripts.js') }}"></script>
</body>
</html>
