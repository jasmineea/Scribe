@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<style>
select.change_status {
    max-width: 210px !important;
}
#page-loader , #page-loader2 {
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
.largeWidth {
    margin: 0 auto;
    max-width: 55%;
}
#datatable1{
    width: 100% !important;
}
</style>
<div id="page-loader">
<h3>Loading page...</h3>
<img src="http://css-tricks.com/examples/PageLoadLightBox/loader.gif" alt="loader">
<p><small>please wait we are creating master files for you.</small></p>
</div> 
<div id="page-loader2">
<h3>Loading page...</h3>
<img src="http://css-tricks.com/examples/PageLoadLightBox/loader.gif" alt="loader">
<p><small>please wait we are uploading file for you.</small></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
        <i class="{{ $module_icon }}"></i>{{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>


        <x-slot name="toolbar">
        <a href='javascript:void(0);' class="btn btn-secondary" data-toggle="tooltip" data-coreui-original-title="{{$record_count_to_create_master_file}} Order(s) In Print Queue">{{$record_count_to_create_master_file}} Order(s) In Print Queue</a>
        <a href='{{ route("backend.settings",["type"=>"master_file_limit"]) }}' class="btn btn-warning" data-toggle="tooltip" data-coreui-original-title="Set Master File Record Limit"><i class="fa fa-cog"></i></a>
        <a href='javascript:void(0);' class="btn btn-success custom_master_file" data-toggle="tooltip" aria-label="Create Order" data-coreui-original-title="Generate Custom master file">Generate Custom master print file</a>
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
                                Status
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
    $('body').on('change','.change_status',function(){
        var id=$(this).data('id');
        var status=$(this).val();
        window.location.href = "{{env('APP_URL')}}/admin/orders/changeStatus/"+id+"/"+status+'/master';
    })
    $("body").on('click','.custom_master_file',function(){
        var token =$('meta[name="csrf-token"]').attr('content');
        var d = bootbox.confirm({
        message: "<form id='infos' action='{{route('frontend.cards.createMasterFile','web')}}' method='post'>\
		<input type='hidden' name='_token' value='"+token+"'>\ <label><b>Selected Orders</b></label><br><table id='datatable2' class='table table-bordered table-hover table-responsive-sm'> <thead> <tr> <th> # </th> <th> User </th> <th> Name </th> <th> Type </th> <th> Total Recipient </th> <th> Status </th><th> Design </th><th> Action </th> </tr> </thead> </table></form> <table id='datatable1' class='table table-bordered table-hover table-responsive-sm'> <thead> <tr> <th> # </th> <th> User </th> <th> Name </th> <th> Type </th> <th> Total Recipient </th> <th> Status </th><th> Design </th> </tr> </thead> </table>",
        buttons: {
        confirm: {
        label: 'Generate Custom File',
        //   className: 'btn-success'
        },
        cancel: {
        label: 'Cancel',
        //   className: 'btn-danger'
        }
        },
        callback: function (result) {
            if(result){
                if(jQuery('#infos .hidden_id').length>0){
                    $("#page-loader").show();
                    $('#infos').submit();
                }else{
                    Alert.error("Please Select Atleast One Order To Generate Master File",'Error',{displayDuration: 5000, pos: 'top'})
                }
                
            }
        }});
		
		d.find('.modal-dialog').addClass('modal-dialog-centered largeWidth');
        $('#datatable1').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            "pageLength": 25,
            responsive: true,
            ajax: '{{ route("backend.orders.index_data2") }}',
            columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'user_id',
                name: 'users.name'
            },
            {
                data: 'campaign_name',
                name: 'campaign_name'
            },
            {
                data: 'campaign_type_2',
                name: 'campaign_type_2'
            },
            {
                data: 'total_recipient',
                name: 'total_recipient'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'message_overview',
                name: 'message_overview'
            }
        ]
    });
    })
    $("body").on('click','.divide_file',function(){
        alert($(this).data('id'));
    })
    $("body").on('change','.file_change',function(){
        $("#page-loader2").show();
    })
    $("body").on('click','.checkbox_select',function(){
        
            $('body').find("#datatable2").append("<tr>"+$(this).closest('tr').html()+"<td class='ddd'><button class='delete_row btn btn-warning'>Delete</button></td></tr>");
            $('body').find("#datatable2 .checkbox_select").remove();
        
    })

    $("body").on('click','.delete_row',function(){
        $(this).closest("tr").remove();
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
                data: 'status',
                name: 'status'
            },
            {
                data: 'created_at',
                name: 'created_at'
            }
        ]
    });
</script>
@endpush