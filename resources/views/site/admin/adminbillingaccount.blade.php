@extends('layouts.app')

@section('title', __('Billing account list'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Billing Accounts') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('A list of all user billing accounts is displayed. Here we approve new applications and edit the old ones. We search, etc.') }}</span>
    <!-- /Breadcrumb -->

@endsection

@section('content')
    <div class="row gutters-sm">
        <div class="col-md-3 mb-3 shadow p-3 mb-5 bg-body rounded">
            @include('layouts.elements.admin.sidebar')
        </div>
        <div class="col-md-9 shadow p-3 mb-5 bg-body rounded">
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="h3 mb-4 page-title">{{ __('Billing account list') }}</h2>
                    <table class="table table-striped" id="table1">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('User eMail') }}</th>
                            <th>{{ __('Type billing account') }}</th>
                            <th>{{ __('Count offers') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Operation') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($billings as $billing)
                            <tr class="
                                @if($billing->destroy == false)
                                    @if($billing->message->displayed == false && $billing->message->sender > 0)
                                    table-primary
                                    @endif
                                @else
                                    table-danger
                                @endif
                                ">
                                <td>{{ $billing->id }}</td>
                                <td><a class="btn btn-outline-white" href="{{ route('viewUserProfile', $billing->user->id) }}">{{ $billing->user->email }}</a></td>
                                <td>
                                    <ul class="list-group list-group-flush">
                                        @if($billing->company == true)
                                            <li>
                                                <i class="fa fa-building-o"></i> {{ __('Company') }}
                                            </li>
                                            <li>{{ $billing->company_name }}</li>
                                        @else
                                            <li><i class="fa fa-user-secret"></i> {{ __('Private') }}</li>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    {{ $billing->created_at }}
                                </td>
                                <td>
                                    @if($billing->destroy == false)
                                        @if($billing->rejected == false)
                                            @if($billing->verified == true)
                                                <i class="fa fa-check-circle-o fa-2x text-success"></i>
                                            @else
                                                <i class="fa fa-spinner fa-2x text-warning"></i>
                                            @endif
                                        @else
                                            <i class="fa fa-times-circle-o fa-2x text-danger"></i>
                                        @endif
                                    @else
                                        <i class="fa fa-trash-o fa-2x text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    <button id="view-profile" type="button" class="btn btn-outline-success btn-floating" data-info="{{ $billing->id }}" data-route="{{ route('adminMoreInfoBillingAccount', $billing->id) }}" data-mdb-toggle="modal" data-mdb-target="#modalMoreInfoBillingAccount" data-mdb-ripple-color="dark" data-bs-html="true" data-bs-toogle="tooltip" title="<em>{{ __('More information for verification and approval.') }}<em>">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scrollable modal -->
    <div class="modal fade" id="modalMoreInfoBillingAccount" tabindex="-1" aria-labelledby="modalMoreInfoBillingAccountLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header ftco-degree-bg mb-2 d-flex">
                    <h5 class="modal-title p-2 w-75" id="userEmail">{{ __('User is Billing account') }} <a href="#" id="userProfileLink" class="text-bg-light">###</a></h5>
                    <div class="p-2 flex-shrink-1">{{ __('Created at') }}: <span class="text-secondary" id="dataCreated">###</span> {{ __('ago.') }}</div>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-md-0">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-warning text-center"><strong>{{ __('Billing account information') }}</strong></h5>
                                <div class="container mt-4">
                                    <div class="row" id="dataInfo">
                                        <div class="col-sm-12">
                                            <strong>{{ __('Company') }}:</strong> <span class="font-italic" id="company">###</span>
                                        </div>
                                        <div id="companyData" class="col-sm-12 visually-hidden">
                                            <div class="col-sm-12">
                                                <strong>{{ __('Company name') }}:</strong> <span class="font-italic" id="company_name">###</span>
                                            </div>
                                            <div class="col-sm-12">
                                                <strong>{{ __('Company nip') }}:</strong> <span class="font-italic" id="company_nip">###</span>
                                            </div>
                                            <div class="col-sm-12">
                                                <strong>{{ __('Company regon') }}:</strong> <span class="font-italic" id="company_regon">###</span>
                                            </div>
                                            <div class="col-sm-12">
                                                <strong>{{ __('Company website') }}:</strong> <a href="#" class="font-italic" id="company_website">###</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('First name') }}:</strong> <span class="font-italic" id="firstName">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Last name') }}:</strong> <span class="font-italic" id="lastName">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Pesel') }}:</strong> <span class="font-italic" id="pesel">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Phone number') }}:</strong>
                                            <span class="font-italic" id="phone_number">
                                                <ul id="numberList" class="list-group list-group-flush">
                                                  <li class="list-group-item">###</li>
                                                </ul>
                                            </span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Country') }}:</strong> <span class="font-italic" id="country">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Province') }}:</strong> <span class="font-italic" id="province">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('City') }}:</strong> <span class="font-italic" id="city">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Street') }}:</strong> <span class="font-italic" id="street">###</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <strong>{{ __('Building number') }}:</strong> <span class="font-italic" id="building_number">###</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div id="action" data-info="#" class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                                        <button type="button" class="btn btn-outline-dark" data-info="accept" id="accept">
                                                {{ __('Accept') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-dark" data-info="reject" id="reject">
                                                {{ __('Reject') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-dark" data-info="delete" id="delete">
                                                {{ __('Delete') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col text-center">
                                <h5 class="text-warning"><strong>{{ __('Message') }}</strong></h5>
                                <div class="container mt-4">
                                    <div class="card mx-auto" style="max-width:400px">
                                        <div class="card-header bg-transparent">
                                            <div class="navbar navbar-expand p-0">
                                                <ul class="navbar-nav me-auto align-items-center">
                                                    <li class="nav-item">
                                                        <a href="" class="nav-link" id="viewUserProfile">
                                                            <div class="position-relative"
                                                                 style="width:50px; height: 50px; border-radius: 50%; border: 2px solid #e84118; padding: 2px">
                                                                <img id="userAvatar" src="https://nextbootstrap.netlify.app/assets/images/profiles/1.jpg"
                                                                     class="img-fluid rounded-circle" alt="">
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="" class="nav-link" id="userName">Nelh</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="messagess" class="card-body p-4" style="height: 500px; overflow: auto;">

                                            <div class="d-flex align-items-baseline mb-4">
                                                <div class="position-relative avatar">
                                                    <img src="https://nextbootstrap.netlify.app/assets/images/profiles/1.jpg"
                                                         class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                </div>
                                                <div class="pe-2">
                                                    <div>
                                                        <div class="card card-text d-inline-block p-2 px-3 m-1">Hi helh, are you available to chat?
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="small">01:10PM</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                                                <div class="pe-2">
                                                    <div>
                                                        <div class="card card-text d-inline-block p-2 px-3 m-1">Sure</div>
                                                    </div>
                                                    <div>
                                                        <div class="card card-text d-inline-block p-2 px-3 m-1">Let me know when you're available?
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="small">01:13PM</div>
                                                    </div>
                                                </div>
                                                <div class="position-relative avatar">
                                                    <img src="https://nextbootstrap.netlify.app/assets/images/profiles/2.jpg"
                                                         class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                    <span
                                                        class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-baseline mb-4">
                                                <div class="position-relative avatar">
                                                    <img src="https://nextbootstrap.netlify.app/assets/images/profiles/1.jpg"
                                                         class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                    <span
                                                        class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                                                </div>
                                                <div class="pe-2">
                                                    <div>
                                                        <div class="card card-text d-inline-block p-2 px-3 m-1">3:00pm??</div>
                                                    </div>
                                                    <div>
                                                        <div class="small">Edited - 01:13PM</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                                                <div class="pe-2">
                                                    <div>
                                                        <div class="card card-text d-inline-block p-2 px-3 m-1">Cool</div>
                                                    </div>
                                                    <div>
                                                        <div class="card card-text p-2 px-3 m-1 mb-5">
                                                            <div class="row align-items-center">
                                                                <div class="col-1">
                                                                    <a href=""><i class="fas fa-play"></i></a>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="progress" style="width:100px; height: 4px;">
                                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 35%"
                                                                             aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="small fw-bold">0:34</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="position-relative avatar">
                                                    <img src="https://nextbootstrap.netlify.app/assets/images/profiles/2.jpg"
                                                         class="img-fluid rounded-circle" alt="" style="height: 40px;width:40px;">
                                                    <span
                                                        class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                                                </div>
                                            </div>

                                        </div>
                                        <form action="{{ route('sendResponseBillingAccount') }}" method="post" id="sendMessage">
                                            <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                                                <div class="input-group">
                                                    <input type="text" name="message" class="form-control border-0" required placeholder="{{ __('Write a message...') }}">
                                                    <div class="input-group-text bg-transparent border-0">
                                                        <button type="submit" class="btn btn-outline-warning" id="submitMessage" data-info="">
                                                            <i class="fa fa-send-o"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function (){
            $('#sendMessage').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url:$(this).attr('action'),
                    method:$(this).attr('method'),
                    data: {data:$('#submitMessage').data('info'), message:$('#sendMessage input').val()},
                    success:
                        function(data) {
                        if(data.status === 0){
                            Toastify({
                                text: data.msg, // "This is a toast",
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
                        }else{
                            $('#sendMessage')[0].reset();
                            var create_at = new Date(data.create);
                            $('#messagess').append("<div class=\"d-flex align-items-baseline text-end justify-content-end mb-4\">" +
                                "<div class=\"pe-2\">" +
                                "<div>" +
                                "<div class=\"card card-text d-inline-block p-2 px-3 m-1\">" + data.message +
                                "</div>" +
                                "</div>" +
                                "<div>" +
                                "<div class=\"small\">" + create_at.getFullYear() +
                                "-" +
                                create_at.getMonth() + "-" + create_at.getDay() + "</div>" +
                                "</div>" +
                                "</div>" +
                                "<div class=\"position-relative avatar\">" +
                                "<img id=\"avatar_message\" src=\"" + data.admin_avatar + "\"" +
                                "class=\"img-fluid rounded-circle\" alt=\"\" style=\"height: 40px;width:40px;\">" +
                                "</div>" +
                                "</div>");
                        }
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#action button').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                $.ajax({
                    url:$('#action').data('info'),
                    method:'POST',
                    data: {data:$(this).data('info')},
                    success:
                        function (data){
                        btn.html(data.button);
                            Swal.fire({
                                title: data.title,
                                text: data.msg,
                                type: data.type
                            }).then(function(){
                                location.reload();
                            });
                    }
                });
            });
        });

        $(document).ready(function(){
            $('button').tooltip();
            $('#modalMoreInfoBillingAccount').on('show.bs.modal', function(e) {
                let btn = $(e.relatedTarget);
                let url = btn.data('route');

                $.ajax({
                    url:url,
                    method:'POST',
                    data: {data:btn.data('info')},
                    beforeSend:function (){
                        $('#numberList').text('');
                        $('#messagess').text('');
                    },
                    success:
                        function (data) {
                            $.each(data.messages, function (prefix, val) {
                                if (!val['message']){
                                    val['message'] = 'No message';
                                }
                                if (val['created_at']){
                                    var created_date = new Date(val['created_at']);
                                }
                                if (val['sender'] === data.user_id){
                                    $('#messagess').append("<div class=\"d-flex align-items-baseline mb-4\">" +
                                        "<div class=\"position-relative avatar\">" +
                                            "<img id=\"avatar_message\" src=\"" + data.user_avatar + "\"" +
                                                 "class=\"img-fluid rounded-circle\" alt=\"\" style=\"height: 40px;width:40px;\">" +
                                        "</div>" +
                                        "<div class=\"pe-2\">" +
                                            "<div>" +
                                                "<div class=\"card card-text d-inline-block p-2 px-3 m-1\">" + val['message'] +
                                                "</div>" +
                                            "</div>" +
                                            "<div>" +
                                                "<div class=\"small\">" + created_date.getFullYear() +
                                                "-" +
                                                created_date.getMonth() + "-" + created_date.getDay() + "</div>" +
                                            "</div>" +
                                        "</div>" +
                                    "</div>");
                                }else{
                                    $('#messagess').append("<div class=\"d-flex align-items-baseline text-end justify-content-end mb-4\">" +
                                        "<div class=\"pe-2\">" +
                                        "<div>" +
                                        "<div class=\"card card-text d-inline-block p-2 px-3 m-1\">" + val['message'] +
                                        "</div>" +
                                        "</div>" +
                                        "<div>" +
                                        "<div class=\"small\">" + created_date.getFullYear() +
                                        "-" +
                                        created_date.getMonth() + "-" + created_date.getDay() + "</div>" +
                                        "</div>" +
                                        "</div>" +
                                        "<div class=\"position-relative avatar\">" +
                                        "<img id=\"avatar_message\" src=\"" + data.admin_avatar + "\"" +
                                        "class=\"img-fluid rounded-circle\" alt=\"\" style=\"height: 40px;width:40px;\">" +
                                        "</div>" +
                                        "</div>");
                                }
                            });

                            $.each(data.phone_number, function (val) {
                            $('#numberList').append("<li class=\"list-group-item\">" + val['name'] + "</li>");
                            });

                            const dateNow = Date.now(); // ustawienie daty za pomocą tekstu (miesiąc/dzień/rok)
                            var dateCreated = new Date(data.created_at);
                            var created_at = new Date(Math.abs(dateNow - dateCreated.getTime()));
                            var dateCreatedAt = '';
                            if ((created_at.getFullYear() - 1970) > 0){
                                dateCreatedAt = (created_at.getFullYear() - 1970) + " " + data.year
                                    + " " + created_at.getMonth() + " " + data.month
                                    + " " + created_at.getDate() + " " + data.day
                                    + " " + created_at.getHours() + " " + data.hour
                                    + " " + created_at.getMinutes() + " " + data.minute
                                    + " " + created_at.getSeconds() + " " + data.second;
                            }else{
                                if (created_at.getMonth() > 0){
                                    dateCreatedAt = created_at.getMonth() + " " + data.month
                                        + " " + created_at.getDate() + " " + data.day
                                        + " " + created_at.getHours() + " " + data.hour
                                        + " " + created_at.getMinutes() + " " + data.minute
                                        + " " + created_at.getSeconds() + " " + data.second;
                                }else{
                                    if (created_at.getDate() > 0){
                                        dateCreatedAt = created_at.getDate() + " " + data.day
                                            + " " + created_at.getHours() + " " + data.hour
                                            + " " + created_at.getMinutes() + " " + data.minute
                                            + " " + created_at.getSeconds() + " " + data.second;
                                    }else {
                                        if (created_at.getHours() > 0){
                                            dateCreatedAt = created_at.getHours() + " " + data.hour
                                                + " " + created_at.getMinutes() + " " + data.minute
                                                + " " + created_at.getSeconds() + " " + data.second;
                                        }else {
                                            if (created_at.getMinutes() > 0){
                                                dateCreatedAt = created_at.getMinutes() + " " + data.minute
                                                    + " " + created_at.getSeconds() + " " + data.second;
                                            }else {
                                                if (created_at.getSeconds() > 0){
                                                    dateCreatedAt = created_at.getSeconds() + " " + data.second;
                                                }else {
                                                    dateCreatedAt = 'Error';
                                                }
                                            }
                                        }

                                    }
                                }
                            }
                            if (data.type_company === 1){
                                $('#companyData').removeClass('visually-hidden');
                            }else{
                                $('#companyData').addClass('visually-hidden');
                            }
                            $('#userName').text(data.name +" "+ data.lname).attr('href', data.user_route);
                            $('#userProfileLink').text(data.user_email).attr('href', data.user_route);
                            $('#viewUserProfile').attr('href', data.user_route);
                            $('#firstName').text(data.name);
                            $('#lastName').text(data.lname);
                            $('#dataCreated').text(dateCreatedAt);
                            $('#company').text(data.company)
                            $('#company_name').text(data.company_name);
                            $('#company_nip').text(data.company_nip);
                            $('#company_regon').text(data.company_regon);
                            $('#company_website').text(data.company_website).attr('href', 'http://'+data.company_website);
                            $('#pesel').text(data.pesel);
                            $('#country').text(data.country);
                            $('#province').text(data.province);
                            $('#city').text(data.city);
                            $('#street').text(data.street);
                            $('#building_number').text(data.building_number);
                            $('#action').attr('data-info', data.action_route);
                            $('#submitMessage').attr('data-info', data.id);
                            $('#accept').text(data.btn_accept);
                            $('#reject').text(data.btn_reject);
                            $('#delete').text(data.btn_delete);

                            $('#userAvatar').attr('src', data.user_avatar);
                        }
                });
            });
        });
    </script>
@endsection
