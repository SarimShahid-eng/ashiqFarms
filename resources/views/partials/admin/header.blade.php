@php
    $users=\Auth::user();
    $profile=asset(Storage::url('avatar/'));
    $currantLang = $users->currentLanguage();
    $languages=Utility::languages();
@endphp
<style>
    .button-new {
        background-color: #FF0000; !important;
        color: #fff;
        border: none;
        font-size: 14px !important;
        font-weight: bold !important;
        letter-spacing: .5px;
        line-height: 24px;
        padding: 9px 15px 9px 15px;
        border-radius: .25rem;
    }
    .button-new:hover{
        color: #fff;
        text-decoration:none;
    }
</style>
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto search-element" method="post">
        <div class="easy-autocomplete"><input type="hidden" name="_token" value="ifSnVqGphjkOu1aqYvyflvadZqTOLssR8oVLlL9q" id="eac-5343" style="" autocomplete="off">
            <div class="easy-autocomplete-container" id="eac-container-eac-5343">
                <ul></ul>
            </div>
        </div>
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

            <li><a href="{{route('dashboard')}}"><img src="{{ asset('assets/img/logo.png') }}" alt="" width="230px"></a></li>
          @if(Auth::user()->id !== 2 )
            <li id="" class="ml-5"><a class=" button-new " href="#"  id="loginAsAdmin" ><i class="fas fa-arrow-left"></i> <span>Login Back to Admin</span> </a></li>
          @endif
        </ul>
    </form>

    <ul class="navbar-nav mr-auto ml-auto">
        <li id="dues_links">
        </li>
    </ul>

    <ul class="navbar-nav mr-auto ml-auto">
        {{-- <li id="some_changes" style="display:none">
            <a class="btn red button mr-3" href="{{route('some_changes')}}?view=1" target="blank"> Remaing Expense</a>
        </li> --}}
    </ul>
    {{-- <ul class="navbar-nav mr-auto ml-auto">
        <li id="some_changes">
            <a class="btn red button mr-3" href="{{route('inventory.index')}}" > Inventoty manage</a>
        </li>
    </ul> --}}

    <ul class="navbar-nav navbar-right">
        @can('manage language')
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg language-dd"><i class="fas fa-language"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">{{__('Choose Language')}}
                    </div>
                    @can('create language')
                        <a href="{{route('manage.language',[$currantLang])}}" class="dropdown-item btn manage-language-btn">
                            <span> {{ __('Create & Customize') }}</span>
                        </a>
                    @endcan
                    <div class="dropdown-list-content dropdown-list-icons">
                        @foreach($languages as $language)
                            @if(\Auth::guard('customer')->check())
                                <a href="{{route('customer.change.language',$language)}}" class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                                    <span> {{Str::upper($language)}}</span>
                                </a>
                            @elseif(\Auth::guard('vender')->check())
                                <a href="{{route('vender.change.language',$language)}}" class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                                    <span> {{Str::upper($language)}}</span>
                                </a>
                            @else
                                <a href="{{route('change.language',$language)}}" class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                                    <span> {{Str::upper($language)}}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
        @endcan


            <li class="dropdown">
            <div class="container-buttons">
                <button class="notes-button nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">Add Note!</button >
                <div class="notes-dropdown dropdown-menu dropdown-menu-end this-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <button onclick="createStickyNote()" class="text-overflow m-0 notes-button-dropdown">Create New Note</button>
                    </div>

                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header noti-title notes-content">
                        <ul class="p-0">
                        @foreach ($note as $key => $notes)
                        <li id="note_{{$notes->noteId}}">
                        <button onclick="createStickyNote(`{{ $notes->noteId }}`, `{{ $notes->name }}`, `{{ $notes->note }}`, `{{ $notes->color }}`)" class="text-overflow m-0 notes-button-dropdown text-start">{{UCWORDS($notes->name)}} </button>
                        </li>
                        @endforeach
                        </ul>
                    </div>

                </div>
            </div>
            </li>
        <li class="dropdown"><a href="#" style="color: #fff !important" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                @if(!empty(Auth::user()->avatar))
                    @if(file_exists(public_path('uploads/profile_images/'.Auth::user()->avatar)))
                        <img alt="image" src="{{ asset('uploads/profile_images/'.Auth::user()->avatar) }}" class="rounded-circle mr-1">
                    @else
                        <img alt="image" src="{{ asset('assets/img/user.png') }}" class="rounded-circle mr-1">
                    @endif
                @else
                 <img alt="image" src="{{ asset('assets/img/user.png') }}" class="rounded-circle mr-1">

                @endif
                <div class="d-sm-none d-lg-inline-block">{{__('Hi')}}, {{\Auth::user()->name}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{__('Welcome!')}}</div>
                @if(\Auth::guard('customer')->check())
                    <a href="{{route('customer.profile')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> {{__('My profile')}}
                    </a>
                @elseif(\Auth::guard('vender')->check())
                    <a href="{{route('vender.profile')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> {{__('My profile')}}
                    </a>
                @else
                    <a href="{{route('profile')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> {{__('My profile')}}
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>{{__('Logout')}}</span>
                </a>
                @if(\Auth::guard('customer')->check())
                    <form id="frm-logout" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                @else
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                @endif
            </div>
        </li>
    </ul>
</nav>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){

                $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            
    $('#loginAsAdmin').click(function(){
        // var currentUserId=$(this).data('session');
        var route="{{route('login.loginWithoutAuth')}}";

          $.ajax({
                url: route, // URL of the endpoint
                type: 'POST',
                data: {
                    currentUserId:'2'
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
    </script>

