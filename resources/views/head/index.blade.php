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
            <h1>{{__('Add Head')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('expense.heads.show')}}">{{__('Expense')}}</a></div>
                <div class="breadcrumb-item active">{{__('Head')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            @if(Auth::user()->type == "company" || Auth::user()->can('add head') || (Auth::user()->can('edit head') && isset($is_update)) )
            <div class="col-12">
              <div class="card repeater">
                  <div class="card-header">
                      <h4>{{(isset($is_update) ? 'Update':'Add')}} Head</h4>
                  </div>
                  <div class="card-body p-4">
                      <form action="{{ route('expense.heads.store') }}" method="POST" class="ajaxForm" id="form">
                        @csrf
                        <div class="row">
                          <div class="col-md-10">
                            <input type="text" class="form-control" required name="head" value="{{ @$update_head->head_name }}">
                          </div>
                          <div class="col-md-2">
                            <input type="submit" name="Add" class="btn btn-primary" value="{{ isset($is_update)?'Update':'Add' }}">
                          </div>
                        </div>
                        <input type="hidden" name="head_id" value="{{ @$update_head->id }}">
                      </form>
                  </div>
              </div>
          </div>
          @endif
          {{-- <div class="col-md-12 text-center">
            @foreach(range('A','Z') AS $pagination)
              <a href="{{ route('expense.heads.show',['search'=>$pagination]) }}" class="badge badge-primary">{{ $pagination }}</a>
            @endforeach
          </div> --}}
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Heads')}}</h4>
                    </div>
                    <div class="card-body p-0">
                        @csrf
                          <table class="table text-center table-bordered dt_table">
                            <thead>
                              <tr style="border: 1px solid #000">
                                <th scope="" style="border: 1px solid #000">#</th>
                                <th scope="" style="border: 1px solid #000">Head Name</th>
                                <th scope="col" style="border: 1px solid #000">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($data AS $key=>$value)
                                  <tr>
                                    <td style="border: 1px solid #000">{{ $loop->iteration }}</td>
                                    <td style="border: 1px solid #000">
                                      {{ $value->head_name }}
                                    </td>
                                    <td style="border: 1px solid #000">
                                      @if(Auth::user()->type == "company" || Auth::user()->can('edit head') )
                                        <a href="{{ route('expense.heads.delete',['id'=>$value->id]) }}" class="btn btn-danger" onclick="return confirm('are you sure?')"><i class="fas fa-trash"></i></a>
                                      @endif
                                      @if(Auth::user()->type == "company" || Auth::user()->can('delete head') )
                                        <a href="{{ route('expense.heads.show',['id'=>$value->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                {{-- @endif --}}
                              @empty
                                <tr>
                                  <td colspan="3" id="hide_record">No Record Found</td>
                                </tr>
                              @endforelse
                            </tbody>
                          </table>
                          {{-- <div class="pagin text-right">
                          {{ $data->links() }}
                          </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
    <script>
      $('#add_head').on('click',function(e){
        $('#save').show();
        e.preventDefault();
        addRow();
      });
      function addRow(){

        var count = 1;
        var tr = '<tr class="new_row">'+
                    // '<td>'+ count +'</td>'+
                    '<td><input type="text" class="form-control" required placeholder="Enter Head Name" name="head_name[]" value=""></td>'+
                    '<td>'+
                      '<a href="" class="btn btn-danger delete">X</a></td>'+
                 '</tr>';

        $('tbody').prepend(tr);
        $('#hide_record').hide();
      }

      $(document).on('click','.delete',function(){
        $(this).parent().parent().remove();
        ($('.new_row').length==0) ? $('#hide_record').show() : '' ;
        ($('.new_row').length==0) ? $('#save').hide() : '' ;
        return false;
      });
    </script>
@endpush

