<!-- Main Sidebar Container -->
<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{asset('images')}}/icon/system-regular-8-account.webp" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a>
                        <span>
                            Resty
                            <span class="user-level">Administrator</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in d-none" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ $elementActive == 'dashboard' ? 'active' : '' }}">
                    <a href="{{url('/')}}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Management</h4>
                </li>
                <li class="nav-item {{ $elementActive == 'user' ||  $elementActive == 'roles' || $elementActive == 'employees' ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#usermgmt">
                        <i class="fas fa-users"></i>
                        <p>User</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $elementActive == 'user' || $elementActive == 'roles' || $elementActive == 'employees' ? 'show' : '' }}" id="usermgmt">
                        <ul class="nav nav-collapse">
                            <li class="{{ $elementActive == 'roles' ? 'active' : '' }}">
                                <a href="{{route('roles')}}">
                                    <span class="sub-item">Roles</span>
                                </a>
                            </li>
                            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                                <a href="{{route('users')}}">
                                    <span class="sub-item">Account</span>
                                </a>
                            </li>
                            <li class="{{ $elementActive == 'employees' ? 'active' : '' }}">
                                <a href="{{route('employees')}}">
                                    <span class="sub-item">Employee</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#sitemgmt">
                        <i class="fas fa-cogs"></i>
                        <p>Settings</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sitemgmt">
                        <ul class="nav nav-collapse">
                            <li class="{{ $elementActive == 'roles' ? 'active' : '' }}">
                                <a href="{{route('roles')}}">
                                    <span class="sub-item">About Us</span>
                                </a>
                            </li>
                            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                                <a href="{{route('users')}}">
                                    <span class="sub-item">Activities</span>
                                </a>
                            </li>
                            <li class="{{ $elementActive == 'employees' ? 'active' : '' }}">
                                <a href="{{route('employees')}}">
                                    <span class="sub-item">Book Now</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="mx-4 mt-2 d-none">
                    <a href="http://themekita.com/atlantis-bootstrap-dashboard.html" class="btn btn-primary btn-block"><span class="btn-label mr-2"> <i class="fa fa-heart"></i> </span>Buy Pro</a>
                </li>
            </ul>
        </div>
    </div>
</div>
