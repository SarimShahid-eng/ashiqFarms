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
            <h1>Add Entry Reason</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('accounts.banks.show')}}">Accounts</a></div>
                <div class="breadcrumb-item active">{{__('Entry Reason')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card repeater">
                  <div class="card-header">
                    <h4>{{ isset($is_update) ? 'Update' : 'Add' }} Entry Reason</h4>
                  </div>
                  @if(Auth::user()->type == "company" || Auth::user()->can('add banks') || (Auth::user()->can('edit banks') && isset($is_update)) )
                    <div class="card-body p-3">
                      <form action="{{ route('accounts.customer_accounts.reasons.store') }}" method="POST" class="ajaxForm" id="form">
                        @csrf
                        <div class="row">
                          <div class="col-md-10">
                            <input type="text" class="form-control" required value="{{ @$update->reason }}" name="reason">
                          </div>
                          <div class="col-md-2">
                            <input type="submit" class="btn btn-primary" value="{{ isset($is_update) ? 'Update':'Add' }}">
                          </div>
                        </div> 
                        <input type="hidden" name="reason_id" value="{{ @$update->id }}"> 
                      </form>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">
            </div>
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Entries Reason</h4>
                    </div>
                    <div class="card-body p-3">
                          <table class="table text-center">
                            <thead>
                              <tr style="border: 1px solid #000">
                                <th scope="" style="border: 1px solid #000">#</th>
                                <th scope="" style="border: 1px solid #000">Reason</th>
                                <th scope="col" style="border: 1px solid #000">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($data AS $key=>$value)
                              <tr style="border: 1px solid #000">
                                <td style="border: 1px solid #000">{{  $data->firstItem()+$key }}</td>
                                <td style="border: 1px solid #000">{{ $value->reason }}</td>
                                <td style="border: 1px solid #000">
                                  
                                  @if(Auth::user()->type == "company" || Auth::user()->can('edit banks') )
                                    <a href="{{ route('accounts.customer_accounts.reasons.edit',['id'=>$value->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                  @endif
                                  
                                  @if(Auth::user()->type == "company" || Auth::user()->can('delete banks') )
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="return confirm('are you sure?') ? run_ajax('{{ route('accounts.customer_accounts.reasons.delete',['id'=>$value->id]) }}',''): '' "><i class="fas fa-trash"></i></a>
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

      function addRow(){

        var count = 1;
        var tr = '<tr class="new_row">'+
                    '<td><input type="text" class="form-control" required placeholder="Enter Bank Name" name="bank_name[]" value=""></td>'+
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

