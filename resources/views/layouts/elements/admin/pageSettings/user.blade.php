<h5 class="mb-0 mt-5">{{ __('Users Settings') }}</h5>
<p>{{ __('In the following settings, you have the option to configure all available settings for users.') }}</p>
<div class="list-group mb-5 shadow">
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <strong class="mb-2">{{ __('Confirmation of email address') }}</strong>
                <p class="text-muted mb-0">{{ __('Each newly registered user must confirm their email address to have full access to the site.') }}</p>
            </div>
            <div class="col-auto">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="activityLog" checked="">
                    <span class="custom-control-label"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Default role') }}</strong>
                    <p class="text-muted mb-0">{{ __('Select default role for new users.') }}  </p>
                </div>
                <div class="col-auto">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option value="en" selected>User</option>
                        <option value="pl">Moderator</option>
                        <option value="ua">Administrator</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

