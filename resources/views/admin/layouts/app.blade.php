<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('admin/assets/images/logo/favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet" />
    
    <!-- Scripts -->
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
        <div class="layout">
            <div class="vertical-layout">
                        		<!--start header -->
		                     @include("admin.includes.header")
		                       <!--end header -->

                               <!--navigation-->
		                    @include("admin.includes.sidebar")
		                         <!--end navigation-->

                                 <!--start page wrapper -->
		                    @yield("wrapper")
		                        <!--end page wrapper -->

                                <!--start footer-->
                             <!-- @include("admin.includes.footer") -->
                                  <!--end footer-->
                  
                    <!--end wrapper-->
            
            </div>
        </div>

        <div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

			</div>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <script src="{{asset('admin/assets/js/crud.js') }}"></script>
        <script src="{{asset('admin/assets/vendors/toastr/toastr.min.js') }}"></script>
        <script src="{{asset('admin/assets/js/vendors.min.js') }}"></script>
        <script src="{{asset('admin/assets/js/app.min.js') }}"></script>
        <script src="{{asset('admin/assets/vendors/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin/assets/vendors/datatables/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{ asset('admin/assets/js/custom.js') }} "></script>
       
  <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('page-js-script');
    <script>
    const base_url = "{{ url('/') }}";
        $('.nav-menu-item').on('click', function() {
            $('.nav-menu-item').removeClass('router-link-active');
            $(this).addClass('router-link-active');
        });
    
</script>
</body>
</html>
