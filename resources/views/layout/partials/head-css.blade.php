    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{URL::asset('build/img/apple-touch-icon.png')}}">

    <!-- Favicon -->
    <link rel="icon" href="{{URL::asset(\App\Models\Setting::getValue('system_favicon', 'build/img/favicon.png'))}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{URL::asset(\App\Models\Setting::getValue('system_favicon', 'build/img/favicon.png'))}}" type="image/x-icon">

@if (!Route::is(['index-rtl']))
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.min.css')}}">
@endif

@if (Route::is(['index-rtl']))
	<!-- Bootstrap RTL CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.rtl.min.css')}}">
@endif

@if (!Route::is(['login', 'register', 'forgot-password', 'change-password', 'error-404', 'error-500', 'under-maintenance', 'coming-soon', 'index-rtl']))
    <!-- Theme Settings Js -->
    <script src="{{URL::asset('build/js/theme-script.js')}}"></script>
@endif

    <link rel="stylesheet" href="{{URL::asset('build/css/animate.css')}}">

    <!-- Main.css -->
    <link rel="stylesheet" href="{{URL::asset('build/css/meanmenu.css')}}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/tabler-icons/tabler-icons.css')}}">

    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fontawesome/css/all.min.css')}}">

@if (Route::is(['index-2', 'index-7', 'car-details', 'cruise-details', 'tour-details', 'flight-details']))
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/slick/slick.css')}}">
@endif

@if (Route::is(['agent-account-settings', 'agent-car-booking', 'agent-chat', 'agent-cruise-booking', 'agent-dashboard', 'agent-listings', 'agent-notifications', 'agent-plans-settings', 'agent-plans', 'agent-security-settings', 'car-details', 'chat', 'cruise-details', 'customer-car-booking', 'customer-cruise-booking', 'customer-flight-booking', 'customer-hotel-booking', 'customer-tour-booking', 'dashboard', 'faq', 'flight-details', 'gallery', 'hotel-details', 'index-2', 'index-3', 'index-4', 'index-5', 'index-6', 'integratio-settings', 'my-profile', 'notification-settings', 'notification', 'preference-sttings', 'pricing-plan', 'profile-settings', 'security-settings', 'testimonial', 'tour-details', 'wallet', 'wishlist']))
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fancybox/jquery.fancybox.min.css')}}">
@endif

@if (!Route::is(['login', 'register', 'forgot-password', 'change-password', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'lock-screen']))    
    <!-- Owlcarousel CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/owlcarousel/owl.carousel.min.css')}}">

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/bootstrap-datetimepicker.min.css')}}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/select2/css/select2.min.css')}}">
@endif

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/iconsax.css')}}">

@if (Route::is(['about-us', 'become-an-artist', 'blog-details', 'blog-grid', 'blog-list', 'booking-confirmation', 'bus-left-sidebar', 'bus-right-sidebar', 'car-booking-information', 'card-booking', 'car-grid', 'car-list', 'car-map', 'contact-us', 'cruise-booking-confirmation', 'cruise-booking', 'cruise-grid', 'cruise-list', 'cruise-map', 'error-404', 'error-500', 'faq', 'flight-booking-confirmation', 'flight-booking', 'flight-grid', 'flight-list', 'flight-map', 'gallery', 'hotel-booking', 'hotel-grid', 'hotel-list', 'hotel-map', 'invoices', 'pricing-plan', 'privacy-policy', 'terms-conditions', 'testimonial', 'tour-booking-confirmation', 'tour-booking', 'tour-grid', 'tour-list', 'tour-map']))
    <!-- Rangeslider CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}">
@endif

@if (Route::is(['add-bus', 'add-flight', 'add-hotel', 'add-car', 'add-cruise', 'add-tour', 'agent-enquiry-details', 'edit-bus', 'edit-flight', 'edit-hotel', 'edit-tour', 'edit-cruise', 'edit-car']))
    <!-- Quill css -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.core.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.snow.css')}}">	
@endif

@if (Route::is(['security-settings', 'agent-plans', 'agent-plans-settings', 'agent-account-settings', 'agent-security-settings'])) 
    <!-- Mobile CSS-->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/intlTelInput.css')}}">
@endif

@if (Route::is(['customer-bus-booking', 'agent-bus-booking', 'integration-settings', 'customer-tour-booking', 'customer-hotel-booking', 'customer-flight-booking', 'customer-cruise-booking', 'customer-car-booking', 'agent-tour-booking', 'agent-settings', 'agent-security-settings', 'agent-plans', 'agent-plans-settings', 'agent-flight-booking', 'agent-cruise-booking', 'agent-account-settings', 'wishlist', 'wallet', 'security-settings', 'review', 'profile-settings', 'payment', 'notification-settings', 'preferences-settings', 'destination', 'agent-enquirers', 'agent-earnings', 'agent-car-booking', 'agent-hotel-booking', 'agent-review'])) 
    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/daterangepicker/daterangepicker.css')}}">
@endif

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/style.css')}}">
