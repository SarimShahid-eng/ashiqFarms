@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection

@section('content')

<style>
    input[type="date"],
    select{padding: 12px 10px !important;height: auto !important;}
        input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  /* -webkit-transform: scale(2); Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  transform: scale(2);
}
</style>

    <section class="section">
        <div class="section-header">
            <h1>{{__('Expense Report')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('Report')}}</div>
                {{-- <div class="breadcrumb-item active">{{__('Add Credit Expense')}}</div> --}}
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Expense Report')}}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="col-md-12">
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 {{ session('error') }}
                              </div>
                            @endif
                            <form action="{{ route('reports.search') }}" method="GET" class="" id="form"  onsubmit="return createTarget(this.target)" target="formtarget">
                                @csrf

                                @if(Auth::user()->type == "company" || Auth::user()->can('edit expense report') )
                                    <div class="form-group row p-2">
                                        <div class="col-md-1 col-form-label">
                                            <label for="">Edit</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="checkbox" name="edit" style="margin-top: 12px;margin-left: 6px;">
                                        </div>
                                    </div>
                                @endif
                                    
                                <div class="form-group row p-2">

                                    <div class="col-md-1 col-form-label">
                                        <label for="">Heads</label>
                                    </div>
                                    <div class="col-md-11">
                                            <select name="head" data-toggle="select2" id="head" class="form-control">
                                                <option value="" selected>Select Head</option>
                                                @forelse($heads As $head)
                                                    <option value="{{ $head->id }}">{{ $head->head_name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group row p-2">
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Subhead</label>
                                    </div>
                                    <div class="col-md-11">
                                        <select  id="subhead"  data-toggle="select2" class="form-control" name="subhead[]" multiple="multiple">
                                            <option value="" disabled>Select Subhead</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row p-2">
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Third Head</label>
                                    </div>
                                    <div class="col-md-11">
                                        <select  id="child_subhead"  data-toggle="select2" class="form-control" name="child_subhead[]" multiple="multiple">
                                            <option value="" disabled>Select Third Head</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="form-group row p-2">
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Fourth Head</label>
                                    </div>
                                    <div class="col-md-11">
                                        <select  id="forth_subhead"  data-toggle="select2" class="form-control" name="forth_subhead[]" multiple="multiple">
                                            <option value="" disabled>Select Forth Head</option>
                                        </select>
                                    </div>
                                </div>

                                

                               

                                    @if(Auth::user()->type == 'company')
                                    <div class="form-group row p-2">
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Users</label>
                                    </div>
                                    <div class="col-md-11">
                                        <select name="users" id=""  class="form-control">
                                            <option value="" selected>Select User</option>
                                            <option value="all">All</option>
                                            @foreach(@$users AS $user)
                                                <option value="{{ $user->id }}" @if($user->name == 'ashiq hussain') selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    @endif
                                    <div class="form-group row p-2">
                                    <div class="col-md-1 col-form-label">
                                        <label for="">Type</label>
                                    </div>
                                    <div class="col-md-11">
                                        <select name="type" id="" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="3">All</option>
                                            <option value="0">Income</option>
                                            <option value="1">Expense</option>
                                            <option value="2">Paid</option>
                                        </select>
                                    </div>
                                </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group row p-2">
                                        <div class="col-md-1 col-form-label">
                                            <label for="">From</label>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="date" class="form-control" required name="from_date" value="{{ date('Y-m-01') }}">
                                        </div>

                                        <div class="col-md-1 col-form-label">
                                            <label for="">To</label>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="date" class="form-control" required name="to_date" value="{{ date('Y-m-t') }}">
                                        </div>
                                    </div>

                                    <div class="text-right p-2">
                                        {{-- <div class="text-right"> --}}
                                            <input type="submit" class="mb-4 btn btn-primary float-right" value="Generate Report">
                                            {{-- <input type="submit" class="mb-4 btn btn-primary float-right" id="csv" value="Generate CSV"> --}}
                                            <button type="button" class="mr-2 btn btn-primary" id="csv">Generate CSV</button>
                                            <input type="hidden" value="{{ @$user_id }}" name="user_id">
                                        {{-- </div> --}}
                                    </div>
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
        $(document).on('change','#head',function(){
            var id = $('#head').val();
            //reset the dropdowns
            $('#subhead').empty();
            $('#child_subhead').empty();
            
            $.ajax({
                url: "{{ url('report/subhead') }}/"+id,
                type:"get",
                success:function(data){
                   $('#subhead').html(data);
                }
           });
        });
         //dropdown for child subheads
        $(document).on('change','#subhead',function(){
            var id = $('#subhead').val();
            $.ajax({
                url : "{{ url('enteries/child-subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    $('#child_subhead').html(data);
                }
            });
        });
        $(document).on('change','#child_subhead',function(){
            var id = $('#child_subhead').val();
            $.ajax({
                url : "{{ url('enteries/forth-subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    $('#forth_subhead').html(data);
                }
            });
        });

        $('#csv').click(function(){
                $('#form').attr("action","{{ route('reports.export.csv') }}");
                $("#form").removeAttr("target");
                $('#form').removeAttr("onsubmit");
                $('#form').submit();
                // location.reload();
                setTimeout(function(){
                    location.reload();
                },3000);
           // }
            
        });

        // $('#form').submit(function(e){
        //     e.preventDefault();
        //     alert(screen.width);
        //     // target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');"
        // });
        
        function createTarget(t){
            var w = window.open("", t,"width,height");
            w.moveTo(0, 0);
            w.resizeTo(screen.width, screen.height);

            return true;
        }
    </script>

@endpush

