@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@section('content')
@push('css-page')
    <link href="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script-page')
    <script src="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endpush
<style>
.row .card{
    background-color:transparent;
}
.card .card-body{
    padding:0;
    background-color:transparent;
}
.card-body{
    padding:0rem;
}
/*.btn{*/
/*    background-color:green;*/
/*    -webkit-border-radius: 10px;*/
/*    color: #FFFFFF;*/
/*    cursor: pointer;*/
/*    display: inline-block;*/
/*    text-align: center;*/
/*    -webkit-animation: glowing 1500ms infinite;*/
/*    -moz-animation: glowing 1500ms infinite;*/
/*    -o-animation: glowing 1500ms infinite;*/
/*    animation: glowing 1500ms infinite;*/
/*}*/
.button-green{
        /*background-color:green !important;*/
        color:#fff;
        border:none;
        animation: glowing_green 2000ms linear infinite;
}
@keyframes glowing_green{
    0% {
    background-color: #7ce464;
    box-shadow: 0 0 3px #7ce464;
}   50% {
    background-color: #5b9e4d;
    box-shadow: 0 0 3px #5b9e4d;
}   100% {
    background-color: #7ce464;
    box-shadow: 0 0 3px #7ce464;
}
}
.button-green:hover{
        background-color:green !important;
        color:#fff;
}
.background{
        /*color: #000 !important;*/
        color: #fff !important;
        /*background: #ffff !important;*/
        /*background: #c33838 !important;*/
        background: #761647 !important;
        
}
.card-body  .dropdown-menu {
       color: #fff !important;
       background: #761647 !important;
}
 .card-body  .dropdown-menu .dropdown-item{
           color: #fff !important;
}
.card-body  .dropdown-menu .dropdown-item:hover{
     background: #761647 !important;
      color: #fff !important;
}
/*.background:hover{*/
/*        color: #FF0000 !important;*/
        
/*}*/
    body{background-image:url("{{ asset('uploads/background_images/'.Auth::user()->background_image) }}"); background-repeat: no-repeat; background-size: cover}
    .col-lg-4.col-md-6.col-sm-6.col-12 {
    max-width: 368px;
}
</style>

<section class="section">
        <div class="section-header">
            <h1>{{__('Dashboard')}}</h1>

            <form action="{{ route('icons.upload') }}" style="display:none" class="ajaxForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="icon_upload" id="icon_upload">
                <input type="hidden" name="icon_slug" id="icon_slug">
                <input type="submit" name="icon_submit" id="icon_submit">
            </form>

            <div class="section-header-breadcrumb">
                <!-- <form action="{{ route('users.background') }}" method="POST" class="ajaxForm mr-3" id="form-1"  enctype="multipart/form-data">
                    @csrf
                    <span class="btn btn-file">
                        @if(!empty(Auth::user()->background_image))
                            <span class="fileinput-new"> {{__('Change Background')}} </span>
                        @else
                            <span class="fileinput-new"> {{__('Select Background')}} </span>
                        @endif
                        <span class="fileinput-exists"> {{__('Image')}} </span>
                        <input type="hidden">
                        <input type="file" name="background" id="background">
                    </span>
                </form> -->

                @if(!empty(Auth::user()->background_image))
                    <!-- <form action="{{ route('users.background.remove') }}" method="POST" class="ajaxForm mr-3">
                        @csrf
                        <input type="submit" class="btn btn-danger" value="Remove Background" name="remove" id="remove">
                    </form> -->
                @endif

                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            </div>

        </div>
        <div style="max-width:630px;">
            <h2>This User does not have permission to access dashboard</h2>
</div>
    </section>

@endsection

@push('script-page')
    <script>
       // $('#background').change(function(){
           // $("form.ajaxForm").submit();
        //});
$(document).ready(function(){
   $('.user_login').click(function(){
        var currentUserId=$(this).data('session');
        var route="{{route('user.autologin')}}";
          $.ajax({
                url: route, // URL of the endpoint
                type: 'POST',
                data: {
                    currentUserId:currentUserId
                }, // Serialize the form data
                success: function(response) {
                       if (response.url) {
                    window.location.href=response.url;
                }
                },
                error: function(xhr) {
                }
            });
    })
        })
// })
        function iconUpload(name){

            $('#icon_upload').trigger('click');

            $('#icon_upload').change(function(){
                $('#icon_slug').val(name);
                $('#icon_submit').trigger('click');
            });
        }
    </script>
@endpush


