@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__((isset($update)?'Update Third Head':'Add Third Head'))}}</h1>
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
                        <h4>{{ (isset($update) ? 'Update Third Head' : 'Add Third Head') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('expense.child.subheads.show') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                <i class="fas fa-plus"></i>{{__('View Third Head')}}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form action="{{ route('expense.child.subheads.store') }}" method="POST" class="ajaxForm" id="form">
                            @csrf
                            <div class="row p-2">
                                <div class="form-group col-md-3">
                                    <select id="head" class="form-control" data-toggle="select2" name="head_id" required>
                                        <option value="">Select Head</option>
                                        @foreach ($heads as $head)
                                        <option value="{{ $head->id }}" @if($head->id == @$head_id->id) selected @endif>{{ $head->head_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select id="subhead" class="form-control" data-toggle="select2" name="subhead_id" required>
                                        <option value="">Select Subhead</option>
                                        @if(isset($update))
                                            @forelse($subheads AS $subhead)
                                                <option value="{{ $subhead->id }}" @if($subhead->id == $update_child->child_id) selected @endif>{{ $subhead->head_name }}</option>
                                            @empty 
                                                <option value="">No SUbheads</option>
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" style="height: 45px;"  placeholder="Enter Child Subhead Name" name="child_subhead" required value="{{ @$update_child->head_name }}">
                                </div>
                                <input type="hidden" name="id" value="{{ @$id }}">
                                <input type="submit" class="btn btn-primary form-group" value="{{ (isset($update)?'Update':'Add') }}">
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
                   $('#subhead').html(data);
                }
           });
        });


    </script>

@endpush