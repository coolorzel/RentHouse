<h5 class="mb-0 mt-5">{{ __('Page Settings') }}</h5>
<p>{{ __('In the following settings, you have the option to configure all available settings for users.') }}</p>
<div class="list-group mb-5 shadow">
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Title') }}</strong>
                    <p class="text-muted mb-0">{{ __('Page title this website.') }} </p>
                </div>
                <div class="col-auto">
                    <input name="" type="text" id="inputPageTitle" class="form-control" aria-describedby="titleHelpInline">
                </div>
                <div class="col-auto">
                                        <span id="titleHelpInline" class="form-text">
                                          {{ __('Must be 1-20 characters long.') }}
                                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Description') }}</strong>
                    <p class="text-muted mb-0">{{ __('Page description this website.') }}  </p>
                </div>
                <div class="col-auto">
                    <input name="" type="text" id="inputPageTitle" class="form-control" aria-describedby="titleHelpInline">
                </div>
                <div class="col-auto">
                                        <span id="titleHelpInline" class="form-text">
                                          {{ __('Must be 1-20 characters long.') }}
                                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Language Site') }}</strong>
                    <p class="text-muted mb-0">{{ __('Select language site.') }}  </p>
                </div>
                <div class="col-auto">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option value="en" selected>English</option>
                        <option value="pl">Poland</option>
                        <option value="ua">Ukraine</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<h5 class="mb-0 mt-5">{{ __('Security Settings') }}</h5>
<p>{{ __('These settings will help protect the privacy of your website as well as help expand your visibility for search engines.') }}</p>
<div class="list-group mb-5 shadow">
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <strong class="mb-2">{{ __('Enable activity logs') }}</strong>
                <p class="text-muted mb-0">{{ __('All logs will be available in the admin panel.') }}  <a href="#">{{ __('Link') }}</a> </p>
            </div>
            <div class="col-auto">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="activityLog" checked="" disabled>
                    <span class="custom-control-label"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <strong class="mb-2">{{ __('Site availability [ON/OFF]') }}</strong>
                <span class="badge badge-pill badge-success">{{ __('Enabled') }}</span>
                <p class="text-muted mb-0">{{ __('Enabled or disabled page for users. When disabled, we provide a message to visitors to the site. Access only for administrators and moderators of the site, via the address') }} <b>.../acp/login</b></p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm">{{ __('Disable') }}</button>
            </div>
        </div>
    </div>
</div>
<h5 class="mb-0">{{ __('Last changes') }}</h5>
<p>{{ __('Who changes settings.') }}</p>
<table class="table border bg-white">
    <thead>
    <tr>
        <th>{{ __('User') }}</th>
        <th>{{ __('Location') }}</th>
        <th>{{ __('IP') }}</th>
        <th>{{ __('Time') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="col"><i class="fe fe-globe fe-12 text-muted mr-2"></i>Chrome - Windows 10</th>
        <td>Paris, France</td>
        <td>192.168.1.10</td>
        <td>Apr 24, 2019</td>
    </tr>
    <tr>
        <th scope="col"><i class="fe fe-smartphone fe-12 text-muted mr-2"></i>App - Mac OS</th>
        <td>Newyork, USA</td>
        <td>10.0.0.10</td>
        <td>Apr 24, 2019</td>
    </tr>
    <tr>
        <th scope="col"><i class="fe fe-globe fe-12 text-muted mr-2"></i>Chrome - iOS</th>
        <td>London, UK</td>
        <td>255.255.255.0</td>
        <td>Apr 24, 2019</td>
    </tr>
    </tbody>
</table>
