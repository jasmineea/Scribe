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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        <a href='javascript:void(0);' class="btn btn-success dub1" data-toggle="tooltip" aria-label="Create Order" data-coreui-original-title="Generate master file">Upload Template</a>
        <a href='{{ route("backend.orders.designfiles","default") }}' onclick="javascript:document.getElementById('page-loader').style.display='block';" class="btn btn-success  " data-toggle="tooltip" aria-label="Create Order" data-coreui-original-title="Generate master file">Default templates</a>
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
                                Template
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Added By
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
<div class="design_form3_div" style="display:none;">
   <form class="design_form3" action="{{ route("frontend.cards.saveDesignType")}}" method="POST">
   <input type="hidden" name="sent_from" value="backend">
   {{ csrf_field() }}
   <table class="table">
      <thead>
         <tr>
            <th>Design</th>
            <th>Select Type</th>
         </tr>
      </thead>
      <tbody>
         @foreach($carddesignswithouttype as $key=>$value)
         <tr>
            <td><img src="{{asset('storage/'.$value['image_path'])}}" style="max-width: 80px;"></td>
            <td>
               <select required name="save_type[{{$value['id']}}]">
                  <option value="">select type</option>
                  <option value="inner">Inner Design</option>
                  <option value="outer">Outer Design</option>
                  <option value="both" selected>Both Inner and Outer Design</option>
               </select>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   </form>
</div>
<form class="design_form1" action="{{ route("frontend.cards.cardDesignUpload")}}" method="POST" id="xsl_upload" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file"  accept=".png,.zip" style="opacity:0;" name="design_file" class="uploadDesign1">
    <input type="hidden" name="sent_from" value="backend">
</form>
@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="module" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="module">
    $(document).ready(function(){
   	if({{count($carddesignswithouttype)}}!='0'){
        var d = bootbox.confirm({
                    message: $(".design_form3_div").html(),
                    buttons: {
                    confirm: {
                    label: 'Save',
                    //   className: 'btn-success'
                    },
                    cancel: {
                    label: 'Cancel',
                    //   className: 'btn-danger'
                    }
                    },
                    callback: function (result) {
                        if(result){
                            $('.design_form3').submit();
                        }
                    }});
   			d.find('.modal-dialog').addClass('modal-dialog-centered');
   	}
   });
    $(".dub1").click(function(){
   	$(".uploadDesign1").trigger('click');
   })
    $(".uploadDesign1").on( 'change', function () {
       $(".loading").show();
          $('.design_form1').submit();
      });
    $("body").on('click','.divide_file',function(){
        alert($(this).data('id'));
    })
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: '{{ route("backend.$module_name.index_data",$type) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'image_path',
                name: 'image_path'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'user_id',
                name: 'user_id'
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
@endpush