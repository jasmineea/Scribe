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
					<div id="msform">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   <fieldset class="field-active">
						<form action="{{ route("frontend.cards.step1Update")}}" method="POST">
							{{ csrf_field() }}
						  <div class="written_letter_form">
							 <div class="Repeater_container">
								<div class="main">
								<div class="row">
								<div class="col-1">
								<ul class="btn btn-outline-primary theme_button" style="position: absolute;padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_1_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_1_tooltip" aria-hidden="true"></i></li></ul>
								</div>
								<div class="col-11">
									<div class="single_row2 max-width-650 custom_box"  id="step_1_tooltip" data-value="{{setting('step_1_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_1_tooltip_title')}}" data-element="step_1_tooltip" data-video_link="{{setting('step_1_video_link')}}">
										<input type="radio" name="step_0_action" {{!isset($final_array['step_0_action'])?'checked':'';}} {{@$final_array['step_0_action']=='new'?"checked":''}} value="new" class="btn-check" id="btn-check-outlined" autocomplete="off">
										<label class="btn btn-outline-primary theme_button step_0_action"  data-val="new" style="width:50%" for="btn-check-outlined">Create New Campaign</label>
										<input type="radio" name="step_0_action" {{@$final_array['step_0_action']=='old'?"checked":''}} value="old" class="btn-check" id="btn-check-outlined1" autocomplete="off">
										<label class="btn btn-outline-primary theme_button step_0_action"  data-val="old" style="width:49%" for="btn-check-outlined1">Use Existing Campaign</label>
									</div>

									<div class="single_row2 max-width-650 existing_campaign_id">
										<select name="existing_campaign_id" id="listing_select" style="width:100%;">
											<option value="">Select Campaign</option>
											@foreach ($campaigns as $item)
											<option value="{{$item->id}}" {{@$final_array['existing_campaign_id']==$item->id?"selected":""}}>{{$item->campaign_name}}</option>
											@endforeach
										</select>
									</div>
									<div class="single_row2 max-width-650 custom_box" id="step_0_action_2">
										<input type="radio" name="step_0_action_2" {{!isset($final_array['step_0_action_2'])?'checked':'';}} {{@$final_array['step_0_action_2']=='edit_existing'?"checked":''}} value="edit_existing" class="btn-check" id="btn-check-outlined3" autocomplete="off">
										<label class="btn btn-outline-primary theme_button step_0_action_2"  data-val="edit_existing" style="width:50%" for="btn-check-outlined3">Edit Existing Campaign</label>
										<input type="radio" name="step_0_action_2" {{@$final_array['step_0_action_2']=='duplicate_existing'?"checked":''}} value="duplicate_existing" class="btn-check" id="btn-check-outlined4" autocomplete="off">
										<label class="btn btn-outline-primary theme_button step_0_action_2"  data-val="duplicate_existing" style="width:49%" for="btn-check-outlined4">Duplicate This Campaign</label>
									</div>
									</div>
									</div>
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
</script>
@endsection