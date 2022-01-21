@include('templates.header')
        <div class="join-team section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="join-team-content text-center">
                            <h2 class="mb-2">Want to work with us?</h2>
                            <p class="mb-4">We're always looking to hire talented folks to join our ever-growing team of
                                designers, engineers, and support staff.</p>
                            <a href="{{url('career')}}" class="btn btn-primary px-4 py-2">View Open Position</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="team-member section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="section-title text-center">
                            <h2>Small team. Big hearts.</h2>
                            <p>Our focus is always on finding the best people to work with. Our bar is high, but do you
                                look
                                ready to take on the challenge?</p>
                        </div>
                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/michael.jpeg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/chikezieemmanuel.jpg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/chijiokeemmanuel.jpeg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/aniprecious.jpg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/lilian.jpeg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/rabbiu.jpg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>
                    <div class="col-md-4 mx-auto" style="margin-bottom: 5px;">
                        <img src="{{asset('home/images/team/meritinfos.jpeg')}}" class="img-fluid rounded shadow-md" alt="...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="trusted-business py-5 text-center">
                            <h3>Trusted by over <strong>thousands of users</strong> in Africa</h3>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="trusted-logo">
                                    <a href="#"><img class="img-fluid" src="{{asset('home/images/logo.png')}}" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="interested-join section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="interested-join-content text-center">
                            <h2>Interested in joining our team?</h2>
                            <p>Hit us up and we'll get in touch with you.</p>
                            <a href="{{url('career')}}" class="btn btn-primary">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('templates.footer')
