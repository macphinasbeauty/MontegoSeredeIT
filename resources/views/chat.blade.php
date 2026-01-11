<?php $page="chat";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-04 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Message</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Message</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Wrapper -->
    <div class="content">
        <div class="container">

            <div class="row">

                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4 theiaStickySidebar">
                    <div class="card user-sidebar mb-4 mb-lg-0">
                        <div class="card-header user-sidebar-header">
                            <div class="profile-content rounded-pill">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : URL::asset('build/img/users/user-01.jpg') }}" alt="image" class="img-fluid avatar avatar-lg rounded-circle me-1">
                                        <div>
                                            <h6 class="fs-16">{{ auth()->user()->name }}</h6>
                                            <span class="fs-14 text-gray-6">Since {{ auth()->user()->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{url('profile-settings')}}" class="p-1 rounded-circle btn btn-light d-flex align-items-center justify-content-center"><i class="isax isax-edit-2 fs-14"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body user-sidebar-body">
                            <ul>
                                <li>
                                    <span class="fs-14 text-gray-3 fw-medium mb-2">Main</span>
                                </li>
                                <li>
                                    <a href="{{url('dashboard')}}" class="d-flex align-items-center">
                                        <i class="isax isax-grid-55"></i> Dashboard
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-calendar-tick5"></i><span>My Bookings</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{url('customer-flight-booking')}}" class="fs-14 d-inline-flex align-items-center">Flights</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-hotel-booking')}}" class="fs-14 d-inline-flex align-items-center">Hotels</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-car-booking')}}" class="fs-14 d-inline-flex align-items-center">Cars</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-cruise-booking')}}" class="fs-14 d-inline-flex align-items-center">Cruise</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-tour-booking')}}" class="fs-14 d-inline-flex align-items-center">Tour</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-bus-booking')}}" class="fs-14 d-inline-flex align-items-center">Bus</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{url('review')}}" class="d-flex align-items-center">
                                        <i class="isax isax-magic-star5"></i> My Reviews
                                    </a>
                                </li>
                                <li>
                                    <div class="message-content">
                                        <a href="{{url('chat')}}" class="d-flex align-items-center active">
                                            <i class="isax isax-message-square5"></i> Messages
                                        </a>
                                        @if(auth()->user()->receivedMessages()->where('is_read', false)->count() > 0)
                                        <span class="msg-count rounded-circle">{{ auth()->user()->receivedMessages()->where('is_read', false)->count() }}</span>
                                        @endif
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <a href="{{url('wishlist')}}" class="d-flex align-items-center">
                                        <i class="isax isax-heart5"></i> Wishlist
                                    </a>
                                </li>
                                <li>
                                    <span class="fs-14 text-gray-3 fw-medium mb-2">Finance</span>
                                </li>
                                <li>
                                    <a href="{{url('wallet')}}" class="d-flex align-items-center">
                                        <i class="isax isax-wallet-add-15"></i> Wallet
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="{{url('payment')}}" class="d-flex align-items-center">
                                        <i class="isax isax-money-recive5"></i> Payments
                                    </a>
                                </li>
                                <li>
                                    <span class="fs-14 text-gray-3 fw-medium mb-2">Account</span>
                                </li>
                                <li>
                                    <a href="{{url('my-profile')}}" class="d-flex align-items-center">
                                        <i class="isax isax-profile-tick5"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <div class="message-content">
                                        <a href="{{url('notification')}}" class="d-flex align-items-center">
                                            <i class="isax isax-notification-bing5"></i> Notifications
                                        </a>
                                        @if(auth()->user()->notifications()->where('is_read', false)->count() > 0)
                                        <span class="msg-count bg-purple rounded-circle">{{ auth()->user()->notifications()->where('is_read', false)->count() }}</span>
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <a href="{{url('profile-settings')}}" class="d-flex align-items-center">
                                        <i class="isax isax-setting-25"></i> Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('index')}}" class="d-flex align-items-center pb-0">
                                        <i class="isax isax-logout-15"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <!-- Chat -->
                <div class="col-xl-9 col-lg-8">
                    <div class="customer-chat">
                        <div class="row chat-window">

                    <!-- Chat User List -->
                    <div class="col-lg-4 chat-cont-left ">
                        <div class="card mb-0 flex-fill">
                            <div class="chat-header">
                                <div class="mb-3">
                                    <h6>Chats</h6>
                                </div>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
										<i class="isax isax-search-normal-14"></i>
									</span>
                                    <input type="email" class="form-control form-control-md" placeholder="Search">
                                </div>
                            </div>
                            <div class="card-body chat-users-list chat-scroll pt-0">
                                @forelse($messages as $message)
                                <a href="#" class="d-flex justify-content-between chat-member mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg {{ $message->sender->is_online ? 'online' : '' }} flex-shrink-0 me-2">
                                            <img src="{{URL::asset('build/img/users/user-08.jpg')}}" alt="User Image">
                                        </div>
                                        <div>
                                            <h6 class="fs-16 fw-medium mb-1">{{ $message->sender->name }}</h6>
                                            <p class="fs-14 text-gray-6 text-truncate">{{ Str::limit($message->message, 20) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-end">
                                            <p class="mb-1 fs-14 text-gray-6">{{ $message->created_at->format('d/m/y') }}</p>
                                            @if(!$message->is_read)
                                            <div class="d-flex justify-content-end">
                                                <span class="msg-count badge badge-primary d-flex align-items-center justify-content-center rounded-circle">1</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @empty
                                <div class="text-center py-4">
                                    <i class="isax isax-message-square fs-48 text-gray-4 mb-2"></i>
                                    <p class="text-gray-6">No messages yet.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!-- Chat User List -->

                    <!-- Chat Content -->
                    <div class="col-lg-8 chat-cont-right chat-window-long">

                        <!-- Chat History -->
                        <div class="card chat-window mb-0 shadow-none flex-fill">
                            <div class="card-header border-0">
                                <div class="msg_head">
                                    <div class="d-flex bd-highlight align-items-center">
                                        <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        @if($messages->isNotEmpty())
                                        <div class="avatar avatar-lg online flex-shrink-0 me-2">
                                            <img src="{{ $messages->first()->sender->avatar ? asset('storage/' . $messages->first()->sender->avatar) : URL::asset('build/img/users/user-08.jpg') }}" alt="User">
                                        </div>
                                        <div>
                                            <h6 class="fs-16 fw-medium mb-1">{{ $messages->first()->sender->name }}</h6>
                                            <p class="fs-14">Online</p>
                                        </div>
                                        @else
                                        <div class="avatar avatar-lg flex-shrink-0 me-2">
                                            <img src="{{URL::asset('build/img/users/user-08.jpg')}}" alt="User">
                                        </div>
                                        <div>
                                            <h6 class="fs-16 fw-medium mb-1">Select a Conversation</h6>
                                            <p class="fs-14">No active chat</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center send-action">
                                        <a href="#" class="btn chat-search-btn send-action-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search">
                                            <i class="isax isax-search-normal-14"></i>
                                        </a>
                                        <a class="btn no-bg send-action-btn rounded-circle" href="#" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                            <li><a href="{{url('index')}}" class="dropdown-item"><i class="isax isax-close-circle me-2"></i>Close Chat</a></li>
                                            <li><a href="#" class="dropdown-item"><i class="fa-solid fa-volume-xmark me-2"></i>Mute Notification</a></li>
                                            <li><a href="#" class="dropdown-item"><i class="isax isax-clock me-2"></i>Disappearing Message</a></li>
                                            <li><a href="#" class="dropdown-item"><i class="isax isax-refresh me-2"></i>Clear Message</a></li>
                                            <li><a href="#" class="dropdown-item"><i class="isax isax-trash me-2"></i>Delete Chat</a></li>
                                            <li><a href="#" class="dropdown-item"><i class="fa-regular fa-thumbs-down me-2"></i>Report</a></li>
                                            <li><a href="#" class="dropdown-item"><i class="fa-solid fa-ban me-2"></i>Block</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Chat Search -->
                                <div class="chat-search search-wrap contact-search">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search Contacts">
                                            <span class="input-group-text"><i class="isax isax-search-normal-14"></i></span>
                                        </div>
                                    </form>
                                </div>
                                <!-- /Chat Search -->
                            </div>
                            <div class="card-body msg_card_body chat-scroll">
                                @if($messages->isNotEmpty())
                                    <ul class="list-unstyled">
                                        @php
                                            $currentDate = null;
                                        @endphp
                                        @foreach($messages as $message)
                                            @php
                                                $messageDate = $message->created_at->format('Y-m-d');
                                                $isCurrentUser = $message->sender_id === auth()->id();
                                            @endphp

                                            @if($currentDate !== $messageDate)
                                                <li class="text-center day-badge mb-4">
                                                    <span class="badge badge-light badge-md text-gray-9 fw-normal fs-14 rounded-pill mx-auto">
                                                        {{ $message->created_at->format('l, M j') }}
                                                    </span>
                                                </li>
                                                @php $currentDate = $messageDate; @endphp
                                            @endif

                                            @if($isCurrentUser)
                                                <!-- Sent Message -->
                                                <li class="sent-message-group">
                                                    <ul>
                                                        <li class="media sent d-flex align-items-end">
                                                            <div class="media-body flex-grow-1">
                                                                <div class="msg-box">
                                                                    <div class="d-flex align-items-center justify-content-end mb-1">
                                                                        <div>
                                                                            <h6 class="fs-16 fw-normal d-flex align-items-center">{{ auth()->user()->name }}</h6>
                                                                            <div class="d-flex justify-content-end">
                                                                                <p class="fs-12">{{ $message->created_at->format('g:i A') }}
                                                                                    <i class="ms-1 text-success fa-solid fa-check-double"></i>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="ms-2">
                                                                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : URL::asset('build/img/users/user-01.jpg') }}" alt="image" class="avatar avatar-lg">
                                                                        </div>
                                                                    </div>
                                                                    <div class="position-relative">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="chat-actions me-2">
                                                                                <a href="#" data-bs-toggle="dropdown">
                                                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                                    <li><a class="dropdown-item reply-btn" href="#"><i class="isax isax-back-square me-2"></i>Reply</a></li>
                                                                                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-share-from-square me-2"></i>Forward</a></li>
                                                                                    <li><a class="dropdown-item" href="#"><i class="isax isax-copy me-2"></i>Copy</a></li>
                                                                                    <li><a class="dropdown-item" href="#"><i class="isax isax-heart me-2"></i>Mark as Favourite</a></li>
                                                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#message-delete"><i class="isax isax-trash me-2"></i>Delete</a></li>
                                                                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-check me-2"></i>Mark as Unread</a></li>
                                                                                    <li><a class="dropdown-item" href="#"><i class="isax isax-archive-1 me-2"></i>Archive Chat</a></li>
                                                                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-thumbtack me-2"></i>Pin Chat</a></li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="sent-message">
                                                                                <p class="fs-14">{{ $message->message }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @else
                                                <!-- Received Message -->
                                                <li class="media received">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <div class="avatar avatar-lg flex-shrink-0 me-2">
                                                            <img src="{{ $message->sender->avatar ? asset('storage/' . $message->sender->avatar) : URL::asset('build/img/users/user-08.jpg') }}" alt="User Image">
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-16 fw-normal d-flex align-items-center">{{ $message->sender->name }}</h6>
                                                            <div class="d-flex justify-content-start">
                                                                <p class="fs-12">{{ $message->created_at->format('g:i A') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div class="position-relative">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="received-message me-2">
                                                                        <p class="fs-14">{{ $message->message }}</p>
                                                                    </div>
                                                                    <div class="chat-actions me-2">
                                                                        <a href="#" data-bs-toggle="dropdown">
                                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                            <li><a class="dropdown-item reply-btn" href="#"><i class="isax isax-back-square me-2"></i>Reply</a></li>
                                                                            <li><a class="dropdown-item" href="#"><i class="fa-regular fa-share-from-square me-2"></i>Forward</a></li>
                                                                            <li><a class="dropdown-item" href="#"><i class="isax isax-copy me-2"></i>Copy</a></li>
                                                                            <li><a class="dropdown-item" href="#"><i class="isax isax-heart me-2"></i>Mark as Favourite</a></li>
                                                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#message-delete"><i class="isax isax-trash me-2"></i>Delete</a></li>
                                                                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-check me-2"></i>Mark as Unread</a></li>
                                                                            <li><a class="dropdown-item" href="#"><i class="isax isax-archive-1 me-2"></i>Archive Chat</a></li>
                                                                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-thumbtack me-2"></i>Pin Chat</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center py-4">
                                        <i class="isax isax-message-square fs-48 text-gray-4 mb-2"></i>
                                        <p class="text-gray-6">No messages in this conversation yet.</p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer border-0">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center chat-input-icons">
                                        <a class="btn no-bg" href="#" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end p-3">
                                            <a href="#" class="dropdown-item"><i class="isax isax-camera me-2"></i>Camera</a>
                                            <a href="#" class="dropdown-item"><i class="isax isax-gallery me-2"></i>Gallery</a>
                                            <a href="#" class="dropdown-item"><i class="isax isax-audio-square me-2"></i>Audio</a>
                                            <a href="#" class="dropdown-item"><i class="isax isax-location me-2"></i>Location</a>
                                            <a href="#" class="dropdown-item"><i class="isax isax-user-cirlce-add me-2"></i>Contact</a>
                                        </div>
                                        <div class="form-item emoj-action-foot">
                                            <a href="javascrip:void(0);" class="action-circle"><i class="fa-regular fa-face-smile"></i></a>
                                            <div class="emoj-group-list-foot down-emoji-circle">
                                                <ul>
                                                    <li>
                                                        <a href="#"><img src="{{URL::asset('build/img/icons/emonji-02.svg')}}" alt="Icon"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{URL::asset('build/img/icons/emonji-05.svg')}}" alt="Icon"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{URL::asset('build/img/icons/emonji-06.svg')}}" alt="Icon"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{URL::asset('build/img/icons/emonji-07.svg')}}" alt="Icon"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{URL::asset('build/img/icons/emonji-08.svg')}}" alt="Icon"></a>
                                                    </li>
                                                    <li class="add-emoj"><a href="#"><i class="isax isax-add"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <a href="#"><i class="isax isax-microphone-2"></i></a>
                                    </div>
                                    <div class="chat-input me-2">
                                        <input class="form-control" placeholder="Type your message here...">
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn_send"><i class="isax isax-send-25 text-white" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Chat Content -->
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection
