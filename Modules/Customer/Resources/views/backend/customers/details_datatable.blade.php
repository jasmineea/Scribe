@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />

            </x-slot>
        </x-backend.section-header>
        <div  class="row mt-4">
            <div class="col-12">
            <table class="table table-responsive-sm table-hover table-bordered">
                <?php
                $all_columns = $$module_name_singular->getTableColumns();
                ?>
                <thead>
                    <tr>
                        <th scope="col">
                            <strong>
                                @lang('Name')
                            </strong>
                        </th>
                        <th scope="col">
                            <strong>
                                @lang('Value')
                            </strong>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_columns as $column)
                    @if(in_array($column->Field,['email_verified_at','password','status','remember_token','payment_intent','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at','avatar','date_of_birth','gender','mobile']))
                        @continue;
                    @endif
                    <tr>
                        <td>
                            <strong>
                                {{ __(label_case($column->Field)) }}
                            </strong>
                        </td>
                        <td style="max-width: 500px;">
                            {!! show_column_value($$module_name_singular, $column) !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

        </div>
        <div  class="row mt-4">
            <div class="col-12">
                <h4 class="card-title mb-3"><i class="fas fa-list"></i> Campaigns</h4>
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Credit Used
                            </th>
                            <th>
                                Total Recipient
                            </th>
                            <th>Download Campaign List</th>
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
        <div  class="row mt-4">
        <div class="col-12">
            <h4 class="card-title mb-3"><i class="fas fa-list"></i> Wallet Transactions</h4>
            <table id="datatable_t" class="table table-bordered table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Credit Used/Purchase
                        </th>
                        <th>
                            Credit Balance
                        </th>
                        <th>
                            Paid Amount($)
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Comment
                        </th>
                        <th>
                            Updated At
                        </th>
                        <!-- <th class="text-end">
                            Action
                        </th> -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div  class="row mt-4">
        <div class="col-12">
            <h4 class="card-title mb-3"><i class="fas fa-list"></i> Campaign Lists</h4>
            <table id="datatable_l" class="table table-bordered table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            List Name
                        </th>
                        <th>
                            Contacts
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Created By
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
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.orders.index_data",["user_id"=>$id]) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'order_amount',
                name: 'order_amount'
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
</script>
<script type="module">
    $('#datatable_t').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.transactions.index_data",["user_id"=>$id]) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'amount',
                name: 'amount'
            },
            {
                data: 'wallet_balance',
                name: 'wallet_balance'
            },
            {
                data: 'currency_amount',
                name: 'currency_amount'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'comment',
                name: 'comment'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            }
        ]
    });
</script>
<script type="module">
    $('#datatable_l').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.listings.index_data",["user_id"=>$id]) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'contact_count',
                name: 'contact_count'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'user_id',
                name: 'user_id'
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