@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="searching">
    <div class="container">
        <div class="row py-5">
            <h3 class="col-md-12 p-2 text-center text-light">Znajdź dom dla siebie</h3>
            <form class="row col-md-8 mx-auto py-3 bg-light justify-content-between">
                <div class="col-lg-12 col-md-12">
                    <input class="form-control my-1" type="text" placeholder="Nazwa">
                </div>
                <div class="col-lg-12 col-md-12">
                    <input class="form-control my-1" type="text" placeholder="Miasto lub województwo">
                </div>
                <div class="col-lg-6 col-md-12">
                    <select class="form-select my-1">
                        <option value="" disabled selected>Kategoria</option>
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                    </select>
                </div>
                <div class="col-lg-6 col-md-12">
                    <select class="form-select my-1">
                        <option value="" disabled selected>Zasięg</option>
                        <option>+ 0 km</option>
                        <option>+ 5 km</option>
                        <option>+ 10 km</option>
                        <option>+ 25 km</option>
                        <option>+ 30 km</option>
                        <option>+ 50 km</option>
                    </select>
                </div>
                
                <div class="col-lg-6 col-md-12 mx-auto">
                    <button class="btn btn-success mt-3 w-100" type="submit">Szukaj</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
