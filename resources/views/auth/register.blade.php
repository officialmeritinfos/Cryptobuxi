
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

		<!-- Meta data -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="WkEA58LmAcC5qN1fvQbNcHXeI0XKsB78Sl5EsMr4" />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <title>{{$pageName}}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="copyright" content="{{$web->siteName}} is a registered trademark of Meritinfos LLC">
    <meta name="title" content="{{$pageName}}">
    <meta name="description" content="{{$pageName}}">
    <meta name="robots" content="index,follow">
    <meta name="author" content="Meritinfos LLC">
    <meta name="keywords" content="{{$web->siteTag}}"/>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{$web->url}}">
    <meta property="og:title" content="{{$pageName}}">
    <meta property="og:description" content="{{$web->siteDescription}}">
    <meta property="og:image" content="{{ asset('home/images/'.$web->favicon) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{$web->url}}">
    <meta property="twitter:title" content="{{$pageName}}">
    <meta property="twitter:description" content="{{$web->siteDescription}}">
    <meta property="twitter:image" content="{{ asset('home/images/'.$web->favicon) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('home/images/'.$web->favicon) }}">
		<!-- Bootstrap css -->
		<link href="{{asset('dashboard/assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

		<!-- Style css -->
		<link href="{{asset('dashboard/assets/css/style.css')}}" rel="stylesheet" />

		<!-- Dark css -->
		<link href="{{asset('dashboard/assets/css/dark.css')}}" rel="stylesheet" />

		<!-- Skins css -->
		<link href="{{asset('dashboard/assets/css/skins.css')}}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{asset('dashboard/assets/css/animated.css')}}" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{asset('dashboard/assets/plugins/web-fonts/icons.css')}}" rel="stylesheet" />
		<link href="{{asset('dashboard/assets/plugins/web-fonts/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
		<link href="{{asset('dashboard/assets/plugins/web-fonts/plugin.css')}}" rel="stylesheet" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    </head>

	<body class="h-100vh  light-mode default-sidebar" style="background-color: #1F51FF; ">
		<div class="page">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-md-12 mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-6 col-lg-6 pt-4">
									<div class="card card-group">
										<div class="card p-4">
											<div class="card-body">
												<div class="text-center title-style mb-6">
													<h1 class="mb-2">Create Your Account</h1>
													<hr>
												</div>
                                                <form method="post"
                                                      id="create_account" action="{{url('register')}}">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label">Name</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-lg "
                                                                    placeholder="Full Name" name="name" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg"
                                                                placeholder="Enter Email" name="email" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="form-label">Phone</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control form-control-lg"
                                                                    placeholder="Enter mobile Phone" name="phone" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="form-label">Password</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control form-control-lg"
                                                                    placeholder="Password" name="password" required id="password">
                                                                <span class="input-group-append">
                                                                    <button class="btn btn-dark box-shadow-0 show-password" type="button">
                                                                    <i class="fa fa-eye"></i></button>
                                                                </span>
                                                                <span class="input-group-append">
                                                                    <button class="btn btn-dark box-shadow-0 hide-password" style="display: none;" type="button">
                                                                    <i class="fa fa-eye-slash"></i></button>
                                                                </span>
                                                            </div>
                                                            <small class="text-info">
                                                                Password must contain at least: one specialcharacter, an upercase and lowercase letter, and number.
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" required />
                                                            <span class="custom-control-label ">
                                                                I certify that I am 18 years of age or older, and agree to the
                                                                <a href="{{url('legal')}}" class="btn-link">
                                                                    User Agreement  </a> and <a href="{{url('privacy')}}" class="btn-link">
                                                                        Privacy Policy </a> including the
                                                                        <a href="{{url('aml')}}" class="btn-link"> Anti-money Laundering
                                                                            policy</a>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-lg btn-primary btn-block px-4" id="submit" disabled>
                                                                <i class="fa fa-arrow-right"></i>
                                                                Create account
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
											</div>
										</div>
									</div>
									<div class="text-center pt-4">
										<div class="font-weight-normal fs-16 text-white">You Already have an account?
                                            <a class="btn-link font-weight-bolder text-white" href="{{url('login')}}">Log in</a>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Jquery js-->
		<script src="{{asset('dashboard/assets/js/vendors/jquery-3.5.1.min.js')}}"></script>

		<!-- Bootstrap4 js-->
		<script src="{{asset('dashboard/assets/plugins/bootstrap/popper.min.js')}}"></script>
		<script src="{{asset('dashboard/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

		<!--Othercharts js-->
		<script src="{{asset('dashboard/assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>

		<!-- Circle-progress js-->
		<script src="{{asset('dashboard/assets/js/vendors/circle-progress.min.js')}}"></script>

		<!-- Jquery-rating js-->
		<script src="{{asset('dashboard/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
		<script src="{{asset('dashboard/auth/password.js')}}"></script>
        <!-- Notifications js -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
	</body>
</html>
