@include('templates.header')

<div class="intro">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xl-6 col-lg-6 col-12">
                <div class="intro-content">
                    <h1>Buy and sell your favorite cryptocurrencies on <strong class="text-primary">{{$web->siteName}}</strong>.

                    </h1>
                    <p>{{$web->siteName}} is the fastest and safest way to buy, sell, store and accept cryptocurrencies.
                     <br>   No more having to wait or fall prey to fraudulent buyers or sellers.</p>
                </div>
                <div class="intro-btn">
                    <a href="{{url('register')}}" class="btn btn-primary">Get Started</a>
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
                            Buy without Registration
                            <i class="la la-arrow-right"></i>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
