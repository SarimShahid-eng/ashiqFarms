@extends('layouts.admin')
@section('page-title')
    {{__('Head')}}
@endsection

@section('content')

<style>
    input[type="date"],
    select{padding: 12px 10px !important;height: auto !important;}
        input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  /* -webkit-transform: scale(2); Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  transform: scale(2);
}
</style>

    <section class="section">
        <div class="section-header">
            <h1>{{__('Import Database')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">{{__('Import')}}</div>
                <div class="breadcrumb-item active">{{__('Database')}}</div>
                {{-- <div class="breadcrumb-item active">{{__('Add Credit Expense')}}</div> --}}
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card repeater">
                    <div class="card-header">
                        <h4>Import Database</h4>
                    </div>
                    @if (Session::has('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">Your
                        <strong> Database</strong> is imported successfully..
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      @endif
                    <div class="card-body p-4">
                        <form method="POST"  action="{{route('import.db')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-10">
                                <input type="file" class="form-control" required="" name="file" value="">
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" name="Impor" class="btn btn-primary" value="Import">
                                </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



