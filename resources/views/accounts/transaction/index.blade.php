@extends('layouts.admin')
@section('page-title')
    {{__('Transaction Mode')}}
@endsection
@section('content')

<style>
.pagin .pagination{display: inline-block;}
.pagin .pagination li{display: inline-block;}
</style>

    <section class="section">
        <div class="section-header">
            <h1>{{__('Transaction Mode')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Transaction Mode')}}</div>
                <div class="breadcrumb-item active">{{__('Add')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            @if(Auth::user()->type == "company" || Auth::user()->can('add transaction') || (Auth::user()->can('edit transaction') && isset($is_update)) )
            <div class="col-12">
              <div class="card repeater">
                <div class="card-header">
                  <h4>{{ isset($is_update)?'Update':'Add' }} Transcation Mode</h4>
                </div>
                <div class="card-body">
                  <form action="{{ route('accounts.customer_accounts.transaction.store') }}" method="POST" class="ajaxForm" id="form">
                    @csrf
                    <div class="form-group row">
                      <div class="col-md-10">
                        <input type="text" class="form-control" value="{{ @$update->mode }}" name="mode">
                      </div>
                      <div class="col-md-2">
                        <input type="submit" class="btn btn-primary" value="{{ isset($is_update)?'Update':'Add' }}">
                        <input type="hidden" value="{{ @$update->id }}" name="transaction_id">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @endif
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Transaction Mode')}}</h4>
                    </div>
                    <div class="card-body p-0">
                          <table class="table text-center">
                            <thead>
                              <tr style="border: 1px solid #000">
                                <th scope="" style="border: 1px solid #000">#</th>
                                <th scope="" style="border: 1px solid #000">Transaction Mode</th>
                                <th scope="col" style="border: 1px solid #000">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($data AS $key=>$value)
                              <tr style="border: 1px solid #000">
                                <td style="border: 1px solid #000">{{ $data->firstItem()+$key }}</td>
                                <td style="border: 1px solid #000">{{ $value->mode }}</td>
                                <td style="border: 1px solid #000">
                                  @if(Auth::user()->type == "company" || Auth::user()->can('edit transaction') )    
                                    <a href="{{ route('accounts.customer_accounts.transactions.show',['id'=>$value->id]) }}" class="btn btn-primary">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  @endif
                                  @if(Auth::user()->type == "company" || Auth::user()->can('delete transaction') )    
                                  <a href="javascript:void(0)" onclick="return confirm('are you sure') ? run_ajax('{{  route('accounts.customer_accounts.transaction.delete',['id'=>$value->id]) }}'): '' " class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                  </a>
                                  @endif
                                </td>
                              </tr>
                              @empty
                                <tr>
                                  <td colspan="3" id="hide_record">No Record Found</td>
                                </tr>
                              @endforelse
                            </tbody>

                          </table>
                          <div class="pagin text-center">
                          {{ $data->links() }}
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
    <script>
      $('#add_head').on('click',function(e){
        e.preventDefault();
        addRow();
      });
      // var count = {{ $data->lastItem() }};
      function addRow(){

        var count = 1;
        var tr = '<tr class="new_row">'+
                    // '<td>'+ count +'</td>'+
                    '<td><input type="text" class="form-control" required placeholder="Enter Mode Name" name="mode[]" value=""></td>'+
                    '<td>'+
                      '<a href="" class="btn btn-danger delete">X</a></td>'+
                 '</tr>';

        $('tbody').prepend(tr);
      $('#hide_record').hide();
      }

      $(document).on('click','.delete',function(){
        $(this).parent().parent().remove();
        ($('.new_row').length==0) ? $('#hide_record').show() : '' ;
        return false;
      });
    </script>
@endpush

