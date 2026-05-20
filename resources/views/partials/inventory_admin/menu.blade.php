@php
$logo=asset(Storage::url('logo/'));
 $company_logo=Utility::getValByName('company_logo');
 $company_=Utility::getValByName('company_small_logo');
@endphp
<div class="main-sidebar sidebar-style-2">
    <!-- <img src="{{ asset('assets/img/logo.png') }}" alt="" width="230px" height="50px"> -->
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <!-- <a href="{{route('dashboard')}}"> -->
                <!-- <img class="img-fluid" src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" alt=""> -->
            <!-- </a> -->
        </div>
        @if(Auth::user()->type == "company" || Auth::user()->can('show dashboard') )
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">
                <!-- <img class="img-fluid" src="{{$logo.'/'.(isset($company_small_logo) && !empty($company_small_logo)?$company_small_logo:'small_logo.png')}}" alt=""> -->
            </a>
        </div>
        @endif
        <ul class="sidebar-menu">

                {{-- @if(Auth::user()->type == "company" || Auth::user()->can('show banana agreement') ) --}}
                    {{-- <li class="dropdown {{ (Request::route()->getName() == 'users') ? ' active' : '' }} ">
                        <a class="nav-link" href="{{ route('inventory.employees.index') }}"> <i class="fas fa-fire"></i> <span>{{__('Employees')}}</span></a>
                    </li> --}}
                {{-- @endif --}}
                <li class="dropdown ">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fire"></i> <span>{{__('Employees')}}</span></a>
                    <ul class="dropdown-menu display-block">
                            <li class="">
                                <a class="nav-link" href="{{ route('inventory.employees.index') }}">{{  __('Employees') }}</a>
                            </li>

                            <li class="">
                                <a class="nav-link" href="{{route('inventory.employees.employees_type')}}">{{__('Employees Type')}}</a>
                            </li>
                    </ul>

                </li>
                <li class="dropdown ">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fire"></i> <span>{{__('Stock')}}</span></a>
                    <ul class="dropdown-menu display-block">
                        <li class="">
                            <a class="nav-link" href="{{ route('inventory.stock.stock_consume') }}">{{  __('Consumer') }}</a>
                        </li>
                        <li class="">
                                <a class="nav-link" href="{{ route('inventory.stock.index') }}">{{  __('Stock') }}</a>
                            </li>


                            {{-- <li class="">
                                <a class="nav-link" href="{{route('inventory.employees.employees_type')}}">{{__('Purchase View')}}</a>
                            </li> --}}
                    </ul>

                </li>




    </aside>
</div>
