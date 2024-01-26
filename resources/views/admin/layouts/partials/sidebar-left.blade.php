<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">Island Bus</div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
            data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="@if (Session::get('page') == 'dashboard') nav-active @endif">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'passcode') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa fa-solid fa-cube"></i>
                            <span>Pass Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.passcode.add') }}"> Add Pass </a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.passcode.list') }}"> View Pass </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'route') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa far fa-map"></i>
                            <span>Route Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.route.store') }}"> Add Route </a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.route.list') }}"> View Route </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'bus-stop') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa far fa-bus"></i>
                            <span>Bus Stop Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.bus.stop.store') }}"> Add Bus Stop </a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.bus.stop.list') }}"> View Bus Stop </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'bus') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            {{-- <i class="fa fa-file-image-o"></i> --}}
                            <i class="fa far fa-bus"></i>
                            <span>Bus Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.bus.store') }}"> Add Bus </a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.bus.list') }}"> View Bus </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'timetable') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            {{-- <i class="fa fa-file-image-o"></i> --}}
                            <i class="fa far fa-bus"></i>
                            <span>Timetable Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.timetable.store') }}"> Add Timetable</a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.timetable.list') }}"> View Timetable </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'driver') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa far fa-user-md"></i>
                            <span>Driver Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.driver.store') }}">Add Driver</a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.driver.list') }}">View Driver</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent @if (Session::get('page') == 'user') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa far fa-user"></i>
                            <span>User Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.user.list') }}">User List</a>
                            </li>
                            {{-- <li class="">
                                <a href="{{ route('admin.user.subscriptionList') }}">Subscripton</a>
                            </li> --}}
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'booking') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa far fa-user-md"></i>
                            <span>Booking Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.booking.list') }}">View Booking</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'job') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            <i class="fa far fa-user-md"></i>
                            <span>Job Management</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.job.store') }}">Add Job</a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.job.list') }}">View Job</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (Session::get('page') == 'notification') nav-expanded @endif">
                        <a href="{{ route('admin.notification.list') }}">
                            {{-- <i class="fa fa-home" aria-hidden="true"></i> --}}
                            <i class="fa far fa-comment"></i>
                            <span>Notification</span>
                        </a>
                    </li>

                    <li class="@if (Session::get('page') == 'feedback') nav-expanded @endif">
                        <a href="{{ route('admin.feedback.list') }}">
                            {{-- <i class="fa fa-home" aria-hidden="true"></i> --}}
                            <i class="fa far fa-comments"></i>
                            <span>Feedback</span>
                        </a>
                    </li>

                    <li class="nav-parent @if (Session::get('page') == 'settings') nav-expanded @endif">
                        <a href="javascript:void(0)">
                            {{-- <i class="fa fa-file-image-o"></i> --}}
                            <i class="fa far fa-cog"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="">
                                <a href="{{ route('admin.help.support.list') }}"> Help & Support </a>
                            </li>
                            <li class="">
                                <a href="{{ route('admin.privacy.policy.list') }}"> Privacy Policy </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <hr class="separator" />
        </div>
    </div>
</aside>
<!-- end: sidebar -->
