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
						<form action="{{ route('frontend.cards.step2Update')}}" method="POST" enctype="multipart/form-data" id="xsl_upload" >
							{{ csrf_field() }}
							<div class="step-2-options">
							<div class="step-2-option">
							@if($final_array['campaign_type']=='on-going')
									<div class="">
										<a href="javascript:void(0)" class="add_campaign_list theme-btn">Create New Live List</a>
									</div>
									@else
									<div class="upload-files-container">
										<div class="drag-file-area">
										<label class="label">
											<span class="material-icons-outlined upload-icon"></span>
											<h3 class="dynamic-message"> Browse file from device</h3>
										<input type="file" style="display:none;" onchange="sub(this)" name="upload_recipients" id="upload_recipients" class="default-file-input"/><span>supported files xls,xlsx or csv</span>
										</label>
										</div>
										<span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> Please select a file first <span class="material-icons-outlined cancel-alert-button">cancel</span> </span>
										<div class="file-block">
											<div class="file-info"><span class="file-name"> </span> | <span class="file-size">  </span> </div>
											<span class="material-icons remove-file-icon">delete</span>
											<div class="progress-bar"> </div>
										</div>
										<!-- <input type="submit" class="upload-button theme-btn" value="Upload"> -->
										@if (isset($final_array['upload_recipients'])&&(empty($final_array['listing_id'])&&empty($final_array['list_id'])))
										<p><a target="_blank" class="action_btn" href="files/{{@$final_array['upload_recipients']}}">Download uploaded Recipient File <i class="fa fa-file-download" aria-hidden="true"></i></a></p>
										@else
										<p><a target="_blank" class="action_btn"  href="javascript:void(0);">Download the Bulk Recipients Data Template <i class="fa fa-file-download" aria-hidden="true"></i></a></p>
										
										@endif
									</div>
									@endif
									
								
								
							</div>
							<div style="    margin-top: {{$final_array['campaign_type']=='on-going'?'7%':'14%'}};    color: #8c8686;    z-index: 9;">OR</div>
							<div class="step-2-option">
								   <div class="cstm-dropdown" style="text-align:center">
										<select name="listing_id" id="listing_select" class="custom-select sources" placeholder="Source Type"  style="background: #E7934C;border-radius: 22px;color: white;font-weight: bold;">
											<option value="0">Select Campaign List</option>
											@foreach ($listings as $item)
											<option value="{{$item->id}}" {{@$final_array['listing_id']==$item->id||@$final_array['list_id']==$item->id?"selected":""}}>{{$item->name}}</option>
											@endforeach
										</select>
									</div>
							</div>
						</div>
						<input type="hidden" name="threshold" value="0">
						<input type="hidden" name="repeat_number" value="0">
						<input type="hidden" name="file_rows" class="file_rows" value="">
						<input type="hidden" name="repeat_number" value="1000">
										
						  
						  <input type="submit" name="next" class="next action-button save_message action-button2" value="GO TO STEP 3">
						  <a href="{{ route('frontend.cards.step1')}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
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
//   var file = obj.value;
//   var fileName = file.split("\\");
//   document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
  $('#listing_select').val(0);
}
</script>
@endsection