@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
<style>
.btn-check {
    position: absolute;
    clip: auto !important;
    pointer-events: none;
    margin-top: 11px;
    margin-left: 16px;
}
</style>
<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
					<div id="msform" class="steps-content">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   <div class="section-heading inner-section-heading text-center mt-10">
							<h3>Send to a single reciepient right now</h3>
						</div>
						
					   <fieldset class="field-active step-2-options">
					   <div class="step-2-form">
						<form action="{{ route('frontend.cards.step2aUpdate')}}" method="POST">
							{{ csrf_field() }}
							<div class="row-field">
								<div class="form-group field-half">
									<label>First Name</label>
									<input type="text" name="first_name" value="{{isset($final_array['first_name'])?$final_array['first_name']:auth()->user()->first_name}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your first name">
								</div>
								<div class="form-group field-half">
									<label>Last Name</label>
									<input type="text" name="last_name" value="{{isset($final_array['last_name'])?$final_array['last_name']:auth()->user()->last_name}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your last name">
								</div>
							</div>
							<div class="row-field">
								<div class="form-group field-full">
									<label>Street Address</label>
									<input type="text" name="address" value="{{isset($final_array['address'])?$final_array['address']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your street address">
								</div>
							</div>
							<div class="row-field">
								<div class="form-group field-third">
									<label>City</label>
									<input type="text" name="city" value="{{isset($final_array['city'])?$final_array['city']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your town / city name">
								</div>
								<div class="form-group field-third">
									<label>State</label>
									<input type="text" name="state" value="{{isset($final_array['state'])?$final_array['state']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your state name">
								</div>
								<div class="form-group field-third">
									<label>Zip Code</label>
									<input type="text" name="pincode" value="{{isset($final_array['pincode'])?$final_array['pincode']:''}}" required class="form-control" id="exampleFormControlInput1" placeholder="Enter your address pin Code">
								</div>
							
							</div>
							<div class="row-field mt-50">
							<a href="{{ route('frontend.cards.step1')}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
							<input type="submit" name="next" class="next action-button upload_file_next action-button2 ApplyLineBreaks" value="GO TO STEP 3">
						  </div>
						</form>
						</div>
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
<script>
	if({{@$final_array['step_0_action']=='old'?"1":'0'}}=='1'){
		$(".existing_campaign_id").show();
		$("#step_0_action_2").show();
	}else{
		$(".existing_campaign_id").hide();
		$("#step_0_action_2").hide();
	}

	$(".step_0_action").click(function(){
		if($(this).data('val')=='old'){
			$(".existing_campaign_id").show();
			$("#step_0_action_2").show();
			$("#listing_select").attr("required","required");
		}else{
			$(".existing_campaign_id").hide();
			$("#listing_select").val('');
			$("#step_0_action_2").hide();
			$("#listing_select").removeAttr("required");
		}
	})
</script>
@endsection