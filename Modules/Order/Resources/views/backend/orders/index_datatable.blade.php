@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ucfirst($type)}} {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            {{-- <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot> --}}
            <x-slot name="toolbar">
            <a href='{{ route("frontend.cards.autoCreateOrder","web") }}' class="btn btn-success  " data-toggle="tooltip" aria-label="Create Order" data-coreui-original-title="Fetch Orders">Fetch Orders</a>
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
                                User
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Total Recipient
                            </th>
                            <th>Download Campaign List</th>
                            <th>Exclude</th>
							<th>Message Overview</th>
                            <th>
                                Status
                            </th>
                            <th>
                                Updated At
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
    $('body').on('change','.change_status',function(){
        var id=$(this).data('id');
        var status=$(this).val();
        window.location.href = "/admin/orders/changeStatus/"+id+"/"+status;
    })
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.$module_name.index_data",["user_id"=>$user_id,"s_id"=>$s_id,"type"=>$type]) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'user_id',
                name: 'user_id'
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
                data: 'download_print_file',
                name: 'download_print_file'
            },
            {
                data: 'exclude_mf',
                name: 'exclude_mf'
            },
            {
                data: 'message_overview',
                name: 'message_overview'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });
    $("body").on('click','.model_preview',function(){
		var img_link=$(this).data('url');
		var style=$(this).attr('style');
		var d = bootbox.alert({
			message: "<img width='100%'  style='"+style+"' src='"+img_link+"'>",
			size: 'large',
			backdrop: true
			});
		d.find('.modal-dialog').addClass('modal-dialog-centered');
	})
    
    $("body").on('click','.checkbox_for_exclude',function(e){
        var id = $(this).data('id');
        var status = $(this).is(':checked')?1:0;
        $.ajax({
            type: 'post',
            url: "{{ route('backend.orders.update_exclude') }}",
            data: {'id':id,'method':'Order','status':status},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                
            },
            success: function(response){
                Alert.success('Record Updated.','Success',{displayDuration: 5000, pos: 'top'})
            },
            complete: function(response){
               
            }
        });
	});
</script>
@endpush