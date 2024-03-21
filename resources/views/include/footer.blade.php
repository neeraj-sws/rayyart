
<footer class="px-md-5 px-3">
    <div class="container">
        <div class="footer ps-sm-3 ps-0 pt-5 row ">
            <div class="logofooter col-sm-6 col-12 mb-sm-0 mb-sm-5 mb-4">
                <a href="#"><img src="{{ asset('front/images/rayyart2.png') }}"></a>
            </div>
            <ul class="Aboutus col-sm-3 col-6 ps-sm-3 ps-4 ">
                <li>
                    <a href="{{ route('about-us') }}" class="term"> About Us</a>
                </li>
                <li>
                    <a href="{{ route('our.story') }}">Our Story</a>
                </li>
                <li><a href="{{ route('cancellation.refunded') }}">Cancellation And Refunded</a></li>

                {{-- <li>
                    <a href="{{ route('ancellation.refunded') }}">Cancellation Refunded</a>
                </li> --}}
                {{-- <li>
                    <a href="#">Team</a>
                </li>
                <li>
                    <a href="#">Careers</a>
                </li>  --}}
            </ul>
            <ul class="Aboutus col-sm-3 col-6">
                <li>
                    <a href="#" class="term">Help</a>
                </li>
                <li>
                    <a href="{{ route('faqs') }}">FAQs</a>
                </li>
                <li>
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">Contact Us</a>
                </li>
            </ul>
        </div>

        <div class="d-md-flex d-bolck  gap-5 justify-content-between align-items-baseline px-sm-4 px-0 mt-lg-5 mt-sm-4 mt-0 pb-md-0 pb-4  ps-ms-0 ps-3">
            <ul class="Aboutus  ps-0 d-flex gap-5 ">
                <li>
                    <a href="{{ route('terms-condition') }}">Terms & Conditions</a>
                </li>
                <li>
                    <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                </li>
            </ul>
            <div class="d-flex gap-4 justify-content-md-end justify-content-center">
                <div class="facebok">
                    <a href="#"> <img src="{{ asset('front/images/Path.png') }}"></a>
                </div>
                <div class="cros">
                    <a href="#"> <img src="{{ asset('front/images/Vector.png') }}"></a>
                </div>
                <div class="cros">
                    <a href="#"> <img src="{{ asset('front/images/insta.png') }}"></a>
                </div>
                <div class="cros1">
                    <a href="#"> <img src="{{ asset('front/images/formkit_linkedin.png') }}"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
