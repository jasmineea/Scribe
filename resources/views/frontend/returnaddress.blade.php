@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('build/assets/app-frontend-f67f5c8c.css')}}">
<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
	<ul class="btn btn-outline-primary theme_button" style="padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_9_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_9_tooltip" aria-hidden="true"></i></li></ul>
		<div class="row"  id="step_9_tooltip" data-value="{{setting('step_9_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_9_tooltip_title')}}" data-element="step_9_tooltip" data-video_link="{{setting('step_9_video_link')}}">
			<div class="col-12">
				<table class="table table-bordered mb-5">
					<thead>
						<tr class="table-header">
							<th scope="col">Full Name.</th>
							<th scope="col">Address</th>
							<th scope="col">City</th>
							<th scope="col">State</th>
							<th scope="col">Zip</th>
							<th scope="col">Created At</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($return_address as $data)
						<tr>
							<th scope="row">{{ $data->full_name }}</th>
							<td >{{ $data->address }}</td>
							<td >{{ $data->city }}</td>
							<td >{{ $data->state }}</td>
							<td >{{ $data->zip }}</td>
							<td>{{ $data->created_at }}</td>
							<td>
							<a href="javascript:void(0);" data-json="{{json_encode($data)}}" class="mr-1 edit_return_address" title="edit return address"><i class="fa fa-pencil"></i></a>
							<a href="javascript:void(0);" data-id="{{$data->id}}" class="mr-1 delete_address" title="delete return address"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{-- Pagination --}}
				<div class="d-flex justify-content-center">
					{!! $return_address->links() !!}
				</div>
			</div>
		</div>
	</div>
</section>
<div class="return_address_class" style="display:none;">
<form action="{{ route("frontend.cards.updateReturnAddress")}}" method="POST" class="xsl_upload" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="row-field">
		<div class="form-group field-half">
			<label>First Name</label>
			<input type="text" name="return_first_name" class="form-control return_first_name" value="" placeholder="Enter your first name">
			<input type="hidden" name="id" class="record_id" value="">
		</div>
		<div class="form-group field-half">
			<label>Last Name</label>
			<input type="text" name="return_last_name" class="form-control return_last_name" value="" placeholder="Enter your last name">
		</div>
	</div>
	<div class="row-field">
		<div class="form-group field-half">
			<label>Street Address</label>
			<input type="text" name="return_address" class="form-control return_address" value="" placeholder="Enter your street address">
		</div>
		<div class="form-group field-half">
			<label>City</label>
			<input type="text" name="return_city" class="form-control return_city" value="" placeholder="Enter your town / city name">
		</div>
	</div>
	<div class="row-field">
		
		<div class="form-group  field-half">
			<label>State</label>
			<input type="text" name="return_state" class="form-control return_state" value="" placeholder="Enter your state name">
		</div>
		<div class="form-group  field-half">
			<label>Zip Code</label>
			<input type="text" name="return_pincode" class="form-control return_pincode" value="" placeholder="Enter your address pin Code">
		</div>

	</div>
	
</form>
</div>
<script>
	$(".delete_address").click(async function(){
              const body = JSON.stringify({'id':$(this).data('id')});
			  var me =$(this);
			  var d = bootbox.confirm({
                    message: 'Are you sure?',
                    buttons: {
                    confirm: {
                    label: 'Yes',
                    //   className: 'btn-success'
                    },
                    cancel: {
                    label: 'No',
                    //   className: 'btn-danger'
                    }
                    },
                    callback: function (result) {
                        if(result){
                            const result = fetch("{{route('frontend.cards.deleteReturnAddress')}}", {
							method: 'POST',
							headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							body,
						});
						me.closest('tr').remove();
                        }
                    }});
				d.find('.modal-dialog').addClass('modal-dialog-centered');
              
          })
	$("body").on('click','.edit_return_address',function(){
		var me = $(this);
		data=me.data('json');
		var d = bootbox.confirm({
                    message: $(".return_address_class").html(),
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
                            $('.xsl_upload')[1].submit();
                        }
                    }});
		
		$('body').find(".return_first_name").val(data.first_name);
		$('body').find(".return_last_name").val(data.last_name);
		$('body').find(".return_address").val(data.address);
		$('body').find(".return_city").val(data.city);
		$('body').find(".return_state").val(data.state);
		$('body').find(".return_pincode").val(data.zip);
		$('body').find(".record_id").val(data.id);
		d.find('.modal-dialog').addClass('modal-dialog-centered');
		
    })
</script>


@endsection