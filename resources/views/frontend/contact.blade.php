@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row">
			<div class="col-3">
				<button class="btn btn-outline-primary theme_button" onclick="history.back()"><i class="fa fa-arrow-left"></i> Go Back</button>
				<ul class="btn btn-outline-primary theme_button" style="padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_10_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_10_tooltip" aria-hidden="true"></i></li></ul>
			</div>
			<div class="col-3">
				<a class="btn btn-outline-primary theme_button" style="width:100%" for="btn-check-outlined" href="{{route('frontend.cards.exportFile',$id)}}">Export</a>
			</div>
			<div class="col-3">
				<form method="post" action={{route('frontend.cards.uploadFile')}} id="upload_file"  enctype="multipart/form-data">
				<label class="btn btn-outline-primary theme_button" style="width:100%" for="btn-check-outlined" onclick="getFile()">Upload</label>
				<input type="file" style="display:none;" onchange="sub(this)" name="upload_recipients" id="upload_recipients">
				<input type="hidden" name="list_id" value="{{$id}}">
				{{ csrf_field() }}
				</form>
			</div>
		</div>
		<br>
		<div class="row"  id="step_10_tooltip" data-value="{{setting('step_10_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_10_tooltip_title')}}" data-element="step_10_tooltip" data-video_link="{{setting('step_10_video_link')}}">
			<div class="col-12" style="overflow:scroll">
				<table class="table table-bordered mb-5">
					<thead>
						<tr class="table-header">
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Phone</th>
							<th scope="col">Email</th>
							<th scope="col">Company Name</th>
							<th scope="col">Address</th>
							<th scope="col">Created At</th>
							@if($contacts[0])
							@foreach ($contacts[0]->metaData as $item)
							<th>{{ $item->meta_key}}</th>
							@endforeach
							@endif
						</tr>
					</thead>
					<tbody>
						@foreach($contacts as $data)
						<tr>
							<th scope="row">{{ $data->id }}</th>
							<td>{{ $data->first_name." ".$data->last_name }}</td>
							<td>{{ $data->phone}}</td>
							<td>{{ $data->email}}</td>
							<td>{{ $data->company_name}}</td>
							<td>{{ $data->address}}, {{ $data->city}}, {{ $data->state}},{{ $data->zip}}</td>
							<td>{{ $data->created_at }}</td>
							@if($data->metaData)
							@foreach (@$data->metaData as $item)
								@if($item->meta_key=='message')
									<td>{!!nl2br($item->meta_value)!!}</td>
								@else
									<td>{{ $item->meta_value}}</td>
								@endif
							@endforeach
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
				{{-- Pagination --}}
				<div class="d-flex justify-content-center">
					{!! $contacts->links() !!}
				</div>
			</div>
		</div>
	</div>
</section>
@include('frontend.includes.loading')
<script>
	$(".loading").hide();
	function getFile() {
  document.getElementById("upload_recipients").click();
}

function sub(obj) {
	$(".loading").show();
$("#upload_file").submit();
}
</script>


@endsection