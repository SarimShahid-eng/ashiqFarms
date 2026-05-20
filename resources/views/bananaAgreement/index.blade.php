    @extends('layouts.admin')
    @section('page-title')
        {{__('Head')}}
    @endsection

    @section('content')
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Contracts')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item active">{{__('Banana Agreement')}}</div>
                </div>
            </div>
            <div class="section-body">
                @if(Auth::user()->type == "company" || Auth::user()->can('add banana agreement') )
                    <div class="col-12">
                        <div class="card repeater">
                            <div class="card-header">
                                <h4>{{__('Contract')}}</h4>
                                <a href="{{ route('bananas.contract') }}" class="btn btn-primary ml-auto"><i class="fas fa-plus"></i> Add New Contract</a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="card repeater">
                        <div class="card-header">
                            <h4>{{__('Agreement List')}}</h4>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead class="thead-dark">
                                  <tr style="border: 1px solid #000">
                                    <th style="border: 1px solid #000" scope="col">Contract Date</th>
                                    <th style="border: 1px solid #000" scope="col">End Date</th>
                                    <th style="border: 1px solid #000" scope="col">Contract Acres</th>
                                    <th style="border: 1px solid #000" scope="col">Contract Amount</th>
                                    <th style="border: 1px solid #000" scope="col">Upcoming Amount</th>
                                    <th style="border: 1px solid #000" scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @forelse($agreement AS $data)

                                    <tr style="border: 1px solid #000">
                                        <td style="border: 1px solid #000">{{ get_date($data->agreement_date) }}</td>
                                        <td style="border: 1px solid #000">{{ get_date($data->end_date) }}</td>
                                        <td style="border: 1px solid #000">{{ $data->acres }}</td>
                                        <td style="border: 1px solid #000">{{ get_price($data->agreement_amount) }}</td>
                                        <td style="border: 1px solid #000">{{@number_format( $data->childSchedule->sortBy('pay_date')->first()->due_amount) }}</td>
                                        <td style="border: 1px solid #000">
                                            @if(Auth::user()->type == "company" || Auth::user()->can('edit banana agreement') )
                                                <a href="{{ route('bananas.edit',['id'=>$data->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            @endif
                                            
                                            @if(Auth::user()->type == "company" || Auth::user()->can('delete banana agreement') )
                                                <a href="javascript:void(0)" onclick="return confirm('Are you sure?') ? run_ajax('{{ route('bananas.delete',['id'=>$data->id]) }}','') : '' "
                                              class="btn btn-danger"  ><i class="fas fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center">No Record Found</td></tr>

                                  @endforelse
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @push('script-page')

    @endpush

