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
                <form action="{{ route('users.background') }}" method="POST" class="ajaxForm mr-3" id="form-1"  enctype="multipart/form-data">
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
                           <input type="submit" name="background" id="background">
                </form> 

                @if(!empty(Auth::user()->background_image))
                    <!-- <form action="{{ route('users.background.remove') }}" method="POST" class="ajaxForm mr-3">
                        @csrf
                        <input type="submit" class="btn btn-danger" value="Remove Background" name="remove" id="remove">
                    </form> -->
                @endif

                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            </div>

        </div>
        <div class="align-items-start d-flex stretch justify-content-between" >
        <div style="max-width:630px;">

        @if(\Auth::user()->type=='company')
            <div class="row">
            </div>
        @endif
       
        @if(Auth::user()->type == 'company' || Auth::user()->can('show dashboard'))

       

        <div class="row">
            @php
            $user_id = auth('web')->user()->id;
            @endphp
        
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a  href="javascript:void(0)" onclick='iconUpload("{{ "head_".$user_id }}")'>
                        <div class="card-icon bg-primary">
    
                            {{-- <img src="{{ asset('uploads/dashboard_icons/11_2.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" onclick='iconUpload()'> --}}
    
                            <!-- <i class="fas fa-users" onclick='iconUpload())'></i> -->
    
                            @if(file_exists(public_path('uploads/dashboard_icons/head_'.$user_id.'.jpg')))
                                <img src="{{ asset('uploads/dashboard_icons/head_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                            @else
    
                                <i class="fas fa-users" ></i>
    
                            @endif
                        </div>
                      </a>
                        <div class="card-wrap">
                            <!-- <div class="card-header pt-3 mb-2">
                                <h4>Manage Head</h4>
                            </div> -->
                            <div class="card-body mt-4">
    
                                <div class="dropdown">
                                    <a class="btn background dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        Manage Head
                                    </a>
    
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('expense.heads.show') }}">Head</a>
                                        <a class="dropdown-item" href="{{route('expense.subheads.show')}}">SubHead</a>
                                        <a class="dropdown-item" href="{{route('expense.child.subheads.show')}}">Third head</a>
                                        <a class="dropdown-item" href="{{route('expense.child.forthheads.show')}}">Fourth head</a>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a  href="javascript:void(0)" onclick='iconUpload("{{ "reports_".$user_id }}")'>
    
                        <div class="card-icon bg-primary">
    
                            @if(file_exists(public_path('uploads/dashboard_icons/reports_'.$user_id.'.jpg')))
                                <img src="{{ asset('uploads/dashboard_icons/reports_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                            @else
    
                                <i class="fas fa-file-alt" ></i>
    
                            @endif
                        </div>
                        </a>
                        <div class="card-wrap">
                            <!-- <div class="card-header pt-3 mb-2">
                                <h4>Manage Head</h4>
                            </div> -->
                            <div class="card-body mt-4">
    
                                <!-- <div class="dropdown"> -->
                                    <a class="btn background" href="{{route('reports.show')}}">
                                        Manage Reports
                                    </a>
                                <!-- </div> -->
    
                            </div>
                        </div>
                    </div>
                </div>
       
         
         
         
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <a  href="javascript:void(0)" onclick='iconUpload("{{ "agreement_".$user_id }}")'>
        
                            <div class="card-icon bg-primary">
        
                                @if(file_exists(public_path('uploads/dashboard_icons/agreement_'.$user_id.'.jpg')))
                                    <img src="{{ asset('uploads/dashboard_icons/agreement_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                                @else
        
                                    <i class="far fa-handshake"></i>
        
                                @endif
                            </div>
                            </a>
                            <div class="card-wrap">
                                <!-- <div class="card-header pt-3 mb-2">
                                    <h4>Manage Head</h4>
                                </div> -->
                                <div class="card-body mt-4">
        
                                    <!-- <div class="dropdown"> -->
                                        <a class="btn background" href="{{ route('banana.show') }}">
                                            Banana Agreement
                                        </a>
                                    <!-- </div> -->
        
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <a  href="javascript:void(0)" onclick='iconUpload("{{ "expense_".$user_id }}")'>
                            <div class="card-icon bg-primary">
        
                                @if(file_exists(public_path('uploads/dashboard_icons/expense_'.$user_id.'.jpg')))
                                <img src="{{ asset('uploads/dashboard_icons/expense_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                            @else
        
                            <i class="fas fa-dollar-sign"></i>
        
                            @endif
                            </div>
                            </a>
                            <div class="card-wrap">
                                <div class="card-body mt-4">
                                    <li id="some_changes" style="list-style: none; display:flex;">
                                        <a class="btn background mr-3 " href="{{route('some_changes')}}?view=1" target="blank"> Remaing Expense</a>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
         
        
        
        
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a  href="javascript:void(0)" onclick='iconUpload("{{ "late_payment_".$user_id }}")'>
                            <div class="card-icon bg-primary">
    
                                @if(file_exists(public_path('uploads/dashboard_icons/late_payment_'.$user_id.'.jpg')))
                                <img src="{{ asset('uploads/dashboard_icons/late_payment_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                            @else
    
                            <i class="fas fa-dollar-sign"></i>
    
                            @endif
                            </div>
                            </a>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <li id="some_changes" style="list-style: none; display:flex;">
                                    <a  id="late" class="btn background mr-3" href="{{route('reports.late')}}" target="blank">Late Payments</a>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a  href="javascript:void(0)" onclick='iconUpload("{{ "upcoming_".$user_id }}")'>
                            <div class="card-icon bg-primary">
    
                            @if(file_exists(public_path('uploads/dashboard_icons/upcoming_'.$user_id.'.jpg')))
                                <img src="{{ asset('uploads/dashboard_icons/upcoming_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                            @else
    
                            <i class="fas fa-dollar-sign"></i>
    
                            @endif
                            </div>
                            </a>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <li id="some_changes" style="list-style: none; display:flex;">
                                    <a id="upcoming" class="btn background mr-3 " href="{{route('reports.due')}}" target="blank">Upcoming Payments</a>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
    
        
        
        
        
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a  href="javascript:void(0)" onclick='iconUpload("{{ "entries_".$user_id }}")'>
                        <div class="card-icon bg-primary">
                            @if(file_exists(public_path('uploads/dashboard_icons/entries_'.$user_id.'.jpg')))
                            <img src="{{ asset('uploads/dashboard_icons/entries_'.$user_id.'.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" >
                        @else
    
                        <i class="far fa-file-alt"></i>
    
                        @endif
                        </div>
                        </a>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <li id="some_changes" style="list-style: none; display:flex;">
                                    <a id="upcoming" class="btn background mr-3 " href="{{route('enteries.show')}}" >Entries</a>
                                </li>
                            </div>
                        </div>
                    
                        </div>
                    </div>
        
            </div>
            </div>
              <form action="{{ route('dashboardImage.store') }}" method="POST" class="ajaxForm mr-3" id="form-1"
                    enctype="multipart/form-data">
                    @csrf
                 <div class="ml-5 p-3" style="
                                border-radius: 4px;
                                background-color: #f1f1f1;
                            ">
                <div class="d-flex gap-4">
    

                <label class="mr-3">Select Image File</label>
                <input type="file"  id="imageInput" class="form-control-file 
                w-50"  accept="image/*" name="image">
            </div>
             @if($dashboard_image)
            <div id="imagePreviewDiv" class=" justify-content-center ">
                        <img id="previewImage" src="{{asset('uploads/dashboard_image/'.$dashboard_image->image) }}" alt="" style="max-width:350px; max-height:100%; "> 
                    </div>
            @endif
           
                         <input type="submit" class="btn btn-primary mt-2" name="image" id="image">
                    </div>
                
                    </form>
        </div>
            


            <!--AGREEMEENTS SECTION-->
         

           
        <!--</div>-->
        @endif
        <div class="border-target"></div>
        <!--users set-->
                <div style="max-width:630px;">
                    <div class="row">
                          @foreach($users as $user)
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a  href="javascript:void(0)" onclick='iconUpload("{{ "head_".$user_id }}")'>
                        <div class="card-icon ">
    
                            {{-- <img src="{{ asset('uploads/dashboard_icons/11_2.jpg') }}" alt="" style="max-width: 100%;vertical-align: top;max-height: 80px;height: 80px;" onclick='iconUpload()'> --}}
    
                            <!-- <i class="fas fa-users" onclick='iconUpload())'></i> -->
                            @if(!empty($user->avatar))
                                @if(file_exists(public_path('uploads/dashboard_icons/head_'.$user_id.'.jpg')))
                                    <img src="{{ asset('/uploads/profile_images/'.$user->avatar) }}" style="width:70px;height:100%;" >
                                @else
        
                                    <i class="fas fa-users" ></i>
        
                                @endif
                             @endif
                        </div>
                      </a>
                        <div class="card-wrap">
                            <!-- <div class="card-header pt-3 mb-2">
                                <h4>Manage Head</h4>
                            </div> -->
                            <div class="card-body mt-4">
    
                                <div class="dropdown">
                                    <a class="user_login btn background rounded-1 " href="#" data-session="{{@$user->id}}" role="button" data-toggle="dropdown" aria-expanded="false">
                                        {{$user->name}}
                                    </a>
    
                                    <!--<div class="dropdown-menu">-->
                                    <!--    <a class="dropdown-item" href="{{ route('expense.heads.show') }}">Head</a>-->
                                    <!--    <a class="dropdown-item" href="{{route('expense.subheads.show')}}">SubHead</a>-->
                                    <!--    <a class="dropdown-item" href="{{route('expense.child.subheads.show')}}">Third head</a>-->
                                    <!--    <a class="dropdown-item" href="{{route('expense.child.forthheads.show')}}">Fourth head</a>-->
                                    <!--</div>-->
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
        
            </div>
            </div>
             <div class="bg-white w-50">
                
            </div>
                    </div>
<!--user set end div-->
    </section>

@endsection

@push('script-page')
    <script>

$(document).ready(function(){
//     $(document).on('change', '#imageInput', function () {
//     let file = this.files[0];

//     if (file) {
//         let imageUrl = URL.createObjectURL(file);

// $('#imagePreviewDiv').addClass('d-flex')
//         $('#previewImage')
//             .attr('src', imageUrl)
//             .show();
//     }
// });
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


