	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>MOBI TRADOS </title>
		<meta name="description" content="MOBI TRADOS Online mobile store">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="all,follow">
		<!-- Bootstrap CSS-->
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/vendor/bootstrap/css/bootstrap.min.css">
			<!-- Owl Carousel-->
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/vendor/owl.carousel2/assets/owl.carousel.css">
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/vendor/owl.carousel2/assets/owl.theme.default.css">
			<!-- Modal Video-->
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/vendor/modal-video/css/modal-video.min.css">
			<!-- Google fonts-->
		<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,800&amp;display=swap"> -->
			<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
		<!-- Device Mockup-->
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/device-mockups.css">
			<!-- theme stylesheet-->
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/style.default.css" id="theme-stylesheet">
			<!-- Custom stylesheet - for your changes-->
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/custom.css">
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/guest.css">
			<link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/flaticon.css">
			<!-- Favicon-->
			<link rel="shortcut icon" href="<?php echo base_url() ?>assets/website/img/favicon.png">
			<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
		/>

	</head>
	<style>
		::-webkit-scrollbar-track
		{
			-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
			background-color: #F5F5F5;
			border-radius: 10px;
		}
		
		::-webkit-scrollbar
		{
			width: 10px;
			background-color: #F5F5F5;
		}
		
		::-webkit-scrollbar-thumb
		{
			border-radius: 10px;
			background-image: -webkit-gradient(linear,
												left bottom,
												left top,
												color-stop(0.44, rgb(122,153,217)),
												color-stop(0.72, rgb(73,125,189)),
												color-stop(0.86, rgb(28,58,148)));
		}
		
		.nav-link
		{
		color: #FFF;
		}
		.nav-link.active {
		color: #ffc107;
		}
		.navbar.active {
		color: #000 !important;
		}
		.navbar-brand img
		{
			max-width:40%;
		}
		#mainlogo{
			width: 30%;
		}
		.navbar-brand{
			width: 50%;
		}
		@media only screen and (min-width: 200px) and (max-width: 670px) {
		.navbar-brand{
			width: 100%;
		}
			#mainlogo{width: 37%;
max-width: unset;
max-height: unset;
		}
		.navbar-brand img {
			max-width:100%;
			max-height:50%;
			
		}
		.main-header {height:80px;}
		.main_div
		{
			background: #452c8e;background-image: linear-gradient(90deg, #472b9a, #351b82);
		}
		}
			</style>
	<body style="overflow-x: hidden">
		<!-- navbar-->
		<header class="header">
			<nav class="navbar navbar-expand-lg fixed-top" style="padding-top: 38px !important;">
				<div class="container"><a class="navbar-brand"  href="#"><img id="mainlogo" src="<?php echo base_url() ?>assets/website/img/logo.svg" alt=""    ></a>
					<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
						data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
						aria-label="Toggle navigation" style="position: absolute;right: 7px;"><i class="fas fa-bars"
							style="color: white;"></i></button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item"><a class="nav-link link-scroll active" href="#hero">Home <span class="sr-only">(current)</span></a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="#features">Features</a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="#about">About Us</a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="#screenshots">Screenshots</a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="#contact">Contact Us</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<style>
			.particle-bg 
			{
				position: absolute;
				top: 40%;
				left: 85%;
			}
			.particle-bg img {
				animation: spin 27s linear infinite;
			} 

			@keyframes spin {
				100% {
					transform: rotate(360deg);
				}
			}
		</style>
		<!-- Hero Section-->
		<section class="hero bg-top" id="hero" style="background: url(<?php echo base_url() ?>assets/website/img/banner-4.svg) no-repeat;overflow: hidden;">
			<div class="container">



				<div class="row py-5" style="position:relative;top:25%">
					<div class="col-lg-5 py-5 main_div">
						<h1 class="font-weight-bold animate__animated animate__slower animate__fadeInLeft"
							style="font-weight:400 !important;color:#FFF"> <br />Download Our App</h1>
						<p class="my-4 text-muted animate__animated animate__slower animate__fadeInLeft"
							style="color:#FFFFFF !important">The fastest online mobile shop.</p>
						<ul class="list-inline mb-0">
							<li class="list-inline-item mb-2 mb-lg-0 animate__animated animate__slower animate__fadeInLeft"><a
									class="btn btn-primary btn-lg px-4" href="https://play.google.com/store/apps/details?id=com.cipher.mobitrados"> <i class="fab fa-google-play mr-3"></i>Google Play</a>
							</li>
							<!-- <li class="list-inline-item animate__animated animate__slower animate__fadeInLeft"><a
									class="btn btn-primary btn-lg px-4" href="#"> <i class="fab fa-app-store mr-3"></i>App Store</a></li> -->
						</ul>
					</div>
					<div class="col-lg-6 ml-auto">

						<div class="device-wrapper mx-auto animate__animated animate__slower animate__fadeInUp"
							style="position:relative;top:15%">
							<div class="device shadow" data-device="iPhoneX" data-orientation="portrait" data-color="black">
								<div class="screen"><img class="img-fluid" style="max-width: 99%;" src="<?php echo base_url() ?>assets/website/img/mobile.png" alt=""></div>
							</div>
						</div>
					</div>
				</div>
				<div class="particle-bg"><img src="<?php echo base_url() ?>assets/website/img/hero-bg-effect.png" alt="particle"></div>
			</div>
		</section>
		<section class="bg-center py-0" id="features"
			style="background: url(<?php echo base_url() ?>assets/website/img/service-bg.svg) no-repeat; background-size: cover">
			<section class="about py-0">
				<!-- about cut -->
			</section>




			<section style="margin-top: -20%; margin-bottom: -5%;" class="best-features-area inner-padding">
				<div class="container-fluid">
					<!-- <div class="row"> 
					<img src="img/best-features.png" alt="" >
					</div> -->
					<div class="row ">
						<!-- <div class="row justify-content-end"> -->
							<div class="col-xl-6 col-lg-6">
								<img src="<?php echo base_url() ?>assets/website/img/best-features.png" alt="" style="width: 100%;">
							</div>
						<div class="col-xl-6 col-lg-6">
							<div class="row">
								<div class="col-lg-10 col-md-10">
									<div class="section-tittle" style="text-align:right">
										<h2>Best features Of <br> Our App!</h2>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="single-features mb-70">
										<div class="features-icon">
											<span class=""></span>
										</div>
										<div class="features-caption">
											<h3>Fast Delivery</h3>
											<p>Products will be delivered within hours under 40km from shop

											</p>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="single-features mb-70">
										<div class="features-icon">
											<span class=""></span>
										</div>
										<div class="features-caption">
											<h3>Best UI</h3>
											<p>Our user interface will guide you for a  fastest check out.

											</p>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="single-features mb-70">
										<div class="features-icon">
											<span class=""></span>
										</div>
										<div class="features-caption">
											<h3>Best Prize</h3>
											<p>
												Great prize drop compared to other e-com apps
											</p>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="single-features mb-70">
										<div class="features-icon">
											<span class=""></span>
										</div>
										<div class="features-caption">
											<h3>Complete Mobile Shop</h3>
											<p>All type of mobile phones and accessories best categorized

											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class=" " style="top: 29%;width: 166%;opacity: 0.1;"> -->
				<!-- <div class="features-shpae features-shpae2 d-none d-lg-block" style="top: 29%;width: 166%;opacity: 0.1;"> -->
					<!-- <img src="img/best-features.png" alt="" > -->
				<!-- </div> -->
			</section>

			<section class="with-pattern-1" id="about" style="padding-top: 0.5rem  !important;">
				<div class="container">
					<div class="row align-items-center mb-5">
						<div class="col-lg-4 mb-4 mb-lg-0"><img class="img-fluid w-100 px-lg-5" src="<?php echo base_url() ?>assets/website/img/objects.svg" alt=""></div>
						<div class="col-lg-8">

							<h2>WHAT WE DO?</h2>
							<p class="text-muted" style="text-align: justify">Mobi Trados gives you a chance to quickly and easily find the phone
							you want and have it delivered to your home in no time, regardless of
							your location.
							</p>

							<h2>WHY DO CUSTOMERS LOVE US?</h2>
							<p class="text-muted" style="text-align: justify">We have been in the business for quite a while now, and it that time
							we have not only managed to make close relationships with numerous
							suppliers all over the world, but also to recognize what people need.
							This means that we are always able to offer all the latest phones, great
							prices, reliable service, fast delivery and premium customer support
							</p>


						</div>

					</div>


					<div class="row align-items-center mb-5">
						<div class="col-lg-8">

							<h2>BEGINNING</h2>
							<p class="text-muted" style="text-align: justify">Mobi Trados website was launched in 2021, but its story actually
							began that when a group of friends decided to go into business
							together. We started selling phones in shops, but our combined
							ambition, drive and abilities soon made us look for new challenges
							and new markets. Starting an online shop provided for both and
							allowed us to develop a strong international presence.
							</p>

							<h2>TODAY</h2>
							<p class="text-muted" style="text-align: justify">Collective experience of our team members and the months we have
spent in the business allowed us to develop a vast network of
suppliers, ensuring that our customers will always find what they are
looking for. This also means that we are able to offer great prices,
which are constantly being updated and follow the shifts in the
market.
Our affordability, fast and reliable delivery, and the fact that you will
always be able to find the phone that you are looking for in our offer,
have made us stand out in the market, but they are simply symptoms of our dedication to what we are doing and our desire to constantly
keep improving. We know that in order to do that, we need to keep in
close touch with our customers and listen to their suggestions and
critiques. This is why our customer service, which is always there to
answer any question that you may have, is just as willing to listen as it
is to inform.
							</p>


						</div>

						<div class="col-lg-4 mb-4 mb-lg-0"><img class="img-fluid w-100 px-lg-5" src="<?php echo base_url() ?>assets/website/img/objects.svg" alt=""></div>
						

					</div>

					<div class="row align-items-center" style="margin-top: 12%;">
						<div class="col-lg-12 mb-12 mb-lg-12">
								<img src="<?php echo base_url() ?>assets/website/img/banner.png" style="width:100%;">
						</div>
						
					</div>
				</div>
			</section>
		</section>


		<section class="p-0" id="screenshots"
			style="background: url(<?php echo base_url() ?>assets/website/img/testimonials-bg.png) no-repeat; background-size: 40% 100%; background-position: left center">
			<div class="container text-center">
				<p class="h6 text-uppercase text-primary">Screenshots</p>
			<style>
				.img
				{
					width:100%;
				}
				.centered
				{
					margin: auto;
					width: 40%;
					padding: 10px;
				}
			</style>	
				<div class="row">
					<div class="col-lg-8 mx-auto">
						<div class="owl-carousel owl-theme testimonials-slider">
							<div class="mx-3 mx-lg-2 my-5 pt-2">
								<div class="centered">
									<img class="img" src="<?php echo base_url() ?>assets/website/img/screens/1.png">
									</div>
							</div>
							<div class="mx-3 mx-lg-2 my-5 pt-2">
								<div class="centered">
									<img class="img" src="<?php echo base_url() ?>assets/website/img/screens/2.png">
									</div>
							</div>
							<div class="mx-3 mx-lg-2 my-5 pt-2">
								<div class="centered">
									<img class="img" src="<?php echo base_url() ?>assets/website/img/screens/5.png">
									</div>
							</div>
							
							<div class="mx-3 mx-lg-2 my-5 pt-2">
								<div class="centered">
									<img class="img" src="<?php echo base_url() ?>assets/website/img/screens/3.png">
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Contact_us Section -->
		<div class="say-something-aera pt-90 pb-90 fix" style="margin-top: 5%;" id="contact">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="offset-xl-1 offset-lg-1 col-xl-5 col-lg-5">
						<div class="say-something-cap">
							<h2>Say Hello</h2>
						</div>
					</div>
					<div class="col-xl-2 col-lg-3">
						<div class="say-btn">
							<a href="#" class="btn radius-btn" style="width: 100%;font-size: 11px;">Contact Us</a>
						</div>
					</div>
				</div>
			</div>

			<div class="say-shape">
				<img src="<?php echo base_url() ?>assets/website/img/say-shape-left.png" alt="" class="say-shape1 rotateme d-none d-xl-block">
				<!-- <img src="img/say-shape-right.png" alt="" class="say-shape2 d-none d-lg-block"> -->
			</div>
		</div>
		<!-- end Contact_us Section -->
		<a class="scropll-top-btn" id="scrollTop" href="#"><i class="fas fa-long-arrow-alt-up"></i></a>


		<footer class="with-pattern-1 position-relative">
			<div class="container section-padding-y">
				<div class="row">
					
					<div class="col-lg-3 mb-6 mb-lg-0">
						<h2 class="h5 mb-4">Quick Links</h2>
						<div class="d-flex">
							<ul class="list-unstyled d-inline-block mr-4 mb-0">
								<li class="mb-2"><a class="footer-link" href="terms_conditions">Terms And Conditions</a></li> </a></li>
								<li class="mb-2"><a class="footer-link" href="privacy_policy">Privacy Policy</a></li>
								<li class="mb-2"><a class="footer-link" href="cancelation_refund_policy">Cancellation / Refund Policy</a></li>
								<li class="mb-2"><a class="footer-link" href="shipping_delivery_policies">Shipping And Delivery Policy</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 mb-4 mb-lg-0">
						<h2 class="h5 mb-4">Services</h2>
						<div class="d-flex">
							<ul class="list-unstyled mr-4 mb-0">
								
								
								<li class="mb-2"><a class="footer-link" href="#features">Features</a></li>
								<li class="mb-2"><a class="footer-link" href="#about">About us</a></li>
								<li class="mb-2"><a class="footer-link" href="#screenshots">Screenshots</a></li>
								<li class="mb-2"><a class="footer-link" href="#contact">Contact us</a></li>
								
							</ul>
						</div>
					</div>
					<div class="col-lg-5">
						<h2 class="h5 mb-4">Contact Info</h2>
						<ul class="list-unstyled mr-4 mb-3">
							<li class="mb-2 text-muted">19/20H Kattaikadu Ammandivilai <br> Kaniyakumari - 629204 </li>
							<li class="mb-2"><a class="footer-link" href="tel:+917358167613">+91 7358167613</a></li>
							<li class="mb-2"><a class="footer-link" href="mailto:mobitrados@gmail.com">mobitrados@gmail.com</a></li>
						</ul>
						<ul class="list-inline mb-0">
							<li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-twitter"></i></a></li>
							<li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-google-plus"></i></a></li>
							<li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="copyrights">
				<div class="container text-center py-4">
					<p class="mb-0 text-muted text-sm">&copy; 2021, <span style="color:#433894">MOBI TRADOS.</span> Developed by <a href="http://ciphertechnologies.co.in" class="" style="color:#e44ba6" >CIPHER TECHNOLOGIES</a>.</p>
				</div>
			</div>
		</footer>
		<!-- JavaScript files-->
		<script src="<?php echo base_url() ?>assets/website/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url() ?>assets/website/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url() ?>assets/website/vendor/owl.carousel2/owl.carousel.min.js"></script>
		<script src="<?php echo base_url() ?>assets/website/vendor/modal-video/js/modal-video.js"></script>
		<script src="<?php echo base_url() ?>assets/website/js/front.js"></script>
		<script>
			// ------------------------------------------------------- //
			//   Inject SVG Sprite - 
			//   see more here 
			//   https://css-tricks.com/ajaxing-svg-sprite/
			// ------------------------------------------------------ //
			function injectSvgSprite(path) {
			
					var ajax = new XMLHttpRequest();
					ajax.open("GET", path, true);
					ajax.send();
					ajax.onload = function(e) {
					var div = document.createElement("div");
					div.className = 'd-none';
					div.innerHTML = ajax.responseText;
					document.body.insertBefore(div, document.body.childNodes[0]);
					}
			}
			// this is set to BootstrapTemple website as you cannot 
			// inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
			// while using file:// protocol
			// pls don't forget to change to your domain :)
			injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
			
		</script>
		<!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	</body>
	</html>