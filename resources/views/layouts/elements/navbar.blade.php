<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-2">
    <div class="container">

        <a class="navbar-brand" href="{{ route('index') }}"><i class="fa fa-home mr-1" style="font-size:24px"></i> {{ config('global.page_name', 'RentHouse') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">{{ __('About us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mieszkania</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Działki</a>
                </li>
            </ul>
            @guest
            <div class="navbar-nav ms-auto">
                @if (Route::has('login'))
                    <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user mr-1" style="font-size:24px"></i> {{ __('My account') }}</a>
                @endif

                @if (Route::has('postNewAd'))
                    <a href="{{ route('postNewAd') }}" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><i class="fa fa-plus-circle mx-1" style="font-size:24px"></i> {{ __('Post new ad') }}</a>
                @endif
            </div>
            @else
                <div class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <button class="btn btn-white nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                        <i id="iconNotification" class="fa fa-bell mr-1 @if((\App\Models\Notification::where(['u_id' => Auth::id(), 'displayed' => false])->count()) > 0) text-warning @endif" style="font-size:24px"></i>
                                        <span class="position-absolute start-100 translate-middle badge rounded-pill bg-info" id="countNotification">
                                            {{ (\App\Models\Notification::where(['u_id' => Auth::id(), 'displayed' => false])->count()) }}
                                            <span class="visually-hidden">{{ __('unread notification') }}</span>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-light" style="min-width: 300px;">
                                            <li><h6 class="dropdown-header">{{ __('Notification list') }}</h6></li>
                                        @if(!Auth::user()->notifications)
                                        <li>{{ __('Empty') }}...</li>
                                        @else
                                            <ol class="list-group" id="notificationList">
                                                @foreach(Auth::user()->notifications()->offset(0)->limit(5)->get() as $notification)
                                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                                        <div data-info="{{ $notification->id }}" data-route="{{ route('notificationChange') }}" class="me-auto">
                                                        <div class="@if($notification->displayed == false) fw-bold  text-warning @endif" data-info="{{ $notification->id }}"><small>{{ __($notification->message) }}</small></div>
                                                        <small><small class="text-secondary">{{ $notification->created_at }}</small></small>
                                                        </div>
                                                        @if($notification->route)
                                                            <button id="redirect" data-info="{{ $notification->id }}" data-route="{{ route('notificationChange') }}" data-redirect="{{ $notification->route }}" class="badge bg-primary rounded-pill">
                                                                <i class="fa fa-arrow-right"></i>
                                                            </button>
                                                        @else
                                                            <span class="badge bg-info rounded-pill">
                                                                <i class="fa fa-arrow-right"></i>
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ol>
                                            <button class="btn btn-outline-white" id="moreNotifications" data-count="10" data-route="{{ route('notificationGet') }}">{{ __('More 5 pcs') }}</button>
                                        @endif
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user mr-1" style="font-size:24px"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-light">

                                        @can('USER-my-account')
                                            <li><a class="dropdown-item" href="{{ route('myProfile') }}">{{ __('My account') }}</a></li>
                                        @endcan
                                            <li><hr class="dropdown-divider"></li>
                                            @can('ACP-view')
                                                <li><a class="dropdown-item" href="{{ route('adminDashboard') }}">{{ __('ACP') }}</a></li>
                                            @endcan
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endif

                        @if (Route::has('postNewAd') && Auth::user()->can('LANDLORD-create-new-offer'))
                            <a href="{{ route('postNewAd') }}" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><i class="fa fa-plus-circle mx-1" style="font-size:24px"></i> {{ __('Post new ad') }}</a>
                        @else
                            <a href="{{ route('myBillingVerificationForm') }}" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><i class="fa fa-plus-circle mx-1" style="font-size:24px"></i> {{ __('New billing account') }}</a>
                        @endif
                </div>
            @endguest
        </div>
    </div>
</nav>

