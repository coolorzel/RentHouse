@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="searching">
        <div class="container">
            <div class="row py-5">
                <h3 class="col-md-12 p-2 text-center text-secondary">Znajdź dom dla siebie</h3>
                <form class="row col-md-8 mx-auto py-3 bg-light justify-content-between">
                    <input class="form-control col-md-7 my-1" type="text" placeholder="Nazwa">
                    <input class="form-control col-md-4 my-1" type="text" placeholder="Miasto lub województwo">
                    <select class="form-control col-md-4 px-0 my-1 form-select">
                        <option value="" disabled selected>Kategoria</option>
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                    </select>
                    <select class="form-control col-md-4 px-0 my-1">
                        <option value="" disabled selected>Zasięg</option>
                        <option>+ 0 km</option>
                        <option>+ 5 km</option>
                        <option>+ 10 km</option>
                        <option>+ 25 km</option>
                        <option>+ 30 km</option>
                        <option>+ 50 km</option>
                    </select>
                    <button class="btn btn-success col-md-3 my-1" type="submit">Szukaj</button>
                </form>
            </div>
        </div>
    </div>
@endsection
