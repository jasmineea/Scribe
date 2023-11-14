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
        <a href='javascript:void(0)' id="btnExport" class="btn btn-warning" data-toggle="tooltip" data-coreui-original-title="Set Master File Record Limit">Export</a>
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
                                Campaign ID
                            </th>
                            <th>
                                Campaign Name
                            </th>
                            <th>
                                Inner Design Files
                            </th>
                            <th>
                                Outer Design Files
                            </th>
                            <th>
                                Total Records
                            </th>
                            <th>
                                Downloaded
                            </th>
                            <th>
                                Downloaded At
                            </th>
                            <th>
                                Created At
                            </th>
                            <th class="text-end">
                                Action
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
                data: 'order_id',
                name: 'order_id'
            },
            {
                data: 'campaign_name',
                name: 'campaign_name'
            },
            {
                data: 'inner_design',
                name: 'inner_design'
            },
            {
                data: 'main_design',
                name: 'main_design'
            },
            {
                data: 'total_records',
                name: 'total_records'
            },
            {
                data: 'downloaded_times',
                name: 'downloaded_times'
            },
            {
                data: 'downloaded_at',
                name: 'downloaded_at'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });
</script>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            var currentdate = new Date(); 
            var datetime = "Export " + currentdate.getDate() + "/"
                        + (currentdate.getMonth()+1)  + "/" 
                        + currentdate.getFullYear() + " "  
                        + currentdate.getHours() + ":"  
                        + currentdate.getMinutes() + ":" 
                        + currentdate.getSeconds();
            let table = document.getElementsByTagName("table");
            console.log(table);
            debugger;
            TableToExcel.convert(table[0], {
                name: datetime+`_export.xlsx`,
                sheet: {
                    name: 'export'
                }
            });
        });
    });
</script>
@endpush