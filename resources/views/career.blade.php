
@include('templates.header')
        <div class="intro-video section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="intro-video-play">
                            <div class="play-btn">

                            </div>
                        </div>
                        <div class="intro-video-content text-center mt-5">
                            <h2>We saved a seat for you</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="career section-padding">
            <div class="container">
                <div class="row align-items-center justify-content-between py-5">
                    <div class="col-xl-5">
                        <div class="career-content-img">
                            <img class="img-fluid" src="{{asset('home/images/team/meritinfos.jpeg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="career-content py-5">
                            <h3>Working at {{$web->siteName}}</h3>
                            <p>We’ve taken a huge challenge and made it into our mission: to create an open financial
                                system
                                for the world. To achieve this, we are building a team of smart, creative, passionate
                                optimists, the kind of people who see opportunity
                                where others see roadblocks. If this sounds like you, <a href="#roles">check out our open
                                    roles.</a></p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between py-5">
                    <div class="col-xl-6">
                        <div class="career-content py-5">
                            <h3>Our values</h3>
                            <p>Our values inform our behavior and the choices we make every day. As a result, our
                                culture is
                                a model of the world we’re trying to build: transparent, joyful, curious, and
                                fast-moving.
                                Our values are a large part of why {{$web->siteName}}
                                is a great place to work, and why we’ve been successful. They are much more than words
                                to us
                                (and we have the emojis to prove it).</p>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="career-content-img">
                            <img class="img-fluid" src="{{asset('home/images/team/chikezieemmanuel.jpg')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between py-5">
                    <div class="col-xl-5">
                        <div class="career-content-img">
                            <img class="img-fluid" src="{{asset('home/images/bg/2.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="career-content py-5">
                            <h3>Our mission</h3>
                            <p>Everyone deserves access to financial services that can help empower
                                 them to create a better life for themselves and their families.
                                 If the world economy ran on a common set of standards that could not be
                                 manipulated by any company or country, the world would be a more fair and free place,
                                 and human progress would accelerate.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="choose-team section-padding" id="roles">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="section-title text-center">
                            <h2>Opened Roles</h2>
                            <p>All roles are Remote</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div id="accordion-faq" class="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseOne1">
                                        <i class="fa"></i>Business Development & Sales</h4>
                                </div>
                                <div id="collapseOne1" class="collapse show" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Business Development Manager</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Business Development Associate, Partner Management</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Global Head of Partner Success</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseOne2">
                                        <i class="fa"></i>Business Operations & Strategy</h4>
                                </div>
                                <div id="collapseOne2" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Business Operations & Strategy Associate </h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Business Operations & Strategy Director, Pricing</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Business Operations & Strategy Manager, Crypto & Ecosystems</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseOne3">
                                        <i class="fa"></i>Corporate Development & Ventures</h4>
                                </div>
                                <div id="collapseOne3" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Associate Manager, M&A Integration</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Business Operations & Strategy Manager, Platform and Payments</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Platform Management Associate, Ventures and Ecosystem</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseOne4">
                                        <i class="fa"></i>Customer Experience</h4>
                                </div>
                                <div id="collapseOne4" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Analyst, Compliance Operations</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Analyst, Content Moderation</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Customer Service Agent</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseOne5">
                                        <i class="fa"></i>Legal & Compliance</h4>
                                </div>
                                <div id="collapseOne5" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Associate, Compliance Tools and Data Analytics</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Compliance, KYC/Onboarding Associate</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Compliance Partnerships & Regulatory Initiatives Senior Associate</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseTwo2">
                                        <i class="fa"></i>Engineering - Frontend</h4>
                                </div>
                                <div id="collapseTwo2" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">React Engineer</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Vue Engineer</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseTwo3">
                                        <i class="fa"></i>Engineering - Backend</h4>
                                </div>
                                <div id="collapseTwo3" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Senior Backend Engineer</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Blockchain Backend Engineer</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Laravel Backend Engineer</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Senior Software Engineer - (Crypto Security Engineer)</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Senior Software Engineer - Database Reliability</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0 collapsed c-pointer" data-toggle="collapse"
                                        data-target="#collapseThree3">
                                        <i class="fa"></i>Marketing & Communications</h4>
                                </div>
                                <div id="collapseThree3" class="collapse" data-parent="#accordion-faq">
                                    <div class="card-body">
                                        <div>
                                            <h5 class="text-primary">Affiliate Marketing Manager</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Director, Institutional Sales Marketing</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Content Strategist, Institutional</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Events Manager</h5>
                                            <span>Remote</span>
                                        </div>
                                        <div>
                                            <h5 class="text-primary">Manager, Retail Product Communications</h5>
                                            <span>Remote</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('templates.footer')
