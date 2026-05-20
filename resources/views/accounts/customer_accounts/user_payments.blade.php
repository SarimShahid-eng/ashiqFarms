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
            <h1>Users Payments</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('accounts.branches.show')}}">Accounts</a></div>
                <div class="breadcrumb-item active">{{__('Usrers Accounts')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-body">
                        <form action="{{ route('accounts.customer_accounts.store') }}" class="ajaxForm">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="">Users</label>
                                    <select class="form-control users" name="customer_id" id="user" required>
                                            <option value="" selected disabled>Select User</option>  
                                        @if (isset($customers))
                                            @forelse($customers AS $customer)
                                                <option value="{{ $customer->id }}" @if(@$balance->customer_id == $customer->id) selected @endif>{{ $customer->name }}</option>
                                            @empty
                                                <option value="">No Customers</option>
                                            @endforelse
                                        @else
                                            <option value="" selected disabled>Select Users</option>
                                        @endif
                                    
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Bank Head</label>
                                    <select class="form-control" name="bank_id" id="bank" required>
                                        <option value="" selected disabled>Select Bank Head</option>
                                        @if(isset($is_update))
                                            @forelse($banks AS $bank)
                                                <option value="{{ $bank->id }}" @if(@$balance->bank_id == $bank->id) selected @endif>{{ $bank->bank_name }}</option>
                                            @empty
                                            @endforelse
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Bank Subhead</label>
                                    <select class="form-control" name="branch_id" id="bank_branch" required>
                                        <option value="" selected disabled>Select Bank Subhead</option>
                                        @if(isset($is_update))
                                            @forelse($branches AS $branch)
                                                <option value="{{ $branch->id }}" @if(@$balance->bank_branch_id == $branch->id) selected @endif>{{ $branch->branch_name }}</option>
                                            @empty
                                                <option value="">No Branch</option>
                                            @endforelse
                                        @else
                                            <option value="" selected disabled>Select branch</option>
                                        @endif    
                         
                                    </select>
                                </div>


                                <table id="table" class="table mt-3">
                                    <tr>

                                        <td>
                                            <div class="form-group">
                                                <label for="">Amount</label>
                                                <input type="number" class="form-control" name="amount" required value="{{ @$balance->amount }}">
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <label for="">Transaction Mode</label>
                                                <select class="form-control" name="mode" id="" required>
                                                    <option value="" disabled selected>Select Mode</option>
                                                   @forelse($transactions As $t)
                                                        <option value="{{ $t->id }}" @if(@$balance->transaction_id == $t->id) selected @endif>{{ $t->mode }}</option>
                                                   @empty
                                                   @endforelse
                                                </select>
                                            </div>
                                            
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="">Type</label>
                                                <select class="form-control" name="type" id="" required>
                                                    <option value="" selected disabled>Select Type</option>
                                                    <option value="in" @if(@$balance->type == 'in') selected @endif>IN</option>
                                                    <option value="out" @if(@$balance->type == 'out') selected @endif>OUT</option>
                                                </select>
                                            </div>
                                            
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="date" class="form-control" name="date" required value="{{ @$balance->balance_date }}">
                                            </div>    
                                        </td>
                                    </tr>
                                </table>

                               
                                <div class="col-md-6">
                                    <label>Cheque/Card/Voucher No</label>
                                    <select class="form-control" name="reason_id">
                                        <option value="">Select Cheque/Card/Voucher No</option>
                                        @foreach($reasons AS $reason)
                                            <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Note</label>
                                    <input type="text" class="form-control" name="note">
                                </div>

                                <input type="hidden" value="{{ @$balance->id }}" name="balance_id">
                                <input type="submit" class="btn btn-primary float-right mt-4" value="{{ (@$is_update == TRUE)? 'Update':'Add' }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
    <script>
        $(document).on('click','#add_row',function(){
            
            var bank_id = $('#bank').val();
            var bank_branch_id = $('#bank_branch').val();

            $.ajax({
                url : "{{ url('accounts/users_accounts/add_row') }}",
                type:"GET",
                data : {bank_id:bank_id, branch_id:bank_branch_id},
                success:function(data){
                    $('#table').append(data);
                }
            });
            return false;
        });
        //remove the appended user row
        $(document).on('click','.remove_row',function(){
            
            $(this).parent().parent().remove();
            
        });

        var user_id = 0;
        //append the user banks
        $(document).on('change','#user',function(){
            var html = '<option value="">Select Branch</option>';
            $('#bank_branch').empty().append(html);
            
            user_id = $(this).val();
            
            $.ajax({
                url : "{{ url('accounts/users_accounts/users_banks') }}/"+user_id,
                type:"GET",
                success:function(data){
                    $('#bank').empty().append(data);
                }
            });
        });
        //append the user bank branches
        $(document).on('change','#bank',function(){
            
            $('#bank_branch').empty();
            user_id = $('#user').val();
            var bank_id = $(this).val();

            $.ajax({
                url : "{{ url('accounts/users_accounts/users_branches') }}/"+bank_id+'/'+user_id,
                type : "GET",
                success:function(data){
                    $('#bank_branch').empty().append(data);
                }
            });
        });

    </script>
@endpush

