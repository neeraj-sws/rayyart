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
