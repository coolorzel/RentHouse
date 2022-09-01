<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">


    <a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Laravel') }}
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav me-auto">

    </ul>

    <!-- Right Side Of Navbar -->
    @if(\Spatie\Permission\Models\Role::exists() == null)
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="login.html"><i class="fa fa-user mr-1" style="font-size:24px"></i> {{ __('My account') }}</a>
            </li>
        @endif

        @if (Route::has('postNewAd'))
            <li class="nav-item">
                <a href="#" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><i class="fa fa-plus-circle mr-1" style="font-size:24px"></i> {{ __('New Ad') }}</a>
            </li>
        @endif
    @else
        <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user mr-1" style="font-size:24px"></i> {{ __('My account') }}</a>
                    </li>
                @endif

                @if (Route::has('postNewAd'))
                    <a href="#" class="btn btn-outline-success my-2 my-sm-0 d-flex align-items-center"><i class="fa fa-plus-circle mr-1" style="font-size:24px"></i> {{ __('New Ad') }}</a>

                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    @endif
</div>

    </div>
</nav>
