@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__((isset($update)?'Update Fourth Head':'Add Fourth Head'))}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('Child SubHead')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{ (isset($update) ? 'Update Fourth Head' : 'Add Fourth Head') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('expense.child.forthheads.show') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                <i class="fas fa-plus"></i>{{__('View Fourth Head')}}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form action="{{ route('expense.child.forheads.store') }}" method="POST" class="ajaxForm" id="form">
                            @csrf
                            <div class="row p-2">
                                <div class="form-group col-md-3">
                                    <select id="head" class="form-control" data-toggle="select2" name="head_id" required>
                                        <option value="">Select Head</option>
                                        @foreach ($heads as $head)
                                        <option value="{{ $head->id }}" @if($head->id == @$head_id->parent_id) selected @endif>{{ $head->head_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select id="subhead" class="form-control" data-toggle="select2" name="subhead_id" required>
                                        <option value="">Select Subhead</option>
                                        @if(isset($update))
                                            @forelse($subheads AS $subhead)
                                                <option value="{{ $subhead->id }}" @if($subhead->id == $second_id->child_id) selected @endif>{{ $subhead->head_name }}</option>
                                            @empty 
                                                <option value="">No Sub heads</option>
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <select id="childhead" class="form-control" data-toggle="select2" name="chil_id" required>
                                        <option value="">Select Third Head</option>
                                        @if(isset($update))
                                            @forelse($third_heads AS $third_head)
                                                <option value="{{ $third_head->id }}" @if($third_head->id == $update_child->forth_head) selected @endif>{{ $third_head->head_name }}</option>
                                            @empty 
                                                <option value="">No Third Head</option>
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" style="height: 45px;"  placeholder="Enter Forth Headr Name" name="forth_subhead" value="{{ @$update_child->head_name }}" required >
                                </div>
                                <div class="text-right col-12">
                                    <input type="hidden" name="id" value="{{ @$id }}">
                                    <input type="submit" class="btn btn-primary form-group" value="{{ (isset($update)?'Update':'Add') }}">
                                </div>
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
        $(document).on('change','#head',function(){
            var id = $('#head').val();
            $('#subhead').empty();
            $.ajax({
                url: "{{ url('report/subhead') }}/"+id,
                type:"get",
                success:function(data){
                    var data = `<option value='' selected disabled>Select Second Head</option>${data}`
                   $('#subhead').html(data);
                }
           });
        });
        $(document).on('change','#subhead',function(){
            var id = $('#subhead').val();
            $('#childhead').empty();
            $.ajax({
                url: "{{ url('report/childhead') }}/"+id,
                type:"get",
                success:function(data){
                    var data = `<option value='' selected disabled>Select Third Head</option>${data}`
                   $('#childhead').html(data);
                }
           });
        });


    </script>

@endpush