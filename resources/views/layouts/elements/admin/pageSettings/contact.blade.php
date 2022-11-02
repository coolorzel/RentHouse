<h5 class="mb-0 mt-5">{{ __('Contact Settings') }}</h5>
<p>{{ __('Contact page settings. Phone number, address, pages in social media.') }}</p>
<div class="list-group mb-5 shadow">

    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('eMail') }}</strong>
                    <p class="text-muted mb-0">{{ __('Enter the email address to contact customer service.') }} </p>
                </div>
                <div class="col-auto">
                    <input name="contact_email" type="text" id="inputContactEmail" class="form-control" aria-describedby="contactEmailHelpInline" value="{{ $valueSettings['contact_email'] }}">
                </div>
                <div class="col-auto">
                                        <span id="contactEmailHelpInline" class="form-text">
                                          {{ __('Must be adress email.') }}
                                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Phone number') }}</strong>
                    <p class="text-muted mb-0">{{ __('Enter the phone number to contact customer service.') }} </p>
                </div>
                <div class="col-auto">
                    <input name="contact_phone_number" type="text" id="inputContactPhone" class="form-control" aria-describedby="contactPhoneHelpInline" value="{{ $valueSettings['contact_phone_number'] }}">
                </div>
                <div class="col-auto">
                                        <span id="contactPhoneHelpInline" class="form-text">
                                          {{ __('Must be number.') }}
                                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('Start work') }}</strong>
                    <p class="text-muted mb-0">{{ __('Enter the customer support start time.') }} </p>
                </div>
                <div class="col-auto">
                    <input name="contact_start_work" type="time" id="inputContactStartWork" class="form-control" aria-describedby="contactStartWorkHelpInline" value="{{ $valueSettings['contact_start_work'] }}">
                </div>
                <div class="col-auto">
                                        <span id="contactStartWorkHelpInline" class="form-text">
                                          {{ __('Must be time.') }}
                                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <strong class="mb-2">{{ __('End work') }}</strong>
                    <p class="text-muted mb-0">{{ __('Enter the customer support end time.') }} </p>
                </div>
                <div class="col-auto">
                    <input name="contact_end_work" type="time" id="inputContactStartWork" class="form-control" aria-describedby="contactEndWorkHelpInline" value="{{ $valueSettings['contact_end_work'] }}">
                </div>
                <div class="col-auto">
                                        <span id="contactEndWorkHelpInline" class="form-text">
                                          {{ __('Must be time.') }}
                                        </span>
                </div>
            </div>
        </div>
    </div>
</div>

