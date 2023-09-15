@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row justify-content-center" id="step_5_tooltip"  data-value="{{setting('step_5_tooltip_message')}}"  data-pos="right"    data-title="{{setting('step_5_tooltip_title')}}"  data-video_link="{{setting('step_5_video_link')}}">
			<div class="col-12">
				<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
					<div id="msform" class="step-5">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   <fieldset>
						<form action="{{ route("frontend.cards.step5Update")}}" method="POST">
							{{ csrf_field() }}
						@if($final_array['campaign_type']=='pending')
						<input type="hidden" name="publish_type" value="pending">
						<input type="hidden" name="schedule_date"  value="">
						<div class="form-card">
							 <div class="row">
								<div class="col-8">
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<label for="exampleFormControlInput1">First name</label>
												<input name="first_name" value="{{isset($final_array['first_name'])?$final_array['first_name']:auth()->user()->first_name}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your first name">
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="exampleFormControlInput1">Last name</label>
												<input name="last_name" value="{{isset($final_array['last_name'])?$final_array['last_name']:auth()->user()->last_name}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your last name">
											</div>
										</div>
									</div>
									{{-- <div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="exampleFormControlInput1">Street address</label>
											<input name="street" value="{{isset($final_array['street'])?$final_array['street']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your street address">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="exampleFormControlInput1">Apartment, suite, unit, etc</label>
											<input name="apartment" value="{{isset($final_array['apartment'])?$final_array['apartment']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your apartment, suite, unit, etc">
										</div>
									</div>
									</div> --}}
										{{-- <div class="row">
											<div class="col-6">
												<div class="form-group">
													<label for="exampleFormControlInput1">Country</label>
													<select id="country" value="{{isset($final_array['country'])?$final_array['country']:''}}" name ="country" placeholder="Select Country" required class="form-control"></select>
												</div>
											</div>
									<div class="col-6">
										<div class="form-group">
											<label for="exampleFormControlInput1">State</label>
											<select id="state" value="{{isset($final_array['state'])?$final_array['state']:''}}" name ="state" placeholder="Select State" required class="form-control">
											<option value=''>Select State</option>
											</select>
										</div>
										</div>
									</div> --}}
									{{-- <div class="row">
											<div class="col-6">
												<div class="form-group">
													<label for="exampleFormControlInput1">Town</label>
													<input name="city" value="{{isset($final_array['city'])?$final_array['city']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your town / city name">
												</div>
											</div>
											<div class="col-6">
											<div class="form-group">
												<label for="exampleFormControlInput1">PIN Code</label>
												<input name="pincode" value="{{isset($final_array['pincode'])?$final_array['pincode']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your address pin Code">
											</div>
										</div>
									</div> --}}
										<div class="row">
											<div class="col-6">
										<div class="form-group">
											<label for="exampleFormControlInput1">Email address</label>
											<input name="email" value="{{isset($final_array['email'])?$final_array['email']:auth()->user()->email}}" required class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
										</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="exampleFormControlInput1">Phone</label>
												<input name="phone" value="{{isset($final_array['phone'])?$final_array['phone']:auth()->user()->mobile}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your phone number">
											</div>
											</div>
									</div>
									<input name="total_recipient" type="hidden" value="{{count($final_array['excel_data']['data'])}}">
										</div>
										   <div class="col-4">
										   <h3 id="order_review_heading">Your order</h3>
										   <div id="order_review" class="woocommerce-checkout-review-order">
											<div class="">
												<table class="shop_table woocommerce-checkout-review-order-table">
												   <tbody>
													  <tr class="cart_item">
														 <th>Total Recipient</th>
														 <td class="product-total">
															<span class="woocommerce-Price-amount amount total_recipient">{{count($final_array['excel_data']['data'])}}</span>
														 </td>
													  </tr>
												   </tbody>
												   @php
													$order_total=sprintf("%.2f",order_total(count($final_array['excel_data']['data'])));
													$wallet_balance=sprintf("%.2f",auth()->user()->wallet_balance);
													@endphp

												   <tfoot>
													  <tr class="cart-subtotal">
														 <th>Points Required</th>
														 <td><span class="woocommerce-Price-amount amount total_cart_amount"><bdi>{{$order_total}}</bdi></span></td>
													  </tr>
													  <tr class="cart-subtotal">
														 <th>Points In Wallet</th>
														 <td><span class="woocommerce-Price-amount amount"><bdi class="user_wallet"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"></span>{{$wallet_balance}}</bdi></span></bdi></span></td>
													  </tr>
													@if ($wallet_balance>=$order_total)
														<tr class="cart-subtotal">
															<td colspan="2"><input type="submit" class="theme-btn" href="javascript:void(0);" value="PLACE ORDER" ></td>
														</tr>
													@else
													<tr class="cart-subtotal">
														<th>Scribe Credits needed for this Campaign</th>
														<td><span class="woocommerce-Price-amount amount"><bdi class="user_wallet"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"></span>{{$order_total-$wallet_balance}}</bdi></span></bdi></span></td>
													</tr>

													<td colspan="2"><a class="theme-btn" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" style="text-align: center;margin-top: 10px;">Buy Scribe Credits Now</a></td>
													@endif
												   </tfoot>
												</table>
											 </div>


										   </div>

									 </div>
								</div>

							 </div>

							{{-- <input type="submit" name="next" class="next action-button upload_last_file_and_message" value="Place Order"> --}}
							<a href="{{ route("frontend.cards.step4")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
						  </div>
						@else
						<div class="form-card">
							<div class="row">
							   <div class="col-12">
								   <div class="row">
									   <div class="col-3">
									   </div>
										<div class="col-6">
										<div class="single_row2 max-width-650 custom_box">
											<input type="radio" name="publish_type" checked value="pending" class="btn-check" id="btn-check-outlined" autocomplete="off">
											<label class="btn btn-outline-primary theme_button" data-value="pending" style="width:50%" for="btn-check-outlined">Publish Now</label>
											<input type="radio" name="publish_type" value="draft" class="btn-check" id="btn-check-outlined1" autocomplete="off">
											<label class="btn btn-outline-primary theme_button"  data-value="draft" style="width:49%" for="btn-check-outlined1">Save As Draft</label>
										</div>

									   </div>

								   </div>

									   </div>

							   </div>

							</div>

						   <input type="submit" name="next" class="next action-button action-button2" value="Place Order">
						   <a href="{{ route("frontend.cards.step4")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
						 </div>
						@endif



						</form>
					   </fieldset>

					</div>

				 </div>
			</div>
		</div>
	</div>
</section>
@if($final_array['campaign_type']=='pending')
<script>
	populateCountries("country", "state");
</script>

@if (auth()->user()->wallet_balance<$order_total)
	<input type="hidden" id="return_url" value="{{route('frontend.cards.step4')}}">
	<input type="hidden" id="recharge_amount" value="{{credit_exchange_rate()*($order_total-auth()->user()->wallet_balance)}}">
	<script src="https://js.stripe.com/v3/"></script>
	@include('frontend.includes.stipeModel')
	<script type="text/javascript" src="{{asset('js/checkout.js')}}"></script>
@endif
@endif
@endsection