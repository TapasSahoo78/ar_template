 <!-- Web Fonts  -->
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet"
     type="text/css" />

 <!-- Vendor CSS -->
 <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />

 <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/vendor/jstree/themes/default/style.css') }}" />

 <!-- Theme CSS -->
 <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" />

 <!-- Skin CSS -->
 <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}" />

 <!-- Theme Custom CSS -->
 <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/stylesheets/jquery-confirm.css') }}" />

 <link rel="stylesheet" href="{{asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />

 @stack('styles')

 <script>
     let baseUrl = "{{ config('arc_config.SITE_URL') }}";
     let assetUrl = "{{ config('arc_config.ASSET_URL') }}";
     let _token = '{{ csrf_token() }}';
     let lang = "en";
 </script>
