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
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Users List</h4>
                        @if(Auth::user()->type == "company" || Auth::user()->can('add users banks and branches') )
                            <div class="card-header-action">
                                <a href="{{ route('accounts.customers.add') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                    <i class="fas fa-plus"></i>Add User
                                </a>
                            </div>
                        @endif
                        {{-- <div class="card-header-action">
                            <a href="{{ route('accounts.customers.bank_and_branch') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                <i class="fas fa-plus"></i>Add User Bank & Branch
                            </a>
                        </div> --}}
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                              <tr style="border: 1px solid #000">
                                <th scope="col" style="border: 1px solid #000">#</th>
                                <th scope="col" style="border: 1px solid #000">User Name</th>
                                <th scope="col" style="border: 1px solid #000">Bank Head</th>
                                <th scope="col" style="border: 1px solid #000">Bank Subhead</th>
                                <th scope="col" style="border: 1px solid #000">Branch Code</th> 
                                {{-- <th scope="col">Branch Location</th>  --}}
                                <th scope="col" style="border: 1px solid #000">Action</th> 
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($customers_bank_branch AS $key=>$data)
                                    @if(!empty(@$data->parentCustomer->name))   
                                        <tr style="border: 1px solid #000">
                                            <td style="border: 1px solid #000">{{ $customers_bank_branch->firstItem()+$key }}</td>
                                            <td style="border: 1px solid #000">{{ @$data->parentCustomer->name }}</td>
                                            <td style="border: 1px solid #000">{{ @$data->parentBank->bank_name }}</td>
                                            <td style="border: 1px solid #000">{{ @$data->parentBankBranch->branch_name }}</td>
                                            <td style="border: 1px solid #000">{{ @$data->parentBankBranch->branch_code }}</td>
                                            <td style="border: 1px solid #000">
                                                @if(Auth::user()->type == "company" || Auth::user()->can('edit users banks and branches') )
                                                    <a href="{{ route('accounts.customers.edit',['id'=>$data->id]) }}" class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if(Auth::user()->type == "company" || Auth::user()->can('delete users banks and branches') )
                                                    <a href="javascript:void(0)" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('accounts.customers.deletes.user_bank_branch',['id'=>$data->id]) }}',''): '' " class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif    
                                @empty 
                                    <tr><td colspan="6" class="text-center">No Record Found</td></tr>
                                @endforelse
                            </tbody>
                          </table>
                          <div>
                              {{ $customers_bank_branch->links() }}
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
@endpush

