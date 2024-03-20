@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
<div class="main">
<div class="card">
     <div class="card-header">
         <h4 class="card-title">Add {{ $single_heading }}</h4>
      </div>
   <div class="card-body">
         <form class="row g-3" action="{{$route->store}}" method="POST" onsubmit="event.preventDefault();clientform_submit(this);return false;"  enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
               <label for="name" class="form-label">Client Name</label>
               <input type="text" class="form-control"  name="name">
            </div>
            <div class="col-md-6">
               <label for="Email" class="form-label">Email</label>
               <input type="email" class="form-control" name="email">
            </div>

            <div class="col-md-6">
               <label for="username" class="form-label">User Name</label>
               <input type="text" class="form-control" name="username">
            </div>
            <div class="col-md-6">
               <label for="Password" class="form-label">Password</label>
               <input type="password" class="form-control" name="password">
            </div>

            <div class="col-md-6">
               <label for="number" class="form-label">Phone Number</label>
               <input type="text" class="form-control" name="phoneNumber"  onkeypress="return /[0-9.]/.test(event.key)">
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Cities</label>
                <select class="form-select select2" name="cities">
                <option value=""> Select Cities ... </option>
                @foreach($cities as $city)
                <option value="{{ $city->id }}"> {{ $city->name }} </option>
                @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                <option value=""> Select Category ... </option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->title }} </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Amenities</label>
                <select class="form-select select2" name="amenity_id[]" multiple>
                <option value=""> Select Amenities ... </option>
                @foreach($amenities as $amenity)
                <option value="{{ $amenity->id }}"> {{ $amenity->title }} </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-6">
               <label for="Outletname" class="form-label">Open Time</label>
               <input type="time" class="form-control" name="opentime">
            </div>
            <div class="col-md-6">
               <label for="Outletname" class="form-label">Close Time</label>
               <input type="time" class="form-control" name="closetime">
            </div>

            <div class="col-md-6">
               <label for="Outletname" class="form-label">Longitude</label>
               <input type="text" class="form-control" name="logitude" onkeypress="return /[0-9.]/.test(event.key)">
            </div>

            <div class="col-md-6">
               <label for="Outletname" class="form-label">Latitude</label>
               <input type="text" class="form-control" name="latitude" onkeypress="return /[0-9.]/.test(event.key)">
            </div>

             <div class="col-md-6">
               <label for="Outletname" class="form-label">Owner  Adhar Card</label>
               <input type="test" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="ownerAdharCard">
            </div>

            <div class="col-md-6">
               <label for="Outletname" class="form-label">Outlet Name</label>
               <input type="text" class="form-control" name="outlet_name">
            </div>
           
            <div class="col-md-6">
               <label for="Outletname" class="form-label">Bank Name</label>
               <input type="test" class="form-control" name="bankName">
            </div>
            <div class="col-md-6">
               <label for="Outletname" class="form-label">Account Holder Name</label>
               <input type="test" class="form-control" name="accountHolderName">
            </div>
            <div class="col-md-6">
               <label for="Outletname" class="form-label">Account Number</label>
               <input type="test" class="form-control allowno" onkeypress="return /[0-9]/i.test(event.key)" name="accountNumber">
            </div>
            <div class="col-md-6">
               <label for="Outletname" class="form-label">IFSC Code</label>
               <input type="test" class="form-control" name="ifscCode">
            </div>

            <div class="col-md-12">
            <label for="Outletname" class="form-label">Outlet address</label>
               <textarea class="form-control" aria-label="With textarea" name="outletAddress"></textarea>
            </div>

            <div class="row mt-2">
               <div class="col-md-10">
               <label for="Outletname" class="form-label">Client Image</label>
               <div class="custom-file">
               <input type="hidden" name="image_path" value="uploads/client/">
               <input type="hidden" name="image_name" value="image">
                  <input type="file" class="custom-file form-control" name="image" onchange="upload_image($(form),'{{ $route->saveimage }}','image','file_id');return false;" accept=".jpg,.jpeg,.png">
                  <input type="hidden" name="file_id" id="file_id" value="">
                  <i class="image_loader fa-btn-loader fa fa-refresh fa-spin fa-1x fa-fw" style="display:none;"></i>
                  <label id="lblErrorMessageBannerImage" style="color:red"></label>
                  </div>
               </div>
               <div class="col-md-2 mt-3">
                     <img src="" id="image_prev" class="img-thumbnail " alt="" width="100"
                        height="100" style="display:none">
                     <label id="lblErrorMessageBannerImage" style="color:red"></label>
                  </div>
            </div>

            <div class="row mt-2">
               <div class="col-md-10">
               <label for="Outletname" class="form-label">Gumasta Image</label>
               <div class="custom-file">
               <input type="hidden" name="gumastaimg_path" value="uploads/client/">
               <input type="hidden" name="gumastaimg_name" value="gumastaimg">
                  <input type="file" class="custom-file form-control" name="gumastaimg" onchange="upload_image($(form),'{{ $route->gumastaimgupload }}','gumastaimg','gumastaimg_id');return false;" accept=".jpg,.jpeg,.png">
                  <input type="hidden" name="gumastaimg_id" id="gumastaimg_id" value="">
                  <i class="image_loader fa-btn-loader fa fa-refresh fa-spin fa-1x fa-fw" style="display:none;"></i>
                  <label id="lblErrorMessageBannerImage" style="color:red"></label>
                  </div>
               </div>
               <div class="col-md-2 mt-3">
                     <img src="" id="gumastaimg_prev" class="img-thumbnail " alt="" width="100"
                        height="100" style="display:none">
                     <label id="lblErrorMessageBannerImage" style="color:red"></label>
                  </div>
            </div>

            <div class="row mt-2">
               <div class="col-md-12">
               <label for="Outletname" class="form-label">Outlet Images</label>
               <div class="custom-file">
               <input type="hidden" name="outlet_images_path" value="uploads/client/">
               <input type="hidden" name="outlet_images_name" value="outlet_images">
                  <input type="file" class="custom-file form-control" name="outlet_images[]" onchange="upload_multipleimage($(form),'{{ $route->outletimagesupload }}','outlet_images','outlet_images_id');return false;" accept=".jpg,.jpeg,.png" multiple>
                  <input type="hidden" name="outlet_images_id[]" id="outlet_images_id" value="">
                  <i class="image_loader fa-btn-loader fa fa-refresh fa-spin fa-1x fa-fw" style="display:none;"></i>
                  <label id="lblErrorMessageBannerImage" style="color:red"></label>
                  </div>
               </div>
               <div class="row mt-3 d-flex " id="outlet_images_prev">
                     <label id="lblErrorMessageBannerImage" style="color:red"></label>
                  </div>
            </div>

            <div class="col-12">
                <hr>
               <button type="submit" class="btn btn-primary float-end">Save <i class="st_loader spinner-border spinner-border-sm"
                  style="display:none;"></i></button>
            </div>
         </form>
   </div>
</div>
</div>
@endsection
@section('page-js-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
        $('.select2').select2();

</script>
@endsection