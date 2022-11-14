
<div class="card mb-3 flex-shrink-0 bg-white">
    <div class="card-body">
        <a href="#" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <span class="fs-5 fw-semibold">{{ __('Admin Control Panel') }}</span>
        </a>
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed {{ request()->is('acp') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="{{ request()->is('acp') ? 'true' : 'false' }}">
                    {{ __('Home') }}
                </button>
                <div class="collapse {{ (Request::is('acp') || Request::is('acp/settings') || Request::is('acp/settings/*')) ? 'show' : '' }}" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('adminDashboard') }}" class="btn btn-link link-dark rounded {{ Request::is('acp') ? 'active' : '' }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('adminSettings') }}" class="btn btn-link link-dark rounded {{ (Request::is('acp/settings') || Request::is('acp/settings/*')) ? 'active' : '' }}">{{ __('Settings') }}</a></li>
                    </ul>
                </div>
            </li>
            <!--<li class="mb-1">
            {{ (Request::is('products/*') || Request::is('products') || Request::is('product/*') ? 'active' : '') }}"><a href="{{url('products')}}
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
            </li>-->
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    {{ __('Account') }}
                </button>
                <div class="collapse {{ (Request::is('acp/users') || Request::is('acp/users/*') || Request::is('acp/roles') || Request::is('acp/roles/*') || Request::is('acp/permissions') || Request::is('acp/permissions/*') || Request::is('acp/conclusions') || Request::is('acp/conclusions/*')) ? 'show' : '' }}" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('adminUserProfile') }}" class="btn btn-link link-dark rounded {{ Request::is('acp/users') ? 'active' : '' }}">{{ __('Users') }}</a></li>
                        <li><a href="{{ route('adminUserRoles') }}" class="btn btn-link link-dark rounded {{ (Request::is('acp/roles') || Request::is('acp/roles/*')) ? 'active' : '' }}">{{ __('Roles') }}</a></li>
                        <li><a href="{{ route('adminUserPermissions') }}" class="btn btn-link link-dark rounded {{ (Request::is('acp/permissions') || Request::is('acp/permissions/*')) ? 'active' : '' }}">{{ __('Permissions') }}</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed position-relative" data-bs-toggle="collapse" data-bs-target="#billing-account-collapse" aria-expanded="false">
                    {{ __('Billing Account') }}
                    @if(count(\App\Models\BillingAccount::where(['verified' => false, 'rejected' => false, 'destroy' => false])->get()) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                    {{ __('New application billing account') }}
                                    <span class="visually-hidden">{{ __('unread messages') }}</span>
                                </span>
                    @endif
                </button>
                <div class="collapse {{ (Request::is('acp/billing') || Request::is('acp/billing/*'))  ? 'show' : '' }}" id="billing-account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('adminUserBillingAccounts') }}" class="position-relative btn btn-link link-dark rounded {{ Request::is('acp/billing') ? 'active' : '' }}">{{ __('All accounts') }}
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                    {{ count(\App\Models\BillingAccount::where(['verified' => false, 'rejected' => false, 'destroy' => false])->get()) }}
                                    <span class="visually-hidden">{{ __('unread messages') }}</span>
                                </span>
                            </a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed position-relative" data-bs-toggle="collapse" data-bs-target="#contact-collapse" aria-expanded="false">
                    {{ __('Contact') }}
                    @if(count(\App\Models\Contact::where('displayed', false)->get()) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                    {{ __('New message') }}
                                    <span class="visually-hidden">{{ __('unread messages') }}</span>
                                </span>
                    @endif
                </button>
                <div class="collapse {{ (Request::is('acp/contact') || Request::is('acp/contact/*')) ? 'show' : '' }}" id="contact-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('adminContactTitle') }}" class="btn btn-link link-dark rounded {{ Request::is('acp/contact/title') ? 'active' : '' }}">{{ __('Title') }}</a></li>
                        <li><a href="{{ route('adminContactMessage') }}" class="btn btn-link link-dark rounded position-relative {{ (Request::is('acp/contact/message') || Request::is('acp/contact/message/*')) ? 'active' : '' }}">{{ __('Messages') }}
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                    {{ count(\App\Models\Contact::where('displayed', false)->get()) }}
                                    <span class="visually-hidden">{{ __('unread messages') }}</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
