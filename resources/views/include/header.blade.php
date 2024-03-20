	<nav class="navbar navbar-expand-md header_box">
			<div class="container">
				<a class="navbar-brand" href="{{ url('/') }}">
					<img src="{{ asset('front/images/Ellipse 22.png') }}" alt="Logo">
				</a>
			 	<button class="bars d-lg-none d-inline-block"type="button">
						 <i class="fa fa-bars" aria-hidden="true"></i>
					</button>
		        <div class="d-lg-flex d-none align-items-baseline d-none" id="box_toggle">		   
						 <ul class=" mobile feane list-unstyled  d-lg-none d-block list-group list-lg-group-Horizontal">
							<li class="nav-item">
								<a class="nav-link" href="#">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">For Business</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Contact Us</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('about-us') }}">About Us</a>
							</li>
					</ul> 
			   
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav  gap-md-3 gap-0 head_list mt-2">
						<li class="nav-item">
							<a class="nav-link" href="#">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">For Business</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Contact Us</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">About Us</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
<div class="page-wrapper chiller-theme d-none">
  <a id="show-sidebar" class="btn btn-sm btn-dark mt-3" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand ">
       <ul class="navbar-nav  gap-md-3 gap-0 head_list">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">For Business</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
            </li>
      </ul>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
    </nav>
    
   </div> 
    </div>