@extends('layouts.inventory_admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Consumer') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active">{{ __('Consumer') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">

                    <div class="card-body  p-0">
                        <form action="{{ route('inventory.stock.stock_consumes_store') }}" method="POST" class="ajaxForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="main_type_body">
                                <div class="form-group main_type_row row p-2 d-flex align-items-center">
                                    <div class="col-md-2 col-form-label">
                                        <label for="">
                                            {{ @$stock_consume_upd->id ? __('Update') : __('Add') }}
                                            Consumer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" id="update_id" value="{{ @$stock_consume_upd->id }}"
                                            class="form-control" name="update_id">
                                        <input type="text" value="{{ @$stock_consume_upd->stock_consume }}"
                                            class="form-control" required="" name="stock_consume">
                                    </div>

                                    <div class="col-md-3 ">
                                        <button class="btn btn-primary">
                                            {{ @$stock_consume_upd->id ? __('Update') : __('Add') }}</button>
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
                        <h4>Added consumer</h4>
                    </div>
                    <div class="card-body p-3">

                        <table class="table text-center">
                            <thead>
                                <tr style="border: 1px solid #000">
                                    <th scope="" style="border: 1px solid #000">#</th>
                                    <th scope="" style="border: 1px solid #000">Consumer</th>
                                    <th scope="col" style="border: 1px solid #000">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stock_consumes as $stock_consume)
                                    <tr style="border: 1px solid #000">
                                        <td style="border: 1px solid #000">{{ $stock_consume->id }}</td>
                                        <td style="border: 1px solid #000">{{ $stock_consume->stock_consume }}</td>
                                        <td style="border: 1px solid #000">
                                            <a href="{{ route('inventory.stock.stock_consume', ['id' => $stock_consume->id]) }}"
                                                class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-danger"
                                                onclick="return confirm('are you sure?') ? run_ajax('{{ route('inventory.stock.stock_consume_delete', ['id' => $stock_consume->id]) }}',''): '' "><i
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
        //         $(document).ready(function(){

        //     if($('#update_id').val() !== ''){
        //         // alert('asdsa')
        //         $('#add_type_col').hide();
        //     }
        // })
    </script>
@endpush
