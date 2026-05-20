@php
$logo=asset(Storage::url('logo/'));
 $company_logo=Utility::getValByName('company_logo');
 $company_=Utility::getValByName('company_small_logo');
@endphp
<div class="main-sidebar sidebar-style-2">
    <!--<img src="{{ asset('assets/img/logo.png') }}" alt="" width="230px" height="50px">-->
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <!--<a href="{{route('dashboard')}}">-->
            <!--     <img class="img-fluid" src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" alt=""> -->
            <!--</a>-->
        </div>
        @if(Auth::user()->type == "company" || Auth::user()->can('show dashboard') )
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">
                <!-- <img class="img-fluid" src="{{$logo.'/'.(isset($company_small_logo) && !empty($company_small_logo)?$company_small_logo:'small_logo.png')}}" alt=""> -->
            </a>
        </div>
        @endif
        <ul class="sidebar-menu">

            @if(Auth::user()->type !== "company" && Auth::user()->can('show dashboard'))
            
                <li class="dropdown {{ (Request::route()->getName() == 'dashboard') ? ' active' : '' }} ">
                    <a class="nav-link" href="{{route('dashboard')}}"> <i class="fas fa-fire"></i> <span>{{__('Dashboard')}}</span></a>
                </li>
                @elseif((Auth::check() && Auth::user()->type == "company"))
                 <li class="dropdown {{ (Request::route()->getName() == 'dashboard') ? ' active' : '' }} ">
                    <a class="nav-link" href="{{route('dashboard')}}"> <i class="fas fa-fire"></i> <span>{{__('Dashboard')}}</span></a>
                </li>
            @endif



                @if(Auth::check() && Auth::user()->type == "company")
                    <li class="dropdown {{ (Request::route()->getName() == 'users') ? ' active' : '' }} ">
                        <a class="nav-link" href="{{ route('users.index') }}"> <i class="fas fa-fire"></i> <span>{{__('User')}}</span></a>
                    </li>
                @endif


                @if(Auth::user()->type == "company" || Auth::user()->can('show expense income') )
                    <li class="dropdown ">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>{{__('Expense / Income')}}</span></a>
                        <ul class="dropdown-menu display-block">

                            @if(Auth::user()->type == "company" || Auth::user()->can('show head') )
                                <li class="">
                                    <a class="nav-link" href="{{ route('expense.heads.show') }}">{{  __('Head') }}</a>
                                </li>
                            @endif
                            @if(Auth::user()->type == "company" || Auth::user()->can('show subhead') )
                                <li class="">
                                    <a class="nav-link" href="{{route('expense.subheads.show')}}">{{__('SubHead')}}</a>
                                </li>
                            @endif

                            @if(Auth::user()->type == "company" || Auth::user()->can('show third subhead') )
                                <li class="">
                                    <a class="nav-link" href="{{route('expense.child.subheads.show')}}">{{__('Third head')}}</a>
                                </li>
                            @endif
                            @if(Auth::user()->type == "company" || Auth::user()->can('show third subhead') )
                                <li class="">
                                    <a class="nav-link" href="{{route('expense.child.forthheads.show')}}">{{__('Fourth head')}}</a>
                                </li>
                            @endif

                            @if(Auth::user()->type == "company" || Auth::user()->can('show entries') )
                                <li class="">
                                    <a class="nav-link" href="{{route('enteries.show')}}">{{__('Entries')}}</a>
                                </li>
                            @endif

                            @if(Auth::user()->type == "company" || Auth::user()->can('show expense report') )
                                <li class="">
                                    <a class="nav-link" href="{{route('reports.show')}}">{{__('Report')}}</a>
                                </li>
                            @endif
                        </ul>

                    </li>
                @endif





                @if(Auth::user()->type == "company" || Auth::user()->can('show banana agreement') )
                    <li class="dropdown {{ (Request::route()->getName() == 'users') ? ' active' : '' }} ">
                        <a class="nav-link" href="{{ route('banana.show') }}"> <i class="fas fa-fire"></i> <span>{{__('Banana Agreement')}}</span></a>
                    </li>
                @endif


                @if(Auth::user()->type == "company" || Auth::user()->can('show accounts') )
                <li class="dropdown ">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>{{__('Accounts')}}</span></a>
                    <ul class="dropdown-menu display-block">
                        @if(Auth::user()->type == "company" || Auth::user()->can('show banks') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.banks.show') }}">Bank Head</a>
                            </li>
                        @endif

                        @if(Auth::user()->type == "company" || Auth::user()->can('show bank branch') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.branches.show') }}">Bank Subhead</a>
                            </li>
                        @endif

                        @if(Auth::user()->type == "company" || Auth::user()->can('show transaction') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customer_accounts.transactions.show') }}">Transaction Mode</a>
                            </li>
                        @endif
                        
                        @if(Auth::user()->type == "company" || Auth::user()->can('show transaction') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customer_accounts.reasons.show') }}">Cheque/Card/Voucher No</a>
                            </li>
                        @endif  

                        @if(Auth::user()->type == "company" || Auth::user()->can('show users') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customer.show') }}">Users </a>
                            </li>
                        @endif

                        @if(Auth::user()->type == "company" || Auth::user()->can('show users banks and branches') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customers.show') }}">User Branches</a>
                            </li>
                        @endif
                        
                        @if(Auth::user()->type == "company" || Auth::user()->can('show users banks and branches') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customers.add') }}">Add User Branches</a>
                            </li>
                        @endif

                        @if(Auth::user()->type == "company" || Auth::user()->can('show users accounts') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customer_accounts.add') }}">Entries</a>
                            </li>
                        @endif

                        @if(Auth::user()->type == "company" || Auth::user()->can('show users accounts report') )
                            <li class="">
                                <a class="nav-link" href="{{ route('accounts.customer_accounts.report') }}">Report</a>
                            </li>
                        @endif
                        
                    </ul>

                </li>
            @endif
            <li class="dropdown {{ (Request::route()->getName() == 'users') ? ' active' : '' }} ">
                <a class="nav-link" href="{{ route('download.database') }}"> <i class="fa fa-database"></i> <span>{{__('Downdoad Database')}}</span></a>
            </li>
          {{--  <li class="dropdown {{ (Request::route()->getName() == 'users') ? ' active' : '' }} ">
                <a class="nav-link" href="{{ route('import.database') }}"> <i class="fa fa-database"></i> <span>{{__('Import Database')}}</span></a>
            </li>--}}
 <li class="dropdown  ">
                <a class="nav-link" href="{{ route('note.show') }}">
                    <i class="fas fa-fire"></i>
                    {{-- <i class="fa fa-database"></i> --}}
                     <span>{{__('Note')}}</span></a>
            </li>
        </ul>
    </aside>
</div>
