@extends('layouts.inventory_admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Employees Details') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active">{{ __('Employee') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">

                    <div class="card-body  p-0">

                    </div>
                    <form action="{{ route('inventory.employees.store') }}" method="POST" class="ajaxForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="main_body">
                            <div class="form-group main_row row p-2">
                                <div class="col-md-1 col-form-label">
                                    <input type="hidden" value="{{ @$employees_update->id }}" name="update_id"
                                        id="">
                                    <label for="">Type</label>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" data-toggle="select2" name="employees_type_id">
                                        <option value="" selected disabled>Select Type</option>
                                        @if (empty($employees_update->id))
                                            @foreach ($employee_types as $employee_typ)
                                                <option value="{{ @$employee_typ->id }}">
                                                    {{ @$employee_typ->employees_type }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($employee_types as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ @$employees_update->employees_type_id == $emp->id ? 'selected' : '' }}>
                                                    {{ $emp->employees_type }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-1 col-form-label">
                                    <label for="">Employees</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" required="" name="name"
                                        value="{{ @$employees_update->name }}">
                                </div>
                                <div class="col-md-3">
                                    <button
                                        class="btn btn-primary">{{ @$employees_update->employees_type_id ? __('Update') : __('Add') }}</button>
                                    <button class="btn btn-warning">Cancel</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <div class="row">

            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Employees </h4>

                    </div>
                    <div class="card-body p-3">

                        <table class="table text-center">
                            <thead>
                                <tr style="border: 1px solid #000">
                                    <th scope="" style="border: 1px solid #000">#</th>
                                    <th scope="" style="border: 1px solid #000">Name</th>
                                    <th scope="" style="border: 1px solid #000">Type</th>
                                    <th scope="col" style="border: 1px solid #000">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employ)
                                    <tr style="border: 1px solid #000">
                                        <td style="border: 1px solid #000">{{ $employ->id }}</td>
                                        <td style="border: 1px solid #000">{{ $employ->name }}</td>
                                        <td style="border: 1px solid #000">{{ $employ->type->employees_type }}</td>
                                        <td style="border: 1px solid #000">
                                            <a href="{{ route('inventory.employees.index', ['id' => $employ->id]) }}"
                                                class="btn btn-primary"><i class="fas fa-edit"></i></a>

                                            <a href="javascript:void(0)" class="btn btn-danger"
                                                onclick="return confirm('are you sure?') ? run_ajax('{{ route('inventory.employees.delete', ['id' => $employ->id]) }}',''): '' "><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>

                        </table>
                        <div class="pagin text-center">

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
@endsection
@push('script-page')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js
                            "></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
