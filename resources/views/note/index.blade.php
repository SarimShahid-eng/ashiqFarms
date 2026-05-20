@extends('layouts.admin')
@section('page-title')
    {{ __('Head') }}
@endsection

@section('content')
    <style>
        .note-toolbar.card-header {
            display: inline-block !important;
        }

        .navbar {

            z-index: 1;

        }

        #Notepad {
            display: none;
        }
    </style>
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
                        <h4>{{ __('Note') }}</h4>
                        <button type="button" id="AddNote" class="btn btn-primary rou"> <i class="fa fa-plus"
                                aria-hidden="true"></i>Add Note</button>

                    </div>
                    <div class="card-body  p-4">

                        <form action="{{ route('note.store') }}" method="POST" class="ajaxForm p-2" id="form"
                            novalidate="">
                            @csrf
                            <div id="Notepad" class=" form-row">
                                <div class="col-md-8">
                                    <textarea id="summernote" class="summernote" name="note" cols="30" rows="10">{{ @$id->note }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Price</label>
                                    <input type="number" class="form-control" name="price" required=""
                                        value="{{ @$id->price }}">
                                </div>
                                <div class="d-block btn-div w-100">
                                    <input type="hidden" id="update_id" name="update_id" value="{{ @$id->id }}">
                                    <input type="submit" class="btn btn-primary float-right mt-3 mb-5"
                                        value="@if (@$id->id) {{ __('Update') }}@else {{ __('Add') }} @endif  ">
                                </div>
                            </div>

                        </form>
                        <div class="col-12 mt-5">
                            <div class="card repeater">
                                <div class="card-header">
                                    <h4>{{ __('Note') }}</h4>

                                </div>
                                {{-- <h4>{{@$id->price}}</h4> --}}
                                <div class="card-body p-0">
                                    <table class="table text-center table-bordered" id="table">
                                        <thead>
                                            <tr style="border: 1px solid #000">
                                                <th scope="col" style="border: 1px solid #000">#</th>
                                                <th scope="col" style="border: 1px solid #000">Note</th>
                                                <th scope="col" style="border: 1px solid #000">price</th>
                                                {{-- <th scope="col" style="border: 1px solid #000">Child Head Name</th>
                                        <th scope="col" style="border: 1px solid #000">Forth Head Name</th> --}}
                                                <th scope="col" style="border: 1px solid #000">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php $count = 1 @endphp

                                            @foreach ($data as $val)
                                                {{-- @dd($val); --}}
                                                <tr>
                                                    <td style="border: 1px solid #000"> {{ @$count++ }}</td>
                                                    <td style="border: 1px solid #000"> {!! @$val->note !!}</td>
                                                    <td style="border: 1px solid #000"> {{ @$val->price }}</td>

                                                    <td style="border: 1px solid #000">
                                                        <a href="{{ route('note.edit', ['id' => @$val->id]) }}"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <a href="javscript:void(0)" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?') ? run_ajax('{{ route('note.delete', ['id' => @$val->id]) }}',''): '' "><i
                                                                class="fas fa-trash"></i></a>
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
                    @endsection
                    @push('script-page')
                        <script>
                            $(document).ready(function() {
                                let upd_id = $('#update_id').val();
                                if (upd_id == '') {
                                    $('#Notepad').hide();

                                } else {
                                    // alert('its not null');
                                    $('#Notepad').css({
                                        'display': 'flex'
                                    });

                                }
                                $(document).on('click', '#AddNote', function() {
                                    let Note = $('#Notepad');
                                    Note.toggleClass("flex-display");
                                    if (Note.hasClass("flex-display")) {
                                        Note.slideDown('slow').css("display", "flex");
                                    } else {
                                        Note.slideUp('slow');
                                    }
                                })

                            })
                            $('#summernote').summernote({
                                placeholder: 'Type Notes Here...',
                                tabsize: 2,
                                height: 100,
                                disableDragAndDrop: true,

                                toolbar: [
                                    // [groupName, [list of button]]
                                    ['style', ['style']],
                                    ['font', ['underline', 'strikethrough', 'superscript', 'subscript']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['fontname', ['fontname']],

                                    // ['height', ['height']]
                                ]
                            });
                            $("#table").dataTable({
                                "lengthMenu": [100, 150, 200],
                                "columnDefs": [{
                                    targets: [0, 2, 3, 4],
                                    searchable: false
                                }, ]
                            });
                        </script>
                    @endpush
