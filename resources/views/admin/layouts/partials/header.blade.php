<!-- start: header -->
<header class="header">
    <div class="logo-container">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" width="75" height="35" alt="ARC Admin" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
            data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">

        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="{{ asset('assets/images/!logged-user.jpg') }}" alt="Joseph Doe" class="img-circle"
                        data-lock-picture="{{ asset('assets/images/!logged-user.jpg') }}" />
                </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">Admin</span>
                    <span class="role">administrator</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <!-- <li>
                        <a role="menuitem" tabindex="-1" href="javascript:void(0)"><i class="fa fa-user"></i> My Profile</a>
                    </li> -->
                    <!-- <li>
                        <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
                    </li> -->
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('admin.logout') }}"><i
                                class="fa fa-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->
