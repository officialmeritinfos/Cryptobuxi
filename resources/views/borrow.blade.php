@include('templates.header')

<div class="intro">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xl-6 col-lg-6 col-12">
                <div class="intro-content" style="color: #343434;">
                    <h1>Borrow from a <strong class="text-primary">{{$web->siteName}}</strong> Trader.

                    </h1>
                    <p>
                        You can borrow cryptocurrencies from verified traders on {{$web->siteName}} to finance your cryptocurrency
                        trading venture, and pay back later with no collateral. There is not fixed loan interest; just discuss with
                        a trader of your choice and get started. You can also borrow up to $1,000,0001 from {{$web->siteName}} using your Cryptocurrency as collateral.
                        There is not fixed loan interest; just discuss with
                        a trader of your choice and get started.
                    </p>
                </div>
                <div class="intro-btn">
                    <a href="{{url('register')}}" class="btn btn-success btn-lg btn-block">Sign up to Get Started</a>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 col-12">
                <img class="img-fluid" src="{{asset('home/images/borrow-dollar-bill-icon-960-original.webp')}}" alt="">
            </div>
        </div>
    </div>
</div>
<div class="portfolio section-padding" data-scroll-index="2">
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-xl-12" style="color:#343434; font-size:20px;">
                <div class="section-title text-left">
                    <h2 class="text-left" style="font-size: 40px;">Why borrow cash?</h2>
                    <p>
                        Have you ever needed cash for something urgent, like medical bills or car repairs?
                         In the past, you might have sold your cryptocurrency to cover it and incurred a taxable gain or loss.
                         Now you don't have to.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-bar-chart"></i></span>
                    <h3>Avoid selling your asset</h3>
                    <p>
                        Selling assets can result in a taxable gain or loss. Borrow from a trader on {{$web->siteName}}
                        to get cash without selling your assets.
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-check"></i></span>
                    <h3>No fees or credit checks</h3>
                    <p>
                        There are no fees or credit checks involved in borrowing from a trader on {{$web->siteName}}. You only pay what
                        you agreed upon with the trader.
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-calendar"></i></span>
                    <h3>Flexible repayment schedule</h3>
                    <p>Pay off the balance on your line of credit on a schedule that works for you. Read our terms of loan</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-money"></i></span>
                    <h3>Get Cash Quickly</h3>
                    <p>Your borrowed cash can be instantly deposited to your bank account.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="portfolio section-padding" data-scroll-index="2">
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-xl-12" style="color:#343434; font-size:20px;">
                <div class="section-title text-left">
                    <h2 class="text-left" style="font-size: 40px;">How it works</h2>
                    <p>
                        Borrowing on {{$web->siteName}} is in two ways. you can borrow either a cryptocurrency or fiat from a
                        verified trader. The options are boundless, and to top it up, there are no charges beyond that agreed between
                        you and your lender.
                    </p>
                </div>
            </div>
        </div>
        <div class="row" style="color:#343434;">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-pie-chart"></i></span>
                    <h3>Choose what to borrow</h3>
                    <p>
                        You can borrow as either a cryptocurrency asset or a fiat using either your fiat or cryptocurrency as
                        collateral respectively.
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-dollar"></i></span>
                    <h3>Get your cash</h3>
                    <p>
                        Using your bank account or trading account, get access to your borrowed cash/asset quickly with no extra fees.
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-calendar"></i></span>
                    <h3>Make scheduled payments</h3>
                    <p>Depending on your agreement, you only need to pay the interest due .
                        Pay off the balance when you’re ready. Additional terms apply.</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="getstart-content">
                    <span><i class="la la-shield"></i></span>
                    <h3>Your asset stays safe</h3>
                    <p>
                        The asset/fiat you use as collateral remains safely held by {{$web->siteName}}.
                        It’s not lent out or used for any other purpose.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
