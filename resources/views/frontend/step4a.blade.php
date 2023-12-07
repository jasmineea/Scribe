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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
<!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.helper.ie8.js"></script><![endif]-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
<!-- NOTE: prior to v2.2.1 tiny-slider.js need to be in <body> -->
<style>
   /* Absolute Center Spinner */
   .design-cont-wrapper label {
    margin-bottom: 10px;
}
	.tns-outer [aria-controls], .tns-outer [data-action] {
		cursor: pointer;
		color: white;
		background-color: #EC8234;
		border: 1px solid;
	}
   #tns1-ow{
      width: 261px;
   }
   .tns-nav{
	display:none;
   }
   #tns1 > .tns-item{
	width: initial;
   }
   .loading {
   position: fixed;
   z-index: 999;
   height: 2em;
   width: 2em;
   overflow: show;
   margin: auto;
   top: 0;
   left: 0;
   bottom: 0;
   right: 0;
   }
   .form-group.field-full.checkbox {
   display: flex;
   justify-content: left;
   flex-direction: revert;
   align-items: center;
   }
   /* Transparent Overlay */
   .loading:before {
   content: '';
   display: block;
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: radial-gradient(rgba(20, 20, 20,.9), rgba(0, 0, 0, .9));
   background: -webkit-radial-gradient(rgba(20, 20, 20,.9), rgba(0, 0, 0,.9));
   }
   /* :not(:required) hides these rules from IE9 and below */
   .loading:not(:required) {
   /* hide "loading..." text */
   font: 0/0 a;
   color: transparent;
   text-shadow: none;
   background-color: transparent;
   border: 0;
   }
   .loading:not(:required):after {
   content: '';
   display: block;
   font-size: 10px;
   width: 1em;
   height: 1em;
   margin-top: -0.5em;
   -webkit-animation: spinner 150ms infinite linear;
   -moz-animation: spinner 150ms infinite linear;
   -ms-animation: spinner 150ms infinite linear;
   -o-animation: spinner 150ms infinite linear;
   animation: spinner 150ms infinite linear;
   border-radius: 0.5em;
   -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
   box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
   }
   /* Animation */
   @-webkit-keyframes spinner {
   0% {
   -webkit-transform: rotate(0deg);
   -moz-transform: rotate(0deg);
   -ms-transform: rotate(0deg);
   -o-transform: rotate(0deg);
   transform: rotate(0deg);
   }
   100% {
   -webkit-transform: rotate(360deg);
   -moz-transform: rotate(360deg);
   -ms-transform: rotate(360deg);
   -o-transform: rotate(360deg);
   transform: rotate(360deg);
   }
   }
   @-moz-keyframes spinner {
   0% {
   -webkit-transform: rotate(0deg);
   -moz-transform: rotate(0deg);
   -ms-transform: rotate(0deg);
   -o-transform: rotate(0deg);
   transform: rotate(0deg);
   }
   100% {
   -webkit-transform: rotate(360deg);
   -moz-transform: rotate(360deg);
   -ms-transform: rotate(360deg);
   -o-transform: rotate(360deg);
   transform: rotate(360deg);
   }
   }
   @-o-keyframes spinner {
   0% {
   -webkit-transform: rotate(0deg);
   -moz-transform: rotate(0deg);
   -ms-transform: rotate(0deg);
   -o-transform: rotate(0deg);
   transform: rotate(0deg);
   }
   100% {
   -webkit-transform: rotate(360deg);
   -moz-transform: rotate(360deg);
   -ms-transform: rotate(360deg);
   -o-transform: rotate(360deg);
   transform: rotate(360deg);
   }
   }
   @keyframes spinner {
   0% {
   -webkit-transform: rotate(0deg);
   -moz-transform: rotate(0deg);
   -ms-transform: rotate(0deg);
   -o-transform: rotate(0deg);
   transform: rotate(0deg);
   }
   100% {
   -webkit-transform: rotate(360deg);
   -moz-transform: rotate(360deg);
   -ms-transform: rotate(360deg);
   -o-transform: rotate(360deg);
   transform: rotate(360deg);
   }
   }
</style>
<div class="loading">Loading&#8230;</div>
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
                    
                        <input name="card_font" type="hidden" value="Lexi-Regular">
                        <div class="row-field row">
                           <div class="col-12 design-cont-wrapper">
						   		<div class="design-container">
                                 <span><b>Inside View</b></span>
                                 <div class="design-view-section">
                                    <!-- Design View Section -->
                                    <div class="design-area design-area-double">
                                       <img style="height: -webkit-fill-available;" class="final_preview font_change" data-url="{{asset('img/preview/')}}/{{$final_array['preview_image']}}" src="{{asset('img/preview/')}}/{{$final_array['preview_image']}}"/>
                                    </div>
                                 </div>
                                 <!-- Design View Section Ends -->
                              </div>
                              <div class="design-container">
                                 <span><b>Outside View</b></span>
                                 <div class="design-view-section">
                                    <!-- Design View Section -->
                                    <div class="tab-content" id="myTabContent">
                                       <div class="tab-pane fade {{empty($type_select)?'show active':''}}" id="envelope" role="tabpanel" aria-labelledby="envelope-tab">
                                          <div class="design-area design-area__envelope">
                                             <img src="{{asset('img/preview/')}}/{{$final_array['enevolope_preview_image']}}"  style="width: 100%;height: inherit;">
                                          </div>
                                       </div>
                                       <div class="tab-pane fade {{!empty($type_select)?'show active':''}}"  id="home" role="tabpanel" aria-labelledby="home-tab">
                                          <div class="design-area design-area__front">
                                             <img src="{{asset('img/1500-with-shadow.png')}}" style="width: 100%;height: inherit;">
                                          </div>
                                       </div>
                                       <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                          <div class="design-area design-area__back">
                                             <img src="{{asset('img/1500-with-shadow.png')}}"  style="width: 100%;height: inherit;">
                                          </div>
                                       </div>
                                      
                                    </div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                       <li class="nav-item" role="presentation">
                                          <button class="nav-link1 theme-btn  {{empty($type_select)?'active':''}}" id="envelope-tab" data-bs-toggle="tab" data-bs-target="#envelope" type="button" role="tab" aria-controls="envelope" aria-selected="false">Envelope View</button>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <button class="nav-link1 theme-btn  {{!empty($type_select)?'active':''}}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Front View</button>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <button class="nav-link1 theme-btn" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Back View</button>
                                       </li>
                                      
                                    </ul>
                                 </div>
                                 <!-- Design View Section Ends -->
								 <div class="row">
									<div class="col-7">
										<br>
											<div class="col-12">
											<label><b>Upload Your Card Design</b></label><br>
												<div class="upd-btn-wrap">
												<div class="design-upload-btn dub1" style="cursor: pointer;">
													<span class="upload-icon upload-icon-white"></span>
													<span>Upload</span>
												</div>
												<p>Supported format: png, jpg or zip file (containing png.jpg files).</p>
											</div>
											</div>
										<br>
										<div class="col-12">
											<label><b>Design your card using below template</b></label><br>
											<a href="https://www.canva.com/design/DAFxz_x-wrM/OFzQr-3l_qZimrt7SL5eWA/view?utm_content=DAFxz_x-wrM&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink&mode=preview" style="color:#ef7600;" target="_blank">Click to design card template</a>
										</div>
			
									
									</div>
									<div class="col-5">
										<div class="row">
										<div class="col-12" style=""><br>
											<label><b>Scribe Templates</b></label>
											<div class="template-word-section step-4-right-buttons my-slider0" style="max-height: 168px;width: max-content;">
											
											@foreach($default_card_design as $k=>$v)
											<div class="design-template-thumb"  style="cursor: pointer;">
                                 <!-- <i class="fa fa-trash delete_image" data-id="{{$v['id']}}" style="position: absolute;right: 4px;top: 4px;"></i> -->
												<img class="image_t" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}">
                                    
											</div>
											@endforeach
											</div>
											
										</div>
										
									
										</div>

									</div>
                              	 </div>
                             
                              <div class="row">
                              		<div class="col-12 pad-0">
										<label><b>Uploaded Designs</b></label>
                              @if(count($carddesigns)<=8)
                              <div class="template-word-section-wrapper"> 
                              <div class="template-word-section step-4-right-buttons " style="max-height: 168px;width: max-content;">
											
											@foreach($carddesigns as $k=>$v)
                                 @php
                                    if($v['type']=='outer'){
                                       $class="image_t";
                                    }
                                    if($v['type']=='inner'){
                                       $class="image_t2";
                                    }
                                    if($v['type']=='both'){
                                       $class="image_t3";
                                    }
                                    @endphp
											<div class="design-template-thumb"  style="cursor: pointer;">
                                 <!-- <i class="fa fa-trash delete_image" data-id="{{$v['id']}}" style="position: absolute;right: 4px;top: 4px;"></i> -->
                                    <i class="fa fa-trash delete_image" data-id="{{$v['id']}}" style="position: absolute;margin-left:45px;z-index: 99;    background: white;    border: 1px solid;    padding: 2px 4px;    border-radius: 15px;color:red;"></i>
												@if($class=='image_t3')
                                       <img class="{{$class}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}">
                                       <img class="{{$class}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}" style="opacity: 1;    top: 0px;    width: 93%;    height: 100%;    border: 1px solid;    border-radius: 11%;    margin-left: -67px;">
                                    @else
                                       <img class="{{$class}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}">
                                    @endif
                                    
											</div>
											@endforeach
                              </div>
											</div>
                              @else
                              <div class="owl-carousel" id="uploadDesignsSlider" style="max-width:100%;">
											<div class="owl-nav"></div> 
												@foreach($carddesigns as $k=>$v)
											<div class="item design-template-thumb" style="cursor: pointer;">
                                    <i class="fa fa-trash delete_image" data-id="{{$v['id']}}" style="position: absolute;right: 4px;top: 4px;z-index: 99;    background: white;    border: 1px solid;    padding: 2px 4px;    border-radius: 15px;color:red;"></i>
                                    @php
                                    if($v['type']=='outer'){
                                       $class="image_t";
                                    }
                                    if($v['type']=='inner'){
                                       $class="image_t2";
                                    }
                                    if($v['type']=='both'){
                                       $class="image_t3";
                                    }
                                    @endphp
                                    @if($class=='image_t3')
                                       <img class="{{$class}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}">
                                       <img class="{{$class}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}" style="opacity: 1;    position: absolute;    top: 0px;    width: 80%;    height: 90%;    border: 1px solid;    border-radius: 11%;">
                                    @else
                                       <img class="{{$class}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}">
                                    @endif
												
                                    
											</div>
											@endforeach

										</div>
                              @endif
											



										<!-- <div class="template-word-section step-4-right-buttons my-slider1" style="max-width:80%;">
											@foreach($carddesigns as $k=>$v)
											<div class="design-template-thumb"  style="cursor: pointer;">
												<img class="{{$v['type']=='outer'?'image_t':'image_t2'}}" src="{{asset('storage/'.$v['image_path'])}}" data-path="{{$v['image_path']}}" data-front-src="{{asset('storage/'.$v['front_image_path'])}}" data-back-src="{{asset('storage/'.$v['back_image_path'])}}" data-front="{{$v['front_image_path']}}" data-back="{{$v['back_image_path']}}">
										     </div>
											@endforeach
										</div> -->
									</div>
                              	</div>
                              <div class="row">
                              	<div class="col-12">
                              			<div class="col-12">
											<div class="form-group field-full checkbox">
											<input type="checkbox" checked id="remember" name="remember" value="1" required>
											<label for="remember">Accept <a href="" target="_blank">Terms and Conditions</a></label>
											</div>
										</div>
                              	</div>
                              </div> </div>
                              
                              <!-- <div class="approve-design-btn">
                                 <a href="#" class="theme-btn">Approve this Design</a>
                                 </div> -->
                              <div class="row-field">
                              </div>
                           </div>
                        </div>
						<form action='{{ route("frontend.cards.step4aUpdate")}}' method="POST" id="msform">
                        {{ csrf_field() }}
                        <input type="hidden" name="front_design" value="{{@$final_array['front_design']}}">
                        <input type="hidden" name="back_design" value="{{@$final_array['back_design']}}">
                        <input type="hidden" name="main_design" value="{{@$final_array['main_design']}}">
                        <input type="hidden" name="inner_design" value="{{@$final_array['inner_design']}}">
                        <input type="submit" name="next" class="next action-button upload_last_file_and_message action-button2" value="Review Campaign">
                        <a href="{{ route("frontend.cards.step3a")}}" class="previous action-button action-button-previous" value="PREVIOUS STEP">PREVIOUS</a>
                     </form>
                     <form class="design_form1" action="{{ route("frontend.cards.cardDesignUpload")}}" method="POST" id="xsl_upload" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="file"  accept=".png,.zip" style="opacity:0;" name="design_file" class="uploadDesign1">
                     </form>
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="design_form3_div" style="display:none;">
   <form class="design_form3" action="{{ route("frontend.cards.saveDesignType")}}" method="POST">
   {{ csrf_field() }}
   <table class="table">
      <thead>
         <tr>
            <th>Design</th>
            <th>Select Type</th>
         </tr>
      </thead>
      <tbody>
         @foreach($carddesignswithouttype as $key=>$value)
         <tr>
            <td><img src="{{asset('storage/'.$value['image_path'])}}" style="max-width: 80px;"></td>
            <td>
               <select required name="save_type[{{$value['id']}}]">
                  <option value="">select type</option>
                  <option value="inner">Inner Design</option>
                  <option value="outer" selected>Outer Design</option>
                  <option value="both">Both Inner and Outer Design</option>
               </select>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   </form>
</div>
<form class="delete_image_form" action='{{ route("frontend.cards.DeleteDesignFile")}}' method="POST">
   {{ csrf_field() }}
   <input type="hidden" name="image_id" id="image_id">
</form>
@if(@$final_array['front_design'])
<input id="front_design" type="hidden" value="{{asset('storage/'.$final_array['front_design'])}}">
<input id="back_design" type="hidden" value="{{asset('storage/'.$final_array['back_design'])}}">
@endif
@if(@$final_array['inner_design'])
<input id="inner_design" type="hidden" value="{{asset('storage/'.$final_array['inner_design'])}}">
@endif
<script>
   $(document).ready(function(){
   	if({{count($carddesignswithouttype)}}!='0'){
   			var d = bootbox.confirm($(".design_form3_div").html(), function(result) {
   				if(result){
   					$('.design_form3').submit();
   				}
   		});
   			d.find('.modal-dialog').addClass('modal-dialog-centered');
   	}
   });
   $(".loading").hide();
   var front_design=$("#front_design").val();
   var back_design=$("#back_design").val();
   var inner_design=$("#inner_design").val();
   if(front_design){
   	$(".design-area__front img").css('background','url('+front_design+') #f8f8f8');
   	$(".design-area__front img").css('background-position','center');
   	$(".design-area__front img").css('background-size','92%');
   	$(".design-area__front img").css('background-repeat','no-repeat');
   }
   if(back_design){
   	$(".design-area__back img").css('background','url('+back_design+') #f8f8f8');
   	$(".design-area__back img").css('background-position','center');
   	$(".design-area__back img").css('background-size','92%');
   	$(".design-area__back img").css('background-repeat','no-repeat');
   	$(".design-area__back img").css('transform','rotate(180deg)');
   }
   
   if(inner_design){
   	$(".design-area-double img").css('background','url('+inner_design+') #f8f8f8');
   	$(".design-area-double img").css('background-position','center');
   	$(".design-area-double img").css('background-size','92%');
   	$(".design-area-double img").css('background-repeat','no-repeat');
   }
   
   $(".dub1").click(function(){
   	$(".uploadDesign1").trigger('click');
   })
   
  
   
   $(".uploadDesign1").on( 'change', function () {
       $(".loading").show();
          $('.design_form1').submit();
      });

   $(".delete_image").on( 'click', function () {
      var id = $(this).data('id');
      var d = bootbox.confirm({
                                message: 'Are you sure?',
                                buttons: {
                                confirm: {
                                label: 'Yes',
                              //   className: 'btn-success'
                                },
                                cancel: {
                                label: 'No',
                              //   className: 'btn-danger'
                                }
                                },
                                callback: function (result) {
                                 if(result){
                                       $(".loading").show();
                                       $("#image_id").val(id);
                                       $('.delete_image_form').submit();
                                    }
                                }});
      });
   
   
   
   $(".design-template-thumb .image_t").click(function(){
      $('.image_t').removeClass('active_thumb');
      $(this).addClass('active_thumb');

   	var src=$(this).attr('src');
   	var src_f=$(this).data('front-src');
   	var src_b=$(this).data('back-src');
   	var path=$(this).data('path');
   	var path_f=$(this).data('front');
   	var path_b=$(this).data('back');
   	//$(".design-area__front img").attr('src',src_b);
   	$(".design-area__front img").css('background','url('+src_b+') #f8f8f8');
   	$(".design-area__front img").css('background-position','center');
   	$(".design-area__front img").css('background-size','92%');
   	$(".design-area__front img").css('background-repeat','no-repeat');
   	$(".design-area__back img").css('background','url('+src_f+') #f8f8f8');
   	$(".design-area__back img").css('background-position','center');
   	$(".design-area__back img").css('background-size','92%');
   	$(".design-area__back img").css('background-repeat','no-repeat');
   	$(".design-area__back img").css('transform','rotate(180deg)');
   
   	//$(".design-area__back img").attr('src',src_f);
   	$("input[name='front_design']").val(path_b);
   	$("input[name='back_design']").val(path_f);
   	$("input[name='main_design']").val(path);
   })
   $(".design-template-thumb .image_t2").click(function(){
      
      $('.image_t2').removeClass('active_thumb');
      $(this).addClass('active_thumb');

   	var src=$(this).attr('src');
   	var path=$(this).data('path');
   	
   	$(".design-area-double img").css('background','url('+src+') #f8f8f8');
   	$(".design-area-double img").css('background-position','center');
   	$(".design-area-double img").css('background-size','92%');
   	$(".design-area-double img").css('background-repeat','no-repeat');
   	 $("input[name='inner_design']").val(path);
   })
   $(".design-template-thumb .image_t3").click(function(){
      $('.image_t').removeClass('active_thumb');
      $('.image_t2').removeClass('active_thumb');
      $('.image_t3').removeClass('active_thumb');
      $(this).addClass('active_thumb');

   	var src=$(this).attr('src');
   	var src_f=$(this).data('front-src');
   	var src_b=$(this).data('back-src');
   	var path=$(this).data('path');
   	var path_f=$(this).data('front');
   	var path_b=$(this).data('back');
   	
   	$(".design-area-double img").css('background','url('+src+') #f8f8f8');
   	$(".design-area-double img").css('background-position','center');
   	$(".design-area-double img").css('background-size','92%');
   	$(".design-area-double img").css('background-repeat','no-repeat');
   	$("input[name='inner_design']").val(path);


    	//$(".design-area__front img").attr('src',src_b);
   	$(".design-area__front img").css('background','url('+src_b+') #f8f8f8');
   	$(".design-area__front img").css('background-position','center');
   	$(".design-area__front img").css('background-size','92%');
   	$(".design-area__front img").css('background-repeat','no-repeat');
   	$(".design-area__back img").css('background','url('+src_f+') #f8f8f8');
   	$(".design-area__back img").css('background-position','center');
   	$(".design-area__back img").css('background-size','92%');
   	$(".design-area__back img").css('background-repeat','no-repeat');
   	$(".design-area__back img").css('transform','rotate(180deg)');
   
   	//$(".design-area__back img").attr('src',src_f);
   	$("input[name='front_design']").val(path_b);
   	$("input[name='back_design']").val(path_f);
   	$("input[name='main_design']").val(path);


   })

   var slider = tns({
		container: '.my-slider0',
		items: 4,
		slideBy: 'page',
		controlsText:['<','>']
		
	});
	var slider = tns({
		container: '.my-slider1',
		items: 3,
		slideBy: 'page',
		axis:'vertical',
		controlsText:['<','>']
		
	});
	var slider = tns({
		container: '.my-slider2',
		items: 3,
		slideBy: 'page',
		axis:'vertical',
		controlsText:['<','>']
		
	});
</script>
@endsection