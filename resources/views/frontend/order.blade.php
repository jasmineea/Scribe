@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
	<ul class="btn btn-outline-primary theme_button" style="padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_7_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_7_tooltip" aria-hidden="true"></i></li></ul>
		<div class="row" id="step_7_tooltip" data-value="{{setting('step_7_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_7_tooltip_title')}}" data-element="step_7_tooltip" data-video_link="{{setting('step_7_video_link')}}">
			<div class="col-12">
				<table class="table table-bordered mb-5">
					<thead>
						<tr class="table-header">
							<th scope="col"># Campaign</th>
							<th scope="col">Name</th>
							<th scope="col">Status</th>
							<th scope="col">Type</th>
							<th scope="col">Total Recipient</th>
							<th scope="col">Scribe Credit Used</th>
							<th scope="col">Message Overview</th>
							<th scope="col">Created At</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $data)
						<tr>
							<th scope="row">{{ $data->id }}</th>
							<td>{{ $data->campaign_name }}</td>
							<td>{{ status_format($data->status) }}</td>
							<td>{{ $data->campaign_type }}</td>
							<td><a href="{{route('frontend.cards.contacts',$data->listing_id)}}">{{isset($data->listing)?$data->listing->contacts->count():0}}</a></td>
							<td>{{ $data->order_amount }}</td>
							<td>@php if(@$data->campaign_message&&file_exists(public_path('img/preview/'.@$data->campaign_message))){ $preview_image=asset('img/preview/'.@$data->campaign_message); echo("<img width='100px' class='model_preview'  style='display:inline;' data-url='".$preview_image."' src='".$preview_image."'>"); }else{ echo $data->campaign_message;} @endphp</td>
							<td>{{ $data->created_at }}</td>
							<td>
							@if($data->campaign_type=='on-going')
							{{-- <a href="{{route('frontend.cards.contacts',$data->listing_id)}}" class="mr-1"><i class="fa fa-address-book"></i></a> --}}
							<a href="{{route('frontend.cards.orderEdit',$data->id)}}" class="mr-1"  title="edit campaign"><i class="fa fa-pencil"></i></a>
								@if($data->status=='paused'||$data->status=='draft')
									@if(empty($data->payment_method_id))
										@if(count(auth()->user()->userPaymentMethods)>0)
											<a href="#" data-url="{{route('frontend.cards.updateStatus',[$data->id,'pending'])}}" class="mr-1 assign_card_to_draft_order" title="start campaign"><i class="fa fa-play"></i></a>
										@else
											<a href="#" data-url="0" class="mr-1 assign_card_to_draft_order" title="start campaign"><i class="fa fa-play"></i></a>
										@endif
									@else
										<a href="{{route('frontend.cards.updateStatus',[$data->id,'pending'])}}" class="mr-1" title="start campaign"><i class="fa fa-play"></i></a>
									@endif
								@endif
								@if($data->status=='pending')
									<a href="{{route('frontend.cards.updateStatus',[$data->id,'paused'])}}" class="mr-1"  title="pause campaign"><i class="fa fa-pause"></i></a>
								@endif
							@else
							@if($data->status=='paused'||$data->status=='draft')
								<a href="{{route('frontend.cards.updateStatus',[$data->id,'pending'])}}" class="mr-1" title="start campaign"><i class="fa fa-play"></i></a>
							@endif
							<a href="{{route('frontend.cards.contacts',$data->listing_id)}}" class="mr-1"  title="campaign recipients"><i class="fa fa-address-book"></i></a>
							<a href="{{route('frontend.cards.duplicateOrder',$data->id)}}" class="mr-1"  title="duplicate this campaign"><i class="fa fa-clone"></i></a>
							@endif
							<a href="{{route('frontend.cards.orderDetail',$data->id)}}" class="mr-1"  title="view campaign detail"><i class="fa fa-eye"></i></a>
							@if($data->status=='payment-pending')
							<a href="javascript:void(0);" class="mr-1 payment_button" data-payment="{{$data->order_amount}}" data-id="{{$data->id}}"  title="ccc"><i class="fa fa-money"  data-bs-toggle="modal" data-bs-target="#exampleModal"></i></a>
							@endif
							<a href="{{route('frontend.cards.contacts',$data->listing_id)}}" class="mr-1"  title="Add more contacts"><i class="fa fa-plus"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{-- Pagination --}}
				<div class="d-flex justify-content-center">
					{!! $orders->links() !!}
				</div>
			</div>
		</div>
	</div>
</section>
<div class="payment_method_ids"  style="display:none;">
<select name='payment_method_id' class="w-100" required>
	<option value="">Select Card</option>
	@foreach (auth()->user()->userPaymentMethods as $item)
	<option value="{{$item->id}}" {{$item->id==@$final_array['payment_method_id']?"selected":""}}>End with {{$item->last_4_digits}}</option>
	@endforeach
</select>
</div>
@include('frontend.includes.squareModel')

{{-- @if (auth()->user()->wallet_balance<$order_total)
	<input type="hidden" id="return_url" value="{{route('frontend.cards.orders')}}">
	<input type="hidden" id="recharge_amount" value="{{$required_balance*credit_exchange_rate()}}"> --}}
	{{-- <script src="https://js.stripe.com/v3/"></script>
	@include('frontend.includes.stipeModel')
	<script type="text/javascript" src="{{asset('js/checkout.js')}}"></script> --}}
{{-- @endif --}}
<script>
	$(document).ready(function(){
		$(".payment_button").click(function(){
			var recharge_amount = $(this).data('payment');
			recharge_amount = parseFloat(recharge_amount).toFixed(2);
			$(".payment_amount").val(parseFloat(recharge_amount*{{credit_exchange_rate()}}));
			$(".order_id").val($(this).data('id'));
			$(".payment_amount").html(recharge_amount);
			$(".actual_payment_amount").html("$"+(recharge_amount*{{credit_exchange_rate()}}).toFixed(2));
		})
	})
</script>
@endsection