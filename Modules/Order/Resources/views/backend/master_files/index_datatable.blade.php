@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<style>
#page-loader {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10000;
    display: none;
    text-align: center;
    width: 100%;
    padding-top: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}
</style>
<div id="page-loader">
<h3>Loading page...</h3>
<img src="http://css-tricks.com/examples/PageLoadLightBox/loader.gif" alt="loader">
<p><small>please wait we are creating master files for you.</small></p>
</div>
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
        <i class="{{ $module_icon }}"></i>{{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>


        <x-slot name="toolbar">
        <a href='{{ route("backend.settings",["type"=>"master_file_limit"]) }}' class="btn btn-warning" data-toggle="tooltip" data-coreui-original-title="Set Master File Record Limit"><i class="fa fa-cog"></i></a>
        <a href='{{ route("frontend.cards.createMasterFile","web") }}' onclick="javascript:document.getElementById('page-loader').style.display='block';" class="btn btn-success  " data-toggle="tooltip" aria-label="Create Order" data-coreui-original-title="Generate master file">Generate master print file</a>
        </x-slot>

        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Pre BCC File
                            </th>
                            <th>
                                Post BCC File
                            </th>
                            <th>
                                Design File
                            </th>
                            <th>
                                Total Records
                            </th>
                            <th>
                                Downloaded At
                            </th>
                            <th>
                                Created At
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">

                </div>
            </div>
            <div class="col-5">
                <div class="float-end">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="module" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="module">
    $("body").on('click','.divide_file',function(){
        alert($(this).data('id'));
    })
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.$module_name.index_data") }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'uploaded_recipient_file',
                name: 'uploaded_recipient_file'
            },
            {
                data: 'post_uploaded_recipient_file',
                name: 'post_uploaded_recipient_file'
            },
            {
                data: 'outer_design_file',
                name: 'outer_design_file'
            },
            {
                data: 'total_records',
                name: 'total_records'
            },
            {
                data: 'downloaded_at',
                name: 'downloaded_at'
            },
            {
                data: 'created_at',
                name: 'created_at'
            }
        ]
    });
</script>
@endpush