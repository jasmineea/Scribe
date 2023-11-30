@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="hero-content" style="text-align: center;margin:auto;width:40%;">
					<h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>Thanks a bunch for filling that out. It means a lot to us, just like you do! We really appreciate you giving us a moment of your time today. Thanks for being you.
					<a class="theme-btn" href="{{route('frontend.cards.orders')}}" style="margin: auto;">View Orders</a>
				</div>

			</div>
		</div>
	</div>
</section>

@endsection