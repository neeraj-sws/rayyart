@extends('layouts.app')

@section('content')
<div class="container-fluid px-0 ">
<section class="sec_one pt-4 pb-sm-4 pb-0 ">

			<div class="">
				<div id="demo" class="carousel slide" data-bs-ride="carousel">

					<!-- Indicators/dots -->
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
						<button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
						<button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
					</div>

					<!-- The slideshow/carousel -->
					<div class="carousel-inner">


						<div class="carousel-item active">
						    <div class="container">
			        <div class="row mx-0 pt-md-5 pt-0  ps-0   gap-5  pt-2 mt-sm-2 mt-0 pb-5 ">

								<div class=" col-md-4 col-12 welome_content pt-lg-5 pt-sm-0 pt-5 mt-sm-3 mt-5  ps-lg-0 ps-4  me-5">
									<h5 class="mt-lg-5 mt-sm-0 mt-5 pt-sm-3 pt-5 ">Welcome to</h5>
									<div class="ray_img1 mt-md-4 mt-2">
										<img src="{{ asset('front/images/Group1.png') }}">
									</div>

									<p class="mt-2">Discover the best salons and parlour in your area. Explore a world
										of beauty and choose from a variety of services that suit your style.</p>
									<div class="RayYart_botn   gap-3 d-flex   mt-xl-5 mt-0">
										<div class="play mt-xl-5 mt-0 pt-3 ">
											<a href="apk/app-release.apk" download="download">
												<img src="{{ asset('front/images/App Store.png') }}">
											</a>
										</div>
										<div class="play mt-xl-5 mt-0 pt-3">
											<a href="apk/app-release.apk" download="download">
												<img src="{{ asset('front/images/Google Play.png') }}">
											</a>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-5 col-12   pe-0 ps-md-3 ps-0 ms-xl-0 ms-md-5 ms-0">
									<div class="ray_imag1 d-md-none d-block" >
									</div>	
									<div class="ray_imag d-md-block d-none">
										<img src="{{ asset('front/images/ray1.png') }}">
									</div>

								</div>
							</div>




						</div>
						</div>

						<div class="carousel-item">
						    <div class="container">
						     <div class="row mx-0 pt-md-5 pt-0  ps-0   gap-5  pt-2 mt-sm-2 mt-0 pb-5 ">

								<div class=" col-md-4 col-12 welome_content pt-lg-5 pt-sm-0 pt-5 mt-sm-3 mt-5  ps-lg-0 ps-4  me-5">
									<h5 class="mt-lg-5 mt-sm-0 mt-5 pt-sm-3 pt-5 ">Welcome to</h5>
									<div class="ray_img1 mt-md-4 mt-2">
										<img src="{{ asset('front/images/Group1.png') }}">
									</div>

									<p class="mt-2">Discover the best salons and parlour in your area. Explore a world
										of beauty and choose from a variety of services that suit your style.</p>
									<div class="RayYart_botn   gap-3 d-flex   mt-xl-5 mt-0">
										<div class="play mt-xl-5 mt-0 pt-3 ">
											<a href="apk/app-release.apk" download="download">
												<img src="{{ asset('front/images/App Store.png') }}">
											</a>
										</div>
										<div class="play mt-xl-5 mt-0 pt-3">
											<a href="apk/app-release.apk" download="download">
												<img src="{{ asset('front/images/Google Play.png') }}">
											</a>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-5 col-12 pe-0 ps-md-3 ps-0 ms-xl-0 ms-md-5 ms-0">
									<div class="ray_imag2 d-md-none d-block" >
									</div>	
									<div class="ray_imag d-md-block d-none" id="said_img">
										<img src="{{ asset('front/images/salide2.jpeg') }}">
									</div>

								</div>
							</div>
						</div>
						</div>

						<div class="carousel-item">
						  <div class="container">
			        <div class="row mx-0 pt-md-5 pt-0  ps-0   gap-5  pt-2 mt-sm-2 mt-0 pb-5 ">

								<div class=" col-md-4 col-12 welome_content pt-lg-5 pt-sm-0 pt-5 mt-sm-3 mt-5  ps-lg-0 ps-4  me-5">
									<h5 class="mt-lg-5 mt-sm-0 mt-5 pt-sm-3 pt-5 ">Welcome to</h5>
									<div class="ray_img1 mt-md-4 mt-2">
										<img src="{{ asset('front/images/Group1.png') }}">
									</div>

									<p class="mt-2">Discover the best salons and parlour in your area. Explore a world
										of beauty and choose from a variety of services that suit your style.</p>
									<div class="RayYart_botn   gap-3 d-flex   mt-xl-5 mt-0">
										<div class="play mt-xl-5 mt-0 pt-3 ">
											<a href="apk/app-release.apk" download="download">
												<img src="{{ asset('front/images/App Store.png') }}">
											</a>
										</div>
										<div class="play mt-xl-5 mt-0 pt-3">
											<a href="apk/app-release.apk" download="download">
												<img src="{{ asset('front/images/Google Play.png') }}">
											</a>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-5 col-12   pe-0 ps-md-3 ps-0 ms-xl-0 ms-md-5 ms-0">
									<div class="ray_imag1 d-md-none d-block" >
									</div>	
									<div class="ray_imag d-md-block d-none">
										<img src="{{ asset('front/images/ray1.png') }}">
									</div>

								</div>
							</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</section>

		<section class="sec_one pt-xxl-2 pt-md-5 pt-2 pb-lg-5 mb-0">
			<div class="container">
				<div class="row mx-0 ps-sm-1 ps-0 ms-md-3 mt-xxl-0 mt-xl-5 mt-0 pt-xl-2 pt-0 mt-sm-0  mt-3 pb-sm-5 pb-0">
					<div class=" col-md-6 col-12 me-5  Convecol_box mt-md-5 mt-0 pt-xl-5 pt-0 ps-md-0 ps-4">
						<h3 class="mt-md-3 mt-0 pt-xxl-5 pt-lg-3 pt-0">Convenience:</h3>
						<p>Book appointments anytime, anywhere – whether you're at home, at work, or on the go.</p>
					</div>
					<div class="col-md-5 col-12 d-flex pe-0 ps-2 justify-content-md-center justify-content-center">
						<div class="OnePlus_img">
							<img src="{{ asset('front/images/OnePlus.png') }}">
						</div>
						<div class="OnePlus_img">
							<img src="{{ asset('front/images/OnePlus1.png') }}">
						</div>
					</div>
				</div>
			</div>
		</section>

	<section class="sec_two pb-5 pt-5">
			<div class="container">
				<div class="row gx-md-5 gx-0 justify-content-xxl-center  justify-content-between mx-0">
			<div class="col-sm-3 col-4 ">
			
				  <div class="hair_cut pb-0 "> 
				    <img src="{{ asset('front/images/hair_cut.png') }}" class="">
				 </div> 
			
			</div>		

					<div class=" col-3 Craft_box  text-center">
						<h1>Craft your vibe
							<br>With Us
						</h1>
					</div>

					<div class="col-sm-3 col-4">
							 <div class="therading  pb-0 "> 
							    <img src="{{ asset('front/images/thrr.png') }}" class="">
					      </div> 
						</div>
			
				</div>

				<div class="row justify-content-md-between justify-content-center mx-0">


					<div class="col-lg-3 col-4  box_center ">
					  <div class="hair_curling pb-0 "> 
						    	<img src="{{ asset('front/images/three.png') }}"class="">
						</div>
						  
						</div>
				


					<div class="col-lg-3 col-4 ">
						<div class="hair_color  pb-sm-3 pb-0"> 
							<img src="{{ asset('front/images/five.png') }}" class="">
					   </div> 			
						</div>
			

					<div class=" col-4 ">
						
							<div class=" Straightening pb-sm-3 pb-0">
							<img src="{{ asset('front/images/start.png') }}"class="img-fluid">
						 </div>
						
					</div>

				</div> 

			</div>
		</section>

<section class="three"  id="partner_section">
<div class="container">
    <div class="salon_img position-relative">
				<img src="{{ asset('front/images/salon.png') }}">
 					
				<div class="position-absolute bottom-0 row pb-4">
					<div class="salon_content  px-3 col-10 ">
						<p class="">Barbers, tired of chaos? Our app brings smooth booking. Let's simplify salon life,
							one appointment at a time!</p>

						<div class="Partner_btn col-md-5 col-sm-6 col-9  text-center my-sm-4 mt-md-5 my-0 ">
							<a href="apk/Rayyart_partner.apk">Partner With Us</a>
						</div>

					</div>

				</div>
		 </div>	
</div>
		</section>
</div>


<script>
  	
			$(document).ready(function() {
			  $(".bars").click(function() {
				$("#box_toggle").toggleClass("d-none");
				$(this).find('i').toggleClass('fa-bars fa-xmark');
			  });
			  
			  $(".head_list a ").click(function() {
              $(".page-wrapper").removeClass("toggled");
              });
			});
	

</script>
@endsection
