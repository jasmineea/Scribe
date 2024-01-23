@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="hero-content" style="text-align: center;margin:auto;padding-top: 0;">
					<h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
					<h2 class="site-header__title" data-lead-id="site-header-title">For submitting your campaign!</h2>
					<p class='thank-you1'>Your letters will send within 2-4 business days, then take 5-7 days to arrive.</p>
					<p class='thank-you1'>Have questions? Email <a href = "mailto: support@scribehandwritten.com">support@scribehandwritten.com</a></p>
					<p class='thank-you1'>Need to Integrate Your CRM? Email <a href = "mailto: graham@scribehandwritten.com">graham@scribehandwritten.com</a> to integrate you account.</p>
					<p class='thank-you1'> Have questions on your marketing strategy, pricing, or need to reorder, or anything else?</p>
					<p class='thank-you1'> Email your client success specialist Stacey Miller, at <a href = "mailto: stacey@scribehandwritten.com">stacey@scribehandwritten.com</a></p>
					<p></p>
					<h2>  What Should I Expect Next? Watch the Video Below Now!</h2>
					<img class="thank-youimg" src="{{ asset('img/video-player-placeholder-very-large.png') }}">
					<!-- <a class="theme-btn" href="{{route('frontend.cards.orders')}}" style="margin: auto;">View Orders</a> -->
				</div>

			</div>
		</div>
	</div>
</section>

@endsection