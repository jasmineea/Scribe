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
							<th scope="col">Campaign List No.</th>
							<th scope="col">Campaign List Name</th>
							<th scope="col">Message Overview</th>
							<th scope="col">Total Recipients</th>
							<th scope="col">Created At</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($listings as $data)
						<tr>
							<th scope="row">{{ $data->id }}</th>
							<td><a href="{{route('frontend.cards.contacts',$data->id)}}">{{ $data->name }}</a></td>
							<td>{{ $data->message?:'-' }}</td>
							<td><a href="{{route('frontend.cards.contacts',$data->id)}}">{{ $data->contacts->count()}}</a></td>
							<td>{{ $data->created_at }}</td>
							<td><a href="{{route('frontend.cards.contacts',$data->id)}}">View All Recipients</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{-- Pagination --}}
				<div class="d-flex justify-content-center">
					{!! $listings->links() !!}
				</div>
			</div>
		</div>
	</div>
</section>


@endsection