@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section" style="display:none;">
	<div class="container-fluid" style="padding-left: 368px;">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
					<div id="msform">
					   <!-- progressbar -->
					   @include('frontend.includes.progressbar')

					   <fieldset>
						<form action="{{ route("frontend.cards.step3aUpdate")}}" method="POST" id="mapping_form" >
							{{ csrf_field() }}
						  <div class="written_letter_form">
							 <div class="Repeater_container">
								<div class="main-upload-list">
								   <div class="single_row2 max-width-650" style="max-width: 1000px;" id="step_4_tooltip"  data-value="{{setting('step_4_tooltip_message')}}"  data-pos="right"    data-title="{{setting('step_4_tooltip_title')}}"  data-video_link="{{setting('step_4_video_link')}}">
									  <div class="custom_message_upload_list">
										 <h4 style="margin-right:8%;"><b>Map columns in your file to Scribe properties</b><div class="pull-right"><ul class="btn btn-outline-primary theme_button" style="position: absolute;padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_4_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_4_tooltip" aria-hidden="true"></i></li></ul></div></h4>
										 <p>Map columns in your file to Custom message and envelope address properties. Each column header below should be mapped to a property. Some of these have already been mapped based on their names. Anything that hasn't been mapped yet can be manually mapped with the dropdown menu.</p>
										 <div class="accordion" id="accordionExample">
											<div class="accordion-item">
											   <h2 class="accordion-header" id="headingOne">
												  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												  1. Map Spreadsheet To Custom Message
												  </button>
											   </h2>
											   <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
												  <div class="accordion-body">
													 <span class="append_rows_columns">

														<table border="1" style="width: 100%;">
															<tbody>
															   <tr>
																  <th>MATCHED</th>
																  <th>COLUMN HEADER</th>
																  <th>PREVIEW INFORMATION</th>
																  <th>SCRIBE PROPERTY</th>
															   </tr>
															   <input type="hidden" name="system_property_1[0]" value="">
															   @if (isset($final_array['excel_data']))
															   @foreach ($final_array['excel_data']['header'] as $key=>$item)
																@if(str_contains($final_array['hwl_custom_msg'],"{".$item."}"))
																<tr>
																	<td><i class="fa fa-check-circle fa_color_green"></i></td>
																	<td>{{$item}}</td>
																	<td>

																		@foreach (array_slice($final_array['excel_data']['data'], 0, 1) as $key_1=>$item_1)
																		@if(!empty($item_1[$item]))
																			{{$item_1[$item]}}
																		@else
																		{!!isset($final_array['system_property_1'][$key])? @$item_1[$final_array['system_property_1'][$key]] :"" !!}
																		@endif
																		@endforeach

																	</td>
																	<td>
																	<select name="system_property_1[{{$item}}]" class="system_property">
																		<option value="">Select Property</option>
																		@foreach ($final_array['excel_data']['header'] as $key_2=>$item_2)
																		<option value="{{$item_2}}" {{$item === $item_2? "Selected" :"" }}>{{$item_2}}</option>
																		@endforeach
																	</select>
																	</td>
																</tr>
																@endif
																@endforeach
															   @endif

															   @if (isset($final_array['tags']))
															   @foreach ($final_array['tags'] as $key=>$item)
																@if(!in_array($item,array_values($final_array['excel_data']['header'])))
																<tr>
																	<td><i class='fa {{isset($final_array["system_property_1"][$key])? "fa-check-circle fa_color_green" :"fa-times-circle fa_color_red" }}'></i></td>
																	<td>{{$item}}</td>
																	<td>

																		@foreach (array_slice($final_array['excel_data']['data'], 0, 1) as $key_1=>$item_1)
																		@if(!empty($item_1[$item]))
																			{{$item_1[$item]}}
																		@else
																		{!!isset($final_array['system_property_1'][$key])? @$item_1[$final_array['system_property_1'][$key]] :"" !!}
																		@endif
																		@endforeach

																	</td>
																	<td>
																	<select name="system_property_1[{{$key}}]" class="system_property">
																		<option value="">Select Property</option>
																		@foreach ($final_array['excel_data']['header'] as $key_2=>$item_2)
																		<option value="{{$item_2}}" {{isset($final_array['system_property_1'][$key])&&@$final_array['system_property_1'][$key]==$item_2? "Selected" :"" }}>{{$item_2}}</option>
																		@endforeach
																		@foreach ($final_array['tags'] as $key_s=>$item_s)
																		@if(!in_array($item_s,array_values($final_array['excel_data']['header'])))
																			<option value="{{$key_s}}" {{(isset($final_array['system_property_1'][$key_s])&&@$final_array['system_property_1'][$key_s]==$key_s)? "Selected" :"" }}>{{$key_s}}</option>
																		@endif
																		@endforeach

																	</select>
																	</td>
																</tr>
																@endif
																@endforeach
															   @endif
															</tbody>
														 </table>
													 </span>
												  </div>
											   </div>
											</div>
											<div class="accordion-item">
											   <h2 class="accordion-header" id="headingTwo">
												  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
												  2. Map Spreadsheet To Envelope Address
												  </button>
											   </h2>
											   <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
												  <div class="accordion-body">
													 <span class="append_rows_columns">
														<table border="1"  style="width: 100%;">
															<tbody>
															   <tr>
																  <th>MATCHED</th>
																  <th>COLUMN HEADER</th>
																  <th>PREVIEW INFORMATION</th>
																  <th>SCRIBE PROPERTY</th>
															   </tr>
															   @if (isset($final_array['excel_data']))
															   @foreach (['FIRST_NAME','LAST_NAME','ADDRESS','CITY','STATE','ZIP'] as $key=>$item)

																<tr>
																	<td><i class="fa {{isset($final_array['system_property_2'][$item])||in_array($item,$final_array['excel_data']['header'])? "fa-check-circle fa_color_green" :"fa-times-circle fa_color_red" }}"></i></td>
																	<td>{{$item}}</td>
																	<td>

																		@foreach (array_slice($final_array['excel_data']['data'], 0, 1) as $key_1=>$item_1)
																		@if(!empty($item_1[$item]))
																		{{$item_1[$item]}}
																		@else
																		{!!isset($final_array['system_property_2'][$item])? @$item_1[$final_array['system_property_2'][$item]] :"" !!}
																		@endif
																		@endforeach

																	</td>
																	<td>
																	<select name="system_property_2[{{$item}}]" class="system_property">
																		<option value="">Select Property</option>
																		@foreach ($final_array['excel_data']['header'] as $key_2=>$item_2)
																		<option value="{{$item_2}}" {{(isset($final_array['system_property_2'][$item])&&@$final_array['system_property_2'][$item]==$item_2)||($item === $item_2)? "Selected" :"" }}>{{$item_2}}</option>
																		@endforeach
																	</select>
																	</td>
																</tr>

																@endforeach
															   @endif
															</tbody>
														 </table>

													 </span>
												  </div>
											   </div>
											</div>
										 </div>
									  </div>
								   </div>
								</div>
							 </div>
						  </div>
						  <input type="submit" name="next" class="next action-button action-button2" value="GO TO STEP 5">
						  <a href="{{ route("frontend.cards.step3")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
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
@php
$final_keys=@$final_array['excel_data']['data']?json_encode(array_slice(@$final_array['excel_data']['data'], 0, 1)[0]):'';
@endphp
<script>
	$(document).ready(function(){
		$(".action-button2").trigger('click');
		setTimeout(() => {
			$("#hero-section").show();
		}, "1500");
		var json_data=JSON.parse('<?=$final_keys?>');
		$(".system_property").on("change",function(){
			var key = $(this).val();
			$(this).closest('tr').find('.fa_color_red').addClass('fa-check-circle fa_color_green').removeClass('fa-times-circle fa_color_red');
			$(this).removeClass('border-red');
			if(json_data[key]!='null'&&typeof json_data[key] !== "undefined"){
				$(this).closest('tr').find('td:eq(2)').html(json_data[key]);
			}else{
				$(this).closest('tr').find('td:eq(2)').html('-');
			}

		})
		$('form#mapping_form').submit( function( event ) {
				event.preventDefault();
				var error=0;
				$('form#mapping_form').find('select').each(function(){
					var me=$(this);
					if(me.val()==''){
						me.addClass('border-red');
						Alert.error('please map all the scribe properties.','Error',{displayDuration: 5000, pos: 'top'})
						error=1;
						if(me.closest(".accordion-item").find('.accordion-button').hasClass('collapsed')){
							if(me.closest(".accordion-item").index()=='0'){
								$(".accordion-button:first").trigger('click');
							}else{
								$(".accordion-button:eq(1)").trigger('click');
							}
						}
						return false;
					}
				});
				if(error=='0'){
					$('form#mapping_form')[0].submit();
					return false;
				}
		});

	})
</script>

@endsection