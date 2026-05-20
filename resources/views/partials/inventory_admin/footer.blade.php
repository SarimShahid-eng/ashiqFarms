<script src="{{ asset('assets/modules/jquery.min.js') }} "></script>

<script src="{{ asset('assets/modules/popper.js') }} "></script>
<script src="{{ asset('assets/modules/tooltip.js') }} "></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }} "></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script>
    moment.locale('{{App::getLocale()}}');
</script>

<!-- <script src="{{ asset('assets/js/stisla.js') }} "></script> -->

<script src="{{ asset('assets/modules/jquery.sparkline.min.js') }} "></script>
<!--
<script src="{{ asset('assets/modules/chart/Chart.min.js') }} "></script>
<script src="{{ asset('assets/modules/chart/Chart.extension.js') }} "></script> -->


<script src="{{ asset('assets/modules/datatables/datatables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/modules/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/bootstrap-toastr/ui-toastr.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }} "></script>

<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }} "></script>
<script src="{{ asset('assets/js/jquery.easy-autocomplete.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}} "></script>

<script src="{{ asset('assets/js/jscolor.js') }} "></script>
<script src="{{ asset('assets/js/scripts.js') }} "></script>
<!-- <script src="{{ asset('assets/js/custom.js') }} "></script> -->
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script src="{{ asset('assets/admin_assets/js/flatpickr.js') }}"></script>
<!-- <script src="{{ asset('assets/admin_assets/js/app.min.js') }}"></script> -->
<script src="https://parsleyjs.org/dist/parsley.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>


<script src="{{ asset('assets/admin_assets/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    var date_picker_locale = {
        format: 'YYYY-MM-DD',
        daysOfWeek: [
            "{{__('Sun')}}",
            "{{__('Mon')}}",
            "{{__('Tue')}}",
            "{{__('Wed')}}",
            "{{__('Thu')}}",
            "{{__('Fri')}}",
            "{{__('Sat')}}"
        ],
        monthNames: [
            "{{__('January')}}",
            "{{__('February')}}",
            "{{__('March')}}",
            "{{__('April')}}",
            "{{__('May')}}",
            "{{__('June')}}",
            "{{__('July')}}",
            "{{__('August')}}",
            "{{__('September')}}",
            "{{__('October')}}",
            "{{__('November')}}",
            "{{__('December')}}"
        ],
    };

    var calender_header = {
        today: "{{__('today')}}",
        month: '{{__('month')}}',
        week: '{{__('week')}}',
        day: '{{__('day')}}',
        list: '{{__('list')}}'
    };
    $(document).ready(function(){
    var form = $('#form'),
        original = form.serialize()

    form.submit(function(){
        window.onbeforeunload = null
    })

    window.onbeforeunload = function(){
        if (form.serialize() != original)
            return 'Are you sure you want to leave?'
    }
    //check if any dues remain
    $.ajax({
        url : "{{ route('bananas.late') }}",
        type: "GET",
        success:function(data){
            // console.log(data);
            $('#dues_links').empty().append(data);
        }

    });


    $.ajax({
        url : "{{ route('some_changes') }}",
        type: "GET",
        success:function(data){
            console.log(data);
            if(data.expenses){
                $("#some_changes").show();
            }
            // $('#dues_links').empty().append(data);
        }

    });
})
</script>

@if ($message = Session::get('success'))
    <script>
        toastrs('Success', '{!! $message !!}', 'success')
    </script>
@endif

@if ($message = Session::get('error'))
    <script>toastrs('Error', '{!! $message !!}', 'error')</script>
@endif

@if ($message = Session::get('info'))
    <script>toastrs('Info', '{!! $message !!}', 'info')</script>
@endif

@stack('script-page')
