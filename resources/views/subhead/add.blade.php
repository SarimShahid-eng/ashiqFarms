@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__((isset($update)?'Update Subhead':'Add Subhead'))}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                {{-- <div class="breadcrumb-item"><a href="{{route('expense.heads.show')}}">{{__('Expense')}}</a></div> --}}
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('SubHead')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Add SubHead')}}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('expense.subheads.show') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                <i class="fas fa-plus"></i>{{__('View SubHead')}}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form action="{{ route('expense.subheads.store') }}" method="POST" class="ajaxForm" id="form">
                            @csrf
                            <div class="row p-2">
                                <div class="form-group col-md-5">
                                    <select id="" class="form-control" data-toggle="select2" name="parent_id" required>
                                        <option value="">Select Head</option>
                                        @forelse($data AS $head)
                                            <option value="{{ $head->id }}" @if(@$update_subhead->parent_id == $head->id) selected @endif>{{ $head->head_name }}</option>
                                        @empty
                                            <option value="">No heads</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control" style="height: 45px;"  placeholder="Enter Subehad Name" name="subhead" required value="{{ @$update_subhead->head_name }}">
                                </div>
                                <input type="hidden" name="id" value="{{ @$id }}">
                                <input type="submit" class="btn btn-primary form-group" value="{{ (isset($update)?'Update':'Add') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
