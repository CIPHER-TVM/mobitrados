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
		<header class="header" style="background-color: #3f2689">
			<nav class="navbar navbar-expand-lg fixed-top" style="padding-top: 38px !important;background-color: #3f2689">
				<div class="container"><a class="navbar-brand"  href="<?php echo base_url() ?>"><img id="mainlogo" src="<?php echo base_url() ?>assets/website/img/logo.svg" alt=""    ></a>
					<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
						data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
						aria-label="Toggle navigation" style="position: absolute;right: 7px;"><i class="fas fa-bars"
							style="color: white;"></i></button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
						<li class="nav-item"><a class="nav-link link-scroll active"  href="<?php echo base_url() ?>">Home <span class="sr-only">(current)</span></a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="<?php echo base_url() ?>#features">Features</a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="<?php echo base_url() ?>#about">About Us</a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="<?php echo base_url() ?>#screenshots">Screenshots</a></li>
							<li class="nav-item"><a class="nav-link link-scroll" href="<?php echo base_url() ?>#contact">Contact Us</a></li>
							
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
		
		<section class="bg-center py-0" id="about"
			style="background: url(<?php echo base_url() ?>assets/website/img/service-bg.svg) no-repeat; background-size: cover">
			<section class="about py-0">
				<!-- about cut -->
			</section>




		
		<!-- Contact_us Section -->
		<div class="say-something-aera pt-90 pb-90 fix" style="margin-top: 5%;" id="hero">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="offset-xl-12 offset-lg-12 col-xl-12 col-lg-12">
						<div class="say-something-cap">
							<h2>Cancellation / Refund Policy</h2>
                         <?php
                         $terms=getAfield("app_terms"," refund_policy","where id=(select max(id) from  refund_policy)");
                         echo $terms;
                          ?>   
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
							<li class="mb-2"><a class="footer-link" href="<?php echo base_url() ?>#features">Features</a></li>
								<li class="mb-2"><a class="footer-link" href="<?php echo base_url() ?>#about">About us</a></li>
								<li class="mb-2"><a class="footer-link" href="<?php echo base_url() ?>#screenshots">Screenshots</a></li>
								<li class="mb-2"><a class="footer-link" href="<?php echo base_url() ?>#contact">Contact us</a></li>
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