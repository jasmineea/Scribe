@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	@auth
	<div class="container-fluid"  style="padding-left: 368px;">
	@else
	<div class="container-fluid">
	@endif
		<div class="row">
			<div class="col-6">
				<div class="hero-content">
					<h1><span>One Off</span><br>
					Handwritten <br>Letters</h1>
					<p>Whether its 1 letter, or 1,000, use our API to connect to your CRM to create handwritten automated flows, or submit one off and bulk orders below!</p>
					<div class="cta-btns">
						<a class="theme-btn" href="{{ route("frontend.cards.step1")}}">Start Building</a>
						<a href="#" class="icon-right-arrow">Book a Demo</a>
					</div>
					<div class="hero-price">
						<span>Starting at $2.99</span>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="hero-images">
					<img src="{{asset('img/kw-legacy.png')}}" class="kw-legacy">
					<img src="{{asset('img/home-hero.png')}}" class="home-hero">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<a href="#" class="scribe-icon"><img src="{{asset('img/scribe-icon.png')}}"></a>
			</div>
		</div>
	</div>
</section>
<section id="campaign-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="section-heading">
					<h2>Create a campaign in <u>5 Steps</u> <span>Made easy!</span></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-4">
				<div class="campaign-boxes">
					<div class="c-number">01</div>
					<div class="c-title">Name your campaign and compose your message.</div>
					//<div class="c-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</div>
				</div>
			</div>
			<div class="col-12 col-sm-4">
				<div class="campaign-boxes">
					<div class="c-number">02</div>
					<div class="c-title">Upload your contact list via CSV</div>
					//<div class="c-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</div>
				</div>
			</div>
			<div class="col-12 col-sm-4">
				<div class="campaign-boxes">
					<div class="c-number">03</div>
					<div class="c-title">Map your contact list fields</div>
					//<div class="c-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</div>
				</div>
			</div>
			<div class="col-12 col-sm-4">
				<div class="campaign-boxes">
					<div class="c-number">04</div>
					<div class="c-title">Choose your handwritten font</div>
					//<div class="c-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</div>
				</div>
			</div>
			<div class="col-12 col-sm-4">
				<div class="campaign-boxes">
					<div class="c-number">05</div>
					<div class="c-title">Review & approve design proof</div>
					//<div class="c-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="how-it-works">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="section-heading">
					<h2>So...how exactly does it work?</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="section-content">
					<p>With emails, text, and linkedin messages and other markering efforts going into spam...It’s time to try a proven intimate touch that breaks through the noise.</p>
					<div class="video-player">
						<img src="{{asset('img/v-player.svg')}}">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="people-say">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="peoplep-say-image">
					<img src="{{asset('img/people-say-img.svg')}}">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="section-heading mt-50">
					<h2>What do people have to say about Scribe?</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="review-box">
					<div class="review-video">
						<img src="{{asset('img/v-img.svg')}}">
					</div>
					<div class="review-meta">
						<div class="review-pic">
							<img src="{{asset('img/portrait.png')}}">
						</div>
						<div class="review-name">
							<h3>Clyde B.</h3>
							<span>CEO | Dillinger Studios</span>
						</div>
						<div class="rewiew-rating">
							<img src="{{asset('img/stars.png')}}">
						</div>
					</div>
					<div class="review-content">
							<h3>Fantasticooo!</h3>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
						</div>
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<div class="review-box">
					<div class="review-video">
						<img src="{{asset('img/v-img.svg')}}">
					</div>
					<div class="review-meta">
						<div class="review-pic">
							<img src="{{asset('img/portrait.png')}}">
						</div>
						<div class="review-name">
							<h3>Clyde B.</h3>
							<span>CEO | Dillinger Studios</span>
						</div>
						<div class="rewiew-rating">
							<img src="{{asset('img/stars.png')}}">
						</div>
					</div>
					<div class="review-content">
							<h3>Fantasticooo!</h3>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
						</div>
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<div class="review-box">
					<div class="review-video">
						<img src="{{asset('img/v-img.svg')}}">
					</div>
					<div class="review-meta">
						<div class="review-pic">
							<img src="{{asset('img/portrait.png')}}">
						</div>
						<div class="review-name">
							<h3>Clyde B.</h3>
							<span>CEO | Dillinger Studios</span>
						</div>
						<div class="rewiew-rating">
							<img src="{{asset('img/stars.png')}}">
						</div>
					</div>
					<div class="review-content">
							<h3>Fantasticooo!</h3>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
						</div>
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<div class="review-box">
					<div class="review-video">
						<img src="{{asset('img/v-img.svg')}}">
					</div>
					<div class="review-meta">
						<div class="review-pic">
							<img src="{{asset('img/portrait.png')}}">
						</div>
						<div class="review-name">
							<h3>Clyde B.</h3>
							<span>CEO | Dillinger Studios</span>
						</div>
						<div class="rewiew-rating">
							<img src="{{asset('img/stars.png')}}">
						</div>
					</div>
					<div class="review-content">
							<h3>Fantasticooo!</h3>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
