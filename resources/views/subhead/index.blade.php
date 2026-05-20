@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Subhead')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                {{-- <div class="breadcrumb-item"><a href="{{route('expense.heads.show')}}">{{__('Expense')}}</a></div> --}}
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('SubHead')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            <div class="col-md-12 text-center">
              {{-- @foreach(range('A','Z') AS $pagination)
                <a href="{{ route('expense.subheads.show',['search'=>$pagination]) }}" class="badge badge-primary">{{ $pagination }}</a>
              @endforeach --}}
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Subhead')}}</h4>
                        @if(Auth::user()->type == "company" || Auth::user()->can('add subhead') )
                          <div class="card-header-action">
                              <a href="{{ route('expense.subheads.add') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                  <i class="fas fa-plus"></i>{{__('Add SubHead')}}
                              </a>
                          </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                      <table class="table text-center table-bordered dt_table">
                        <thead>
                          <tr style="border: 1px solid #000">
                            <th scope="col" style="border: 1px solid #000">#</th>
                            <th scope="col" style="border: 1px solid #000">Parent Head</th>
                            <th scope="col" style="border: 1px solid #000">SubHead Name</th>
                            <th scope="col" style="border: 1px solid #000">Action</th>

                          </tr>
                        </thead>
                        <tbody>
                          @forelse($data->sortBy('parent.head_name') AS $key=>$value)
                            {{-- @if($value->slug != 'banana') --}}
                              <tr>
                                <th scope="row" style="border: 1px solid #000">{{ $loop->iteration }}</th>
                                <td style="border: 1px solid #000">{{ @$value->parent->head_name }}</td>
                                <td style="border: 1px solid #000">{{ @$value->head_name }}</td>
                                <td style="border: 1px solid #000">
                                  @if(Auth::user()->type == "company" || Auth::user()->can('edit subhead') )
                                    <a href="{{ route('expense.subheads.edit',['id'=>$value->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                  @endif
                                  @if(Auth::user()->type == "company" || Auth::user()->can('delete subhead') )
                                    <a href="javscript:void(0)" class="btn btn-danger" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('expense.subheads.delete',['id'=>$value->id]) }}',''): '' "><i class="fas fa-trash"></i></a>
                                  @endif
                                  </td>
                              </tr>
                            {{-- @endif --}}
                          @empty
                            <tr>
                              <td colspan="4">No Record Found</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                      {{-- <div class="float-right">
                        {{ $data->links() }}
                      </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


