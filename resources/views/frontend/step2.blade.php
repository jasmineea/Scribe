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
											<div class="mb-2">
												<textarea required name="hwl_custom_msg" id="hwl_custom_msg_1" class="hwl_custom_msg custm-edtr" style="min-height: 3.5in;max-height: 3.5in;width: 4.5in;max-width: 4.5in;padding: 0px !important; outline: none;border: none;overflow: hidden;resize: none;" placeholder="Type your Note here.">{{@$final_array['hwl_custom_msg']}}</textarea></div>
											<h6 class="wrd-cuntng" id="lines">110 words remaining</h6>
											<p style="width: 71%;font-weight: 500;"><b style="color:#EF7600;">Note:</b> When you paste text into the editor, it might require re-formatting.</p>
										</div>
									  <div class="col-6" style="padding-left: 3%;">
									  <h4 style="font-size: 19px;"><b>Select message length option  </b></h4>
											<select name="message_length"  class="form-select message_length">
												<option value="short" {{@$final_array['message_length']=='short'?'selected':''}}>Short Text (upto 110 words or max 13 lines)</option>
												<option value="long" {{@$final_array['message_length']=='long'?'selected':''}}>Long Text (upto 140 words or max 16 lines)</option>
											</select>
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
										 
										 <div class="row-field">
										@if (isset($return_address)&&!empty($return_address))
										<div class="form-group field-half" style="padding-top:11px;">
										 	<select required name="return_address_id" class="custom-select sources return_address_id required_class" style="padding: 10px 10px;border: 1px solid #ef7600;background: #E7934C;border-radius: 22px;color: white;font-weight: bold;">
											<option value="">Select Address</option>
											@foreach ($return_address as $key => $item)
												<option value="{{$item['id']}}" {{$item['id']==@$final_array['return_address_id']?'selected':''}}>{{$item['full_name']}}, {{$item['address']}}, {{$item['city']}}, {{$item['state']}}, {{$item['zip']}}</option>
											@endforeach
											</select>
											</div>
											<div style="padding-left: 15px;padding-top: 19px;padding-right: 9px;">
												or
											</div>
										@endif
										<div class="form-group field-half">
										<input type="button" name="" class="add_return_address action-button action-button-tag" value="Add Return Address" style="">
										</div>
										</div>
											<div class="return_address_class">
												<div class="row-field">
													<div class="form-group field-half">
														<label>First Name</label>
														<input type="text" name="return_first_name" value="" class="form-control" id="exampleFormControlInput1" placeholder="Enter your first name">
													</div>
													<div class="form-group field-half">
														<label>Last Name</label>
														<input type="text" name="return_last_name" value="" class="form-control" id="exampleFormControlInput1" placeholder="Enter your last name">
													</div>
												</div>
												<div class="row-field">
													<div class="form-group field-half">
														<label>Street Address</label>
														<input type="text" name="return_address" value="" class="form-control" id="exampleFormControlInput1" placeholder="Enter your street address">
													</div>
													<div class="form-group field-half">
														<label>City</label>
														<input type="text" name="return_city" value="" class="form-control" id="exampleFormControlInput1" placeholder="Enter your town / city name">
													</div>
												</div>
												<div class="row-field">
													
													<div class="form-group  field-half">
														<label>State</label>
														<input type="text" name="return_state" value="" class="form-control" id="exampleFormControlInput1" placeholder="Enter your state name">
													</div>
													<div class="form-group  field-half">
														<label>Zip Code</label>
														<input type="text" name="return_pincode" value="" class="form-control" id="exampleFormControlInput1" placeholder="Enter your address pin Code">
													</div>
												
												</div>
											</div>
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
@if(@$final_array['message_length']=='long')
<input id="input_lines" type="hidden" value="16">
<input id="input_words" type="hidden" value="140">
<script>
	$("#hwl_custom_msg_1").css('max-height','4.5in');
				$("#hwl_custom_msg_1").css('min-height','4.5in');
				$(".line_15").show();
				
</script>
@else
<input id="input_lines" type="hidden" value="13">
<input id="input_words" type="hidden" value="110">
<script>
	$("#hwl_custom_msg_1").css('max-height','3.5in');
				$("#hwl_custom_msg_1").css('min-height','3.5in');
				$(".line_15").hide();
</script>
@endif

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
	$(document).ready(function(){
		$(".return_address_class").hide();
		$(".add_return_address").click(function(){
			$(".return_address_class").toggle('slow');
			if($(".return_address_id").hasClass('required_class')){
				$(".return_address_id").removeClass('required_class');
				$('.return_address_id').prop('required',false);;
				$(".return_address_class").find('.form-control').prop('required',true);;
				console.log('1');
			}else{
				$(".return_address_id").addClass('required_class');
				$('.return_address_id').prop('required',true);;
				$(".return_address_class").find('.form-control').prop('required',false);;
				console.log('2');
			}
		})
		$(".message_length").change(function(){
			
			if($(this).val()=='long'){
				$("#hwl_custom_msg_1").css('max-height','4.5in');
				$("#hwl_custom_msg_1").css('min-height','4.5in');
				$("#input_lines").val('16');
				$("#input_words").val('140');
				$(".line_15").show();
			}else{
				$("#hwl_custom_msg_1").css('max-height','3.5in');
				$("#hwl_custom_msg_1").css('min-height','3.5in');
				$("#input_lines").val('13');
				$("#input_words").val('110');
				$(".line_15").hide();
			}
			$('.hwl_custom_msg').trigger('keyup');
		})
})
	function getFile() {
  document.getElementById("upload_recipients").click();
}


function sub(obj) {
  var file = obj.value;
  var fileName = file.split("\\");
  document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
}
</script>

@endsection
