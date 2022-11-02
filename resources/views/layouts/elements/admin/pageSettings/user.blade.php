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
                    <input name="user_email_verify" value="0" type="hidden">
                    <input name="user_email_verify" type="checkbox" class="custom-control-input" value="1" id="userEmailVerify" @if($valueSettings['user_email_verify'] == true) checked @endif>
                    <span class="custom-control-label"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <strong class="mb-2">{{ __('Active registration of a new user') }}</strong>
                <p class="text-muted mb-0">{{ __('Enabled, it allows new users to register on the site.') }}</p>
            </div>
            <div class="col-auto">
                <div class="custom-control custom-switch">
                    <input name="user_register_available" value="0" type="hidden">
                    <input name="user_register_available" type="checkbox" class="custom-control-input" value="1" id="userRegisterAvailable" @if($valueSettings['user_register_available'] == true) checked @endif>
                    <span class="custom-control-label"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <strong class="mb-2">{{ __('Active login on the website') }}</strong>
                <p class="text-muted mb-0">{{ __('Should the website login option be enabled?') }}</p>
            </div>
            <div class="col-auto">
                <div class="custom-control custom-switch">
                    <input name="user_login_available" value="0" type="hidden">
                    <input name="user_login_available" type="checkbox" class="custom-control-input" value="1" id="userLoginAvailable" @if($valueSettings['user_login_available'] == true) checked @endif>
                    <span class="custom-control-label"></span>
                </div>
            </div>
        </div>
    </div>

<!--
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
-->
</div>

