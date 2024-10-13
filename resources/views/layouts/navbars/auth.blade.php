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
                            {{Auth::user()->name}}
                            <span class="user-level">
                                {{Auth::user()->roleName(Auth::user()->role)}}
                            </span>
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
                @if(Auth::user()->can('role-list') || Auth::user()->can('user-list') || Auth::user()->can('employee-list') ||Auth::user()->role == 1)
                    <li class="nav-item {{ $elementActive == 'user' ||  $elementActive == 'roles' || $elementActive == 'employees' ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#usermgmt">
                            <i class="fas fa-users"></i>
                            <p>User</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $elementActive == 'user' || $elementActive == 'roles' || $elementActive == 'customer' ? 'show' : '' }}" id="usermgmt">
                            <ul class="nav nav-collapse">
                                @if(Auth::user()->can('role-list') || Auth::user()->role == 1)
                                    <li class="{{ $elementActive == 'roles' ? 'active' : '' }}">
                                        <a href="{{route('roles')}}">
                                            <span class="sub-item">Roles</span>
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('user-list') || Auth::user()->role == 1)
                                    <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                                        <a href="{{route('users')}}">
                                            <span class="sub-item">Account</span>
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('customer-list') || Auth::user()->role == 1)
                                    <li class="{{ $elementActive == 'customer' ? 'active' : '' }}">
                                        <a href="{{route('customers')}}">
                                            <span class="sub-item">Customer</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if(Auth::user()->can('aboutus-list') || Auth::user()->can('activity-list') || Auth::user()->can('booknow-list') || Auth::user()->can('volunteer-list') || Auth::user()->role == 1)
                <li class="nav-item {{ $elementActive == 'aboutus' ||  $elementActive == 'activities' || $elementActive == 'booknow' || $elementActive == 'accomodation' || $elementActive == 'survey' || $elementActive == 'feedback_form' ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#sitemgmt">
                        <i class="fas fa-cogs"></i>
                        <p>Settings</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $elementActive == 'aboutus' || $elementActive == 'activities' || $elementActive == 'booknow' || $elementActive == 'announcement' || $elementActive == 'volunteer' || $elementActive == 'qrcode' || $elementActive == 'accomodation' || $elementActive == 'survey' || $elementActive == 'feedback_form' ? 'show' : '' }}" id="sitemgmt">
                        <ul class="nav nav-collapse">
                            @if(Auth::user()->can('aboutus-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'aboutus' ? 'active' : '' }}">
                                    <a href="{{route('aboutus')}}">
                                        <span class="sub-item">About Us</span>
                                    </a>
                                </li>
                            @endif
                            <li class="{{ $elementActive == 'announcement' ? 'active' : '' }}">
                                <a href="{{route('announcements')}}">
                                    <span class="sub-item">Announcement</span>
                                </a>
                            </li>
                            @if(Auth::user()->can('activity-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'activities' ? 'active' : '' }}">
                                    <a href="{{route('activities')}}">
                                        <span class="sub-item">Activities</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->can('booknow-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'booknow' ? 'active' : '' }}">
                                    <a href="{{route('bookings')}}">
                                        <span class="sub-item">Bookings</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->can('volunteer-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'volunteer' ? 'active' : '' }}">
                                    <a href="{{route('volunteers')}}">
                                        <span class="sub-item">Volunteer</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->can('qrcode-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'qrcode' ? 'active' : '' }}">
                                    <a href="{{route('qrcodes')}}">
                                        <span class="sub-item">QR Code</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->can('qrcode-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'survey' ? 'active' : '' }}">
                                    <a href="{{route('survey.index')}}">
                                        <span class="sub-item">Demographic Survey</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->can('qrcode-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'feedback_form' ? 'active' : '' }}">
                                    <a href="{{route('feedbacks')}}">
                                        <span class="sub-item">Feedback Form</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->can('accomodation-list') || Auth::user()->role == 1)
                                <li class="{{ $elementActive == 'accomodation' ? 'active' : '' }}">
                                    <a href="{{route('accomodations')}}">
                                        <span class="sub-item">Accomodation</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                <li class="mx-4 mt-2 d-none">
                    <a href="http://themekita.com/atlantis-bootstrap-dashboard.html" class="btn btn-primary btn-block"><span class="btn-label mr-2"> <i class="fa fa-heart"></i> </span>Buy Pro</a>
                </li>
            </ul>
        </div>
    </div>
</div>
