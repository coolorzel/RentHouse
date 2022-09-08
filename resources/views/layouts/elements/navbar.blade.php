<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ route('index') }}"><i class="fa fa-home mr-1" style="font-size:24px"></i> {{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Domy</a>
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
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user mr-1" style="font-size:24px"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-light">

                                        @can('USER-my-account')
                                            <li><a class="dropdown-item" href="{{ route('myProfile') }}">{{ __('My account') }}</a></li>
                                        @endcan
                                        @can('USER-offer-menagement')
                                            <li><a class="dropdown-item" href="#">{{ __('Create Offers') }}</a></li>
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

                    @if (Route::has('postNewAd'))
                        <a href="{{ route('postNewAd') }}" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><i class="fa fa-plus-circle mx-1" style="font-size:24px"></i> {{ __('Post new ad') }}</a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</nav>
