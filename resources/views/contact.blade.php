@include('templates.header')
<div class="contact-form section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="section-title">
                            <h2>Let us hear from you directly!</h2>
                            <p>We always want to hear from you! Let us know how we can best help you and we'll do our
                                very best.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="info-list">
                            <h5 class="mb-3">Address</h5>
                            <ul>
                                <li><i class="fa fa-map-marker"></i>{{$web->siteAddress}} </li>
                                <li><i class="fa fa-phone"></i> {{$web->phone}}</li>
                                <li><i class="fa fa-envelope"></i> {{$web->siteEmail}}</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('templates.footer')
