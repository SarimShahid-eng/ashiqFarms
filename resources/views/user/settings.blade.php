@extends('layouts.admin')
@php
    $profile=asset(Storage::url('avatar/'));
@endphp
@section('page-title')
    {{__('Profile Account')}}
@endsection
@push('css-page')
    <link href="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script-page')
    <script src="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Settings')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Settings')}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Manage Settings')}}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="setting-tab">
                                    <div class="row">

                                        <form action="{{ route('users.background') }}" method="POST" class="ajaxForm mr-3" id="form-1"  enctype="multipart/form-data">
                                            @csrf
                                            <span class="btn btn-primary btn-file">
                                                @if(!empty(Auth::user()->background_image))
                                                    <span class="fileinput-new"> {{__('Change Background')}} </span>
                                                @else
                                                    <span class="fileinput-new"> {{__('Select Background')}} </span>
                                                @endif
                                                <span class="fileinput-exists"> {{__('Image')}} </span>
                                                <input type="hidden">
                                                <input type="file" name="background" id="background">
                                            </span>
                                        </form>
                                        
                                        @if(!empty(Auth::user()->background_image))
                                            <form action="{{ route('users.background.remove') }}" method="POST" class="ajaxForm mr-3">
                                                @csrf
                                                <input type="submit" class="btn btn-danger" value="Remove Background" name="remove" id="remove">
                                            </form>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('script-page')
    <script>
        $('#background').change(function(){
            $("form.ajaxForm").submit();
        });

    </script>
@endpush