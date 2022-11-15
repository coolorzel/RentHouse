@extends('layouts.app')

@section('title', __('Create billing account'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary active">{{ __('My account') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Billing account') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Create new') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Create new billing account to post rental offers.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{ route('newBillingAccountCreate') }}" id="billingAccountCreatePost">
                    @csrf
                    @method('POST')
                    <div class="card mb-3">


                        <span class="alert alert-warning text-danger error-text" style="display:none;" id="errors"><ul id="errors-list"></ul></span>

                        <div class="card-body">
                            <div class="card-header mb-3">
                                <h4>{{ __('Create new billing account') }}</h4>
                                <p>{{ __('The created account for settlements must be created with truth. If there are any errors, you will be informed. All data must be true. The data relates to your company or relevant billing data. This data will be available in the announcement.') }}</p>
                                <p> <span class="text-danger">*</span> - {{ __('Required fields marked') }}.</p>
                                <p> <span class="text-danger">**</span> - {{ __('Required fields for companies are marked') }}.</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Type account') }} <span class="text-danger">*</span></h6>
                                </div>
                                <div class="col-sm-9 row mb-2 align-items-center">
                                    <div class="col-auto">
                                    <select id="company" name="company" class="form-select form-select-lg" aria-label=".form-select-lg example">
                                        <option value="0">{{ __('Private') }}</option>
                                        <option value="1">{{ __('Company') }}</option>
                                    </select>
                                    </div>
                                    <div class="col-auto">
                                        <span class="d-flex form-text">
                                            {{ __('Private - Private data for billing') }}
                                        </span>
                                        <span class="d-flex form-text">
                                            {{ __('Company - Company data for billing') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Name and last name') }} <span class="text-danger">*</span></h6>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" name="name" aria-label="First name" class="form-control-sm form-control" style="width: 50%;" value="{{ $user->name }}">
                                        <input type="text" name="lname" aria-label="Last name" class="form-control-sm form-control" style="width: 50%;" value="{{ $user->lname }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Phone number') }} <span class="text-danger">*</span></h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm phone_number" id="phone_number" name="phone_number" value="" placeholder="692-059-930">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Pesel') }} <span class="text-danger">*</span></h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm pesel" id="pesel" name="pesel" value="" placeholder="91061160095">
                                    <span id="validPeselLabel" class="text-small text-danger" style="display:none;">{{ __('Pesel valid...') }}</span>
                                </div>
                            </div>
                            <hr>
                            <div id="company_div">
                                <div class="row">
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <h6 class="mb-0">{{ __('Company name') }} <span class="text-danger">**</span></h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" id="company_name" name="company_name" placeholder="Rent-House SP.Z.O.O" disabled readonly>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <h6 class="mb-0">{{ __('Company nip') }} <span class="text-danger">**</span></h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm company_nip" id="company_nip" name="company_nip" placeholder="123-456-78-90" disabled readonly>
                                        <span id="validNipLabel" class="text-small text-danger" style="display:none;">{{ __('Nip valid...') }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <h6 class="mb-0">{{ __('Company regon') }} <span class="text-danger">**</span></h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm company_regon" id="company_regon" name="company_regon" placeholder="12-345678-9" disabled readonly>
                                        <span id="validRegonLabel" class="text-small text-danger" style="display:none;">{{ __('Regon valid...') }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <h6 class="mb-0">{{ __('Company website') }}</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group flex-nowrap form-outline">
                                            <span class="input-group-text" id="symbolCreateLink">http://</span>
                                            <input name="company_website" id="company_website" type="text" class="form-control form-control-sm" aria-label="editLinks" aria-describedby="addon-wrapping" disabled readonly>
                                            <label class="form-label" for="company_website" style="margin-left: 53px;">{{ __('Your website address') }}.</label>
                                            <div class="form-notch"><div class="form-notch-leading" style="width: 62px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Address') }} <span class="text-danger">*</span></h6>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input name="country" class="form-control form-control-sm" list="datalistCountryOptions" id="country" placeholder="{{ __('Country') }}" style="width:50%" value="{{ $user->country }}">
                                        <input name="province" class="form-control form-control-sm" list="datalistProvinceOptions" id="province" placeholder="{{ __('Province') }}" value="{{ $user->province }}" style="width:50%">
                                    </div>
                                    <div class="input-group">
                                        <input name="zipcode" class="form-control form-control-sm zipcode" list="datalistZipcodeOptions" id="zipcode" placeholder="{{ __('Zip-Code') }}" value="{{ $user->zipcode }}" style="width:20%">
                                        <input name="city" class="form-control form-control-sm" list="datalistCityOptions" id="city" placeholder="{{ __('City') }}" value="{{ $user->city }}" style="width:30%">
                                        <input name="street" class="form-control form-control-sm" list="datalistStreetOptions" id="street" placeholder="{{ __('Street') }}" value="{{ $user->street }}" style="width:30%">
                                        <input name="building_number" class="form-control form-control-sm number" list="datalistNumberOptions" id="building_number" placeholder="{{ __('Number') }}" value="{{ $user->number }}" style="width:20%">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-header">{{ __('Comment on your application') }}.</div>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="5" id="message" name="message"></textarea>
                                <span class="">{{ __('You have') }} <span id="counter"></span> {{ __('characters left') }}.</span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-warning">{{ __('Send') }} <i class="fa fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var optionsPesel =  {
            onComplete: function(cep) {
                var reg = /^[0-9]{11}$/;
                if(reg.test(cep) === false) {
                    alert('CEP Vailed!:' + cep);
                }else{
                    var digits = (""+cep).split("");
                    if ((parseInt(cep.substring( 4, 6)) > 31)||(parseInt(cep.substring( 2, 4)) > 12)) {
                        document.getElementById("validPeselLabel").style.display = 'block';
                    }
                    var checksum = (1*parseInt(digits[0]) + 3*parseInt(digits[1]) + 7*parseInt(digits[2]) + 9*parseInt(digits[3]) + 1*parseInt(digits[4]) + 3*parseInt(digits[5]) + 7*parseInt(digits[6]) + 9*parseInt(digits[7]) + 1*parseInt(digits[8]) + 3*parseInt(digits[9]))%10;
                    if(checksum === 0) checksum = 10;
                    {
                        checksum = 10 - checksum;

                        if (parseInt(digits[10]) === checksum){
                            document.getElementById("validPeselLabel").style.display = 'none';
                        }else{
                            document.getElementById("validPeselLabel").style.display = 'block';
                        }
                    }
                }
            },
            /*onKeyPress: function(cep, event, currentField, options){
                console.log('A key was pressed!:', cep, ' event: ', event,
                    'currentField: ', currentField, ' options: ', options);
            },
            onChange: function(cep){
                console.log('cep changed! ', cep);
            },
            onInvalid: function(val, e, f, invalid, options){
                var error = invalid[0];
                console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            }*/
        };

        $('.pesel').mask("00000000000", optionsPesel, {
            placeholder: "95020900482"
        });

        var optionsNip =  {
            onComplete: function(cepNip) {
                var nipWithoutDashes = cepNip.replace(/-/g,"");
                var reg = /^[0-9]{10}$/;
                if(reg.test(nipWithoutDashes) === false) {
                    alert('CEP Vailed!:' + cepNip);
                }else{
                    var digits = (""+nipWithoutDashes).split("");
                    var checksum = (6*parseInt(digits[0]) + 5*parseInt(digits[1]) + 7*parseInt(digits[2]) + 2*parseInt(digits[3]) + 3*parseInt(digits[4]) + 4*parseInt(digits[5]) + 5*parseInt(digits[6]) + 6*parseInt(digits[7]) + 7*parseInt(digits[8]))%11;

                    if (parseInt(digits[9]) === checksum){
                        document.getElementById("validNipLabel").style.display = 'none';
                    }else{
                        document.getElementById("validNipLabel").style.display = 'block';
                    }
                }
            },
            /*onKeyPress: function(cep, event, currentField, options){
                console.log('A key was pressed!:', cep, ' event: ', event,
                    'currentField: ', currentField, ' options: ', options);
            },
            onChange: function(cep){
                console.log('cep changed! ', cep);
            },
            onInvalid: function(val, e, f, invalid, options){
                var error = invalid[0];
                console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            }*/
        };

        $('.company_nip').mask("000-000-00-00", optionsNip, {
            placeholder: "123-456-78-90"
        });

        var optionsRegon =  {
            onComplete: function(cepRegon) {
                var regonWithoutDashes = cepRegon.replace(/-/g,"");
                var reg = /^[0-9]{9}$/;
                if(reg.test(regonWithoutDashes) === false) {
                    alert('CEP Vailed!:' + regonWithoutDashes);
                }else{
                    var digits = (""+regonWithoutDashes).split("");
                    var checksum = (8*parseInt(digits[0]) + 9*parseInt(digits[1]) + 2*parseInt(digits[2]) + 3*parseInt(digits[3]) + 4*parseInt(digits[4]) + 5*parseInt(digits[5]) + 6*parseInt(digits[6]) + 7*parseInt(digits[7]))%11;
                    if(checksum === 10)
                        checksum = 0;
                    if (parseInt(digits[8])===checksum){
                        document.getElementById("validRegonLabel").style.display = 'none';
                    }else{
                        document.getElementById("validRegonLabel").style.display = 'block';
                    }
                }
            },
            /*onKeyPress: function(cep, event, currentField, options){
                console.log('A key was pressed!:', cep, ' event: ', event,
                    'currentField: ', currentField, ' options: ', options);
            },
            onChange: function(cep){
                console.log('cep changed! ', cep);
            },
            onInvalid: function(val, e, f, invalid, options){
                var error = invalid[0];
                console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            }*/
        };

        $('.company_regon').mask("00-000000-0", optionsRegon, {
            placeholder: "12-345678-9"
        });

        $('.phone_number').mask("000-000-000", {
            placeholder: "123-456-789"
        });

    </script>
    <script>
        $('#company').on('change', function() {
            var formEdit = [];
            var divNode = document.getElementById("company_div");
            var inputNodes = divNode.getElementsByTagName('INPUT');

            var i;
            if($(this).val() === '1')
            {
                for(i = 0; i < inputNodes.length; i++){
                    formEdit.push({
                        name: inputNodes[i].name
                    });
                }
                formEdit.forEach((index) => {
                    const element = document.getElementsByName(index.name)[0];
                    element.readOnly = false;
                    element.disabled = false;
                });
            }else{
                for(i = 0; i < inputNodes.length; i++){
                    formEdit.push({
                        name: inputNodes[i].name
                    });
                }
                formEdit.forEach((index) => {
                    const element = document.getElementsByName(index.name)[0];
                    element.readOnly = true;
                    element.disabled = true;
                });
            }
        });
    </script>
    <script>

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function (){

            $('#billingAccountCreatePost').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                    url:$(this).attr('action'),
                    method:$(this).attr('method'),
                    data:new FormData(this),
                    processData: false,
                    dataType:'json',
                    contentType:false,
                    success:
                        function(data) {
                            if (data.status == 0) {

                                $.each(data.error, function (prefix, val) {
                                    Toastify({
                                        text: val[0], // "This is a toast",
                                        duration: 3000,
                                        //destination: "https://github.com/apvarun/toastify-js",
                                        newWindow: true,
                                        close: true,
                                        gravity: "top", // `top` or `bottom`
                                        position: "right", // `left`, `center` or `right`
                                        stopOnFocus: true, // Prevents dismissing of toast on hover
                                        style: {
                                            background: "linear-gradient(to right, #aac900, #ff0000)",
                                        },
                                        onClick: function(){} // Callback after click
                                    }).showToast();
                                });
                            } else {
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.href=data.route;
                                });
                            }
                        }
                });
            });

        });
    </script>

    <script>
        window.onload = function(){
            var maxLength = 240;
            var oSpan = document.getElementById('counter');
            oSpan.innerHTML = maxLength +'';
            $('#message').on('keyup', function(){
                var string = document.getElementById('message')
                oSpan.innerHTML = (maxLength - ( string.value.length ) ) +'';
                if( maxLength < string.value.length ) {
                    whenBeMaxLength = string.value.substring(0, maxLength);
                    string.value = whenBeMaxLength;
                    oSpan.innerHTML = (maxLength - ( string.value.length ) ) +'';
                }
            });
        }
    </script>
@endsection
