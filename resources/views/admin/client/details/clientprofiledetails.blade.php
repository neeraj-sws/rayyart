
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
                                                    <img id="image_prev" class="img-fluid w-100 rounded" src=" {{ asset('uploads/client/')}}/{{$clientProfile->Image->file}}" alt="upload avatar">
                                                </div>
                                                <div class="upload upload-text w-100">
                                                    <div>
                                                        <label for="upload" class="btn btn-secondary w-100">Client Image</label>
                                                    </div>
                                                    <input type="hidden" name="cid" value="{{ $clientProfile->id }}">
                                                    <input type="hidden" name="image_path" value="uploads/client/">
                                                    <input type="hidden" name="image_name" value="image">
                                                        <!-- <input type="hidden" name="file_id" id="file_id" value=""> -->
                                                        <i class="image_loader fa-btn-loader fa fa-refresh fa-spin fa-1x fa-fw" style="display:none;"></i>
                                                        <label id="lblErrorMessageBannerImage" style="color:red"></label>
                                                    <input id="upload" type="file" name="image" class="upload-input" onchange="upload_image($(form),'{{ $route->clientupdateprofiledetails }}','image','file_id');return false;">
                                                </div>
                                            </div>
                                            </form>
                                            <div class="col-md">
                                            <form action="{{ $route->clientupdateprofiledata }}"onsubmit="event.preventDefault();clientprofile_submit(this);return false;" method="POST" >
                                                <table class="table">
                                                @csrf
                                                    <tbody>
                                                    <input type="hidden" name="id" value="{{ $clientProfile->id }}">
                                                       <tr>
                                                          <th class="py-3">Name</th>
                                                          <td class="py-3 clientName">{{ ucfirst($clientProfile->name) }}</td>
                                                         <td> <input type="text" name="name" value="{{$clientProfile->name}}" class="client_name form-control d-none">
                                                          </td>
                                                       </tr>
                                                       <tr>
                                                          <th class="py-3">Email</th>
                                                          <td class="py-3 clientEmail">{{ $clientProfile->email }}  </td>
                                                         <td> <input type="text" name="email" value="{{$clientProfile->email}}" class="client_email form-control d-none">
                                                          </td>
                                                       </tr>
                                                       <tr>
                                                          <th class="py-3">User Name</th>
                                                          <td class="py-3 clientUsername"> {{ ucfirst($clientProfile->username) }}  </td>
                                                        <td>  <input type="text" name="username" value="{{$clientProfile->username}}" class="client_username form-control d-none">    
                                                        </td>
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
                     
                                    
                                        
<script>
$("#editprofile").click(function() {
   
     $(".clientName").addClass("d-none"); 
     $(".clientEmail").addClass("d-none"); 
     $(".clientUsername").addClass("d-none"); 

     $(".client_name").removeClass("d-none");
     $(".client_email").removeClass("d-none");
     $(".client_username").removeClass("d-none");
     $("#update").removeClass("d-none");
  });
</script>
