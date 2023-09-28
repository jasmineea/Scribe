@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
					<div id="msform">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')
					   <fieldset class="field-active">
						<form action="{{ route("frontend.cards.step2Update")}}" method="POST" id="xsl_upload" enctype="multipart/form-data">
							{{ csrf_field() }}
<<<<<<< Updated upstream
						  <div class="written_letter_form">
							 <div class="Repeater_container">
								<div class="main">
								<div class="row">
								<div class="col-1">
								<ul class="btn btn-outline-primary theme_button" style="position: absolute;padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_2_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_2_tooltip" aria-hidden="true"></i></li></ul>
								</div>
								<div class="col-11">

									<div class="single_row2 max-width-650 custom_box">
										<div class="mb-3">
											<label for="exampleInputEmail1" class="form-label">Campaign Name</label>
											<input name="campaign_name" required value="{{@$final_array['campaign_name']}}" class="form-control" id="exampleInputEmail1" placeholder="Enter campaign name">
										  </div>
									</div>
									<div class="single_row2 max-width-650 custom_box">
										<input type="radio" name="campaign_type" {{!isset($final_array['campaign_type'])?'checked':'';}} {{@$final_array['campaign_type']=='pending'?"checked":''}} value="pending" class="btn-check" id="btn-check-outlined" autocomplete="off">
										<label class="btn btn-outline-primary theme_button" style="width:50%" for="btn-check-outlined">One Time Campaign</label>
										<input type="radio" name="campaign_type" {{@$final_array['campaign_type']=='on-going'?"checked":''}} value="on-going" class="btn-check" id="btn-check-outlined1" autocomplete="off">
										<label class="btn btn-outline-primary theme_button" style="width:49%" for="btn-check-outlined1">On Going Campaign</label>
									</div>
									<div class="single_row2 max-width-650 custom_box" id="step_2_tooltip"  data-value="{{setting('step_2_tooltip_message')}}"  data-pos="right"    data-title="{{setting('step_2_tooltip_title')}}"  data-video_link="{{setting('step_2_video_link')}}">
									  	<select name="listing_id" id="listing_select">
=======
							<div class="step-2-options">
							<div class="step-2-option">
								
									<div class="upload-files-container">
										<div class="drag-file-area">
											<span class="material-icons-outlined upload-icon"></span>
											<h3 class="dynamic-message"> Drag & drop any file here </h3>
											<label class="label"> or <span class="browse-files"> <input type="file" onchange="sub(this)" name="upload_recipients" id="upload_recipients" class="default-file-input"/> <span class="browse-files-text">browse file</span> <span>from device</span> </span> </label>
										</div>
										<span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> Please select a file first <span class="material-icons-outlined cancel-alert-button">cancel</span> </span>
										<div class="file-block">
											<div class="file-info"> <span class="material-icons-outlined file-icon">description</span> <span class="file-name"> </span> | <span class="file-size">  </span> </div>
											<span class="material-icons remove-file-icon">delete</span>
											<div class="progress-bar"> </div>
										</div>
										<button type="button" class="upload-button theme-btn"> Upload </button>
									</div>
								
								@if (isset($final_array['upload_recipients'])&&(empty($final_array['listing_id'])&&empty($final_array['list_id'])))
										<p><a target="_blank" class="action_btn" href="files/{{@$final_array['upload_recipients']}}">Download uploaded Recipient File <i class="fa fa-file-download" aria-hidden="true"></i></a></p>
										@endif
							</div>
							<div class="step-2-option">
								<div class="cstm-dropdown">
								<select name="listing_id" id="listing_select" class="custom-select sources" placeholder="Source Type">
>>>>>>> Stashed changes
											<option value="0">Select Campaign List</option>
											@foreach ($listings as $item)
											<option value="{{$item->id}}" {{@$final_array['listing_id']==$item->id||@$final_array['list_id']==$item->id?"selected":""}}>{{$item->name}}</option>
											@endforeach
										</select>
<<<<<<< Updated upstream

										<input type="hidden" name="threshold" value="0">
										<input type="hidden" name="repeat_number" value="0">
										<i class="fa fa-plus add_campaign_list"></i>
										<input type="hidden" name="repeat_number" value="1000">
										<p>To choose a preexisting list, use the drop down menu above. To make a new list, simply click on the Plus icon.</p>
										 OR
										 <br>
										 <div id="yourBtn" class="select_design" onclick="getFile()">click to upload a Recipient file</div>
										 <div style='height: 0px;width: 0px; overflow:hidden;'><input type="file" onchange="sub(this)" name="upload_recipients" id="upload_recipients"></div>


										 <input type="hidden" name="file_rows" class="file_rows" value="">

										@if (isset($final_array['upload_recipients'])&&(empty($final_array['listing_id'])&&empty($final_array['list_id'])))
										<p><a target="_blank" class="action_btn" href="files/{{@$final_array['upload_recipients']}}">Download uploaded Recipient File <i class="fa fa-file-download" aria-hidden="true"></i></a></p>
										@endif

									  <p>The Scribe Handwritten bulk mailing system uses a formatted spreadsheet to feed recipients' names and addresses. You can download the bulk upload template from below, fill in the data and upload it again.</p>
								   </div>
								   <div class="single_row2 max-width-650" id="single_row2">
									  <div class="custom_message_upload_list">
										 <div class="buttons">
											<div class="">
											   <a class="action_btn" href="javascript:void(0);">Download the Bulk Recipients Data Template <i class="fa fa-file-download" aria-hidden="true"></i></a>
											</div>
										 </div>
									  </div>
								   </div>
								   </div>
								</div>

								</div>
							 </div>
						  </div>
=======
									</div>
									<div class="cstm-add-btn">
										<a href="javascript:void(0)" class="add_campaign_list">+</a>
									</div>
							</div>
						</div>
						<input type="hidden" name="threshold" value="0">
						<input type="hidden" name="repeat_number" value="0">
						<input type="hidden" name="file_rows" class="file_rows" value="">
						<input type="hidden" name="repeat_number" value="1000">
										
						  
>>>>>>> Stashed changes
						  <input type="submit" name="next" class="next action-button save_message action-button2" value="GO TO STEP 3">
						  <a href="{{ route("frontend.cards.step1")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
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
<input type='hidden' id='list_create_url' name="list_create_url" value='{{ route("frontend.cards.step2ListCreate")}}'>
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
  $('#listing_select').val(0);
}
</script>
@endsection