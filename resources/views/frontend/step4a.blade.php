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
		<div class="row">
			<div class="col-12">
				<div class="steps-content">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   
					    <div class="section-heading inner-section-heading text-center mt-10">
							<h3>Choose or Upload your design</h3>
						</div>
						<div class="step-2-options">
						
							<div class="step-2-form">
									<div class="tool-tip-row">
										<div class="help-icons">
											<a href="#"><i class="fa fa-info-circle"></i></a>
										</div>
									</div>
								<form action='{{ route("frontend.cards.step4aUpdate")}}' method="POST" id="msform">
								{{ csrf_field() }}
								<input name="card_font" type="hidden" value="Lexi-Regular">
								<div class="row-field row">
									<div class="col-12 col-sm-9">
										<div class="design-container">
											<span>Outside View</span>
												<div class="design-view-section"><!-- Design View Section -->
													<div class="tab-content" id="myTabContent">
														<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
															<img class="final_preview font_change" data-url="{{asset('img/preview/')}}/{{$final_array['front_preview_image']}}" src="{{asset('img/preview/')}}/{{$final_array['front_preview_image']}}"/>
														</div>
														<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><div class="design-area design-area__back">
															<img class="final_preview font_change" data-url="{{asset('img/preview/')}}/{{$final_array['back_preview_image']}}" src="{{asset('img/preview/')}}/{{$final_array['back_preview_image']}}"/>
														</div>
													</div>
												</div>

												<ul class="nav nav-tabs" id="myTab" role="tablist">
												<li class="nav-item" role="presentation">
													<button class="nav-link theme-btn active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Front View</button>
												</li>
												<li class="nav-item" role="presentation">
													<button class="nav-link theme-btn" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Back View</button>
												</li>
											</ul>
										</div><!-- Design View Section Ends -->
										</div>



										<div class="design-container mt-50">
											<span>Inside View</span>
											<div class="design-view-section"><!-- Design View Section -->
												<div class="design-area design-area-double">
												<img class="final_preview font_change" data-url="{{asset('img/preview/')}}/{{$final_array['preview_image']}}" src="{{asset('img/preview/')}}/{{$final_array['preview_image']}}"/>
												</div>
										</div><!-- Design View Section Ends -->
										</div>
										<!-- <div class="approve-design-btn">
											<a href="#" class="theme-btn">Approve this Design</a>
										</div> -->
										<div class="row-field">
									<div class="form-group field-full checkbox">
										<input type="checkbox" name="remember" value="Remember Me">
										<label>Accept Terms and Conditions</label>
									</div>
								</div>

										
									</div>
									<div class="col-12 col-sm-3">
										<div class="template-word-section step-4-right-buttons">
											<div class="design-upload-btn">
												<span class="upload-icon upload-icon-white"></span>
												<span>Upload</span>
												<input type="file" id="uploadDesign" class="">
											</div>
											<div class="design-template-thumb">
												<img src="img/thumbnail.jpeg">
											</div>
											<div class="design-template-thumb">
												<img src="img/thumbnail.jpeg">
											</div>
											<div class="design-template-thumb">
												<img src="img/thumbnail.jpeg">
											</div>
											<div class="design-template-thumb">
												<img src="img/thumbnail.jpeg">
											</div>
										</div>
									</div>
								</div>
							

								<input type="submit" name="next" class="next action-button upload_last_file_and_message action-button2" value="STEP5">
						<a href="{{ route("frontend.cards.step3a")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
						</form>
							</div>
						</div>
				 </div>
			</div>
		</div>
	</div>

</section>
@endsection