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
<script src="{{ asset('assets/js/sticky-notes.js')}}"></script>


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
            if($.inArray("upcoming",data)!=-1){
                $('#upcoming').attr('class','btn green button mr-3');

            }
            if($.inArray("late",data)!=-1){
                $('#late').attr('class','btn red button mr-3');
            }
            // $('#dues_links').empty().append(data);
        }

    });


    $.ajax({
        url : "{{ route('some_changes') }}",
        type: "GET",
        success:function(data){
            if(data.expenses){
                $('#some_changes').find('a').attr('class','btn red button mr-3');
            }
            // $('#dues_links').empty().append(data);
        }

    });
})


            function saveNotes(obj) {

                const notes = document.getElementsByClassName("note");
                const notesArray = Array.from(notes).map(note => ({
                    id: note.querySelector(".note-id").innerText,
                    name: note.querySelector(".note-name").innerText.trim(),
                    note: note.querySelector(".note-content").innerText,
                    color: '#edcf71',
                    status: note.querySelector(".note-status").innerText.trim(),
                }));

                $.ajax({
                    url: '{{ route('admin.notes.save') }}',
                    type: 'POST', // Change method to POST for data modification
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(notesArray[0]),
                    success: function (res) {
                        // console.log(notesArray);
                        html=`<li id="note_${notesArray[0].id}">
                        <button onclick='createStickyNote("${notesArray[0].id}","${notesArray[0].name}", "${notesArray[0].note}","${notesArray[0].color}")' class="text-overflow m-0 notes-button-dropdown text-start">${notesArray[0].name} </button>
                        </li>`;
                        if($('#note_'+notesArray[0].id).length>0){
                            $('#note_'+notesArray[0].id).html(`<button onclick='createStickyNote("${notesArray[0].id}","${notesArray[0].name}","${notesArray[0].note}", "${notesArray[0].color}")' class="text-overflow m-0 notes-button-dropdown text-start">${notesArray[0].name} </button>`);
                            // return false;
                        }else{
                            $('.notes-content').find('ul').prepend(html);
                        }
                        obj.parentNode.parentNode.remove()
                        // console.log("Notes saved successfully");
                        // Optionally handle success response
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // console.error("Error saving notes:", textStatus, errorThrown);
                        // Optionally handle error response
                    }
                });
            }

            function deleteStickyNote(noteId) {
                const deleteButton = event.target;
                console.log(deleteButton.classList);
                if (deleteButton.classList.contains("delete")) {
                    const note = deleteButton.parentNode.parentNode;

                    const noteid = noteId;

                    $.ajax({
                        url: '{{ route('admin.notes.delete') }}?id='+noteid,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function (res) {
                            // console.log("Notes deleted successfully");
                            $('#note_'+noteid).remove();
                            // window.location.reload(true);
                            // Optionally handle success response
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // console.error("Error saving notes:", textStatus, errorThrown);
                            // Optionally handle error response
                        }
                    });

                    note.remove();
                }

            }

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
