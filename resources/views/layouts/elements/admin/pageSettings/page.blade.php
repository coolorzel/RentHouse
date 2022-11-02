<h5 class="mb-0 mt-5">{{ __('Page Settings') }}</h5>
<p>{{ __('In the following settings, you have the option to configure all available settings for page.') }}</p>
<div class="list-group mb-5 shadow">
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Title') }}</strong>
                    <p class="text-muted mb-0">{{ __('Page title this website.') }} </p>
                </div>
                <div class="col-auto">
                    <input name="page_name" type="text" id="inputPageTitle" class="form-control" aria-describedby="titleHelpInline" value="{{ $valueSettings['page_name'] }}">
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
                    <input name="page_description" value="{{ $valueSettings['page_description'] }}" type="text" id="inputPageTitle" class="form-control" aria-describedby="titleHelpInline">
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
                    <select name="page_default_language" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option value="en" @if($valueSettings['page_default_language'] == 'en') selected @endif>English</option>
                        <option value="pl" @if($valueSettings['page_default_language'] == 'pl') selected @endif>Poland</option>
                        <option value="ua" @if($valueSettings['page_default_language'] == 'ua') selected @endif>Ukraine</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<h5 class="mb-0 mt-5">{{ __('Security Settings') }}</h5>
<p>{{ __('These settings will help protect the privacy of your website as well as help expand your visibility for search engines.') }}</p>
<div class="list-group mb-5 shadow">
    <!--<div class="list-group-item">
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
    </div>-->
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <strong class="mb-2">{{ __('Site availability [ON/OFF]') }}</strong>
                @if($valueSettings['page_available'] == true) <span class="badge badge-pill badge-success" id="status">{{ __('Enabled') }}</span> @else <span class="badge badge-pill badge-danger">{{ __('Disabled') }}</span> @endif
                <p class="text-muted mb-0">{{ __('Enabled or disabled page for users. When disabled, we provide a message to visitors to the site. Access only for administrators and moderators of the site, via the address') }} <b>.../acp/login</b></p>
            </div>
            <div class="col-auto">
                @if($valueSettings['page_available'] == true)
                    <button id="availableSite" class="btn btn-danger btn-sm" type="button" data-link="{{ route('adminSettingAvailable') }}">{{ __('Disable') }}</button>
                @else
                    <button id="availableSite" class="btn btn-success btn-sm" type="button" data-link="{{ route('adminSettingAvailable') }}">{{ __('Enable') }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
