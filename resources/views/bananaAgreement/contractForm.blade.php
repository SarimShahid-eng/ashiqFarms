@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection
<style>
    .note-editable { background-color: white !important; color: black !important; }
</style>
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Contract Details')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">{{__('Banana Agreement')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    {{-- <div class="card-header">
                        <h4>{{__('Add New Contract')}}</h4>
                        <a href="" class="btn btn-primary ml-auto"><i class="fas fa-plus"></i> Print</a>
                    </div> --}}
                    <div class="card-body p-0">
                        <div>
                            <h5 class="text-center">Agreement Details</h5>
                            <form action="{{ route('bananas.store') }}" method="POST" class="ajaxForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row p-3">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Agreement Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" required name="agreement_date">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Agreement End Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" required name="end_date">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Acres</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" required name="acres">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Agreement Amount</label>
                                            </div>
                                            <div class="col-md-8">

                                            <input type="text" class="form-control currency" target="#agreement_amount" required name="">

                                                <input type="hidden" id="agreement_amount" required name="agreement_amount">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Contract Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                 <input type="text" required class="form-control" name="contract_name"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>
                                                    Select Image File
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control-file" name="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table" border="0" id="schedule_fields">
                                    <tr>
                                        <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for="">Due Payment Schedule</label></td>
                                        <td style="padding-right: 10px"><input type="date" class="form-control" name="due_date[]"></td>
                                        <td style="padding: 0">
                                        <input type="text" class="form-control currency parent" placeholder="Amount" name="">
                                        <input type="hidden" class="amount" placeholder="Amount" name="due_amount[]">

                                    </td>
                                        <td></td>
                                    </tr>



                                    <tr>
                                        <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for="">Due Payment Schedule</label></td>
                                        <td style="padding-right: 10px"><input type="date" class="form-control" name="due_date[]"></td>
                                        <td style="padding: 0">

                                        <input type="text" class="form-control currency parent" placeholder="Amount" name="">
                                        <input type="hidden" class="amount" placeholder="Amount" name="due_amount[]">
                                    </td>

                                        <td><button class="btn btn-primary" id="add_schedule"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </table>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="">Any Note</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea class="form-control summernote" name="note" id="note" style="height: 200px !important"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 pb-4">
                                        <button class="btn btn-primary">Submit</button>
                                        <button class="btn btn-warning">Cancel</button>
                                    </div>
                                    <input type="hidden" value="{{ Auth::id() }}" name="user_id">
                            </form>
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
        // add the scheduel fields
        $(document).on('click','#add_schedule',function(e){
            e.preventDefault();

            var field = '<tr>'+
                            '<td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label>Due Payment Schedule</label></td>'+
                            '<td style="padding-right: 10px"><input type="date" class="form-control" name="due_date[]"></td>'+
                            '<td style="padding: 0"><input type="text" class="form-control currency parent" placeholder="Amount" name=""><input type="hidden" class="amount" placeholder="Amount" name="due_amount[]"></td>'+
                            '<td><button class="btn btn-danger delete_row"><strong>X</strong></button></td>'+
                        '</tr>';
            $('#schedule_fields').append(field);
            $('.currency').mask('000,000,000,000,000', {reverse: true});

        });
        //remove the schedule fields
        $(document).on('click','.delete_row',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });


        $(function() {

                $('.currency').mask('000,000,000,000,000', {reverse: true});
                $(document).on('keyup','.currency',function(){
                    if($(this).hasClass('parent')){
                        $(this).parent().find('.amount').val($(this).parent().find('.currency').cleanVal());
                        return false;
                    }
                    $($(this).attr('target')).val($('.currency').cleanVal());
                 })

                $('.summernote').summernote({
                 airMode: true,
                 "codemirror": { "theme": "ambiance" },
                });


        })
    </script>
@endpush
