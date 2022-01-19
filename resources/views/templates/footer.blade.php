<div class="bottom section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="bottom-logo">
                    <img class="pb-3" src="{{ asset('home/images/'.$web->logo) }}" style="width:150px;">

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Company</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="#">Affiliate</a></li>
                        <li><a href="#">Legal</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">AML</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Supported Crypto</a></li>
                        <li><a href="#">Supported Countries</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Individual</h4>
                    <ul>
                        <li><a href="#">Wallet</a></li>
                        <li><a href="#">Buy and Sell</a></li>
                        <li><a href="#">Earn Free Cryptocurrency</a></li>
                        <li><a href="#">Lending</a></li>
                        <li><a href="#">Peer to Peer</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="bottom-widget">
                    <h4 class="widget-title">Some Exchange Pair</h4>
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

<div class="footer">
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
