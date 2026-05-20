@extends('layouts.admin')
@section('page-title')
    {{ __('Head') }}
@endsection

@section('content')

    <section class="section">


        <div class="section-header">
            <h1>{{ __('Entries') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active">{{ __('Note') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <button type="button" id="AddNote" class="btn btn-primary rou" onclick="createStickyNote()"> <i class="fa fa-plus"
                                aria-hidden="true"></i>Add Note</button>

                    </div>
                    <div class="card-body  p-0">


                        <div class="col-12">
                            <div class="card repeater">
                                <div class="card-header">
                                    {{-- <h4>{{ __('Note') }}</h4> --}}

                                </div>
                                <div class="card-body p-0">
                                    <table class="table text-center table-bordered" id="table">
                                        <thead>
                                            <tr style="border: 1px solid #000">
                                                <th scope="col" style="border: 1px solid #000">Sr</th>
                                                <th scope="col" style="border: 1px solid #000">Note</th>
                                                <th scope="col" style="border: 1px solid #000">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php $count = 1 @endphp

                                            @foreach ($note as $val)
                                                {{-- @dd($val->noteId); --}}
                                                <tr>
                                                    <td style="border: 1px solid #000"> {{ @$count++ }}</td>
                                                    <td style="border: 1px solid #000"> {!! @$val->note !!}</td>

                                                    <td style="border: 1px solid #000">
                                                        <button  type="button" onclick="createStickyNote(`{{@$val->noteId}}`, `{{@$val->name}}`, `{{@$val->note}}`, ``)"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-danger delete"
                                                        onclick="if (confirm('Are you sure?')) { deleteStickyNote('{{@$val->noteId}}')} else {return false}"><i
                                                                class="fas fa-trash"></i></button>
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
                </div>
            </div>
        </div>
    </section>
                    @endsection
                    @push('script-page')
                        <script>
                            $(document).ready(function() {


                            })

                            // $("#table").dataTable({
                            //     "lengthMenu": [100, 150, 200],
                            //     "columnDefs": [{
                            //         targets: [0, 2, 3],
                            //         searchable: false
                            //     }, ]
                            // });
                        </script>
                    @endpush
