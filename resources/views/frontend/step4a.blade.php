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
														<div class="design-area design-area__front">
															
															</div>
														</div>
														<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><div class="design-area design-area__back">
															
														</div>
													</div>
												</div>

												<ul class="nav nav-tabs" id="myTab" role="tablist">
												<li class="nav-item" role="presentation">
													<button class="nav-link1 theme-btn active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Front View</button>
												</li>
												<li class="nav-item" role="presentation">
													<button class="nav-link1 theme-btn" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Back View</button>
												</li>
											</ul>
										</div><!-- Design View Section Ends -->
										</div>



										<div class="design-container mt-50">
											<span>Inside View</span>
											<div class="design-view-section"><!-- Design View Section -->
												<div class="design-area design-area-double">
												<img style="height: -webkit-fill-available;" class="final_preview font_change" data-url="{{asset('img/preview/')}}/{{$final_array['preview_image']}}" src="{{asset('img/preview/')}}/{{$final_array['preview_image']}}"/>
												</div>
										</div><!-- Design View Section Ends -->
										</div>
										<!-- <div class="approve-design-btn">
											<a href="#" class="theme-btn">Approve this Design</a>
										</div> -->
										<div class="row-field">
									<div class="form-group field-full checkbox">
										<input type="checkbox" name="remember" value="1">
										<label>Accept Terms and Conditions</label>
									</div>
								</div>

										
									</div>
									<div class="col-12 col-sm-3">
										<div class="template-word-section step-4-right-buttons">
											<div class="design-upload-btn">
												<span class="upload-icon upload-icon-white"></span>
												<span>Upload</span>
											</div>
											@foreach($carddesigns as $k=>$v)
											<div class="design-template-thumb">
												<img src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}">
											</div>
											@endforeach
										</div>
									</div>
								</div>
							
								<input type="hidden" name="front_design" value="">
								<input type="hidden" name="back_design" value="">
								<input type="submit" name="next" class="next action-button upload_last_file_and_message action-button2" value="STEP5">
						<a href="{{ route("frontend.cards.step3a")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
						</form>
						<form id="design_form" action="{{ route("frontend.cards.cardDesignUpload")}}" method="POST" id="xsl_upload" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="file" style="opacity:0;" name="design_file" id="uploadDesign" class="">
							<input type="hidden" name="type" id="card_design_type" value="front">
						</form>
							</div>
						</div>
				 </div>
			</div>
		</div>
	</div>

</section>
@if(@$final_array['front_design'])
<input id="front_design" type="hidden" value="{{asset('storage/'.$final_array['front_design'])}}">
<input id="back_design" type="hidden" value="{{asset('storage/'.$final_array['back_design'])}}">
@endif
<script>
	var front_design=$("#front_design").val();
	var back_design=$("#back_design").val();
	if(front_design){
		$(".design-area__front").css('background','url('+front_design+') #f8f8f8');
	}
	if(back_design){
	$(".design-area__back").css('background','url('+back_design+') #f8f8f8');
	}

	$(".design-upload-btn").click(function(){
		$("#uploadDesign").trigger('click');
	})
	$("#uploadDesign").on( 'change', function () {
                $('#design_form').submit();
            });
	$(".design-template-thumb img").click(function(){
		var src=$(this).attr('src');
		var path=$(this).data('path');
		$(".design-area__front").css('background','url('+src+') #f8f8f8');
		$(".design-area__back").css('background','url('+src+') #f8f8f8');
		$("input[name='front_design']").val(path);
		$("input[name='back_design']").val(path);
	})
	</script>
@endsection