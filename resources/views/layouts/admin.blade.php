<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
@include('partials.admin.head')

<style>
    .select2-container .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default .select2-selection--multiple, .select2-container--default .select2-search--dropdown .select2-search__field,
    select,
    textarea,
    input[type="date"],
    input[type="password"],
    input[type="number"],
    input[type="text"]{border-color:#000!important}

    textarea{resize: none}
    table.dataTable td {
        font-size: 15px;
        font-weight:bold
    }
</style>

<body class="sidebar-mini">
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        @include('partials.admin.header')

        @include('partials.admin.menu')
        <div class="main-content">
            @include('partials.admin.content')
        </div>

    </div>
</div>
<div id="commonModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCommanModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelCommanModelLabel"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
<script>
    $("table.dt_table").dataTable({
        "lengthMenu": [100, 150, 200],
        // "order": [[2, 'ASC']],
    });

</script>

</body>
</html>
