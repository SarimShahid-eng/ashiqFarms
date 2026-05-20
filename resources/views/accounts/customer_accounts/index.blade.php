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
            <h1>Users Accounts List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('accounts.branches.show')}}">Accounts</a></div>
                <div class="breadcrumb-item active">{{__('Users Accounts')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Users Accounts</h4>
                        @if(Auth::user()->type == "company" || Auth::user()->can('add users accounts') )
                            <div class="card-header-action">
                                <a href="{{ route('accounts.customer_accounts.add') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                    <i class="fas fa-plus"></i>Add User Balance
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mtbl" style="border-color: #000">
                            <thead>
                              <tr style="border-color: #000">
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">#</th>
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">User Name</th>
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">Bank Head</th>
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">Bank Subhead</th>
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">Amount</th>
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">Mode</th>
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">Type</th> 
                                <th scope="col" style="border-color: #000; border-bottom: 1px solid #000">Action</th> 
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($balances AS $key=>$balance)
                                    <tr style="border-color: #000">
                                        <td style="border-color: #000">{{ $balances->firstItem() + $key }}</td>
                                        <td style="border-color: #000">{{ @$balance->parentCustomer->name }}</td>
                                        <td style="border-color: #000">{{ @$balance->parentBank->bank_name }}</td>
                                        <td style="border-color: #000">{{ @$balance->parentBankBranch->branch_name }}</td>
                                        <td style="border-color: #000">{{ round($balance->amount) }}</td>
                                        <td style="border-color: #000">{{ @$balance->parentTransaction->mode }}</td>
                                        <td style="border-color: #000">{{ $balance->type }}</td>
                                        <td style="border-color: #000">
                                            @if(Auth::user()->type == "company" || Auth::user()->can('edit users accounts') )
                                                <a href="{{ route('accounts.customer_accounts.edit',['id'=>$balance->id]) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if(Auth::user()->type == "company" || Auth::user()->can('delete users accounts') )
                                                <a href="javascript:void(0)" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('accounts.customer_accounts.delete',['id'=>$balance->id]) }}',''): '' " class="btn btn-danger" onclick="return confirm('are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center" colspan="8">No Record Found</td></tr>
                                @endforelse
                            </tbody>
                          </table>
                          {{ @$balances->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
@endpush

