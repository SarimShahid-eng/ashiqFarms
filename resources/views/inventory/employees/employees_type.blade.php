@extends('layouts.inventory_admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Employees Type') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active">{{ __('Employee type') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">

                    <div class="card-body  p-0">
                        <form action="{{ route('inventory.employees.type_store') }}" method="POST" class="ajaxForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="main_type_body">
                                <div class="form-group main_type_row row p-2 d-flex align-items-center">
                                    <div class="col-md-2 col-form-label">
                                        <label for="">{{ @$employees_upd->id ? __('Update') : __('Add') }} Type</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" id="update_id" value="{{@$employees_upd->id}}" class="form-control"  name="update_id">
                                        <input type="text" value="{{@$employees_upd->employees_type}}" class="form-control" required="" name="employees_type">
                                    </div>

                                    <div class="col-md-3 ">
                                        <button class="btn btn-primary"> {{@$employees_upd->employees_type?__('Update'):__('Add')}}</button>
                                        <button class="btn btn-warning">Cancel</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Added Employees Type</h4>
                    </div>
                    <div class="card-body p-3">

                        <table class="table text-center">
                            <thead>
                                <tr style="border: 1px solid #000">
                                    <th scope="" style="border: 1px solid #000">#</th>
                                    <th scope="" style="border: 1px solid #000">Employees Types</th>
                                    <th scope="col" style="border: 1px solid #000">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee_types as $employ_typed)
                                    <tr style="border: 1px solid #000">
                                        <td style="border: 1px solid #000">{{ $employ_typed->id }}</td>
                                        <td style="border: 1px solid #000">{{ $employ_typed->employees_type }}</td>
                                        <td style="border: 1px solid #000">
                                            <a href="{{route('inventory.employees.employees_type',['id'=>$employ_typed->id])}}"
                                                class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-danger"
                                                onclick="return confirm('are you sure?') ? run_ajax('{{route('inventory.employees.employees_type.delete',['id'=>$employ_typed->id])}}',''): '' "><i
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
    </section>
@endsection
@push('script-page')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js
                    "></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <script>

        $(document).ready(function(){

    if($('#update_id').val() !== ''){
        // alert('asdsa')
        $('#add_type_col').hide();
    }
})

    </script>
@endpush
