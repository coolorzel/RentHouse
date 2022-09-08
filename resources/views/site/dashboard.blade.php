@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="searching w-100">
        <div class="container">
            <div class="row py-5">
                <h3 class="col-md-12 p-2 text-center text-secondary text-white">Znajdź dom dla siebie</h3>
                <form class="row col-md-8 mx-auto py-3 bg-light justify-content-between">
                    <div class="col-sm-12 my-1">
                        <input class="form-control" type="text" name="" value="" placeholder="Nazwa">
                    </div>
                    <div class="col-sm-12 my-1">
                        <input class="form-control" type="text" name="" value="" placeholder="Miasto lub województwo">
                    </div>
                    <div class="col-sm-6 my-1">
                        <select class="form-select">
                            <option value="" disabled selected>Kategoria</option>
                            <option>Action</option>
                            <option>Action</option>
                            <option>Action</option>
                            <option>Action</option>
                            <option>Action</option>
                        </select>
                    </div>
                    <div class="col-sm-6 my-1">
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
                    <div class="col-sm-12 my-1">
                        <button class="btn btn-success col-sm-2 float-end" type="submit">Szukaj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
