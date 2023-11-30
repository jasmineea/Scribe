@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
        <a href='{{ route("backend.customers.create") }}' class="btn btn-success  " data-toggle="tooltip" aria-label="Create Order" data-coreui-original-title="Add Customer">Add Customer</a>
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
                                Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Phone
                            </th>
                            {{-- <th>
                                Gender
                            </th>
                            <th>
                                Date Of Birth
                            </th> --}}
                            <th>
                                Credit Balance
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
    $("body").on('click','.recharge_wallet',function(){
        var token =$('meta[name="csrf-token"]').attr('content');
		var d = bootbox.confirm("<form id='infos' action='{{route('backend.customers.wallet_recharge')}}' method='post'>\
		<input type='hidden' name='_token' value='"+token+"'>\
		<input type='hidden' name='user_id' value='"+$(this).data('id')+"'>\
		Current Balance <input type='text' readonly value='"+$(this).data('wallet')+"' class='form-control'/><br/>\
		Enter Amount <input type='number' min='0' value='0.00' class='form-control' name='recharge_amount' /><br/>\
        Select Option <Select name='action_type' class='form-control'><option value='cr'>Credit</option><option value='dr'>Debit</option></Select><br/>\
		</form>", function(result) {
			if(result){
				$('#infos').submit();
			}
	});
		d.find('.modal-dialog').addClass('modal-dialog-centered');
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            // {
            //     data: 'gender',
            //     name: 'gender'
            // },
            // {
            //     data: 'date_of_birth',
            //     name: 'date_of_birth'
            // },
            {
                data: 'wallet_balance',
                name: 'wallet_balance'
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
</script>
@endpush