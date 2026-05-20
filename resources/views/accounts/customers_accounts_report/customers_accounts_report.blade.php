@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection

@section('content')


<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{background-color: #6777ef; color: #fff;}
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{margin-left: 0 !important; border: 0 !important;color: transparent;}
</style>


<section class="section">
        <div class="section-header">
            <h1>{{__('Users Accounts Report')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">{{__('Accounts')}}</div>
                <div class="breadcrumb-item active">{{__('Users Accouts Report')}}</div>
                {{-- <div class="breadcrumb-item active">{{__('Add Credit Expense')}}</div> --}}
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Users Accounts Report')}}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="col-md-12">
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 {{ session('error') }}
                              </div>
                            @endif

                            <form action="{{ route('accounts.customer_accounts.search') }}" method="GET" class="" id="form">
                                @csrf
                                @if(Auth::user()->type == "company" || Auth::user()->can('edit users accounts report') )
                                    <div class="form-group row p-2">
                                        <div class="col-md-2 col-form-label">
                                            <label for="">Edit</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="checkbox" name="edit">
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="form-group row p-2">
                                    @if(Auth::user()->type == 'company')
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Users</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select  name="customer" id="user" class="form-control users" data-toggle="select2" required>
                                            <option value="" selected disabled>Select User</option>
                                            @forelse($customers AS $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @endif
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Bank Head</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="banks" id="bank" class="form-control" data-toggle="select2">
                                            <option value="">Select Bank Head</option>
                                        </select>
                                       
                                    </div>

                                    <div class="col-md-1 col-form-label">
                                        <label for="">Bank Subhead</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="branches[]" id="bank_branch" class="form-control"  data-toggle="select2" multiple="multiple">
                                        </select>
                                    </div>

                                    
                                </div>

                                <div class="form-group row p-2">
                                    
                                    <div class="col-md-10">
                                        <div class="row" id="branches">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="form-group row p-2">

                                    

                                    <div class="col-md-1 col-form-label">
                                        <label for="">Type</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="type" id="" class="form-control">
                                            <option value="" selected disabled>Select Type</option>
                                            {{-- <option value="all">All</option> --}}
                                            <option value="in">In</option>
                                            <option value="out">Out</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 col-form-label">
                                        <label for="">From</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" required name="from_date">
                                    </div>

                                    <div class="col-md-1 col-form-label">
                                        <label for="">To</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" required name="to_date">
                                    </div>
                                    
                                </div>



                                <div class="text-right p-2">
                                        <input type="submit" class="mb-4 btn btn-primary float-right" value="Generate Report" target="new">
                                        <input type="hidden" value="{{ @$user_id }}" name="user_id" id="user_id">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
    <script>
            //append the bank branches when select the bank
            $(document).on('change','#user',function(){
                var id = $('#user').val();
                
                $.ajax({
                    url : "{{ url('accounts/users_accounts/user_banks_branches') }}/"+id,
                    type:"GET",
                    success:function(){
                        console.log("done");
                    }
                });
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

