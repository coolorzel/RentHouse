@extends('layouts.app')

@section('title', __('My profile'))

@section('content')
    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
                <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
                    <p class="h2 text-secondary align-self-center">{{ __('My profile') }}</p>
                </div>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3 shadow p-3 mb-5 bg-body rounded">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div style="position:relative;display:inline-block;text-align:center;">
                                    <div class="user-img d-flex align-items-center">
                                        @if (Auth::check() && Auth::user()->avatar)
                                            <img src="{{ asset('assets/uploads/users/'.Auth::id().'/avatar/'.Auth::user()->avatar) }}" alt="avatar" class="rounded-circle" width="150" height="150">
                                        @else
                                            <img src="{{ asset('project/img/default_avatar.png') }}" alt="default_avatar" class="rounded-circle" width="150" height="150">
                                        @endif
                                    </div>
                                    @if (Auth::check() && Auth::user()->avatar)
                                    <button type="button" class="btn btn-danger btn-floating" style="position: absolute;top: 5px;left: 5px;" data-mdb-toggle="modal" data-mdb-target="#deleteAvatarModal">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                        <div class="modal fade" id="deleteAvatarModal" tabindex="-1" aria-labelledby="deleteAvatarModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="userAvatarDelete" method="post" action="{{ route('myAvatarDelete') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="delete" value="true">
                                                        <div class="modal-header">
                                                            {{ __('Delete your avatar.') }}
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to remove the avatar and set the default one?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-mdb-dismiss="modal">
                                                                {{ __('Cancle') }}</button>
                                                            <button type="submit" name="delete" value="true" class="btn btn-danger btn-ok">{{ __('Delete') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-info btn-floating" style="position: absolute; top: 5px; right: 5px;" data-mdb-toggle="modal" data-mdb-target="#changeAvatarModal">
                                        <i class="fa fa-magic"></i>
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="changeAvatarModal" tabindex="-1" aria-labelledby="changeAvatarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeAvatarModalLabel">{{ __('Change avatar') }}</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3 class="jumbotron">{{ __('Add a new avatar to your profile.') }}</h3>
                                                <form method="post" action="{{ route('myAvatarUpdate') }}" enctype="multipart/form-data">
                                                    <div class="dropzone" id="changeAvatarDropzone"></div>
                                                    @csrf
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                                                    {{ __('Close') }}</button>
                                                <button type="button" class="btn btn-primary" id="buttonChangeAvatar">
                                                    {{ __('Save changes') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h4>{{ Auth::user()->name }} {{ Auth::user()->lname }}</h4>
                                    <p class="text-secondary mb-1">{{ strtoupper(Auth::user()->roles->first()->name) }}</p>
                                    <p class="text-muted font-size-sm">{{ Auth::user()->province }} {{ Auth::user()->city }} {{ Auth::user()->street }} {{ Auth::user()->number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    {{ __('Website') }}</h6>
                                <span class="text-secondary"><a href="{{ Auth::user()->website }}">{{ Auth::user()->website }}</a></span>
                                <button type="button" class="btn-sm btn-info btn-floating" style="position: absolute;/* top: 2px; */right: -20px;" data-mdb-toggle="modal" data-mdb-target="#changeAvatarModal">
                                    <i class="fa fa-magic"></i>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                                <span class="text-secondary">@bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <button type="button" class="btn btn-outline-info btn-rounded" style="position: absolute; top: -15px; left: -15px;">Add new link</button>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 shadow p-3 mb-5 bg-body rounded">
                    <form method="post" enctype="multipart/form-data" action="{{ route('myProfileUpdate') }}" id="UserProfileInfoForm">
                        @csrf
                        @method('POST')
                    <div class="card mb-3" id="editData">


                        <span class="alert alert-warning text-danger error-text" style="display:none;" id="errors"><ul id="errors-list"></ul></span>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Name and last name') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group">
                                        <input type="text" readonly name="name" aria-label="First name" class="form-control-sm text-secondary form-control-plaintext" style="width: 50%;" value="{{ $user->name }}">
                                        <input type="text" readonly name="lname" aria-label="Last name" class="form-control-sm text-secondary form-control-plaintext" style="width: 50%;" value="{{ $user->lname }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Email') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="email" readonly class="form-control-plaintext form-control-sm text-secondary" id="editData email" name="email" value="{{ $user->email }}" placeholder="login@domain.com" disabled>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Username') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm text-secondary" id="editData username" name="username" value="{{ $user->username }}" placeholder="{{ __('Nickname') }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Phone') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="tel" readonly class="form-control-plaintext form-control-sm text-secondary phone" id="editData phone_number" name="phone_number" value="{{ $user->phone_number }}" placeholder="583 - 932 - 930">
                                    <span class="text-danger error-text phone_number_error"></span>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('Address') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-2">
                                        <input name="country" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistCountryOptions" id="exampleDataList editData" placeholder="{{ __('Country') }}" style="width:50%" value="{{ $user->country }}" disabled>
                                        <input name="province" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistProvinceOptions" id="exampleDataList editData" placeholder="{{ __('Province') }}" value="{{ $user->province }}" style="width:50%">
                                    </div>
                                    <div class="input-group">
                                        <input name="zipcode" readonly class="form-control-plaintext form-control-sm text-secondary zipcode" list="datalistZipcodeOptions" id="exampleDataList editData zipcode" placeholder="{{ __('Zip-Code') }}" value="{{ $user->zipcode }}" style="width:20%">
                                        <input name="city" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistCityOptions" id="exampleDataList editData" placeholder="{{ __('City') }}" value="{{ $user->city }}" style="width:30%">
                                        <input name="street" readonly class="form-control-plaintext form-control-sm text-secondary" list="datalistStreetOptions" id="exampleDataList editData" placeholder="{{ __('Street') }}" value="{{ $user->street }}" style="width:30%">
                                        <input name="number" readonly class="form-control-plaintext form-control-sm text-secondary number" list="datalistNumberOptions" id="exampleDataList editData" placeholder="{{ __('Number') }}" value="{{ $user->number }}" style="width:20%">
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-info" id="editButtonSelect" target="__blank" href="#" onclick="editButtonData()" type="button">Edit</button>
                                    <button class="btn btn-primary" id="cancelButtonSelect" target="__blank" href="#" onclick="cancelButtonData()" style="display:none;" type="button">Cancel</button>
                                    <button class="btn btn-success" id="saveButtonSelect" target="__blank" href="#" style="display:none;" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="card mb-3" id="editData">
                        <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>1</td>
                                <td>nazwa</td>
                                <td>
                                    OPERATION
                                </td>
                            </tr>


                            </tbody>
                        </table>
                        </div>
                    </div>

                    <div class="card chart-container">
                        <canvas id="chart"></canvas>
                    </div>

                    <div class="row gutters-sm">
                        <div class="col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                    <small>Web Design</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Website Markup</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>One Page</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Mobile Template</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Backend API</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                    <small>Web Design</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Website Markup</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>One Page</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Mobile Template</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>Backend API</small>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>



@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function (){

            $('#userAvatarDelete').on('submit', function(e){
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
                                $('#errors').show();

                                $.each(data.error, function (prefix, val) {
                                    $('#errors-list').append("<li>" + val[0] + "</li>");
                                });
                            } else {

                                $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload();
                                });
                            }
                        }
                });
            });

        });

        $(function (){

            $('#UserProfileInfoForm').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                   url:$(this).attr('action'),
                   method:$(this).attr('method'),
                   data:new FormData(this),
                   processData: false,
                   dataType:'json',
                   contentType:false,
                   beforeSend:function (){
                       $('#errors-list').text('');
                   },
                    success:
                        function(data){
                        if(data.status == 0) {
                           $('#errors').show();

                           $.each(data.error, function (prefix, val) {
                               $('#errors-list').append("<li>" + val[0] + "</li>");
                           });
                       }else{

                            $('#errors').hide();
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.type
                                }).then(function(){
                                    location.reload();
                                });
                           //alert(data.msg);
                           if(data.status == 1){
                               formEdit.forEach((index) => {
                                   const element = document.getElementsByName(index.name)[0];
                                   element.readOnly = true;
                                   element.classList.remove('form-control');
                                   element.classList.add('form-control-plaintext');
                                   element.classList.remove('text-black');
                                   element.classList.add('text-secondary');
                               });
                               document.getElementById('editButtonSelect').style.display = '';
                               document.getElementById('cancelButtonSelect').style.display = 'none';
                               document.getElementById('saveButtonSelect').style.display = 'none';
                               formEdit = [];
                           }
                       }
                    }
                });
            });
        });
    </script>
    <script>

        Dropzone.options.changeAvatarDropzone = {
            url: '{{ route('myAvatarUpdate') }}',
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilesize: 256,
            resizeWidth: 150,
            resizeHeight: 150,
            resizeMethod: "crop",
            maxFiles: 1,
            acceptedFiles: '.png,.jpg,.jpeg',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            name: 'avatarFile',
            init: function () {

                var myDropzone = this;

                // Update selector to match your button
                $("#buttonChangeAvatar").click(function (e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });

                this.on('sending', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    var data = $('#changeAvatarDropzone').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                });
            },
            success:
                function(file, response){
                    if(response.status == 1) {

                        Swal.fire({
                            title: response.title,
                            text: response.msg,
                            type: response.type
                        }).then(function(){
                                location.reload();
                            });
                    }
                }
        }
    </script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    JS
    <script>
        const ctx = document.getElementById("chart").getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["sunday", "monday", "tuesday",
                    "wednesday", "thursday", "friday", "saturday"],
                datasets: [{
                    label: 'Last week',
                    backgroundColor: 'rgba(161, 198, 247, 1)',
                    borderColor: 'rgb(47, 128, 237)',
                    data: [3000, 4000, 2000, 5000, 8000, 9000, 2000],
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            },
        });
    </script>
@endsection
