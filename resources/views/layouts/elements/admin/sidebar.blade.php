
<div class="card mb-3 flex-shrink-0 bg-white">
    <div class="card-body">
        <a href="#" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <span class="fs-5 fw-semibold">{{ __('Admin Control Panel') }}/span>
        </a>
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed {{ request()->is('acp') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="{{ request()->is('acp') ? 'true' : 'false' }}">
                    {{ __('Home') }}
                </button>
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('adminDashboard') }}" class="btn btn-link link-dark rounded {{ request()->is('acp') ? 'active' : '' }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('adminSettings') }}" class="btn btn-link link-dark rounded {{ request()->is('acp/settings') ? 'active' : '' }}{{ request()->is('acp/settings/*') ? 'active' : '' }}">{{ __('Settings') }}</a></li>
                        <li><a href="{{ route('adminStatistics') }}" class="btn btn-link link-dark rounded">{{ __('Statistics') }}</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    {{ __('Offers') }}
                </button>
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Overview</a></li>
                        <li><a href="#" class="link-dark rounded">Weekly</a></li>
                        <li><a href="#" class="link-dark rounded">Monthly</a></li>
                        <li><a href="#" class="link-dark rounded">Annually</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                    Orders
                </button>
                <div class="collapse" id="orders-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">New</a></li>
                        <li><a href="#" class="link-dark rounded">Processed</a></li>
                        <li><a href="#" class="link-dark rounded">Shipped</a></li>
                        <li><a href="#" class="link-dark rounded">Returned</a></li>
                    </ul>
                </div>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    Account
                </button>
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">New...</a></li>
                        <li><a href="#" class="link-dark rounded">Profile</a></li>
                        <li><a href="#" class="link-dark rounded">Settings</a></li>
                        <li><a href="#" class="link-dark rounded">Sign out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
