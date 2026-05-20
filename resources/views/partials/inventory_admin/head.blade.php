<head>
    @php
        $logo=asset(Storage::url('logo/'));
    $company_favicon=Utility::getValByName('company_favicon');

    @endphp
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'AccountGo')}} - @yield('page-title')</title>

    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($compa4ny_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <link href="{{ asset('assets/modules/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/modules/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    @stack('css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default .select2-selection--multiple, .select2-container--default .select2-search--dropdown .select2-search__field,
        select,
        textarea,
        input[type="date"],
        input[type="password"],
        input[type="number"],
        input[type="text"]{border-color:#000!important}

        textarea{resize: none}
        table.dataTable td {
            font-size: 15px;
            font-weight:bold
        }
    </style>
</head>
