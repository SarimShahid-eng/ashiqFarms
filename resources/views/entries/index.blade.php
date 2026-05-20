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
                        @if(Auth::user()->type == "company" || Auth::user()->can('add entries') || Auth::user()->can('edit entries') )
                        <div class="form-group row p-2">
                        
                             <div class="col-md-1 col-form-label">
                                <label for="">Type</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" data-toggle="select2" name="type" id="type" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="0">Income</option>
                                    <option value="1" selected>Expense</option>
                                    <option value="2">Paid</option>
                                </select>
                            </div>
                            <div class="col-md-1 col-form-label">
                                <label for="">Date</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" required id="date" value="{{ date('Y-m-d') }}">
                            </div>

                            @if(Auth::user()->type == "company" || Auth::user()->can('add entries') )
                                <div class="col-md-1.5">
                                    <input type="submit" class="form-control btn-primary" value="Add" id="add_expense" name="add">
                                </div>
                            @endif

                            @if(Auth::user()->type == "company" || Auth::user()->can('edit entries') )
                                <div class="col-md-1.5 ml-2">
                                    <input type="submit" class="btn btn-warning" id="edit_expense" value="Edit" name="edit">
                                </div>
                            @endif
                        </div>
                        @endif
                        </form>

                        <div id="credit_form" class="d-none">
                            <form action="{{ route('enteries.store') }}" method="POST"  class="ajaxForm" >
                                <!--class="form ajaxForm"-->
                                <!--id='form'-->
                                @csrf
                             <div class="form-group row p-2">
                                <div class="col-md-1 col-form-label">
                                    <label for="">User</label>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" data-toggle="select2" name="currentuser_id" id="user" >
                                        <option selected value="">Select User</option>
                                        @foreach($users as $user)
                                      <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                        <!--<option value="" selected disabled>Select User</option>-->
                                        <!--<option value="0">Income</option>-->
                                        <!--<option value="1" >Expense</option>-->
                                        <!--<option value="2">Paid</option>-->
                                    </select>
                                </div>
                            </div>
                                <table class="table text-center">
                                    <thead>
                                      <tr>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">Head &nbsp; &nbsp; &nbsp;</th>
                                        <th scope="col">SubHead</th>
                                        <th scope="col">Third Head</th>
                                        <th scope="col">Fourth Head</th>
                                        <th scope="col">Work</th>
                                        <th scope="col">Acres</th>
                                        <th scope="col">Material</th>
                                        <th>Qty</th>
                                        <th>Unit Rate</th>
                                        <th>Total</th>
                                      </tr>
                                    </thead>
                                    <tbody id="created_data">

                                    </tbody>
                                  </table>
                                  <input type="submit" class="btn btn-primary float-right mt-3 mb-2 mr-5" value="save" id="save">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!--listing-->
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Entries List')}}</h4>
                    </div>
                    <div class="card-body p-0">
                            <form action="" class="col-12" id="search" method="GET">
                                <div class="form-group row">
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Type</label>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" data-toggle="select2" name="search_type" id="search_type" required>
                                            <option value="" selected disabled>Select Type</option>
                                            <option value="0">Income</option>
                                            <option value="1">Expense</option>
                                            <option value="2">Paid</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 col-form-label">
                                        <label for="">From</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" required name="search_from" id="search_from" value="{{ date('Y-m-01') }}">
                                    </div>

                                    <div class="col-md-1 col-form-label">
                                        <label for="">To</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" required name="search_to" id="search_to" value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary" id="search_submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <table class=" table text-center table-bordered mtbl dt_table">
                                <thead>
                                    <tr style="border: 1px solid #000">
                                    <th style="border: 1px solid #000">Date</th>
                                    <th style="border: 1px solid #000">Head &nbsp; &nbsp; &nbsp;</th>
                                    <th style="border: 1px solid #000">SubHead</th>
                                    <th style="border: 1px solid #000">Third Head</th>
                                    <th style="border: 1px solid #000">Forth Head</th>
                                    <th style="border: 1px solid #000">Work</th>
                                    <th style="border: 1px solid #000">Acres</th>
                                    <th style="border: 1px solid #000">Material</th>
                                    <th style="border: 1px solid #000">Qty</th>
                                    <th style="border: 1px solid #000; max-width: 85px; width: 80px">Unit Rate</th>
                                    <th style="border: 1px solid #000">Total</th>
                                    <th style="border: 1px solid #000">Type</th>
                                    </tr>
                                </thead>
                                <tbody id="list">
                                    @forelse($lists as $list)
                                    <tr style="border: 1px solid #000">

                                        <td style="border: 1px solid #000">{{ get_date($list->expense_date) }}</td>
                                        <td style="border: 1px solid #000">{{ @$list->parentHead->head_name}}</td>
                                        <td style="border: 1px solid #000">{{ @$list->parentSubHead->head_name}}</td>
                                        <td style="border: 1px solid #000">{{ @$list->parentChildSubHead->head_name}}</td>
                                        <td style="border: 1px solid #000">{{ @$list->parentForthSubhead->head_name}}</td>
                                        <td style="border: 1px solid #000">{{ $list->work }}</td>
                                        <td style="border: 1px solid #000">{{ $list->acres }}</td>
                                        <td style="border: 1px solid #000">{!! wordwrap($list->material) !!}</td>
                                        <td style="border: 1px solid #000">{{ $list->quantity }}</td>
                                        <td style="border: 1px solid #000; max-width: 85px; width: 80px">{{ $list->unit_rate }}</td>
                                        <td style="border: 1px solid #000">{{ round($list->total) }}</td>
                                        <td style="border: 1px solid #000">
                                            @if($list->payment_type == 1)
                                            Expense
                                            @elseif($list->payment_type == 2)
                                            paid
                                            @else
                                            Income
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    {{-- <tr>
                                        <td colspan="12">No Record Found</td>
                                    </tr> --}}
                                @endforelse
                                </tbody>
                            </table>
                            <div class="float-right" id="pagination">
                                {{-- {{ @$lists->links() }} --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        //dropdown for subheads
        $(document).on('change','.main_head',function(){
            var obj=$(this);
            var id = obj.val();
            // obj.parent().find('.subhead').empty().append('<option value="" selected>Select Child Subhead</option>');
            $.ajax({
                url : "{{ url('enteries/subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    obj.parent().parent().find('.subhead').html(data);
                }
            });
        });
        //dropdown for child subheads child_subhead
        $(document).on('change','.subhead',function(){
            var obj=$(this);
            var id = obj.val();
            $.ajax({
                url : "{{ url('enteries/child-subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    obj.parent().parent().find('.child_subhead').html(data);
                }
            });
        });
        //dropdown for child subheads
        $(document).on('change','.child_subhead',function(){
            var obj=$(this);
            var id = obj.val();
            $.ajax({
                url : "{{ url('enteries/forth-subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    obj.parent().parent().find('.forth_subhead').html(data);
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
                        if($('#save').hasClass("d-none")){
                            $('#save').removeClass("d-none");
                        }

                    }
                });

            }

            if(date !== '' && type == 0){
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
                        $('#payment_type').val(0);
                    }
                });
            }
            //for paid
            if(date !== '' && type == 2){
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
                        $('#payment_type').val(2);
                    }
                });
            }
        });

        $(document).on('change','#type',function(){
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

                        if(!($('#hide_button').length)){
                             $('#save').addClass('d-none');
                        }else{
                            $('#save').removeClass('d-none');
                        }

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
        //for search
        $(document).on('click','#search_submit',function(e){
            var type = $('#search_type').val();
            var from = $('#search_from').val();
            var to = $('#search_to').val();

            if(type != null && from !== '' && to !== ''){
                e.preventDefault();

                $.ajax({
                    url : "{{ url('enteries/search') }}/"+type+'/'+from+'/'+to,
                    data : {type:type,from:from,to:to},
                    type : "get",
                    success:function(data){
                        $('#list').empty().append(data);
                        $('#pagination').hide();
                    }
                });
            }
        });
        //for autofill total
        $(document).on('keyup','.unit_rate',function(){
            if($(this).parent().parent().find('.unit_rate').val() != ''){
                total($(this));
            }
        });


        $(document).on('keyup','.quantity',function(){
            if($(this).parent().parent().find('.quantity').val() != ''){
                total($(this));

            }
        });

        function total(obj){

            var  quantity  = obj.parent().parent().find('.quantity').val();
            var  unit_rate = obj.parent().parent().find('.unit_rate').val();
            var  total = quantity * unit_rate;
               // Keeping 2 decimal places
            var fixedTotal = parseFloat(total.toFixed(2));
            obj.parent().parent().find('.total').val(fixedTotal);

        }

      $(document).on('change','#date',function(e){
        // $(document).on('change','#date',function(){
            e.preventDefault();
            var year = moment($(this).val()).format('YYYY');
            var current_year = moment().format('YYYY');
            console.log(year);
            if(current_year>year){
                var confirm___ = confirm("You Select Old Date Click Ok To Continue");
                if(!confirm___){
                   $("#date").val(moment().format('YYYY-MM-DD'));
                }
            }

        })

    </script>
@endpush

