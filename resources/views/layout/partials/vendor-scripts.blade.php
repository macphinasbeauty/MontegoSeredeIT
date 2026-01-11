    <!-- Jquery JS -->
    <script src="{{URL::asset('build/js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap JS -->
    <script src="{{URL::asset('build/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Wow JS -->
    <script src="{{URL::asset('build/js/wow.min.js')}}"></script>

@if (Route::is(['dashboard', 'chat', 'agent-dashboard', 'agent-listings', 'agent-hotel-booking', 'agent-enquirers', 'agent-earnings', 'agent-chat' ]))
    <!-- Apex JS -->
    <script src="{{URL::asset('build/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/apexchart/chart-data.js')}}"></script>
@endif

    <!-- MeanMenu Js -->
    <script src="{{URL::asset('build/js/jquery.meanmenu.min.js')}}"></script>

@if (Route::is(['agent-account-settings', 'agent-car-booking', 'agent-chat', 'agent-cruise-booking', 'agent-dashboard', 'agent-listings', 'agent-notifications', 'agent-plans-settings', 'agent-plans', 'agent-security-settings', 'car-details', 'chat', 'cruise-details', 'customer-car-booking', 'customer-cruise-booking', 'customer-flight-booking', 'customer-hotel-booking', 'customer-tour-booking', 'dashboard', 'faq', 'flight-details', 'gallery', 'hotel-details', 'index-2', 'index-3', 'index-4', 'index-5', 'index-6', 'index-7', 'integratio-settings', 'my-profile', 'notification-settings', 'notification', 'preference-sttings', 'pricing-plan', 'profile-settings', 'security-settings', 'testimonial', 'tour-details', 'wallet', 'wishlist' ]))
    <!-- Fancybox JS -->
    <script src="{{URL::asset('build/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
@endif

@if (Route::is(['index-2', 'index-7', 'car-details', 'cruise-details', 'tour-details', 'flight-details' ]))
    <!-- Slick Slider -->
    <script src="{{URL::asset('build/plugins/slick/slick.min.js')}}"></script>
@endif

@if (!Route::is(['login', 'register', 'forgot-password', 'change-password', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'lock-screen']))    
    <!-- Owlcarousel Js -->
    <script src="{{URL::asset('build/plugins/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Sticky Sidebar JS -->
    <script src="{{URL::asset('build/plugins/theia-sticky-sidebar/ResizeSensor.js')}}"></script>
    <script src="{{URL::asset('build/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}"></script>
@endif

@if (Route::is(['about-us', 'become-an-artist', 'blog-details', 'blog-grid', 'blog-list', 'booking-confirmation', 'bus-left-sidebar', 'bus-right-sidebar', 'car-booking-information', 'card-booking', 'car-grid', 'car-list', 'car-map', 'contact-us', 'cruise-booking-confirmation', 'cruise-booking', 'cruise-grid', 'cruise-list', 'cruise-map', 'error-404', 'error-500', 'faq', 'flight-booking-confirmation', 'flight-booking', 'flight-grid', 'flight-list', 'flight-map', 'gallery' ,'hotel-booking', 'hotel-grid', 'hotel-list', 'hotel-map', 'invoices', 'pricing-plan', 'privacy-policy', 'terms-conditions', 'testimonial', 'tour-booking-confirmation', 'tour-booking', 'tour-grid', 'tour-list', 'tour-map' ]))
    <!-- Rangeslider JS -->
    <script src="{{URL::asset('build/plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>
    <script src="{{URL::asset('build/plugins/ion-rangeslider/js/custom-rangeslider.js')}}"></script>
    <script src="{{URL::asset('build/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
@endif

@if (!Route::is(['login', 'register', 'forgot-password', 'change-password', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'lock-screen']))    
    <!-- Select2 JS -->
    <script src="{{URL::asset('build/plugins/select2/js/select2.min.js')}}"></script>
@endif

@if (Route::is(['add-bus','add-flight','add-hotel','add-car','add-cruise','add-tour','agent-enquiry-details','edit-bus','edit-flight','edit-hotel','edit-tour','edit-cruise','edit-car']))
    <!-- Quill Editor JS -->
    <script src="{{URL::asset('build/plugins/quill/quill.min.js')}}"></script>
@endif

@if (!Route::is(['login', 'register', 'forgot-password', 'change-password', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'lock-screen']))    
    <!-- Counter JS -->
    <script src="{{URL::asset('build/js/jquery.counterup.min.js')}}"></script>
    <script src="{{URL::asset('build/js/jquery.waypoints.min.js')}}"></script>

    <!-- Datepicker Core JS -->
    <script src="{{URL::asset('build/plugins/moment/moment.js')}}"></script>
    <script src="{{URL::asset('build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endif

@if (Route::is(['customer-bus-booking','agent-bus-booking','agent-car-booking','agent-cruise-booking','agent-flight-booking','agent-hotel-booking','agent-review','integration-settings','customer-tour-booking','customer-hotel-booking','customer-flight-booking','customer-cruise-booking','customer-car-booking','agent-tour-booking','agent-settings','agent-security-settings','agent-plans','agent-plans-settings','agent-flight-booking','agent-cruise-booking','agent-account-settings','wishlist','wallet','security-settings','review','profile-settings','payment','notification-settings','preferences-settings','destination','agent-enquirers','agent-earnings','agent-car-booking' ,'agent-hotel-booking','agent-review'])) 
    <!-- Daterangepikcer JS -->
    <script src="{{URL::asset('build/js/moment.js')}}"></script>
    <script src="{{URL::asset('build/plugins/daterangepicker/daterangepicker.js')}}"></script>
@endif

@if (Route::is(['chat','agent-chat']))
    <!-- Slimscroll JS -->
    <script src="{{URL::asset('build/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
@endif

@if (Route::is(['hotel-map']))
    <!-- map JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6adZVdzTvBpE2yBRK8cDfsss8QXChK0I"></script>
    <script src="{{URL::asset('build/js/map-grid.js')}}"></script>
@endif

@if (Route::is(['car-map']))
    <!-- map JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6adZVdzTvBpE2yBRK8cDfsss8QXChK0I"></script>
    <script src="{{URL::asset('build/js/map-car.js')}}"></script>
@endif

@if (Route::is(['cruise-map']))
    <!-- map JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6adZVdzTvBpE2yBRK8cDfsss8QXChK0I"></script>
    <script src="{{URL::asset('build/js/map-cruise.js')}}"></script>
@endif

@if (Route::is(['tour-map']))
    <!-- map JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6adZVdzTvBpE2yBRK8cDfsss8QXChK0I"></script>
    <script src="{{URL::asset('build/js/map-tour.js')}}"></script>
@endif

    <!-- cursor JS -->
    <script src="{{URL::asset('build/js/cursor.js')}}"></script>

@if (Route::is(['index', 'flight-list', 'flight-grid', 'flight-map']))
    <!-- Flight Search JS -->
    <script src="{{URL::asset('build/js/flight-search.js')}}"></script>
@endif

@if (Route::is(['security-settings','agent-plans','agent-plans-settings','agent-account-settings','agent-security-settings'])) 
    <!-- Mobile Input -->
    <script src="{{URL::asset('build/plugins/intltelinput/js/intlTelInput.js')}}"></script>
@endif

@if (!Route::is(['index-rtl']))
    <!-- Script JS -->
    <script src="{{URL::asset('build/js/script.js')}}"></script>
@endif

@if (Route::is(['index-rtl'])) 
    <!-- Script JS -->   
    <script src="{{URL::asset('build/js/script-rtl.js')}}"></script>
@endif