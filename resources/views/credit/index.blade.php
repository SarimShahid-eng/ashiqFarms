@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Expense')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('Add Expense')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Expense')}}</h4>
                    </div>
                    <div class="card-body p-0">
                      
                        <form action="" method="GET" class="" id="form_date">
                        @csrf
                        <div class="form-group row p-2">
                            <div class="col-md-2 col-form-label">
                                <label for="">Enter Expense Date</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" required id="date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-1.5">
                                <input type="submit" class="form-control btn-primary" value="Add Expense" id="add_expense">
                            </div>
                            <div class="col-md-1.5 ml-2">
                                {{-- <input type="button" class="form-control btn-warning" value="Edit Expense" id="edit_expense"> --}}
                                <button type="button" class="btn btn-warning" id="edit_expense">Edit Expense</button>
                            </div>
                        </div>
                        </form>
                        
                        <div id="credit_form" class="d-none">
                            <form action="{{ route('credits.store') }}" method="POST"  class="form" id="form">
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
        </div>
    </section>
@endsection
@push('script-page')
    <script>
        
        $(document).on('change','.main_head',function(){
            var id = $('.main_head').val();
            var obj = $(this);
            // var id = $(this).val();
            
            $.ajax({
                url : "{{ url('credit/subheads') }}/"+id,
                type : "get",
                data : { id:id },
                success:function(data){
                    obj.parent().parent().find('.subhead').html(data);
                    // $('.subhead').html(data);
                }
            });
        });


        $('#form_date input[type="submit"]').click(function(e){
            
            $('#credit_form').removeClass('d-none');
            var date = $('#form_date input[type="date"]').val();
            
            
            if(date !== ''){
                e.preventDefault();
                $.ajax({
                    url : "{{ route('credits.add') }}",
                    data: {add:"add",},
                    type: "GET",
                    success:function(data){
                        $('#created_data').empty().append(data);
                        $('input[name="expense_date"]').val(date);
                        $('.delete_row').addClass('d-none');
                    }
                });
            }
        });

        $(document).on('click','.add_row',function(){
            var date = $('#form_date input[type="date"]').val();
            
            $.ajax({
                    url : "{{ route('credits.add') }}",
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
        $('#edit_expense').click(function(){
            
            $('#credit_form').removeClass('d-none');
            var date = $("#date").val();
            // $('.form').removeAttr('id');
            if(date !== ''){
                $.ajax({
                    url : "{{ route('credits.edit') }}",
                    data: {edit:"edit",date:date},
                    type: "GET",
                    success:function(data){
                        $('#created_data').empty().append(data);
                        
                    }
                });
            }
        });

        //for delete
         function deleteData(id){
            var conf = confirm("are you sure");

            if(conf == true){
                $('.d'+id).remove();

                $.ajax({
                    url : "{{ url('credit/delete') }}/"+id,
                    type: "GET",
                    success:function(data){
                        
                    }
                });
            }
        }

        

    </script>
@endpush

