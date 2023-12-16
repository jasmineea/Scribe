@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('build/assets/app-frontend-f67f5c8c.css')}}">
    <style type="text/css">
        .container {
            margin-top: 40px;
        }
        .panel-heading {
        display: inline;
        font-weight: bold;
        }
        .flex-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 55%;
        }
		.hide{
			display: none !important;
		}
		.form-row.row {
			padding-bottom: 15px;
		}

</style>
<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
	<ul class="btn btn-outline-primary theme_button" style="padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_6_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_6_tooltip" aria-hidden="true"></i></li></ul>
		<div class="row">
			<div class="col-6">
				<div class="hero-content" style="padding-top: 10px !important;"   id="step_6_tooltip" data-value="{{setting('step_6_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_6_tooltip_title')}}" data-element="step_6_tooltip" data-video_link="{{setting('step_6_video_link')}}">
					{{-- <h1><span>wallet</span></h1> --}}

					<p><b>Scribe Credit Balance </b>: {{auth()->user()->wallet_balance}}</p>
					<ul class="recharge_block">
						<li><button class="theme-btn">100</button></li>
						<li><button class="theme-btn">500</button></li>
						<li><button class="theme-btn">1000</button></li>
						<li><button class="theme-btn">2000</button></li>
						<li><button class="theme-btn">5000</button></li>
					</ul>

				<form role="form" action="#" method="get" class="validation" id="wallet_form">


					<div class='form-row row'>
						<div class='col-xs-12 col-md-10 form-group required'>
							<label class='control-label'>Enter Credit Amount</label> <input
								class='form-control' id="recharge_amount_input"  size='4'
								type='number' name="amount" value="{{ app('request')->input('amount')}}"  placeholder="Enter Credit Amount" required>
								<input type="hidden" id="recharge_amount" value="">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button class="theme-btn" type="submit">Pay Now</button>
						</div>
					</div>

				</form>

				</div>
				</div>
				<div class="col-6">
				<table class="table">
					<thead>
						<tr>
						<th scope="col">Hadwritten Card</th>
						<th scope="col">Price($)</th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
						<th scope="row">1 to 100</th>
						<td>{{setting('card_written_pricing_less_then_equal_to_100')}}</td>
						</tr>
						<tr>
						<th scope="row">101 to 500</th>
						<td>{{setting('card_written_pricing_101_to_500')}}</td>
						</tr>
						<tr>
						<th scope="row">501 to 1000</th>
						<td>{{setting('card_written_pricing_501_to_1000')}}</td>
						</tr>
						<tr>
						<th scope="row">1001 to 2000</th>
						<td>{{setting('card_written_pricing_1001_to_2000')}}</td>
						</tr>
						<tr>
						<th scope="row">Greater then 2000</th>
						<td>{{setting('card_written_pricing_greater_2000')}}</td>
						</tr>
						
						
					</tbody>
					</table>
				</div>
				<div class="col-12">
					<table class="table table-bordered mb-5">
						<thead>
							<tr class="table-header">
								<th scope="col">#</th>
								<th scope="col">Type</th>
								<th scope="col">Amount</th>
								<th scope="col">Wallet Balance</th>
								<th scope="col">Payment method</th>
								<th scope="col">Paid($)</th>
								<th scope="col">Transactions Id</th>
								<th scope="col">Info</th>
								<th scope="col">Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach($transactions as $data)
							<tr>
								<th scope="row">{{ $data->id }}</th>
								<td>{{ $data->type }}</td>
								<td>{{ $data->amount }}</td>
								<td>{{ $data->wallet_balance }}</td>
								<td>{{ $data->payment_method }}</td>
								<td>{{ $data->currency_amount }}</td>
								<td>{{ $data->online_transaction_id }}</td>
								<td>{{ $data->comment }}</td>
								<td>{{ $data->created_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{-- Pagination --}}
					<div class="d-flex justify-content-center">
						{!! $transactions->links() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('frontend.includes.squareModel')

<input type="hidden" id="return_url" value="{{route('frontend.cards.wallet')}}">
<script src="https://js.stripe.com/v3/"></script>
<script>
	$(document).ready(function(){
		$(".recharge_block button").click(function(){
			$("#recharge_amount_input").val(parseFloat($(this).html()));
			$("#recharge_amount").val(parseFloat($(this).html())*per_credit_price($(this).html()));
		})
		$( "#wallet_form" ).submit(function( event ) {
			initialize();
			$('#exampleModal').modal('toggle');
			var recharge_amount = parseFloat($("#recharge_amount_input").val()).toFixed(2);
			$(".payment_amount").val(recharge_amount);
			$(".payment_amount").html(recharge_amount);
			$(".actual_payment_amount").html("$"+(recharge_amount*per_credit_price(recharge_amount)).toFixed(2));
			// $("#recharge_amount").val();
			// $.ajax({
			// 				url: "{{route('frontend.cards.createStripeElementPopup')}}",
			// 				type: "GET",
			// 				headers: { "Content-Type": "application/json",'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			// 				dataType: 'json',
			// 				success: function (data) {
			// 					$('#exampleModal .modal-body').html(data);
			// 				},
			// 				error: function (data) {
			// 				}
			// 			});
			event.preventDefault();
			});


	})
</script>

<script type="text/javascript" src="{{asset('js/checkout.js')}}"></script>

@endsection