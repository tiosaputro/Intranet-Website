@php
$userProfile = App\Models\UserProfile::where('user_id', Auth::user()->id)->first();
@endphp
<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center"
    data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav">
            <li class="nav-item">
            </li>
        </ul>
    </div>

    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <span class="brand-logo">
                <img src="{{ asset('app-assets/images/logo/logo.png') }}"
                    style="max-width:136px; max-height: 40px;" />
                <!-- {{-- <b class="shadow-siap" style="margin-left:-5%; font-size:20pt;">- SIAP</b> --}} -->
            </span>
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#">
                        <i data-feather="menu" class="ficon"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto" v-if="loggedin">
            <li class="nav-item dropdown dropdown-notification me-25">
                <a class="nav-link" href="javascript:;" data-bs-toggle="dropdown">
                    <i data-feather="bell" class="ficon"></i>
                    <!-- span jumlah -->
                    <!-- <span class="badge rounded-pill bg-danger badge-up">
                </span> -->
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end" style="display: none;">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                            <div class="badge rounded-pill badge-light-primary">6 New</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list"><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar"><img
                                            src="{{ asset('app-assets/images/portrait/small/avatar-s-15.jpg') }}"
                                            alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Congratulation Sam
                                            🎉</span>winner!</p><small class="notification-text"> Won the monthly best
                                        seller badge.</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar"><img
                                            src="{{ asset('app-assets/images/portrait/small/avatar-s-15.jpg') }}"
                                            alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">New
                                            message</span>&nbsp;received</p><small class="notification-text"> You have
                                        10 unread messages</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content">MD</div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Revised Order
                                            👋</span>&nbsp;checkout</p><small class="notification-text"> MD Inc. order
                                        updated</small>
                                </div>
                            </div>
                        </a>
                        <div class="list-item d-flex align-items-center">
                            <h6 class="fw-bolder me-auto mb-0">System Notifications</h6>
                            <div class="form-check form-check-primary form-switch">
                                <input class="form-check-input" id="systemNotification" type="checkbox" checked="">
                                <label class="form-check-label" for="systemNotification"></label>
                            </div>
                        </div><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content"><i data-feather="x" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Server
                                            down</span>&nbsp;registered</p><small class="notification-text"> USA Server
                                        is down due to hight CPU usage</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-success">
                                        <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Sales
                                            report</span>&nbsp;generated</p><small class="notification-text"> Last month
                                        sales report generated</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Read all
                            notifications</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span
                            class="user-name fw-bolder">{{ Auth::user()->name }}</span><span
                            class="user-status">{{ Auth::user()->email }}</span></div>
                    <span class="avatar">
                        @if (empty($userProfile->path_photo))
                            <img class="round"
                                src="{{ asset('app-assets/images/portrait/small/avatar-s-15.jpg') }}" alt="avatar"
                                height="40" width="40">
                        @else
                            <img class="round" src="{{ asset($userProfile->path_photo) }}" alt="avatar"
                                height="40" width="40">
                        @endif

                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ url('profile') }}"><i class="me-50"
                            data-feather="user"></i> Profile</a>
                    {{-- <a class="dropdown-item" href="{{ url('inbox') }}"><i class="me-50" data-feather="mail"></i> Inbox</a>
                    <a class="dropdown-item" href="{{ url('my-tasks') }}"><i class="me-50" data-feather="check-square"></i> Task</a>
                    <a class="dropdown-item" href="{{ url('my-chats') }}"><i class="me-50" data-feather="message-square"></i> Chats</a> --}}
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('logout') }}"><i class="me-50"
                            data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>

    </div>
</nav>

<!-- END: Header-->
