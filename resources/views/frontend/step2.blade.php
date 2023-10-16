@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
@php
if(@isset($final_array['listing_id'])&&!empty($final_array['listing_id'])){
	$class_tooltip="step_3";
}else{
	$class_tooltip="step_3a";
}
@endphp
<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
					<div id="msform">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   <fieldset>

						<form action="{{ route("frontend.cards.step3Update")}}" method="POST" id="xsl_upload" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="written_letter_form">
							 <div class="Repeater_container">
								<div class="main">
								<div class="row">
								<div class="col-1">
								<ul class="btn btn-outline-primary theme_button" style="position: absolute;padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="{{$class_tooltip}}_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="{{$class_tooltip}}_tooltip" aria-hidden="true"></i></li></ul>
								</div>
								<div class="col-11">
								<div class="main-upload-list">
								@if($class_tooltip=="step_3")
									<div class="single_row2 max-width-650 custom_box" id="step_3_tooltip" data-value="{{setting('step_3_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_3_tooltip_title')}}" data-element="step_3_tooltip" data-video_link="{{setting('step_3_video_link')}}">
								@else
									<div class="single_row2 max-width-650 custom_box" id="step_3a_tooltip" data-value="{{setting('step_3a_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_3a_tooltip_title')}}" data-element="step_3a_tooltip" data-video_link="{{setting('step_3a_video_link')}}">
								@endif
									  <div class="custom_message" >
										<div class="row">
										<div class="col-6">
										 <h4 style="font-size: 19px;"><b>Please enter your custom message</b></h4>
										 <div class="mb-2"><textarea required name="hwl_custom_msg" id="hwl_custom_msg_1" class="hwl_custom_msg custm-edtr" style="min-height: 5in;max-height: 5in;width: 4.1in;max-width: 4.1in;padding: 0px; outline: none;border: none;" placeholder="Type your Note here.">{{@$final_array['hwl_custom_msg']}}</textarea></div>
										 <h6 class="wrd-cuntng">120 words remaining</h6>
									  </div>
									  <div class="col-6" style="padding-left: 3%;">
									  <div class="group-btn">
											<p class="template_words"></p>

											@if (isset($final_array['tags']))
												@foreach ($final_array['tags'] as $key => $item)
													<input type="button" data-toggle="tooltip" data-placement="bottom" name="" class="lname_btn group-btn-item action-button action-button-tag" data-placeholder="{@php echo($key); @endphp}" value="{{$item}}" aria-label="{{$item}}" data-bs-original-title="{{$item}}" >
													<input type="hidden" name="tags[{{$key}}]" value="{{$item}}">
												@endforeach
											@endif


											<input type="button" name="" class="create_custom_parameter action-button action-button-tag" value="Create Custom Parameter" style="">
											
										 </div>
										 <b style="color:#EF7600;">Note:</b> When you paste text into the editor, it might require re-formatting.
									  </div>
									  </div>
									  <input type="hidden" name="textmsg" value="{{@$final_array['textmsg']}}" class="textmsg">
									  <input type="hidden" name="list_id" value="{{@$final_array['list_id']}}" class="">
									  
								   </div>
								   </div>

								</div>
								</div>
							 </div>
						  </div>
						  <input type="submit" name="next" class="next action-button upload_file_next action-button2 ApplyLineBreaks" value="GO TO STEP 4">
						  @if($final_array['campaign_type']=='single')
						  <a href="{{ route('frontend.cards.step2a')}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
						  @else
						  <a href="{{ route('frontend.cards.step2')}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
						  @endif
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


@endsection
<style>
	.select_design,#yourBtn,#listing_select{
  position: relative;
  width: 300px;
  padding: 10px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border: 1px dashed #BBB;
  text-align: center;
  background-color: white;
  cursor: pointer;
  color: #ef7600;
    border: 1px solid #ef7600;
	margin: 10px 0px;
}
	</style>
<script>
	function getFile() {
  document.getElementById("upload_recipients").click();
}

function sub(obj) {
  var file = obj.value;
  var fileName = file.split("\\");
  document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
}
</script>