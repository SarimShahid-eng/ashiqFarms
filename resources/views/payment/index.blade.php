@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Entries')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                {{-- <div class="breadcrumb-item active">{{__('Payment')}}</div> --}}
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('Entries')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Entries')}}</h4>
                    </div>
                    <div class="card-body p-0">
                      
                        <form action="" method="GET" class="" id="form_date">
                        @csrf
                        <div class="form-group row p-2">
                            <div class="col-md-1 col-form-label">
                                <label for="">Type</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="type" id="type" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="0">Payment</option>
                                    <option value="1">Expense</option>
                                </select>
                            </div>
                            <div class="col-md-1 col-form-label">
                                <label for="">Date</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" required id="date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-1.5">
                                <input type="submit" class="form-control btn-primary" value="Add Expense" id="add_expense" name="add">
                            </div>
                            <div class="col-md-1.5 ml-2">
                                <input type="submit" class="btn btn-warning" id="edit_expense" value="Edit Expense" name="edit">
                            </div>
                        </div>
                        </form>
                        
                        <div id="credit_form" class="d-none">
                            <form action="{{ route('enteries.store') }}" method="POST"  class="form ajaxForm" id='form'>
                                @csrf
                                <table class="table text-center">
                                    <thead>
                                      <tr>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">Head &nbsp; &nbsp; &nbsp;</th>
                                        <th scope="col">SubHead</th>
                                        <th scope="col">Work</th>
                                        <th scope="col">Acres</th>
                                        <th scope="col">Material</th>
                                        <th>Qty</th>
                                        <th>Unit Rate</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                
                                      </tr>
                                    </thead>
                                    <tbody id="created_data">
                                      
                                    </tbody>
                                  </table>

                                  <input type="submit" class="btn btn-primary float-right mt-3 mb-2 mr-5" value="save">    
                            </form>
                        </div> 
                    
                    </div>
                </div>
            </div>
            <!--listing-->
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Entries')}}</h4>
                    </div>
                    <div class="card-body p-0">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                    <th scope="col">Head &nbsp; &nbsp; &nbsp;</th>
                                    <th scope="col">SubHead</th>
                                    <th scope="col">Work</th>
                                    <th scope="col">Acres</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit Rate</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Total</th>
                            
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @forelse($lists AS $list)
                                        <tr>
                                            <td>{{ $list->parentHead->head_name}}</td>
                                            <td>{{ $list->parentSubHead->head_name}}</td>
                                            <td>{{ $list->work }}</td>
                                            <td>{{ $list->acres }}</td>
                                            <td>{{ $list->material }}</td>
                                            <td>{{ $list->quantity }}</td>
                                            <td>{{ $list->unit_rate }}</td>
                                            <td>
                                                @if($list->payment_type == 1)
                                                Expense
                                                @else
                                                Payment
                                                @endif
                                            </td>
                                            <td>{{ $list->total }}</td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">No Record Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> 
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
    <script>

        $(document).on('change','.main_head',function(){
            var id = $('.main_head').val();
            $.ajax({
                url : "{{ url('enteries/subheads') }}/"+id,
                type : "get",
                data : { id:id },
                success:function(data){
                    $('#subhead').empty().append(data);
                }
            });
        });
        //this function dsipaly the add form
        $('#add_expense').click(function(e){
            
            var date = $('#form_date input[type="date"]').val();
            var type = $('#form_date select').val();
            
            if(date !== '' && type == 1){
                $('#credit_form').removeClass('d-none');

                e.preventDefault();
                $.ajax({
                    url : "{{ route('enteries.add') }}",
                    data: {add:"add",},
                    type: "GET",
                    success:function(data){
                        $('#created_data').empty().append(data);
                        $('input[name="expense_date"]').val(date);
                        $('.delete_row').addClass('d-none');
                        $('#payment_type').val(1);
                    }
                });
            }

            if(date !== '' && type == 0){
                $('#credit_form').removeClass('d-none');

                e.preventDefault();
                $.ajax({
                    url : "{{ route('payments.add') }}",
                    data: {add:"add",},
                    type: "GET",
                    success:function(data){
                        $('#created_data').empty().append(data);
                        $('input[name="expense_date"]').val(date);
                        $('.delete_row').addClass('d-none');
                        $('#payment_type').val(0);
                    }
                });
            }
        });

        $(document).on('click','#type',function(){
            $('#credit_form').addClass('d-none');
            $('#created_data').empty();
        });

        $(document).on('click','.add_row',function(){
            var date = $('#form_date input[type="date"]').val();
            
            $.ajax({
                    url : "{{ route('enteries.add') }}",
                    data: {add:"add",},
                    type: "GET",
                    success:function(data){
                        $('#created_data').append(data);
                        $('input[name="expense_date"]').val(date);
                    }
                    
                });
        });

        $(document).on('click','.delete_row',function(){
           $(this).parent().parent().remove();
           
        });

        
        //for edit
        $('#edit_expense').click(function(e){
            
            var date = $("#date").val();
            var type = $('#type').val();

            if(date !== '' && type != null){
                $('#credit_form').removeClass('d-none');
                e.preventDefault();

                $.ajax({
                    url : "{{ route('enteries.edit') }}",
                    data: {edit:"edit",date:date,type:type},
                    type: "GET",
                    success:function(data){
                        $('#created_data').empty().append(data);
                        
                    }
                });
            }
        });

        function deleteData(id){
            var conf = confirm("are you sure ?");
            if(conf == true){
                $('.d'+id).remove();
                $.ajax({
                    url : "{{ url('enteries/delete') }}/"+id,
                    type: "GET",
                    success:function(data){
                        
                    }
                });
            }
        }

    </script>
@endpush

