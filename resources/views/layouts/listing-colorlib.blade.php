<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Colorlib">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
    <!-- Page Title -->
    <title>Restaurant Directory Application</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
	<div id="app">
		<!--============================= HEADER =============================-->
		<div class="nav-menu">
			<div class="bg transition">
				<div class="container-fluid fixed">
					<div class="row">
						<div class="col-md-12">
							<nav class="navbar navbar-expand-lg navbar-light">
								<a class="navbar-brand" href="{{ url('/') }}">Restaurant Directory</a>
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
									<span class="icon-menu"></span>
								</button>
								<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
									<ul class="navbar-nav">
										<li class="nav-item dropdown">
											<a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Explore
												<span class="icon-arrow-down"></span>
											</a>
											<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
												<a class="dropdown-item" href="#">Action</a>
												<a class="dropdown-item" href="#">Another action</a>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Listing
												<span class="icon-arrow-down"></span>
											</a>
											<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
												<a class="dropdown-item" href="#">Action</a>
												<a class="dropdown-item" href="#">Another action</a>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Pages
												<span class="icon-arrow-down"></span>
											</a>
											<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
												<a class="dropdown-item" href="#">Action</a>
												<a class="dropdown-item" href="#">Another action</a>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</li>
										<li class="nav-item active">
											<a class="nav-link" href="#">About</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="#">Blog</a>
										</li>
										<li><a href="#" class="btn btn-outline-light top-btn"><span class="ti-plus"></span> Add Restaurant</a></li>
									</ul>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- SLIDER -->
		<section class="slider d-flex align-items-center">
			<!-- <img src="images/slider.jpg" class="img-fluid" alt="#"> -->
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="col-md-12">
						<div class="slider-title_box">
							<div class="row">
								<div class="col-md-12">
									<div class="slider-content_wrap">
										<h1>Restaurant Listing Application</h1>
										<h5>Developed with using Laravel 5.7 & Vue.js</h5>
									</div>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-md-4">
									<div class="featured-btn-wrap">
										<a href="#restaurants" class="btn btn-danger">VIEW RESTAURANTS</a>
									</div>
								</div>
							</div>
							<!--<div class="row d-flex justify-content-center">
								<div class="col-md-10">
									<form class="form-wrap mt-4">
										<div class="btn-group" role="group" aria-label="Basic example">
											<input type="text" placeholder="What are your looking for?" class="btn-group1">
											<input type="text" placeholder="New york" class="btn-group2">
											<button type="submit" class="btn-form"><span class="icon-magnifier search-icon"></span>SEARCH<i class="pe-7s-angle-right"></i></button>
										</div>
									</form>
									<div class="slider-link">
										<a href="#">Browse Popular</a><span>or</span> <a href="#">Recently Addred</a>
									</div>
								</div>
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--// SLIDER -->
		<!--//END HEADER -->
	@yield('content')
		<!--============================= FOOTER =============================-->
		<footer class="main-block dark-bg">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="copyright">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							<p>Copyright &copy; 2018 Listing. All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							<ul>
								<li><a target="_blank" href="https://www.linkedin.com/in/yenerunver/"><span class="ti-linkedin"></span></a></li>
								<li><a target="_blank" href="https://twitter.com/yenerunver"><span class="ti-twitter-alt"></span></a></li>
								<li><a target="_blank" href="https://instagram.com/yenerunver"><span class="ti-instagram"></span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--//END FOOTER -->
	</div>
	<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
