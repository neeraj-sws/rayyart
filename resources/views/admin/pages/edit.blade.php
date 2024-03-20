@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
<div class="main">
   <div class="card">
      <div class="card-body">
         <div class="card-header">
            <h4 class="card-title">Edit {{ $single_heading }}</h4>
         </div>
         <form class="row g-3 mt-1" action="{{ $route->store }}" onsubmit="event.preventDefault();pagesform_submit(this);return false;" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $info->id }}">

            <div class="col-md-6">
               <label for="name" class="form-label">Title</label>
               <input type="text" class="form-control"  name="title" value="{{ $info->title }}" readonly/>
            </div>
            <div class="col-md-6 d-none">
               <label for="text" class="form-label">Slug</label>
               <input type="text" class="form-control" name="slug" value="{{ $info->slug }}">
            </div>
           
            <div class="col-md-12 ">
             <label for="Outletname" class="form-label">Description</label>
               <textarea class="form-control tinymceEditor" rows="10"  name="description">{{$info->description}}</textarea>
            </div>
      
            <div class="col-12">
               <button type="submit" class="btn btn-primary float-end">Update <i class="st_loader spinner-border spinner-border-sm"
                  style="display:none;"></i></button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('page-js-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.tiny.cloud/1/ywqmxeye1bqw640inrzx59t5k336ioq2oad0rc5d4cydjlnt/tinymce/6/tinymce.min.js" referrerpolicy="origin"> </script>
<!-- <script src="http://doctor_appointment.local.com/admin/assets/js/custom.js "></script> -->

@endsection