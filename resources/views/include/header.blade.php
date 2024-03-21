<div class="container-fluid px-0 ">

    <nav class="navbar navbar-expand-md header_box">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('front/images/Ellipse 22.png') }}" alt="Logo">
            </a>
                            <!-- <ul class="d-sm-flex  d-none one_navbar gap-4 py-5 mt-2">
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
                            </ul> -->
                            <!-- 			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
                </button> -->

            <!-- Modal -->
            @php $CompanyContact =\App\Models\CompanyContact::first(); @endphp
            <div class="modal fade pe-0" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-2 " id="exampleModalLabel">Contact us</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body ps-md-5 ps-4 mt-2">
                            <div class="d-flex ">
                                <div class="Vector_img ">
                                    <img src="{{ asset('front/images/phone.png')}}">
                                </div>
                                <div class="phone_content ps-3">
                                    <h2 class="mb-0">Phone number</h2>
                                    <p>{{ $CompanyContact->phone }}</p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div class="Vector_img1 pt-sm-1 pt-0 ">
                                    <img src="{{ asset('front/images/Vector (1).png')}}">
                                </div>
                                <div class="phone_content ps-3">
                                    <h2 class="mb-0">Email</h2>
                                    <p>{{ $CompanyContact->email }}</p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div class="Vector_img2 pt-sm-1 pt-0">
                                    <img src="{{ asset('front/images/Vector (2).png')}}">
                                </div>
                                <div class="phone_content ps-3">
                                    <h2 class="mb-0">Address</h2>
                                    <p class="add_title" style="width: 305px;">{{ $CompanyContact->address }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div> -->
                    </div>
                </div>
            </div>

            <ul class="navbar-nav  gap-md-3 gap-0 head_list  d-md-flex d-none mt-2 py-4">
                <li class="nav-item">
                    <a class="btn btn-primary" class="nav-link " href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" class="nav-link" href="#partner_section">For Business</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" class="nav-link" href="{{ route('about-us') }}">About Us</a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="page-wrapper chiller-theme d-md-none d-block">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>

        <nav id="sidebar" class="sidebar-wrapper">

            <div class="sidebar-content">

                <div class="sidebar-brand ">
                    <ul class="navbar-nav  gap-md-3 gap-0 head_list mt-2 w3-animate-left" id="hove">

                        <li class="nav-item">
                            <a class="btn btn-primary" class="nav-link ps-5" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" class="nav-link ps-5" href="#partner_section" id="businessLink">For Business</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class="nav-link ps-5" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" class="nav-link ps-5" href="{{ route('about-us') }}">About Us</a>
                        </li>
                    </ul>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

            </div>
        </nav>

    </div>
    <!-- tig623ti81`7ir76fvcytf6 -->


    <!-- 3y7hg27dxgv4x873 -->

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("businessLink").addEventListener("click", function(event) {
            event.preventDefault();

            var pageWrapper = document.querySelector(".page-wrapper");
            var sidebarWrapper = document.querySelector(".sidebar-wrapper");

            if (pageWrapper.classList.contains("toggled")) {
                pageWrapper.classList.remove("toggled");
                sidebarWrapper.classList.remove("d-block");
            } else {
                pageWrapper.classList.add("toggled");
                sidebarWrapper.classList.add("d-block");
            }
            var partnerSection = document.getElementById("partner_section");
        partnerSection.scrollIntoView({ behavior: "smooth" });
        });
    });
</script>

