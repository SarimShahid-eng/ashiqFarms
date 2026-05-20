@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Thirt Head')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                {{-- <div class="breadcrumb-item"><a href="{{route('expense.heads.show')}}">{{__('Expense')}}</a></div> --}}
                <div class="breadcrumb-item active">{{__('Expense')}}</div>
                <div class="breadcrumb-item active">{{__('Third Head')}}</div>
            </div>
        </div>
        <div class="section-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="row">
            </div>
            <div class="col-md-12 text-center">
              {{-- @foreach(range('A','Z') AS $pagination)
                <a href="{{ route('expense.child.subheads.show',['search'=>$pagination]) }}" class="badge badge-primary">{{ $pagination }}</a>
              @endforeach --}}
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>{{__('Third Head')}}</h4>
                        @if(Auth::user()->type == "company" || Auth::user()->can('add third subhead') )
                          <div class="card-header-action">
                              <a href="{{ route('expense.child.subheads.add') }}"  class="btn btn-icon icon-left btn-primary" id="add_head">
                                  <i class="fas fa-plus"></i>{{__('Add Third SubHead')}}
                              </a>
                          </div>
                        @endif
                    </div>
                    {{-- <form action="{{ route('expense.child.subheads.show') }}" method="GET">
                      @csrf
                      <div class="row mt-3">
                        <div class="form-group col-md-10">
                          <input type="text" class="form-control" name="search" id="search" placeholder="Search">
                        </div>

                        <div class="form-group col-md-2">
                          <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        </div>
                      </div>
                    </form> --}}
                    <div class="card-body p-0">
                      <table class="table text-center table-bordered" id="table">
                        <thead>
                          <tr style="border: 1px solid #000">
                            <th scope="col" style="border: 1px solid #000">#</th>
                            <th scope="col" style="border: 1px solid #000">Head Name</th>
                            <th scope="col" style="border: 1px solid #000">Subhead Name</th>
                            <th scope="col" style="border: 1px solid #000">Child Head Name</th>
                            <th scope="col" style="border: 1px solid #000">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          {{-- @forelse ($heads->sortBy('inverse_child.head_name') as $key=>$head)
                          <tr>
                            <td style="border: 1px solid #000">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000">{{ @$parent[$head->inverseChild->parent_id]->head_name }}</td>

                            <td style="border: 1px solid #000">{{ @$head->inverseChild->head_name }}</td>
                            <td style="border: 1px solid #000">{{ @$head->head_name }}</td>
                            <td style="border: 1px solid #000">
                              @if(Auth::user()->type == "company" || Auth::user()->can('edit third subhead') )
                                <a href="{{ route('expense.child.subheads.edit',['id'=>$head->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                              @endif
                              @if(Auth::user()->type == "company" || Auth::user()->can('delete third subhead') )
                                <a href="javscript:void(0)" class="btn btn-danger" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('expense.child.subheads.delete',['id'=>$head->id]) }}',''): '' "><i class="fas fa-trash"></i></a>
                              @endif
                              </td>
                          </tr>
                          @empty
                              <td colspan="5" class="text-center">No Record Found</td>
                          @endforelse --}}
                          @php $count = 0 @endphp
                          {{-- @foreach($headss AS $head)
                            @foreach($head->sub AS $sub_head)
                              @foreach($sub_head->child AS $child)
                                <tr>
                                  <td style="border: 1px solid #000">{{ ++$count }}</td>
                                  <td style="border: 1px solid #000">{{$head->head_name }}</td>

                                  <td style="border: 1px solid #000">{{ $sub_head->head_name }}</td>
                                  <td style="border: 1px solid #000">{{ @$child->head_name }}</td>
                                  <td style="border: 1px solid #000">
                                    @if(Auth::user()->type == "company" || Auth::user()->can('edit third subhead') )
                                      <a href="{{ route('expense.child.subheads.edit',['id'=>$child->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @if(Auth::user()->type == "company" || Auth::user()->can('delete third subhead') )
                                      <a href="javscript:void(0)" class="btn btn-danger" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('expense.child.subheads.delete',['id'=>$child->id]) }}',''): '' "><i class="fas fa-trash"></i></a>
                                    @endif
                                    </td>
                                </tr>
                              @endforeach
                            @endforeach
                          @endforeach --}}
                          @foreach($headss AS $val)
                                <tr>
                                  <td style="border: 1px solid #000">{{ ++$count }}</td>
                                  <td style="border: 1px solid #000">{{ @$val->first_name }}</td>
                                  <td style="border: 1px solid #000">{{ @$val->second_name }}</td>
                                  <td style="border: 1px solid #000">{{ @$val->third_name }}</td>
                                  <td style="border: 1px solid #000">
                                    @if(Auth::user()->type == "company" || Auth::user()->can('edit third subhead') )
                                      <a href="{{ route('expense.child.subheads.edit',['id'=>$val->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @if(Auth::user()->type == "company" || Auth::user()->can('delete third subhead') )
                                      <a href="javscript:void(0)" class="btn btn-danger" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('expense.child.subheads.delete',['id'=>$val->id]) }}',''): '' "><i class="fas fa-trash"></i></a>
                                    @endif
                                    </td>
                                </tr>
                                 @endforeach
                        </tbody>
                      </table>
                      <div class="float-right">
                        {{-- {{ $heads->links() }} --}}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script-page')
    <script>
        $("#table").dataTable({
          "lengthMenu": [100, 150, 200],
          "columnDefs": [
              {
                  targets: [0,2,3,4],
                  searchable: false
              },
          ],
          
      });
    </script>
@endpush

