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

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
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
                                Credit Used/Purchase
                            </th>
                            <th>
                                Scribe Credit Balance
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
                            {{-- <th class="text-end">
                                Action
                            </th> --}}
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
        ajax: '{{ route("backend.$module_name.index_data",["user_id"=>$user_id]) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'user_id',
                name: 'user_id'
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
@endpush