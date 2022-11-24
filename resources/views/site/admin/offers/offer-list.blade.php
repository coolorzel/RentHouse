@extends('layouts.app')

@section('title', __('Offers list'))

@section('menu')

    <!-- Breadcrumb -->
    <div class="col-md-12 shadow p-2 mb-3 bg-body rounded d-flex">
        <button type="button" class="btn btn-outline-secondary" onclick="javascript:history.back()"><i class="fa fa-arrow-left"></i></button>
        <button class="btn btn-outline-secondary">{{ __('ACP') }}</button>
        <button class="btn btn-outline-secondary active">{{ __('Offers list') }}</button>
    </div>
    <span class="text-secondary" style="position: relative;top: -28px;left: 18px;">{{ __('A list of all user offers is displayed. Here we approve new applications and edit the old ones. We search, etc.') }}</span>
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
                    <h2 class="h3 mb-4 page-title">{{ __('Offers list') }}</h2>
                    <table class="table table-striped" id="table1">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('User eMail') }}</th>
                            <th>{{ __('Title offer') }}</th>
                            <th>{{ __('Type offer') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Operation') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($offers as $offer)
                            <tr class="
                                @if($offer->isDeactive == true)
                                    table-danger
                                @endif
                                ">
                                <td>{{ $offer->id }}</td>
                                <td><a class="btn btn-outline-white" href="{{ route('viewUserProfile', $offer->u_id) }}">{{ $offer->user->email }}</a></td>
                                <td>{{ $offer->name }}</td>
                                <td>
                                    <ul class="list-group list-group-flush">
                                        @if($offer->billingAccount->company == true)
                                            <li>
                                                <i class="fa fa-building-o"></i> {{ __('Company') }}
                                            </li>
                                            <li>{{ $offer->billingAccount->company_name }}</li>
                                        @else
                                            <li><i class="fa fa-user-secret"></i> {{ __('Private') }}</li>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    {{ $offer->created_at }}
                                </td>
                                <td>
                                    @if($offer->archivum == false)
                                        @if($offer->isDeactive == false)
                                            @if($offer->isAcceptMod == true)
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
                                    <a href="@if($offer->slug) {{ route('offerShow', [$offer->category->slug, $offer->id, $offer->slug]) }} @endif" class="btn btn-warning">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
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
