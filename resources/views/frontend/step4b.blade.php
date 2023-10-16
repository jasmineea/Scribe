@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
@php
if(@isset($final_array['campaign_type'])&&!empty($final_array['campaign_type'])&&$final_array['campaign_type']=='pending'){
	$class_tooltip="step_5";
}else{
	$class_tooltip="step_5a";
}

@endphp
<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
					<div id="msform" class="steps-content">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   <div class="section-heading inner-section-heading text-center mt-10">
						<h3>Your Campaing is complete. Save or send your campaign below! </h3>
						</div>
						<div class="step-2-options step-5-content">
							
							<form action="{{ route("frontend.cards.step5Update")}}" method="POST" id="final_form">
								{{ csrf_field() }}
								<input type="hidden" name="publish_type" value="pending">
								<input type="hidden" name="auto_charge" value="0">
								<input type="hidden" name="send_or_save" value="0">
							</form>
							@php
								$order_total=sprintf("%.2f",credit_exchange_rate(count($final_array['excel_data']['data'])));
							@endphp
							@if (auth()->user()->wallet_balance>=$order_total||@$final_array['show_save_draft']==1)
								<div class="step-5-buttons">
									<a href="#" class="send-campaign"><span>Send Campaign</span></a>
									<a href="#" class="save-campaign"><span>Save Campaign & Send Later</span></a>
								</div>
							@else
							<div class="step-5-buttons">
							<a href="#" class="send-campaign disabled"><span>Send Campaign</span></a>
								<a href="#" class="save-campaign"><span>Save Campaign & Send Later</span></a>
							</div>
							<div class="purchase-credit">
								<a href="#" class="theme-btn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" >Purchase More credits</a>
							</div>
							@endif
							
							
							
							<h2 class="mt-50">Campaign Details</h2>
							<div class="campaign-details">
								<h3>Total Credits Required: <span>{{$order_total}}</span></h3>
								<ul class="campaign-details-list">
									<li class="bootbox_click" data-action="view_recpients">View Recipients<a class="close"></a></li>
									<li class="bootbox_click" data-action="message">View Message<a class="close"></a></li>
									<li class="bootbox_click" data-action="card_design">View Card Design<a class="close"></a></li>
								</ul>
							</div>
						</div>

						<fieldset style="display:none">
							<form action="{{ route("frontend.cards.step5Update")}}" method="POST">
								{{ csrf_field() }}
						  <div class="form-card">
						  
							 <div class="row">
								<!-- <h4 class="frm-hdng"><b>Preview</b></h4> -->
								<div class="frms-flds">
								   <div class="row">
									  <div class="col-md-8">
										 <h4 class="frm-hdng">
											<b>Card Preview</b>
											
											<select class="select_font" name="card_font" style="float: right;background: white;border: 2px solid #ef7600;border-radius: 5px;font-size: 15px;font-weight: 400;">
											   {{-- <option value="">Select Font</option> --}}
											   <option value="Lexi-Regular" selected {{'Lexi-Regular'==@$final_array['card_font']? "selected" :"" }}>Lexi-Regular</option>
											   {{-- <option value="Rose-Regular" {{'Rose-Regular'==@$final_array['card_font']? "selected" :"" }}>Rose-Regular</option>
											   <option value="elaineregular" {{'elaineregular'==@$final_array['card_font']? "selected" :"" }}>Elaine Regular</option>
											   <option value="henryregular" {{'henryregular'==@$final_array['card_font']? "selected" :"" }}>Henry Regular</option>
											   <option value="morganregular" {{'morganregular'==@$final_array['card_font']? "selected" :"" }}>Morgan Regular</option> --}}
											</select>
										 </h4>
										 
										 <div><img class="final_preview font_change" data-url="{{asset('img/preview/')}}/{{$final_array['preview_image']}}" src="{{asset('img/preview/')}}/{{$final_array['preview_image']}}"/></div>
										 <p></p>
									  </div>
										@if($class_tooltip=="step_5")
											<div class="col-md-4" id="step_5_tooltip"  data-value="{{setting('step_5_tooltip_message')}}"  data-pos="right"    data-title="{{setting('step_5_tooltip_title')}}"  data-video_link="{{setting('step_5_video_link')}}">
										@else
											<div class="col-md-4" id="step_5a_tooltip"  data-value="{{setting('step_5a_tooltip_message')}}"  data-pos="right"    data-title="{{setting('step_5a_tooltip_title')}}"  data-video_link="{{setting('step_5a_video_link')}}">
										@endif

										 <h4 class="frm-hdng" style="margin-right:25%;"><b>Order Detail</b><div class="pull-right"><ul class="btn btn-outline-primary theme_button" style="float;right;position: absolute;padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="{{$class_tooltip}}_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="{{$class_tooltip}}_tooltip" aria-hidden="true"></i></li></ul></div></h4>
										 <div class="">
											@if($final_array['campaign_type']=='pending')
											<input type="hidden" name="auto_charge" value="0">
											<table class="shop_table woocommerce-checkout-review-order-table">
											   <tbody>
												  <tr class="cart_item">
													 <th>Total Recipient</th>
													 <td class="product-total">
														<span class="woocommerce-Price-amount amount total_recipient">{{count(@$final_array['excel_data']['data'])}}</span>
														<input name="total_recipient" type="hidden" value="{{count(@$final_array['excel_data']['data'])}}">
													 </td>
												  </tr>
											   </tbody>
											   <tfoot>
												@php
												$order_total=sprintf("%.2f",credit_exchange_rate(count($final_array['excel_data']['data'])));

												@endphp
												  <tr class="cart-subtotal">
													 <th>Scribe Credits Required</th>
													 <td><span class="woocommerce-Price-amount amount total_cart_amount"><bdi>{{$order_total}}</bdi></span></td>
												  </tr>
												  <tr class="cart-subtotal">
													 <th>Scribe Credit Balance</th>
													 <td><span class="woocommerce-Price-amount amount"><bdi class="user_wallet"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"></span>{{auth()->user()->wallet_balance}}</bdi></span></bdi></span></td>
												  </tr>


													@if (auth()->user()->wallet_balance>=$order_total||@$final_array['show_save_draft']==1)
														<tr class="cart-subtotal">
															@if(@$final_array['show_save_draft'])
																<td colspan="2"><input type="submit" class="theme-btn" href="javascript:void(0);" value="Save As Draft" style="text-align: center;margin-top: 10px;"></td>
															@else
																<td colspan="2"><input type="submit" class="theme-btn" href="javascript:void(0);" value="PLACE ORDER" style="text-align: center;margin-top: 10px;"></td>
															@endif
															
														</tr>
													@else
													<tr class="cart-subtotal">
														<th>Scribe Credits needed for this Campaign</th>
														<td><span class="woocommerce-Price-amount amount"><bdi class="user_wallet"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"></span>{{format_money($order_total-auth()->user()->wallet_balance)}}</bdi></span></bdi></span></td>
													 </tr>
													 <tr class="cart-subtotal">
														<td colspan="2"><a class="theme-btn text-align-and-mt" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" >Buy Scribe Credits Now</a></td>
													</tr>
													@endif


											   </tfoot>
											</table>
											<p><b>Note:</b><ul>@if(@$final_array['show_save_draft'])<li>The list for this campaign has no contacts. Add contacts before ordering. You can save the campaign as a draft.</li>@endif
											 <li>All preview shown are for illustration purpose only. actual output may vary.</li></ul></p>
												@if(@$final_array['show_save_draft'])
												<input type="hidden" name="publish_type" value="draft">
												@else
												<input type="hidden" name="publish_type" value="pending">
												@endif

											@else
											<table class="shop_table woocommerce-checkout-review-order-table">
												<tbody>
												   <!-- <tr class="cart_item">
													  <th>Scribe Credits Required</th>
													  <td class="product-total">
														 <span class="woocommerce-Price-amount amount">{{setting('card_written_pricing_less_then_equal_to_100')}} per Handwritten Card</span>

													  </td>
												   </tr> -->
												   <tr class="cart_item">
													<th>Enable Auto Recharge</th>
													<td class="product-total">
													   <span class="woocommerce-Price-amount amount">
														<div class="btn-group btn-group-toggle" data-toggle="buttons">
															<label class="btn btn-secondary active">
															  <input type="radio" name="auto_charge" value='1' {{@$final_array['auto_charge']?'checked':''}} id="option1" autocomplete="off" checked> Yes
															</label>
															<label class="btn btn-secondary">
															  <input type="radio" name="auto_charge" value='0' {{@$final_array['auto_charge']?'checked':''}} id="option2" autocomplete="off"> No
															</label>
														  </div>
														</span>
													</td>
												 </tr>
												 <tr class="cart_item">
													<th>Primary payment method:</th>
													<td class="product-total">
													   <span class="woocommerce-Price-amount amount">
														@if(count(auth()->user()->userPaymentMethods)>0)
														<select name='payment_method_id' id="payment_method_id" required>
															<option value="">Select Card</option>
															@foreach (auth()->user()->userPaymentMethods as $item)
															<option value="{{$item->id}}" {{$item->id==@$final_array['payment_method_id']?"selected":""}}>End with {{$item->last_4_digits}}</option>
															@endforeach
														</select>
														<a  href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-align-and-mt"><i class="fa fa-plus-square"></i></a>
														@else
														<a class="theme-btn text-align-and-mt" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" >Add Card</a>
														<input type='checkbox' style="opacity: 0;width: 0;height: 0;" name='payment_method_id' oninvalid="this.setCustomValidity('Please add primary payment method.')" required>
														@endif
													   </span>
													</td>
												 </tr>
												 @if($final_array['campaign_type']=='on-going')
												 <tr class="cart_item">
													<th>Action:</th>
													<td class="product-total">
													   <span class="woocommerce-Price-amount amount">
													   <select name='publish_type' id="publish_type">
															<option value="pending">Publish Now</option>
															<option value="draft">Save As Draft</option>
														</select>
													   </span>
													</td>
												 </tr>
												 <tr class="cart-subtotal">
												 <th></th>
															<td><input type="submit" class="theme-btn" href="javascript:void(0);" value="PLACE ORDER" style="text-align: center;margin-top: 10px;"></td>
												</tr>
												 @else
												 <input type="hidden" name="publish_type" value="pending">
												 @endif

												</tbody>

											 </table>
											 @php
											 	$order_total=0;
											 @endphp
											 <p><b>Note:</b> Once your Scribe Credit Balance reaches 0, your wallet will automatically be recharged with 50 credits. All Preview Shown Are For Illustration Purpose Only. Actual Output May Vary.</p>
											@endif


										 </div>
									  </div>
									  <div class="col-md-8">
										 <h4 class="frm-hdng"><b>Envelope Preview</b></h4>
										 <div class="preview_background font_change">{!!enevolopePreview(@$final_array['excel_data']['data'][2],$final_array['system_property_2'])!!}</div>
									  </div>
								   </div>
								</div>
							 </div>
						  </div>
						  <!-- <input type="submit" name="next" class="next action-button upload_last_file_and_message action-button2" value="PLACE ORDER"> -->
						  <a href="{{ route("frontend.cards.step3a")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
							</form>
					   </fieldset>
					   <a>
					   </a>
					</div>
					<a>
					</a>
				 </div>
			</div>
		</div>
	</div>

</section>
<input id="front_design" type="hidden" value="{{asset('storage/'.$final_array['front_design'])}}">
<input id="preview_image" type="hidden" value="{{asset('img/preview/')}}/{{$final_array['preview_image']}}">
<div  id="view_res" style="display:none">
<table  class="table">
	<thead>
		<tr>
			@foreach($final_array['excel_data']['header'] as $k=>$v)
			<th>{{$v}}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
	<tr>
			@foreach($final_array['excel_data']['data'] as $k=>$v)
			@foreach($v as $k1=>$v1)
			<td>{{$v1}}</td>
			@endforeach
			@endforeach
		</tr>
	</tbody>
</table>
</div>
@include('frontend.includes.squareModel')
@php
$credit_exchange_rate=credit_exchange_rate();
if($final_array['campaign_type']=='pending'){
	$required_balance=format_money($order_total*per_credit_price($order_total))-auth()->user()->wallet_balance;
}else{
	$required_balance=format_money($order_total*per_credit_price($order_total));
}

$required_balance= number_format((float)$required_balance, 2, '.', '');
@endphp
@if (auth()->user()->wallet_balance<$order_total)
	<input type="hidden" id="return_url" value="{{route('frontend.cards.step4')}}">
	<input type="hidden" id="recharge_amount" value="{{$required_balance*credit_exchange_rate()}}">
	{{-- <script src="https://js.stripe.com/v3/"></script>
	@include('frontend.includes.stipeModel')
	<script type="text/javascript" src="{{asset('js/checkout.js')}}"></script> --}}
@endif
<script>
	$(document).ready(function(){
		var recharge_amount = parseFloat("{{$order_total}}").toFixed(2);
		console.log(recharge_amount);
		if(recharge_amount=='0.00'){
			$(".payment_line,.saved_card").hide();
			$(".pay_button").html('Save Card<div class="spinner hidden" id="spinner"></div>');
		}else{
			$(".payment_line,.saved_card").show();
			$(".pay_button").html('Pay<b class="actual_payment_amount"></b><div class="spinner hidden" id="spinner"></div>');
		}

		$(".payment_amount").val(parseFloat(recharge_amount));
		$(".payment_amount").html(recharge_amount);
		$(".actual_payment_amount").html("${{$required_balance}}");
		$("#publish_type").on('change',function(){
			if($(this).val()=='draft'){
				$("#payment_method_id").attr('required',false);
			}else{
				$("#payment_method_id").attr('required',true);
			}
		})
		$(".send-campaign").click(function(){
			$("input[name='publish_type']").val('pending');
			$("#final_form").submit();
		})
		$(".save-campaign").click(function(){
			$("input[name='publish_type']").val('draft');
			$("#final_form").submit();
		})
		
		$(".bootbox_click").click(function(){
			var action = $(this).data('action');
			if(action=='view_recpients'){
				var d = bootbox.alert($("#view_res").html());
				d.find('.modal-dialog').addClass('large_modal');
			}
			if(action=='message'){
				var d = bootbox.alert('<img src="'+$("#preview_image").val()+'">');
			}
			if(action=='card_design'){
				var d = bootbox.alert('Front View: <br><br><img src={{asset("img/Front.png")}} style="width: 100%;height: inherit;background:url('+$("#front_design").val()+')"><br>Back View: <br><img src={{asset("img/Back.png")}} style="width: 100%;height: inherit;background:url('+$("#front_design").val()+')">');
			}
			
			d.find('.modal-dialog').addClass('modal-dialog-centered');
		})
		
	})
</script>
@endsection