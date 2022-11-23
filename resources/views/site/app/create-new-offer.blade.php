@extends('layouts.app')

@section('title', __('Create new offer'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('Offer') }}</button>
        <button class="btn btn-outline-secondary">{{ __('Step 1 (Type offer)') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Step 2 (Create offer)') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Create new offer.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <style>
        .dropzone {
            border:2px dashed orange;
        }
    </style>
    <form action="{{ route('offerCreateStore', [$category->slug, $offer->id]) }}" method="post" id="formOfferCreate">
    <div class="row gutters-sm">
            @method('post')
            @csrf
        <div class="col-md-8 p-3 mb-5 bg-body rounded" id="forms">
                <input class="element-form" type="hidden" id="city" name="city" value="{{ $offer->city }}">
                <input class="element-form" type="hidden" id="state" name="state" value="{{ $offer->state }}">
                <input class="element-form" type="hidden" id="postcode" name="postcode" value="{{ $offer->postcode }}">
                <input class="element-form" type="hidden" id="lat" name="lat" value="{{ $offer->lat }}">
                <input class="element-form" type="hidden" id="lon" name="lon" value="{{ $offer->lon }}">
                <h3>{{ __('Localization') }}</h3>
                <hr>
                @if(array_key_exists('location', $forms))
                    <div class="form-group">
                        <label for="searchInput">{{ $forms['location']['title'] }}</label>
                        <!-- Search input -->
                        <div class="input-group">
                            <input type="text" class="form-control element-form" id="searchInput" name="location" value="{{ $offer->city }}" placeholder="Enter a location...">
                            <input type="text" class="form-control element-form" id="searchInputPostcode" name="postcodes" value="{{ $offer->postcode }}" placeholder="Enter a postcode...">
                        </div>

                        <!-- Button trigger modal -->
                        <button id="searchButton" type="button" class="btn-sm btn-primary element-form" data-mdb-toggle="modal" name="btnSearchLocation" data-mdb-target="#searchLocationModal">
                            {{ __('Search') }}
                        </button>
                        <span type="button" class="btn-sm btn-info">
                                                {{ __('City') }} <span id="city_s" class="badge bg-info">@if(empty($offer->city)) City @else {{ $offer->city }} @endif</span>
                                            </span>
                        <span type="button" class="btn-sm btn-info">
                                                {{ __('State') }} <span id="state_s" class="badge bg-info">@if(empty($offer->state)) State @else {{ $offer->state }} @endif</span>
                                            </span>
                        <span type="button" class="btn-sm btn-info">
                                                {{ __('Post code') }} <span id="postcode_s" class="badge bg-info">@if(empty($offer->postcode)) XX-XXX @else {{ $offer->postcode }} @endif</span>
                                            </span>
                        <!-- Modal -->
                        <div class="modal fade" id="searchLocationModal" tabindex="-1" role="dialog" aria-labelledby="searchLocationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Select city') }}...</h5>
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul id="resultList">
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-mdb-dismiss="modal">{{ __('Save changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <h3>{{ __('Basic information') }}</h3>
                <hr>
                <!-- Tytuł -->
                @if(array_key_exists('name', $forms))
                    <div class="form-group">
                        <label for="name">{{ $forms['name']['title'] }}</label>
                        <input type="text" class="form-control element-form" id="name" name="name" onkeyup="tranSlug()" value="{{ $offer->name }}">
                    </div>
                @endif
            <!-- Slug -->
                @if(array_key_exists('slug', $forms))
                    <div class="form-group">
                        <label for="slug">{{ $forms['slug']['title'] }}</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $offer->slug }}" disabled>
                    </div>
                @endif

                <div class="row">
                    <!-- Cena wystawienia -->
                    @if(array_key_exists('regular_rent', $forms))
                        <div class="form-group col-md-6">
                            <label for="regular_rent">{{ $forms['regular_rent']['title'] }}</label>
                            <div class="input-group">
                                <input type="text" id="regular_rent" class="form-control element-form" aria-label="Amount (to the nearest pln)" placeholder="Addon on both side" name="regular_rent" value="{{ $offer->regular_rent }}">
                                <span class="input-group-text">PLN</span>
                            </div>
                        </div>
                    @endif
                <!-- Kaucja -->
                    @if(array_key_exists('deposit', $forms))
                        <div class="form-group col-md-6">
                            <label for="deposit">{{ $forms['deposit']['title'] }}</label>
                            <div class="input-group">
                                <input type="text" id="deposit" class="form-control element-form" aria-label="Amount (to the nearest pln)" placeholder="Addon on both side" name="deposit" value="{{ $offer->deposit }}">
                                <span class="input-group-text">PLN</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <!-- Pokoje -->
                    @if(array_key_exists('rooms', $forms))
                        <div class="form-group col-md-4">
                            <label for="rooms">{{ $forms['rooms']['title'] }}</label>
                            <div class="input-group text-center mb-3" style="width:130px;">
                                <span class="input-group-text decrement-btn">-</span>
                                <input type="text" id="rooms" class="form-control text-center element-form rooms" name="rooms" value="@if(empty($offer->rooms))0
@else{{ $offer->rooms }}@endif">
                                <span class="input-group-text increment-btn">+</span>
                            </div>
                        </div>
                    @endif
                <!-- Powierzchnia m2 -->
                    @if(array_key_exists('surface', $forms))
                        <div class="form-group col-md-4">
                            <label for="surface">{{ $forms['surface']['title'] }}</label>
                            <div class="input-group text-center mb-3" style="width:130px;">
                                <span class="input-group-text decrement-btn">-</span>
                                <input type="text" id="surface" class="form-control text-center element-form" name="surface" value="@if(empty($offer->surface))0
@else{{ $offer->surface }}@endif">
                                <span class="input-group-text increment-btn">+</span>
                            </div>
                        </div>
                    @endif
                <!-- Działka -->
                    @if(array_key_exists('land_area', $forms))
                        <div class="form-group col-md-4">
                            <label for="land_area">{{ $forms['land_area']['title'] }}</label>
                            <div class="input-group text-center mb-3" style="width:130px;">
                                <span class="input-group-text decrement-btn">-</span>
                                <input type="text" id="land_area" class="form-control text-center element-form" name="land_area" value="@if(empty($offer->land_area))0
@else{{ $offer->land_area }}@endif">
                                <span class="input-group-text increment-btn">+</span>
                            </div>
                        </div>
                    @endif
                </div>

                @if(array_key_exists('images', $forms))
                <!-- File chooser -->
                    <h3>{{ $forms['images']['title'] }}</h3>
                    <hr>

                    <div class="form-group">
                        <div class="dropzone dropzone-file-area" id="fileUpload">
                            <div class="dz-default dz-message">
                                <button class="btn btn-white" type="button" style="height: 100%;width: 100%;">
                                    <img src="{{ asset('project/img/btn_upload.png') }}" alt="upload">
                                </button>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ __('Select the main photo') }}:</h3>
                            </div>
                            <div class="panel-body">
                                <div class="container parent">
                                    <div class="row" id="uploaded_image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            <!-- Opis -->
                <h3>{{ __('Detailed information') }}</h3>
                <hr>
                @if(array_key_exists('description', $forms))
                    <div class="form-group">
                        <label for="description">{{ $forms['description']['title'] }}</label>
                        <textarea class="form-control element-form" id="description" rows="7" name="description">{{ $offer->description }}</textarea>
                    </div>
                @endif
            <!-- Krótki opis -->
                @if(array_key_exists('short_description', $forms))
                    <div class="form-group">
                        <label for="short_description">{{ $forms['short_description']['title'] }}</label>
                        <input type="text" class="form-control element-form" id="short_description" name="short_description" value="{{ $offer->short_description }}">
                    </div>
                @endif

            <!-- Ogrzewanie -->
                @if(array_key_exists('heating', $forms))
                    <h3>{{ $forms['heating']['title'] }}</h3>
                    <hr>
                    <div class="row">
                        @foreach($forms['heating']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input element-form" id="heating[{{ $item->name }}]" name="heating[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['heating']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="heating[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Media -->
                @if(array_key_exists('media', $forms))
                    <h3>{{ $forms['media']['title'] }}</h3>
                    <hr>
                    <div class="row">
                        @foreach($forms['media']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input element-form" id="media[{{ $item->name }}]" name="media[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['media']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="media[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Zabezpieczenia -->
                @if(array_key_exists('security', $forms))
                    <h3>{{ $forms['security']['title'] }}</h3>
                    <hr>
                    <div class="row">
                        @foreach($forms['security']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input element-form" id="security[{{ $item->name }}]" name="security[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['security']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="security[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Opłaty -->
                @if(array_key_exists('charges', $forms))
                    <h3>{{ $forms['charges']['title'] }}</h3>
                    <hr>
                    <div class="row">
                        @foreach($forms['charges']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input element-form" id="charges[{{ $item->name }}]" name="charges[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['charges']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="charges[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Wyposażenie -->
                @if(array_key_exists('equipment', $forms))
                    <h3>{{ $forms['equipment']['title'] }}</h3>
                    <hr>
                    <div class="row">
                        @foreach($forms['equipment']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input element-form" id="equipment[{{ $item->name }}]" name="equipment[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['equipment']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="equipment[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Miejsce parkingowe -->
                @if(array_key_exists('parking', $forms))
                    <h3>{{ $forms['parking']['title'] }}</h3>
                    <hr>
                    <div class="row">
                        @foreach($forms['parking']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input element-form" id="material[{{ $item->name }}]" name="parking[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['parking']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="material[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Identyfikator płatności -->
                @if(array_key_exists('payment', $forms))
                    <div class="form-group">
                        <label for="payment">{{ $forms['payment']['title'] }}</label>
                        <select name="payment" id="payment" class="form-control element-form" style="width: 100%">
                            @foreach($forms['payment']['items'] as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, $forms['payment']['active'])
                                                ? 'selected'
                                                : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            <!-- Typ ogłoszenia -->
                @if(array_key_exists('typeoffer', $forms))
                    <div class="form-group">
                        <label for="typeoffer">{{ $forms['typeoffer']['title'] }}</label>
                        <select name="typeoffer" id="typeoffer" class="form-control element-form" style="width: 100%">
                            <option value="">--{{ __('Please choose an option') }}--</option>
                            @foreach($forms['typeoffer']['items'] as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, $forms['typeoffer']['active'])
                                                ? 'selected'
                                                : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif



                @if(array_key_exists('contact_tel', $forms) || array_key_exists('contact_email', $forms))
                    <div class="row mb-2">

                    @if(array_key_exists('contact_tel', $forms))
                        <!-- Kontakt telefoniczny -->
                            <div class="form-group col-md-6">
                                <label for="contact_tel">{{ $forms['contact_tel']['title'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">+48</span>
                                    <input id="contact_tel" type="tel" class="form-control element-form" aria-label="Phone number" placeholder="Enter a phone number" name="contact_tel" value="{{ $offer->contact_tel }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}">
                                </div>
                            </div>
                    @endif

                    @if(array_key_exists('contact_email', $forms))
                        <!-- contact_email -->
                            <div class="form-group col-md-6">
                                <label for="contact_email">{{ $forms['contact_email']['title'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="email" id="contact_email" class="form-control element-form" aria-label="Adress eMail" placeholder="Enter a adress eMail" name="contact_email" value="{{ $offer->contact_email }}">
                                </div>
                            </div>
                        @endif
                    </div>
            @endif

            <!-- Submit button -->
                <div class="btn-group-lg" id="submit">
                <button type="submit" name="add" value="add" class="btn btn-outline-warning element-form">{{ __('Add') }}</button>
                <button type="submit" name="save" value="save" class="btn btn-warning element-form">{{ __('Save') }}</button>
                </div>


        </div>
        <div class="col-md-4 p-3 mb-5 bg-body rounded position-relative">
            <h3>{{ __('Billing account') }}</h3>
            <hr>
            <div class="text-warning spinner-grow position-absolute top-0" id="firstChangeAccount" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            <div class="col-md-12 p-3">
                <ul class="list-group" id="billingAccount">
                    @foreach($billingAccounts as $item)
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="billing_id" value="{{ $item->id }}" id="billingAccountNr{{$item->id}}" autocomplete="off" onclick="changeForm(this)" @if($offer->billing_id == $item->id) checked @endif>
                            <label class="form-check-label" for="billingAccountNr{{$item->id}}">
                                    <div class="row">
                                        <div class="col text-center align-self-center">
                                            @if($item->company == true)
                                                <i class="fa fa-building-o"></i>
                                            @else
                                                <i class="fa fa-user-secret"></i>
                                            @endif
                                        </div>
                                        <div class="col align-self-center">
                                            <div class="row">
                                                @if(isset($item->company_name))
                                                    <strong class="text-warning">{{ __('Company name: ') }}</strong> {{ $item->company_name }}
                                                @endif
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('First name: ') }}</strong> {{ $item->name }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('Last name: ') }}</strong> {{ $item->lname }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 text-center">
                                                    <strong>{{ __('Address:') }}</strong>
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('Country:') }}</strong> {{ $item->country }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('Province:') }}</strong> {{ $item->province }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('City:') }}</strong> {{ $item->city }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('Post Code:') }}</strong> {{ $item->zipcode }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <strong>{{ __('Street:') }}</strong> {{ $item->street }} {{ $item->building_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
    </form>

@endsection

@section('scripts')
    <script>
        const plus = document.querySelector(".increment-btn"),
            minus = document.querySelector(".decrement-btn"),
            num = document.querySelector(".rooms");
        let a = 0;
        plus.addEventListener("click", ()=>{
           a++
           num.innerText = a;
        });

        minus.addEventListener("click", ()=>{
            if(a > 1){
                a--;
                num.innerText = a;
            }
        })
    </script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit button').on('click', function() {
            let btn = ($(this).attr('value'))
            $('#formOfferCreate').submit(function (e) {
                //let btn = $(e.relatedTarget)\
                const dataForm = new FormData(this)
                dataForm.append('btn', btn)
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: dataForm,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success:
                        function (data) {
                            if (data.status === 0) {
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

                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function (){
                                    if(data.route) {
                                        location.replace(data.route)
                                    }else{
                                        location.reload()
                                    }
                                })
                            }
                        }
                })
                e.preventDefault()
            })
        })
    </script>

    <script type="text/javascript">

        Dropzone.options.fileUpload = {
            url: '{{ route('offerImagesStore', [$offer->cat_id, $offer->id]) }}',
            autoProcessQueue : true,
            acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            name: 'file',
            init:function(){
                var submitButton = document.querySelector("#submit-all");
                myDropzone = this;

                this.on("complete", function(){
                    if(this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0)
                    {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    load_images();
                });

            },

        };

        load_images();

        function load_images()
        {
            $.ajax({
                url:"{{ route('offerImagesFetch', [$offer->cat_id, $offer->id]) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data)
                {
                    $('#uploaded_image').text('');
                    $.each(data.images, function (index, val) {
                        $('#uploaded_image').append("" +
                            "<div class='col col-sm-4 col-md-4 text-center position-relative'>" +
                            "<input type='radio' name='images_id' id='images-" + index + "' class='d-none imgbgchk' value='" + index + "'" + val.isChecked + ">" +
                                "<label for='images-" + index + "'>" +
                                "<img class='rounded-3 border border-warning' src='" + val.src + "' alt='" + val.name + "'>" +
                                    "<div class='tick_container'>" +
                                        "<div class='tick'><i class='fa fa-check'></i></div>" +
                                    "</div>" +
                                "</label>" +
                            "<button type='button' class='btn btn-link remove_image position-absolute' id='" + val.name + "'><i class='fa fa-trash fa-2x text-danger' aria-hidden='true'></i></button>" +
                            "</div>")
                    })
                }
            })
        }

        $(document).on('click', '.remove_image', function(){
            var name = $(this).attr('id');
            $.ajax({
                url:"{{ route('offerImagesDestroy', [$offer->cat_id, $offer->id]) }}",
                type: 'DELETE',
                data:{name : name},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                    load_images();
                }
            })
        });

    </script>

    <script>
        function tranSlug()
        {
            let element = document.getElementById("name");
            let e = element.value;
            let replaceElement = e.replace(/ /g, "-");
            document.getElementById("slug").value = (replaceElement);
        }
    </script>

    <script>
        const searchInput = document.getElementById('searchInput')
        const searchInputPostcode = document.getElementById('searchInputPostcode')
        const resultList = document.getElementById('resultList')
        const saveList = [];
        const currentMarkers = [];

        document.getElementById('searchButton').addEventListener('click', () => {
            const query = searchInput.value
            const postcode = searchInputPostcode.value
            //fetch('https://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&q=' + query + '&postalcode=' + postcode)
            fetch('https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=' + query + '&postalcode=' + postcode)
                .then(result => result.json())
                .then(parsedResult => {
                    setResultList(parsedResult);
                });
        });


        function isEmpty(str) {
            return (!str || str.length === 0 );
        }

        function setResultList(parsedResult) {
            resultList.innerHTML = "";
            //for (const marker of currentMarkers) {
            //map.removeLayer(marker);
            //}
            //map.flyTo(new L.LatLng(20.13847, 1.40625), 2);
            for (const result of parsedResult) {
                if (result.type === "administrative" || result.type === "village")
                {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    //li.textContent = 'City: ' + result.address.town + ', Post Code: ' + result.address.town;
                    li.innerHTML = result.display_name;

                    li.innerHTML2 = JSON.stringify({
                        city: result.address.town,
                        village: result.address.village,
                        administrative: result.address.administrative,
                        suburb: result.address.suburb,
                        state: result.address.state,
                        postcode: result.address.postcode,
                        lat: result.lat,
                        lon: result.lon
                    }, undefined, 2);
                    li.addEventListener('click', (event) => {
                        for (const child of resultList.children) {
                            child.classList.remove('active');
                        }
                        event.target.classList.add('active');
                        const clickedData = JSON.parse(event.target.innerHTML2);
                        if (!!clickedData.administrative)
                        {
                            document.getElementById('city').value = clickedData.administrative;
                            document.getElementById('state').value = clickedData.state;
                            document.getElementById('postcode').value = clickedData.postcode;
                            document.getElementById('city_s').textContent = clickedData.administrative;
                            document.getElementById('state_s').textContent = clickedData.state;
                            document.getElementById('postcode_s').textContent = clickedData.postcode;
                            document.getElementById('lat').value = clickedData.lat;
                            document.getElementById('lon').value = clickedData.lon;
                        }
                        if (!!clickedData.city)
                        {
                            document.getElementById('city').value = clickedData.city;
                            document.getElementById('state').value = clickedData.state;
                            document.getElementById('postcode').value = clickedData.postcode;
                            document.getElementById('city_s').textContent = clickedData.city;
                            document.getElementById('state_s').textContent = clickedData.state;
                            document.getElementById('postcode_s').textContent = clickedData.postcode;
                            document.getElementById('lat').value = clickedData.lat;
                            document.getElementById('lon').value = clickedData.lon;
                        }
                        if (!!clickedData.village)
                        {
                            document.getElementById('city').value = clickedData.village;
                            document.getElementById('state').value = clickedData.state;
                            document.getElementById('postcode').value = clickedData.postcode;
                            document.getElementById('city_s').textContent = clickedData.village;
                            document.getElementById('state_s').textContent = clickedData.state;
                            document.getElementById('postcode_s').textContent = clickedData.postcode;
                            document.getElementById('lat').value = clickedData.lat;
                            document.getElementById('lon').value = clickedData.lon;
                        }
                        if (!!clickedData.suburb)
                        {
                            document.getElementById('city').value = clickedData.suburb;
                            document.getElementById('state').value = clickedData.state;
                            document.getElementById('postcode').value = clickedData.postcode;
                            document.getElementById('city_s').textContent = clickedData.suburb;
                            document.getElementById('state_s').textContent = clickedData.state;
                            document.getElementById('postcode_s').textContent = clickedData.postcode;
                            document.getElementById('lat').value = clickedData.lat;
                            document.getElementById('lon').value = clickedData.lon;
                        }
                        //const position = new L.LatLng(clickedData.lat, clickedData.lon);
                        //map.flyTo(position, 10);
                    })
                    //const position = new L.LatLng(result.lat, result.lon);
                    //currentMarkers.push(new L.marker(position).addTo(map));
                    resultList.appendChild(li);
                }
            }
        }
    </script>

    <script>
    window.onload = function(){
        formEdit = [];
        const divNode = document.getElementById("formOfferCreate")
        const inputNodes = divNode.getElementsByClassName('element-form')
        const forms = document.getElementById("forms")
        let pulse = document.getElementById("firstChangeAccount")
        if ($('input[name=billing_id]:checked').length > 0) {
            pulse.style.display = 'none';
        }else{
            forms.classList.remove('bg-body')
            forms.classList.add('bg-secondary')

            for(var i = 0; i < inputNodes.length; i++){
                formEdit.push({
                    name: inputNodes[i].name,
                    value: inputNodes[i].value,
                    id: inputNodes[i].id
                });
            }
            formEdit.forEach((index) => {
                const element = document.getElementsByName(index.name)[0]
                element.readOnly = true;
                element.disabled = true;
            });
        }
    }

    let billingAccountRadio = document.querySelector('input[name = "billing_id"]:checked');
    function changeForm(item) {

        formEdit = [];
        const divNode = document.getElementById("formOfferCreate")
        const inputNodes = divNode.getElementsByClassName('element-form')
        const forms = document.getElementById("forms")
        let pulse = document.getElementById("firstChangeAccount")
        if (item != null) {
            forms.classList.remove('bg-secondary')
            forms.classList.add('bg-body')
            pulse.style.display = 'none';

            for(var i = 0; i < inputNodes.length; i++){
                formEdit.push({
                    name: inputNodes[i].name,
                    value: inputNodes[i].value,
                    id: inputNodes[i].id
                });
            }
            formEdit.forEach((index) => {
                const element = document.getElementsByName(index.name)[0]
                element.readOnly = false;
                element.disabled = false;
            });
        }
    }

    </script>
@endsection
