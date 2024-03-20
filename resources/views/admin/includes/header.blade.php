 <!-- Header START -->
 <div class="header-text-dark header-nav layout-vertical">
                <div class="header-nav-wrap">
                    <div class="header-nav-left">
                        <div class="header-nav-item desktop-toggle">
                            <div class="header-nav-item-select cursor-pointer">
                                <i class="nav-icon feather icon-menu icon-arrow-right"></i>
                            </div>
                        </div>
                        <div class="header-nav-item mobile-toggle">
                            <div class="header-nav-item-select cursor-pointer">
                                <i class="nav-icon feather icon-menu icon-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                                    @php 
                                        $admin  = Auth::guard('admin')->user();
                                        $admin = $admin->load('photo');
                                    @endphp
                    <div class="header-nav-right">
                        <div class="header-nav-item">
                            <div class="dropdown header-nav-item-select nav-profile" >
                                <div class="toggle-wrapper" id="nav-profile-dropdown" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-circle avatar-image" style="width: 35px; height: 35px; line-height: 35px;">
                                    @if(!empty($admin->icon))
                                     <img src="{{ asset('uploads/admin/' . $admin->photo->file) }}" alt="logo">
                                     @endif
                             <img src="" alt="logo">
                                    </div>
                                    
                                    <span class="fw-bold mx-1"> {{ ucfirst( Auth::guard('admin')->user()->name ) }}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="nav-profile-header">
                                       <div class="d-flex align-items-center">
                                            <div class="avatar avatar-circle avatar-image">
                                                 @if(!empty($admin->icon))
                                                <img src="{{ asset('uploads/admin/' . $admin->photo->file) }}" alt="">
                                                  @endif
                                                  <img src="" alt="">
                                            </div>
                                            <div class="d-flex flex-column ms-1">
                                                <span class="fw-bold text-dark"> {{ ucfirst( Auth::guard('admin')->user()->name ) }} </span>
                                                <span class="font-size-sm"> {{Auth::guard('admin')->user()->email }}</span>
                                            </div>
                                       </div>
                                    </div>
                                    <a href="{{ route('admin.admins.adminProfile',['id' => Auth::guard('admin')->user()->id]) }}"   class="dropdown-item">
                                       <div class="d-flex align-items-center">
                                           <i class="font-size-lg me-2 feather icon-user"></i>
                                           <span>Profile</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item">
                                       <div class="d-flex align-items-center"><i class="font-size-lg me-2 feather icon-power"></i>
                                        <span>Sign Out</span>
                                    </div>
                                    </a>
                                 </div>
                            </div>
                        </div>     
                    </div>
                </div>
            </div>    
            <!-- Header END -->