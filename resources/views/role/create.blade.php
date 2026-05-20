@extends('layouts.admin')
@php
    $profile=asset(Storage::url('avatar/'));
@endphp
@section('page-title')
    {{__('User')}}
@endsection
@section('content')

<section class="section">


<div class="section-header">
            <h1>{{__('User')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('User')}}</div>
            </div>
        </div>
{{Form::open(array('url'=>route('roles.store'),'method'=>'post','class'=>'ajaxForm'))}}

<div class="row">
    <div class="col-md-12">
        <!-- <div class="form-group">
            {{Form::label('name',__('Name'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name')))}}
            @error('name')
            <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div> -->
        <div class="form-group">
            {{Form::label('name',__('Name'),array('class'=>'')) }}
            {{Form::text('name',@$user->name,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
            @error('name')
            <span class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">

    <div class="form-group">
            {{Form::label('email',__('Email'))}}
            {{Form::text('email',@$user->email,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required',))}}
            <input type="hidden" value="{{@$user->id}}" name="id">
            @error('email')
            <span class="invalid-email" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
    <div class="form-group">
            {{Form::label('password',__('Password'))}}
            {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password')))}}
            @error('password')
            <span class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
        </div>
</div>
<div class="row">
    <div class="col-md-12">
    <div class="form-group">
            {{Form::label('Image',__('Image'))}}
            {{Form::file('avatar',array('class'=>'form-control'))}}
            {{-- {{Form::hidden('old_avatar',@$user->avatar,array('class'=>'form-control'))}} --}}
            @error('avatar')
            <span class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
        </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            @if(!empty($permissions))
                <h6>{{__('Assign Permission to Roles')}} </h6>
                <table class="table table-striped mb-0" id="dataTable-1">
                    <thead>
                    <tr>
                        <th>{{__('Module')}} </th>
                        <th>{{__('Permissions')}} </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                     $modules=['expense income','head','subhead','third subhead','fourth subhead','entries','expense report','banana agreement','accounts','banks','bank branch','users','users banks and branches','users accounts','users accounts report','transaction','dashboard'];

                    @endphp
                    @foreach($modules as $module)
                        <tr>
                            <td>{{ ucfirst($module) }}</td>
                            <td>
                                <div class="row ">
                                    @if(in_array('manage '.$module,(array) $permissions))
                                        @if($key = array_search('manage '.$module,$permissions))
                                            @php
                                                if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif



                                    @if(in_array('add '.$module,(array) $permissions))
                                        @if($key = array_search('add '.$module,$permissions))
                                        @php
                                                if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif


                                    @if(in_array('test '.$module,(array) $permissions))
                                        @if($key = array_search('add '.$module,$permissions))
                                        @php
                                                if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if(in_array('edit '.$module,(array) $permissions))
                                        @if($key = array_search('edit '.$module,$permissions))
                                        @php
                                        if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                            $checked = 'checked';
                                        }else{
                                            $checked = '';
                                        }
                                    @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif



                                    @if(in_array('change password '.$module,(array) $permissions))
                                        @if($key = array_search('change password '.$module,$permissions))
                                        @php
                                                if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Change Password',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif


                                    @if(in_array('delete '.$module,(array) $permissions))
                                        @if($key = array_search('delete '.$module,$permissions))
                                             @php
                                                if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif


                                    @if(in_array('show '.$module,(array) $permissions))
                                        @if($key = array_search('show '.$module,$permissions))
                                        @php
                                                if(isset($role_has_permission) && in_array($key,$role_has_permission)){
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key,$checked])}}
                                                {{Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])}}<br>
                                            </div>
                                        @endif
                                    @endif




                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
        {{Form::submit((isset($update)? 'Update':'Create'),array('class'=>'btn btn-primary'))}}
    </div>
</div>
{{Form::close()}}
</section>

@endsection

