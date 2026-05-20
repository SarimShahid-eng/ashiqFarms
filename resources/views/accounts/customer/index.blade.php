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
            <h1>User list</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('accounts.branches.show')}}">Accounts</a></div>
                <div class="breadcrumb-item active">{{__('Users')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            @if(Auth::user()->type == "company" || Auth::user()->can('add banks') || (Auth::user()->can('edit banks') && isset($is_update)) )
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{ (isset($is_update)?'Update':'Add') }} User</h4>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('accounts.customer.store') }}" method="GET" class="ajaxForm p-2" id="form">
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" required value="{{ @$update->name }}" name="name">
                                </div>
                                <div class="col-md2">
                                    <input type="submit" class="btn btn-primary" value="{{ (isset($is_update) ? 'Update':'Add' ) }}">
                                </div>
                            </div>
                            <input type="hidden" name="customer_id" value="{{ @$update->id }}">
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Users List</h4>
                    </div>
                    <div class="card-body p-3">
                        <table class="table text-center">
                            <thead>
                              <tr style="border: 1px solid #000">
                                <th scope="col" style="border: 1px solid #000">#</th>
                                <th scope="col" style="border: 1px solid #000">Users</th>
                                <th scope="col" style="border: 1px solid #000">IN</th>
                                <th scope="col" style="border: 1px solid #000">OUT</th>
                                <th scope="col" style="border: 1px solid #000">Action</th> 
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($customers AS $key=>$data)
                                    <tr style="border: 1px solid #000">
                                        <td style="border: 1px solid #000">{{ $customers->firstItem()+$key }}</td>
                                        <td style="border: 1px solid #000">{{ @$data->name }}</td>
                                        <td style="border: 1px solid #000">{{ round(@$data->childBalanceIn->sum('amount')) }}</td>
                                        <td style="border: 1px solid #000">{{ round(@$data->childBalanceOut->sum('amount')) }}</td>
                                        <td style="border: 1px solid #000">
                                            @if(Auth::user()->type == "company" || Auth::user()->can('edit users') )
                                                <a href="{{ route('accounts.customer.show',['id'=>$data->id]) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if(Auth::user()->type == "company" || Auth::user()->can('delete users') )
                                                <a href="javascript:void(0)" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('accounts.customer.delete',['id'=>$data->id]) }}',''): '' " class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty 
                                    <tr><td colspan="6" class="text-center">No Record Found</td></tr>
                                @endforelse
                            </tbody>
                          </table>
                          <div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
@endpush

