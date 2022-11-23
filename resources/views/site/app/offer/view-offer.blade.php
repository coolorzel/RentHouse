@extends('layouts.app')

@section('title', __('Create new offer'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary disabled">{{ __('View') }}</button>
        <button class="btn btn-outline-secondary">{{ $offer->category->name }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Offer nr:') }} {{ $offer->id }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('Create new offer.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')

    <section class="section bg-gray">
        <!-- Container Start -->
        <div class="container">
            <div class="row gutters-sm">
                <!-- Left sidebar -->
                <div class="col-md-8 shadow p-3 bg-body rounded">
                    <div class="product-details">
                        <h1 class="product-title">{{ $offer->name }}</h1>
                        <div class="product-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-user-o"></i>{{ __('From') }}: <a href="{{ route('viewUserProfile', $offer->user->id) }}">{{ $offer->user->email }}</a></li>
                                <li class="list-inline-item"><i class="fa fa-folder-open-o"></i>{{ __('Category') }} <a href="{{ route('searchInCategory', $category->slug) }}">{{ $category->name }}</a></li>
                                <li class="list-inline-item"><i class="fa fa-location-arrow"></i>{{ __('Location') }} <a href="#">{{ $offer->city }} / {{ $offer->postcode }}</a></li>
                            </ul>
                        </div>

                        <!--uct slider -->
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                            <div class="carousel-indicators bg-dark rounded-9 bg-opacity-10">
                                @foreach($offer->images as $key => $item)
                                    @if($item->id == $offer->images_id)
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" class="active" aria-current="true" aria-label="Slide {{$item->id}}"></button>
                                    @else
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" aria-label="Slide {{$item->id}}"></button>
                                    @endif
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded-6 bg-warning border border-5 border-warning border-opacity-25">

                                @foreach($offer->images as $item)
                                    @if($item->id == $offer->images_id)
                                        <div class="carousel-item active" data-image="{{ asset('images/'.$offer->id.'/'.$offer->cat_id.'/'.$item->name) }}">
                                            <img src="{{ asset('images/'.$offer->id.'/'.$offer->cat_id.'/'.$item->name) }}" class="d-block w-100" style="height: 350px;" alt="{{ $item->alt }}"/>
                                        </div>
                                    @else
                                        <div class="carousel-item" data-image="{{ asset('images/'.$offer->id.'/'.$offer->cat_id.'/'.$item->name) }}">
                                            <img src="{{ asset('images/'.$offer->id.'/'.$offer->cat_id.'/'.$item->name) }}" class="d-block w-100" style="height: 350px;" alt="{{ $item->alt }}"/>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <i class="fa fa-chevron-circle-left fa-2x text-warning"></i>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <i class="fa fa-chevron-circle-right fa-2x text-warning"></i>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <!-- product slider -->

                        <div class="content mt-5 pt-5">
                            <ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                                       aria-selected="true">{{ __('Descriptions') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile"
                                       aria-selected="false">{{ __('Details') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                   <div class="card mb-3">
                                       <div class="card-body">
                                            <div class="card-header">
                                                <h3>{{ __('Description') }}</h3>
                                            </div>
                                           <p>{{ $offer->description }}</p>
                                       </div>
                                   </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <h3>{{ __('More information') }}</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="row justify-content-md-center">
                                                        <div class="row d-grid gap-2">
                                                            <div class="p-2 col-sm-6 col-md-6 bg-body bg-opacity-10 border-warning border-top border-bottom">
                                                                pytanie 2
                                                            </div>
                                                            <div class="p-2 col-sm-6 col-md-6 bg-body bg-opacity-10 border-warning border-top border-bottom">
                                                                odpowiedz 2
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <h3 class="tab-title">Product Review</h3>
                                    <div class="product-review">
                                        <div class="media">
                                            <!-- Avater -->
                                            <img src="images/user/user-thumb.jpg" alt="avater">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 shadow p-3 bg-body rounded">
                    <div class="sidebar">
                        <div class="widget price text-center">
                            <h4>Cena</h4>
                            <p>$230</p>
                        </div>
                        <!-- User Profile widget -->
                        <div class="widget user text-center">
                            @if ($offer->user->avatar)
                                <img src="{{ asset('assets/uploads/users/'.$offer->user->id.'/avatar/'.$offer->user->avatar) }}" alt="avatar" class="rounded-circle" width="150" height="150">
                            @else
                                <img src="{{ asset('project/img/default_avatar.png') }}" alt="default_avatar" class="rounded-circle" width="150" height="150">
                            @endif
                            <h4><a href="">Jonathon Andrew</a></h4>
                            <p class="member-time">Member Since Jun 27, 2017</p>
                            <a href="">See all ads</a>
                            <ul class="list-inline mt-20">
                                <li class="list-inline-item"><a href="" class="btn btn-contact d-inline-block  btn-primary px-lg-5 my-1 px-md-3">Contact</a></li>
                                <li class="list-inline-item"><a href="" class="btn btn-offer d-inline-block btn-primary ml-n1 my-1 px-lg-4 px-md-3">Make an
                                        offer</a></li>
                            </ul>
                        </div>
                        <!-- Map Widget -->
                        <div class="widget map">
                            <div class="map">
                                <div id="map_canvas" data-latitude="51.507351" data-longitude="-0.127758"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- Container End -->
    </section>

@endsection

@section('scripts')
<script>
</script>
@endsection
