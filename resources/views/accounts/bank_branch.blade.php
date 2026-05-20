@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
@section('content')

<style>
.pagin .pagination{display: inline-block;}
.pagin .pagination li{display: inline-block;}
</style>

    <section class="section">
        <div class="section-header">
            <h1>{{ (isset($is_update)) ? 'Update' :'Add' }} Bank Subhead</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('accounts.branches.show')}}">Accounts</a></div>
                <div class="breadcrumb-item active">{{__('Bank Subhead')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Bank Subhead</h4>
                        {{-- <div class="card-header-action">
                            <a href=""  class="btn btn-icon icon-left btn-primary" id="add_head">
                                <i class="fas fa-plus"></i>Add Bank
                            </a>
                        </div> --}}
                    </div>
                    <div class="card-body p-0">
                      <form action="{{ route('accounts.branches.store') }}" method="POST" class="ajaxForm p-2" id="form">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="">Bank Head</label>
                                <select class="form-control" name="bank_id" id="" required>
                                    <option value="" selected disabled>select</option>
                                    @forelse($banks AS $bank)
                                        <option value="{{ $bank->id }}" @if( isset($edit->bank_id) && $edit->bank_id == $bank->id) selected @endif>{{ $bank->bank_name }}</option>
                                    @empty
                                        <option value="" selected disbaled>No Bank</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Bank Subhead Name</label>
                                <input type="text" class="form-control" name="branch_name" required value="{{ @$edit->branch_name }}"> 
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-6">
                                <label for="">Branch Code</label>
                                <input type="text" class="form-control" name="branch_code" required value="{{ @$edit->branch_code }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Opening Balance</label>
                                <input type="number" class="form-control" name="opening_balance" required value="{{ @$edit->opening_balance }}">
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-12">
                                <label for="">Location</label>
                                <input type="text" class="form-control" name="location" value="{{ @$edit->location }}">
                            </div>
                        </div>
                        <input type="hidden" name="update_id" value="{{ @$edit->id }}">
                        <input type="submit" class="btn btn-primary float-right mt-3 mb-5" value="{{ (isset($is_update)) ?'Update' : 'Add' }}">
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
@endpush

