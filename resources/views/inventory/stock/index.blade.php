@extends('layouts.inventory_admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Stock Details') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active">{{ __('Stock') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    {{-- Stock name quantity consumed --}}
                    <div class="card-body  p-0">
                        <form action="{{ route('inventory.stock.store') }}" method="POST" class="ajaxForm"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden"name="update_id" value="{{@$stock_update->id}}">
                            <div class="form-row pb-2">
                                <div class="col-md-6">
                                    <label for="">Stock Name</label>
                                    <input type="text" value="{{@$stock_update->name}}" class="form-control" name="name" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Stock price</label>
                                    <input type="number" value="{{@$stock_update->price}}" class="form-control" name="price" required=""
                                        >
                                </div>
                            </div>
                            <div class="form-row pb-2">
                                <div class="col-md-6">
                                    <label for="">Stock Qty</label>
                                    <input type="number" value="{{@$stock_update->qty}}" class="form-control" name="qty" required="">
                                </div>
                                {{-- stock_consume --}}
                                <div class="col-md-6">
                                    <label for="">Stock Consumed</label>

                                    <select class="form-control" data-toggle="select2" name="stock_consume_id">
                                        <option value="" selected disabled>Select Stock Consumed</option>
                                        @if (empty($stock_update))
                                                @foreach ($stock_consumes as $stock_consume)
                                                    <option value="{{ @$stock_consume->id }}">
                                                       {{$stock_consume->stock_consume}}
                                                    </option>
                                                @endforeach
                                        @else

                                            @foreach ($stock_consumes as $stck_emp)
                                                <option value="{{ @$stck_emp->id }}"
                                                    {{ @$stock_update->stock_consume_id == @$stck_emp->id ? 'selected' : '' }}>
                                                    {{ @$stck_emp->stock_consume}}
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="form-row pb-2 d-flex align-items-center">
                                <div class="col-md-6">
                                    <label for="">Employee</label>
                                    <select class="form-control" data-toggle="select2" name="employees_id">
                                        <option value="" selected disabled>Select Employee</option>
                                        @if (empty($stock_update))
                                                @foreach ($employees as $employee)
                                                    <option value="{{ @$employee->id }}">
                                                        {{ @$employee->name }} - {{$employee->type->employees_type}}
                                                    </option>
                                                @endforeach
                                        @else
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ @$stock_update->employees_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->name }} - {{$emp->type->employees_type}}
                                                </option>
                                            @endforeach
                                        @endif
                                         {{-- @foreach ($employees as $employee)
                                            <option value="{{ @$employee->id }}">
                                                {{ @$employee->name }}
                                            </option>
                                        @endforeach  --}}
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <button class="btn btn-primary"> {{@$stock_update->id?__('Update'):__('Add')}}</button>
                                    {{-- <button class="btn btn-warning">Cancel</button> --}}
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Stock List</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr style="border: 1px solid #000">
                                    <th style="border: 1px solid #000" scope="col">Stock Name</th>
                                    <th style="border: 1px solid #000" scope="col"> Price</th>
                                    <th style="border: 1px solid #000" scope="col"> Qty</th>
                                    <th style="border: 1px solid #000" scope="col">Consumed</th>
                                    <th style="border: 1px solid #000" scope="col"> Employee</th>
                                    <th style="border: 1px solid #000" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($stock_employees as $stemploy)
{{-- {{}} --}}
                                <tr style="border: 1px solid #000">
                                    <td style="border: 1px solid #000">{{$stemploy->name}}</td>
                                    <td style="border: 1px solid #000">{{$stemploy->price}}</td>
                                    <td style="border: 1px solid #000">{{$stemploy->qty}}</td>
                                    <td style="border: 1px solid #000">{{$stemploy->stock_consume->stock_consume}}</td>
                                    <td style="border: 1px solid #000">{{$stemploy->employees->name }}-{{$stemploy->employees->type->employees_type}}</td>
                                    <td style="border: 1px solid #000">
                                        <a href="{{route('inventory.stock.index',['id'=>$stemploy->id])}}"
                                        class="btn btn-primary"><i class="fas fa-edit"></i></a>

                                        <a href="javascript:void(0)"
                                        onclick="return confirm('Are you sure?') ? run_ajax('{{route('inventory.stock.delete',['id'=>$stemploy->id])}}','') : '' "
                                        class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
@endsection
