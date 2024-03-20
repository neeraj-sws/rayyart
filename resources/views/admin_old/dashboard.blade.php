@extends("admin.layouts.app")

@section("wrapper")
     <!-- Content START -->
     <div class="content">
                <div class="main">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                <a href="{{route('admin.client.client')}}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                        <span class="text-muted fw-semibold">Total</span>
                                            <h4 >Client's</h4>
                                        </div>
                                        <div class="text-dark fw-bold font-size-lg">{{$clients}}</div>
                                    </div>
                                    </a>
                                    <div class="mt-4" id="monthly-revenue" style="max-width: 250px;"></div>
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                <a href="{{route('admin.category.category')}}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                        <span class="text-muted fw-semibold">Total</span>
                                            <h4 >Categories</h4>
                                        </div>
                                        <div class="text-dark fw-bold font-size-lg">{{ $categorys }}</div>
                                    </div>
                                    </a>
                                    <div class="mt-4" id="monthly-revenue" style="max-width: 250px;"></div>
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                <a href="{{route('admin.amenity.amenity')}}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        
                                        <div>
                                        <span class="text-muted fw-semibold">Total</span>
                                            <h4>Amenities</h4>
                                        </div>
                                        <div class="text-dark fw-bold font-size-lg">{{ $amenity }}</div>
                                    </div>
                                    </a>
                                    <div class="mt-4" id="monthly-revenue" style="max-width: 250px;"></div>
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                <a href="{{route('admin.services.services')}}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                        <span class="text-muted fw-semibold">Total</span>
                                            <h4>Services</h4>
                                        </div>
                                        <div class="text-dark fw-bold font-size-lg">{{ $services }}</div>
                                    </div>
                                    </a>
                                    <div class="mt-4" id="monthly-revenue" style="max-width: 250px;"></div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    
                </div>

        
            <!-- Content END -->

@endsection  
