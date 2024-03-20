<div class="mb-4 d-md-flex align-items-center justify-content-between">
                                            <div>
                                                <h4>Change Password</h4>
                                                
                                            </div>
                                            
                                        </div>
                                        <form action="{{ $route->updatePassword }}" onsubmit="event.preventDefault();adminProfile_submit(this);return false;" method="POST">
                                        <div class="row">
                                            <div class="col-md">
                                                <table class="table">
                                                    <tbody>
                                                        
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $info->id }}">
                                                       <tr>
                                                          <th class="py-4">Old Password</th>
                                                          <td class="py-4"> <input type="password" name="oldpassword"  class=" form-control" placeholder="Old Password"> </td>
                                                       </tr>
                                                       <tr>
                                                          <th class="py-4">New Password</th>
                                                          <td class="py-4"> <input type="password" name="newpassword" class="form-control" placeholder="New Password"> </td>
                                                       </tr>  
                                                    </tbody>
                                                 </table>
                                                 <div class="col-12" id="update">
                                                <button type="submit" class="btn btn-primary float-end">Update <i class="st_loader spinner-border spinner-border-sm"
                                                    style="display:none;"></i></button>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        </form>