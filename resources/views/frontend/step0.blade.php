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
							<h3>Let's get started. What would you like to do?</h3>
						</div>
					   <fieldset class="field-active">
						<form action="{{ route("frontend.cards.step1Update")}}" method="POST">
							{{ csrf_field() }}
							<div class="step-1-options step-0">
								<div class="step-0-radios">
									<input type="radio" name="campaign_type" {{!isset($final_array['campaign_type'])?'checked':'';}} {{@$final_array['campaign_type']=='pending'?"checked":''}} value="pending" class="input_radio" id="campaign_type1" autocomplete="off"  visibility="hidden">
									<div class="step-1-option selected" style="cursor: pointer;" for="campaign_type1" href="javascript:void(0)"><div><img src="img/campaign-1.png"><h4>One-time Campaign</h4></div>
									</div>
								</div>
								<div class="step-0-radios">
									<input type="radio" name="campaign_type" {{@$final_array['campaign_type']=='on-going'?"checked":''}} value="on-going" class="input_radio" id="campaign_type2" autocomplete="off" visibility="hidden">
									<div class="step-1-option" style="cursor: pointer;" for="campaign_type2" href="javascript:void(0)"><div><img src="img/campaign-on.png"><h4>Ongoing Campaign</h4></div></div>
								</div>
								<div class="step-0-radios">
									<input type="radio" name="campaign_type" {{@$final_array['campaign_type']=='single'?"checked":''}} value="single" class="input_radio" id="campaign_type3" autocomplete="off" visibility="hidden">
									<div class="step-1-option" style="cursor: pointer;" for="campaign_type3" href="javascript:void(0)"><div><img src="img/campaign-letter.png"><h4>Send One Letter</h4></div></div>
								</div>
							</div>
						  
						  <input type="submit" name="next" class="next action-button save_message action-button2" value="GO TO STEP 2">
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
	$(".step-1-option").click(function(){
		$('.input_radio').prop('checked', false);
		$(this).find('.input_radio').prop('checked', true);
	})
</script>
@endsection