@include('templates.header')

<div class="intro">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xl-6 col-lg-6 col-12">
                <div class="intro-content">
                    <h1>Become a  <strong class="text-primary">{{$web->siteName}}</strong> affiliate.
                    </h1>
                    <p>Help us introduce the world to bitcoin, cryptocurrency, and the new financial system.</p>
                </div>

                <div class="intro-btn">
                    <a href="{{url('affiliate/enroll')}}" class="btn btn-primary">Become an affiliate</a>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 col-12">
                <img class="img-fluid" src="{{asset('home/images/nakamoto.png')}}" alt="">
            </div>
        </div>
    </div>
</div>


<div class="portfolio section-padding" data-scroll-index="2">
    <div class="container">
        <div class="row py-lg-5 justify-content-center">
            <div class="col-xl-7">
                <div class="section-title text-center">
                    <h2>How it works</h2>
                    <p>Join our affiliate program and earn commission by promoting {{$web->siteName}}</p>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="getstart-content">
                    <span><img class="img-fluid" src="{{asset('home/images/delegate.png')}}" style="width:50px;"></span>
                    <h3 class="font-weight-bold">Become an affiliate</h3>
                    <p>
                        After your application is approved, you’ll get access to promotional
                         assets and Impact tracking software.
                        </p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="getstart-content">
                    <span><img class="img-fluid" src="{{asset('home/images/addToWatchlist.png')}}" style="width:50px;"></span>
                    <h3 class="font-weight-bold">Promote {{$web->siteName}}</h3>
                    <p>
                        Link to {{$web->siteName}} in articles, create new content, or place ads on your website
                    </p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="getstart-content">
                    <span><img class="img-fluid" src="{{asset('home/images/moneyEarn.png')}}" style="width:50px;"></span>
                    <h3 class="font-weight-bold">Earn Commissions</h3>
                    <p>
                        When new customers join {{$web->siteName}} through your promotions, you could earn a commission.
                    </p>
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
@include('templates.footer')
