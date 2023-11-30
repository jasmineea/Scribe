

<input type="hidden" id="return_url" value="{{route('frontend.cards.wallet')}}">
<input type="hidden" id="create_token_url" value="{{route('frontend.cards.createStripeToken')}}">
<input type="hidden" id="pk_key" value="{{env('STRIPE_KEY')}}">
<input type="hidden" id="recharge_amount" value="{{$amount}}">
<section id="hero-section">
	<div class="container-fluid padding_top_135" style="padding-left: 368px;">
		<div class="row">
			<div class="col-12">
				<form id="payment-form">
                <div id="link-authentication-element">
                    <!--Stripe.js injects the Link Authentication Element-->
                </div>
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay now</span>
                </button>
                <div id="payment-message" class="hidden"></div>
                </form>
			</div>
		</div>
	</div>
</section>
