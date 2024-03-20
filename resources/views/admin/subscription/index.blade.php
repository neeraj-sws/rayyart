@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
    <div class="main">
        <div class="card">
            <div class="card-body">
                <div class="d-flex ">
                    <h4>{{ $single_heading }}</h4>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="javascript:void(0);" class="btn btn-primary"
                                onclick="addForm('{{ $route->add }}');return false;"><i
                                    class="bx bxs-plus-square"></i>Add {{ $single_heading }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
        <div class="row">
        @foreach($users as $user)            
        <div class="col-3">
        <div class="card">
            <div class="card-body text-center">
                <!-- <div class="card-body"> -->
                <img alt="Package Logo" src="{{ asset('uploads/admin') }}/{{ @$user->photo->file }}" class="w-50 mb-2 rounded-circle" style="height: 119px;">
                    <p class="card-text text-dark my-2" style="font-weight: 700;">{{ $user->title}}</p>
                    <p class="card-text my-2">Rs{{ $user->price}}.00</p>
                    <p class="card-text">Package Duration: <span class="text-dark" >{{ $user->validation}}Months</span></p>
                    <a href="javascript:void(0);" class="btn btn-primary"
                                onclick="edit_row('{{ $route->edit }}','{{ $user->id }}');return false;">
                                <i class="bx bxs-plus-square"></i>Edit</a>
                        <a href="javascript:void(0);" class="btn btn-primary"
                                onclick="delete_rows('{{ $route->destroy }}','{{ $user->id }}')">
                                <i class="bx bxs-plus-square"></i>Delete</a>            
                <!-- </div> -->
                
            </div>
        </div>
        </div>
        @endforeach
        </div>
    </div>
    @endsection
    @section('page-js-script')
    @endsection
    <script>


// function subscription_submit(e) {
//   $.ajax({
//     url: $(e).attr('action'),
//     method: "POST",
//     dataType: "json",
//     data: $(e).serialize(),
//     success: function (data) {
//       if (data.status == 1) {
//         $(e).find('.st_loader').hide();
//         toastr.success(data.message, 'Success');
//         window.location.href = base_url+'/admin/subscription';
//         dataTable.draw(false);
        
//       } else if (data.status == 0) {
//         toastr.error($err, 'Error');
//       }
     
//     },
  
//   });
// }

    </script>