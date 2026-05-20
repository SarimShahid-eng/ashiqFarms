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
            <h1>Bank Subheads List</h1>
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
                        <h4>Bank Subheads</h4>
                        @if(Auth::user()->type == "company" || Auth::user()->can('add Bank branch') )
                            <div class="card-header-action">
                                <a href="{{ route('accounts.branches.add') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                    <i class="fas fa-plus"></i>Add Bank Subhead
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                              <tr style="border: 1px solid #000">
                                <th scope="col" style="border: 1px solid #000">#</th>
                                <th scope="col" style="border: 1px solid #000">Bank Head</th>
                                <th scope="col" style="border: 1px solid #000">Branch Subhead</th>
                                <th scope="col" style="border: 1px solid #000">Branch Code</th>
                                <th scope="col" style="border: 1px solid #000">Opening Balance</th> 
                                <th scope="col" style="border: 1px solid #000">Balance</th> 
                                <th scope="col" style="border: 1px solid #000">Location</th> 
                                <th scope="col" style="border: 1px solid #000">Action</th> 
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($branches AS $key=>$branch)
                                    <tr style="border: 1px solid #000">
                                        <td style="border: 1px solid #000">{{ $key+1 }}</td>
                                        <td style="border: 1px solid #000">{{ @$branch->parentBank->bank_name }}</td>
                                        <td style="border: 1px solid #000">{{ $branch->branch_name }}</td>
                                        <td style="border: 1px solid #000">{{ $branch->branch_code }}</td>
                                        <td style="border: 1px solid #000">{{ round($branch->opening_balance) }}</td>
                                        <td style="border: 1px solid #000">
                                            <?php
                                                // number_format($branch->childBalnceTypeIn->sum('amount') - $branch->childBalnceTypeOut->sum('amount') )
                                                $in = $branch->childBalanceTypeIn->sum('amount');
                                                $out = $branch->childBalanceTypeOut->sum('amount');
                                                $balance = $in-$out;
                                                $account_balance = $branch->opening_balance + $balance;
                                                echo round($account_balance);

                                                    
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #000">{{ @$branch->location }}</td>
                                        <td style="border: 1px solid #000; width: 150px;">
                                            @if(Auth::user()->type == "company" || Auth::user()->can('edit bank branch') )
                                                <a href="{{ route('accounts.branches.edit',['id'=>$branch->id]) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            
                                            @if(Auth::user()->type == "company" || Auth::user()->can('delete bank branch') )
                                                <a href="javascript:void(0)" class="btn btn-danger" onclick="return confirm('are you sure?') ? run_ajax('{{ route('accounts.branches.delete',['id'=>$branch->id]) }}',''): '' ">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Recoud Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
@endpush

