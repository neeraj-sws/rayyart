          <!-- Side Nav START -->
          <div class="side-nav vertical-menu nav-menu-light scrollable">
                <div class="nav-logo">
                    <div class="w-100 logo">
                        <img class="img-fluid" src="{{asset('admin/assets/images/logo/logo.png')}}" style="max-height: 70px;" alt="logo">
                    </div>
                    <div class="mobile-close">
                        <i class="icon-arrow-left feather"></i>
                    </div>
                 </div>
                 <ul class="nav-menu">
                    <li class="nav-menu-item {{ ($single_heading == 'Dashboard')? 'router-link-active': '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="feather icon-home"></i>
                            <span class="nav-menu-item-title">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li class="nav-group-title">APPS</li> -->
                    <li class="nav-menu-item {{ ($single_heading == 'Admin')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.admins.admins') }}">
                            <i class="icon-user feather"></i>
                            <span class="nav-menu-item-title">Admin</span>
                        </a>
                    </li>
                    
                    <li class="nav-menu-item {{ ($single_heading == 'Customer')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.customer.user') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Customers</span>
                        </a>
                    </li>
              
                    <li class="nav-menu-item {{ ($single_heading == 'Client')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.client.client') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Client</span>
                        </a>
                    </li>

                    <li class="nav-menu-item {{ ($single_heading == 'Category')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.category.category') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Category</span>
                        </a>
                    </li>
                    <li class="nav-menu-item {{ ($single_heading == 'Amenity')? 'router-link-active': '' }} ">
                      <a href="{{ route('admin.amenity.amenity') }}">
                          <i class="icon-users feather"></i>
                          <span class="nav-menu-item-title">Amenities</span>
                      </a>
                  </li>

                    <li class="nav-menu-item {{ ($single_heading == 'Services')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.services.services') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Services</span>
                        </a>
                    </li>

                    <li class="nav-menu-item {{ ($single_heading == 'City')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.city.city') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Cities</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- Side Nav END -->