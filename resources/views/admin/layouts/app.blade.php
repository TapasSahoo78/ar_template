<!DOCTYPE html>
<html class="fixed">

<head>
    <!-- Basic -->
    <meta charset="UTF-8" />

    <title>Island Bus</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/favicon.ico') }}" />
    <meta name="keywords" content="Silver Shine" />
    <meta content="" name="description">
    <meta name="robots" content="noindex,nofollow">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    @include('admin.layouts.partials.styles')
</head>

<body>
    @if ($withOutHeaderSidebar)
        <section class="body">
            <!-- start: header -->
            @include('admin.layouts.partials.header')
            <!-- end: header -->

            <div class="inner-wrapper">
                <!-- start: sidebar -->
                @include('admin.layouts.partials.sidebar-left')
                <!-- end: sidebar -->

                <section role="main" class="content-body">
                    <!-- start: page -->
                    @yield('content')
                    <!-- end: page -->
                </section>
            </div>
            @include('admin.layouts.partials.sidebar-right')
        </section>
    @else
        @yield('content')
    @endif
    @include('admin.layouts.partials.scripts')
</body>

</html>
