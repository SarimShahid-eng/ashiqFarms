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
            <h1>{{ (isset($is_update)) ? 'Update' :'Add' }} User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('accounts.branches.show')}}">Accounts</a></div>
                <div class="breadcrumb-item active">{{__('Add User')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Add User</h4>
                    </div>
                    <div class="card-body p-0">
                      <form action="{{ route('accounts.customers.stores.bank_and_branch') }}" method="POST" class="ajaxForm p-2" id="form">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="">Users</label>
                                <select class="form-control" name="user_id" id="user" required>
                                    <option value="" selected disabled>Select User</option>
                                    @forelse($customers AS $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Bank Name</label>
                                
                                <select class="form-control" name="bank_id" id="bank" required>
                                    <option value="" selected disabled>Select Bank</option>
                                    @forelse($banks AS $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            
                            </div>

                            <div class="col-md-4">
                                <label for="">Branch Name</label>
                                
                                <select class="form-control" name="bank_branch_id" id="bank_branch" required>
                                    <option value="" selected disabled>Select Branch</option>
                                </select>
                            
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
<script>
    $(document).on('change','#bank',function(){
        var id = $(this).val();
        $.ajax({
            url : "{{ url('/accounts/users/branches') }}",
            type: "GET",
            data:  {bank_id:id},
            success:function(data){
                $('#bank_branch').empty().append(data);
            } 
        });
    });
</script>
@endpush

