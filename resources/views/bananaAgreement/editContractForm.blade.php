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
                    <div class="card-body p-0">


                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-print-block d-none">
                                    <div class="row">
                                        {{-- <div class="col-4 text-center">
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="" width="230px" height="50px">
                                        </div> --}}
                                        <div class="col-12 text-center">
                                            <h1 style="font-size: 48px; font-family: Algerian; color:red">Aashique Farm</h1>
                                        </div>
                                        {{-- <div class="col-4 text-center">
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="" width="230px" height="50px">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div>
                            <h5 class="text-center mb-4">Agreement Details</h5>
                            <a href="{{ route('bananas.agreement.print',['id'=>@$edit_data->id]) }}" target="_blank" class="d-print-none btn btn-primary float-right" style="
                                position: relative;
                                top: -45px;
                            ">Print</a>

                            <button class="d-print-none btn btn-primary float-right" style="position: relative; top: -45px;" onclick="window.print();">Print This Page</button>

                            <form action="{{ route('bananas.update') }}" method="POST" class="ajaxForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row p-3">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Agreement Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" required name="agreement_date" value="{{ @$edit_data->agreement_date }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Agreement End Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" required name="end_date" value="{{ @$edit_data->end_date }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Acres</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" required name="acres" step="any" value="{{ $edit_data->acres }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Agreement Amount</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control currency" target="#agreement_amount" required name="" value="{{ @$edit_data->agreement_amount }}">

                                                <input type="hidden" id="agreement_amount" required name="agreement_amount" value="{{ @$edit_data->agreement_amount }}">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="">Contract Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="contract_name" value=" {{$edit_data->contract_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-print-none">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>
                                                    Select Image File
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control-file" name="image"><br>
                                                <input type="hidden" name="old_image" value="{{ @$edit_data->image }}">
                                                @if(file_exists($edit_data->image))
                                                    <img src="{{ asset($edit_data->image) }}" alt="" width="350px" height="">
                                                @else
                                                    <img src="{{ asset('public/uploads/no_image.JPG') }}" alt="" width="200px" height="130px">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table" border="0" id="schedule_fields">
                                    @forelse($edit_data->childSchedule AS $schedule)
                                        @if($schedule->status == 'paid')
                                            <tr>
                                                <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for="">Due Payment Schedule</label></td>
                                                <td style="padding-right: 10px">{{ get_date($schedule->due_date) }}</td>
                                                <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for="">Due Amount</label></td>
                                                <td style="min-width: 160px; padding-right:0; padding-left: 10px;">{{ get_price($schedule->due_amount) }}</td>
                                                <td style="min-width: 160px; padding-right:0; padding-left: 10px;">Paid Date: {{ get_date($schedule->pay_date) }}</td>
                                                <td style="min-width: 160px; padding-right:0; padding-left: 10px;">
                                                    <a href="javascript:void(0)" class="btn btn-danger d-print-none" onclick="return confirm('are your sure?') ? run_ajax('{{ route('bananas.schedules.delete',['id'=>$schedule->id]) }}','') : '' "><i class="fas fa-trash"></i></a>
                                                </td>

                                            </tr>
                                        @else
                                            <tr id="my_row{{ $schedule->id }}">
                                                <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for="">Due Payment Schedule</label></td>
                                                <td style="padding-right: 10px"><input type="date" class="form-control" name="due_date[]" value="{{ @$schedule->due_date }}"></td>
                                                <td style="padding: 0">
                                                    <input type="text" class="form-control currency parent" placeholder="Amount" name="" value="{{ @$schedule->due_amount }}"><input type="hidden" class="amount" placeholder="Amount" name="due_amount[]" value="{{ @$schedule->due_amount }}">
                                                </td>
                                                <input type="hidden" name="schedule_id[]" value="{{ $schedule->id }}">
                                                <td style="padding-right: 0;padding-left:15px;min-width: 105px;"><label for="">Payment Paid</label></td>
                                                <td style="padding-right: 10px"><input type="date" class="form-control" name="pay_date[]" value="{{ @$schedule->pay_date }}"></td>
                                                <td>
                                                    @if($schedule->status != 'paid')
                                                    <a class="btn btn-primary get_row d-print-none"  href="javascript:void(0)" id="{{ $schedule->id }}">Paid</a>
                                                    @endif
                                                    <a href="javascript:void(0)" class="btn btn-danger d-print-none" onclick="return confirm('are your sure?') ? run_ajax('{{ route('bananas.schedules.delete',['id'=>$schedule->id]) }}','') : '' "><i class="fas fa-trash"></i></a>

                                                </td>

                                                <td></td>
                                            </tr>
                                        @endif
                                    @empty

                                    @endforelse
                                    <tr>
                                        <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for="">Due Payment Schedule</label></td>
                                        <td style="padding-right: 10px"><input type="date" class="form-control" name="due_date[]"></td>
                                        <td style="padding: 0">

                                        <input type="text" class="form-control currency parent" placeholder="Amount" name=""><input type="hidden" class="amount" placeholder="Amount" name="due_amount[]">
                                    </td>

                                        <td style="padding-right: 0;padding-left:15px;min-width: 105px;"><label for="">Payment Paid</label></td>
                                        <td style="padding-right: 10px"><input type="date" class="form-control" name="pay_date[]"></td>
                                        <td><button class="btn btn-primary  d-print-none" id="add_schedule"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </table>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="">Any Note</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea class="form-control summernote" name="note" id="">{{ @$edit_data->note }}</textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 pb-4">
                                        <button class="btn btn-primary  d-print-none">Submit</button>
                                        <button class="btn btn-warning d-print-none">Cancel</button>
                                    </div>
                                    <input type="hidden" value="{{ Auth::id() }}" name="user_id">
                                    <input type="hidden" value="{{ @$edit_data->id }}" name="id">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        @media print{
            .navbar-bg,
            .main-sidebar,
            .section-header-breadcrumb,
            .navbar{display: none !important;}
            .main-content{padding-left: 0 !important; padding-top: 0 !important}

        }
    </style>

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
                            '<td style="padding-right: 0;padding-left:15px;min-width: 105px;"><label>Payment Paid</label></td>'+
                            '<td style="padding-right: 10px"><input type="date" class="form-control" name="pay_date[]"></td>'+
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
        $(document).on('click','.get_row',function(e){

            var id=$(this).attr('id');
            var due_date =$(`#my_row${id}`).find('input[name="due_date[]"]').val();
            var due_amount =$(`#my_row${id}`).find('input[name="due_amount[]"]').val();
            var pay_date = $(`#my_row${id}`).find('input[name="pay_date[]"]').val();

            var params = {id:id,due_date:due_date,due_amount:due_amount,pay_date:pay_date,status:'paid'}

            getAjaxRequests("{{ url('banana/paid') }}", params, "GET", function(data){
                if(data.success){
                    toast(data.success, 'Success!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                }
            },true)
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

        //paid function
    </script>
@endpush

