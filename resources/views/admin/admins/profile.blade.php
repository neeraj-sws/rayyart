@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
<div class="main">
<div class="card">
                        <div class="container-fluid">
                            <div class="row content-min-height">
                                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                                    <h4 class="mb-3 ms-3 mt-3">Profile</h4>
                                    <div class="columns-panel-item-group">
                              
                                        <a class="columns-panel-item columns-panel-item-link " id="profile" onclick="adminProfile('{{ $route->profileAdmin}}','{{ $info->id }}','profile');return false;" href="javascript:void(0);">
                                            <div class="d-flex align-items-center">
                                                <i class="feather font-size-lg icon-user"></i>
                                                <span class="ms-3">Profile</span>
                                            </div>
                                        </a>

                                        <a class="columns-panel-item columns-panel-item-link " id="editpassword" onclick="adminProfile('{{ $route->editPassword}}','{{ $info->id }}','editpassword');return false;" href="javascript:void(0);">
                                            <div class="d-flex align-items-center">
                                                <i class="feather font-size-lg icon-user"></i>
                                                <span class="ms-3">Change Password</span>
                                            </div>
                                        </a>
                        
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card-body" id="editprofile">
                                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                            <div>
                                                <h4>Personal Information</h4>
                                                <p>Basic info, like your name and address on this account.</p>
                                            </div>
                                            <button class="btn btn-primary" id="editprofile">Edit Profile</button>
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col" style="max-width: 200px;">
                                                <form action="">
                                                <div class="mb-3">
                                                    <img class="img-fluid w-100 rounded" src="{{ asset('uploads/admin/'. $info->photo->file)}}" id="image_prev" alt="upload avatar">
                                                </div>
                                                <div class="upload upload-text w-100">
                                                    <div>
                                                        <label for="upload" class="btn btn-secondary w-100">Upload</label>
                                                    </div>
                                                    <input id="upload" type="file" name="image" class="upload-input" onchange="upload_image($(form),'{{ $route->adminProfileImage }}','image','file_id');return false;" accept=".jpg,.jpeg,.png">
                                                    <input type="hidden" name="adminId" value="{{ $info->id }}">
                                                    <input type="hidden" name="image_path" value="uploads/admin/">
                                                    <input type="hidden" name="image_name" value="image">
                                                    <input type="hidden" name="file_id" id="file_id" value="">
                                                </div>
                                                </form>
                                            </div>
                                            <div class="col-md">
                                                <table class="table">
                                                    <tbody>
                                                        <form action="{{ $route->adminProfileUpdate }}" onsubmit="event.preventDefault();adminProfile_submit(this);return false;" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $info->id }}">
                                                       <tr>
                                                          <th class="py-4">Name</th>
                                                          <td class="py-4 adminName">{{ ucfirst($info->name) }}</td>
                                                          <td> <input type="text" name="name" value="{{ $info->name }}" class="adminname form-control d-none"> </td>
                                                       </tr>
                                                       <tr>
                                                          <th class="py-4">Email</th>
                                                          <td class="py-4 adminEmail">{{ $info->email }}</td>
                                                          <td> <input type="text" name="email" value="{{ $info->email }}" class="adminemail form-control d-none"> </td>
                                                       </tr>
                                                       <tr>
                                                          <th class="py-4">User Name</th>
                                                          <td class="py-4 adminUserName">{{ $info->username }}</td>
                                                          <td> <input type="text" name="username" value="{{ $info->username }}" class="adminUsername form-control d-none"> </td>
                                                       </tr>
                                                      
                                                    </tbody>
                                                 </table>
                                                 <div class="col-12 d-none" id="update">
                                                <button type="submit" class="btn btn-primary float-end">Update <i class="st_loader spinner-border spinner-border-sm"
                                                    style="display:none;"></i></button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
@endsection
@section('page-js-script')
<script>
    $("#editprofile").click(function() {
   
   $(".adminName").addClass("d-none"); 
   $(".adminEmail").addClass("d-none"); 
   $(".adminUserName").addClass("d-none"); 

   $(".adminUsername").removeClass("d-none");
   $(".adminemail").removeClass("d-none");
   $(".adminname").removeClass("d-none");
   $("#update").removeClass("d-none");
});
</script>
@endsection