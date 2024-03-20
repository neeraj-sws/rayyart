          <!-- Side Nav START -->
          <div class="side-nav vertical-menu nav-menu-light scrollable">
                <div class="nav-logo">
                    <div class="w-100 logo">
                        <img class="img-fluid" src="{{asset('admin/assets/rayyartlogo.png')}}" style="max-height: 50px;" alt="logo">
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
                            <span class="nav-menu-item-title">Active Client</span>
                        </a>
                    </li>
                    
                    <li class="nav-menu-item {{ ($single_heading == 'InavtiveClient')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.client.inactivelist') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Inactive Client</span>
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

                    <li class="nav-menu-item {{ ($single_heading == 'State')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.state.state') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">State</span>
                        </a>
                    </li>
                    
                    <li class="nav-menu-item  {{ ($single_heading == 'Pages')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.pages.pages') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Pages</span>
                        </a>
                    </li>

                    <li class="nav-menu-item {{ ($single_heading == 'Advertisment')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.advertisment.addvets') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Advertisments</span>
                        </a>
                    </li>
                    <li class="nav-menu-item {{ ($single_heading == 'Appointments')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.appointment.appointment') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Appointments</span>
                        </a>
                    </li>
                     <li class="nav-menu-item  {{ ($single_heading == 'Subscription')? 'router-link-active': '' }} ">
                        <a href="{{ route('admin.subscription.subscription') }}">
                            <i class="icon-users feather"></i>
                            <span class="nav-menu-item-title">Subscription</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- Side Nav END -->