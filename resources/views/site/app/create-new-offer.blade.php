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
    <div class="row gutters-sm">
        <div class="col-md-12 p-3 mb-5 bg-body rounded">
            <form action="{{ route('offerCreateStore', $category->slug) }}" method="post" id="add-offer-form">
                @method('patch')
                @csrf
                <input type="hidden" name="category_id" value="">
                <input type="hidden" id="city" name="city" value="">
                <input type="hidden" id="state" name="state" value="">
                <input type="hidden" id="postcode" name="postcode" value="">
                <input type="hidden" id="lat" name="lat" value="">
                <input type="hidden" id="lon" name="lon" value="">
                <h3>{{ __('Localization') }}</h3>
                <hr>
                @if(array_key_exists('location', $forms))
                    <div class="form-group">
                        <label for="zip-code">{{ $forms['location']['title'] }}</label>
                        <!-- Search input -->
                        <input type="text" class="form-control" id="searchInput" name="location" value="{{ $offer->city }}" placeholder="Enter a location...">
                        <!-- Google map -->
                        <div id="map"></div>
                        <!-- MODAL -->

                        <!-- Button trigger modal -->
                        <button id="searchButton" type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Wyszukaj
                        </button>
                        <span type="button" class="btn-sm btn-info">
                                                Miasto <span id="city_s" class="badge bg-info">@if(empty($offer->city)) City @else {{ $offer->city }} @endif</span>
                                            </span>
                        <span type="button" class="btn-sm btn-info">
                                                Gmina <span id="state_s" class="badge bg-info">@if(empty($offer->state)) State @else {{ $offer->state }} @endif</span>
                                            </span>
                        <span type="button" class="btn-sm btn-info">
                                                Kod pocztowy <span id="postcode_s" class="badge bg-info">@if(empty($offer->postcode)) XX-XXX @else {{ $offer->postcode }} @endif</span>
                                            </span>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Wybierz miasto...</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul id="resultList">
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"data-dismiss="modal">Save changes</button>
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
                        <label for="zip-code">{{ $forms['name']['title'] }}</label>
                        <input type="text" class="form-control" id="name" name="name" onkeyup="tranSlug()" value="{{ $offer->name }}">
                    </div>
                @endif
            <!-- Slug -->
                @if(array_key_exists('slug', $forms))
                    <div class="form-group">
                        <label for="zip-code">{{ $forms['slug']['title'] }}</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $offer->slug }}" disabled>
                    </div>
                @endif

                <div class="form-row">
                    <!-- Cena wystawienia -->
                    @if(array_key_exists('regular_rent', $forms))
                        <div class="form-group col-md-6">
                            <label for="zip-code">{{ $forms['regular_rent']['title'] }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Amount (to the nearest pln)" placeholder="Addon on both side" name="regular_rent" value="{{ $offer->regular_rent }}">
                                <span class="input-group-text">PLN</span>
                            </div>
                        </div>
                    @endif
                <!-- Kaucja -->
                    @if(array_key_exists('deposit', $forms))
                        <div class="form-group col-md-6">
                            <label for="zip-code">{{ $forms['deposit']['title'] }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Amount (to the nearest pln)" placeholder="Addon on both side" name="deposit" value="{{ $offer->deposit }}">
                                <span class="input-group-text">PLN</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-row">
                    <!-- Pokoje -->
                    @if(array_key_exists('rooms', $forms))
                        <div class="form-group col-md-4">
                            <label for="zip-code">{{ $forms['rooms']['title'] }}</label>
                            <div class="input-group text-center mb-3 rooms" style="width:130px;">
                                <span class="input-group-text decrement-btn">-</span>
                                <input type="text" class="form-control text-center" name="rooms" value="@if(empty($offer->rooms))0
@else{{ $offer->rooms }}@endif">
                                <span class="input-group-text increment-btn">+</span>
                            </div>
                        </div>
                    @endif
                <!-- Powierzchnia m2 -->
                    @if(array_key_exists('surface', $forms))
                        <div class="form-group col-md-4">
                            <label for="zip-code">{{ $forms['surface']['title'] }}</label>
                            <div class="input-group text-center mb-3 rooms" style="width:130px;">
                                <span class="input-group-text decrement-btn">-</span>
                                <input type="text" class="form-control text-center" name="surface" value="@if(empty($offer->surface))0
@else{{ $offer->surface }}@endif">
                                <span class="input-group-text increment-btn">+</span>
                            </div>
                        </div>
                    @endif
                <!-- Działka -->
                    @if(array_key_exists('land_area', $forms))
                        <div class="form-group col-md-4">
                            <label for="zip-code">{{ $forms['land_area']['title'] }}</label>
                            <div class="input-group text-center mb-3 rooms" style="width:130px;">
                                <span class="input-group-text decrement-btn">-</span>
                                <input type="text" class="form-control text-center" name="land_area" value="@if(empty($offer->land_area))0
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
                                <h3 class="sbold">Drop files here to upload</h3>
                                <span>You can also click to open file browser</span>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Select the main photo:</h3>
                            </div>
                            <div class="panel-body" id="uploaded_image">

                            </div>
                        </div>
                    </div>
                @endif


            <!-- Opis -->
                <h3>{{ __('Detailed information') }}</h3>
                <hr>
                @if(array_key_exists('description', $forms))
                    <div class="form-group">
                        <label for="zip-code">{{ $forms['description']['title'] }}</label>
                        <textarea class="form-control" id="exampleFormControlTextarea3" rows="7" name="description">{{ $offer->description }}</textarea>
                    </div>
                @endif
            <!-- Krótki opis -->
                @if(array_key_exists('short_description', $forms))
                    <div class="form-group">
                        <label for="zip-code">{{ $forms['short_description']['title'] }}</label>
                        <input type="text" class="form-control" id="short_description" name="short_description" value="{{ $offer->short_description }}">
                    </div>
                @endif

            <!-- Ogrzewanie -->
                @if(array_key_exists('heating', $forms))
                    <h3>{{ $forms['heating']['title'] }}</h3>
                    <hr>
                    <div class="form-row">
                        @foreach($forms['heating']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="material[{{ $item->name }}]" name="heating[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['heating']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="material[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Media -->
                @if(array_key_exists('media', $forms))
                    <h3>{{ $forms['media']['title'] }}</h3>
                    <hr>
                    <div class="form-row">
                        @foreach($forms['media']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="material[{{ $item->name }}]" name="media[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['media']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="material[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Zabezpieczenia -->
                @if(array_key_exists('security', $forms))
                    <h3>{{ $forms['security']['title'] }}</h3>
                    <hr>
                    <div class="form-row">
                        @foreach($forms['security']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="material[{{ $item->name }}]" name="security[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['security']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="material[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Opłaty -->
                @if(array_key_exists('charges', $forms))
                    <h3>{{ $forms['charges']['title'] }}</h3>
                    <hr>
                    <div class="form-row">
                        @foreach($forms['charges']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="material[{{ $item->name }}]" name="charges[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['charges']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="material[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Wyposażenie -->
                @if(array_key_exists('equipment', $forms))
                    <h3>{{ $forms['equipment']['title'] }}</h3>
                    <hr>
                    <div class="form-row">
                        @foreach($forms['equipment']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="material[{{ $item->name }}]" name="equipment[{{ $item->name }}]" value="{{ $item->id }}"
                                        {{ in_array($item->id, $forms['equipment']['active'])
                                                            ? 'checked'
                                                            : '' }}>
                                    <label class="form-check-label" for="material[{{ $item->name }}]">{{ $item->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            <!-- Miejsce parkingowe -->
                @if(array_key_exists('parking', $forms))
                    <h3>{{ $forms['parking']['title'] }}</h3>
                    <hr>
                    <div class="form-row">
                        @foreach($forms['parking']['items'] as $item)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="material[{{ $item->name }}]" name="parking[{{ $item->name }}]" value="{{ $item->id }}"
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
                        <label for="first-name">{{ $forms['payment']['title'] }}</label>
                        <select name="payment" id="payment_id" class="form-control" style="width: 100%">
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
                        <label for="first-name">{{ $forms['typeoffer']['title'] }}</label>
                        <select name="typeoffer" id="payment_id" class="form-control" style="width: 100%">
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
                    <div class="form-row">

                    @if(array_key_exists('contact_tel', $forms))
                        <!-- Kontakt telefoniczny -->
                            <div class="form-group col-md-6">
                                <label for="zip-code">{{ $forms['contact_tel']['title'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">+48</span>
                                    <input id="phone-mask" type="tel" class="form-control" aria-label="Phone number" placeholder="Enter a phone number" name="contact_tel" value="{{ $offer->contact_tel }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}">
                                </div>
                            </div>
                    @endif

                    @if(array_key_exists('contact_email', $forms))
                        <!-- contact_email -->
                            <div class="form-group col-md-6">
                                <label for="zip-code">{{ $forms['contact_email']['title'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="email" class="form-control" aria-label="Adress eMail" placeholder="Enter a adress eMail" name="contact_email" value="{{ $offer->contact_email }}">
                                </div>
                            </div>
                        @endif
                    </div>
            @endif

            <!-- Submit button -->
                <button name="butt" value="add" class="btn btn-transparent">{{ __('Add') }}</button>
                <button name="butt" value="save" class="btn btn-transparent">{{ __('Save') }}</button>


            </form>
        </div>
    </div>

@endsection

@section('scripts')
@endsection
