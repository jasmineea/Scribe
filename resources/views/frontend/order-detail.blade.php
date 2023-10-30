@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section id="hero-section">
    <div class="container-fluid" style="padding-left: 368px;">
		<div class="row">
            <div class="col-12">
				<button class="btn btn-outline-primary theme_button" onclick="history.back()"><i class="fa fa-arrow-left"></i> Go Back</button>
                <ul class="btn btn-outline-primary theme_button" style="padding: var(--bs-btn-padding-y) 10px;"><li style="list-style: none;float: left;padding-right: 8px;"><i class="fa fa-info-circle step-info" data-element="step_8_tooltip"></i></li><li  style="list-style: none;
											float: left;"><i class="fa fa-video-camera show_video" data-element="step_8_tooltip" aria-hidden="true"></i></li></ul>
                @if($order_detail['campaign_type']=='on-going')
				<a class="btn btn-outline-primary theme_button pull-right mr-1" href="{{route('frontend.cards.orderEdit',$order_detail['id'])}}"><i class="fa fa-pencil"></i> Edit</a>
                    @if($order_detail['status']=='paused'||$order_detail['status']=='draft')
                        <a class="btn btn-outline-primary theme_button pull-right mr-1" href="{{route('frontend.cards.updateStatus',[$order_detail['id'],'pending'])}}" class="mr-1" title="start campaign"><i class="fa fa-play"></i> Play</a>
                    @endif
                    @if($order_detail['status']=='pending')
                        <a class="btn btn-outline-primary theme_button pull-right mr-1" href="{{route('frontend.cards.updateStatus',[$order_detail['id'],'paused'])}}" class="mr-1"  title="pause campaign"><i class="fa fa-pause"></i> Pause</a>
                    @endif
                @endif
				<a class="btn btn-outline-primary theme_button pull-right mr-1" href="{{route('frontend.cards.duplicateOrder',$order_detail['id'])}}"><i class="fa fa fa-clone"></i> Duplicate It</a>
				<a class="btn btn-outline-primary theme_button pull-right mr-1" href="{{route('frontend.cards.exportFile',$order_detail['listing_id'])}}"><i class="fa fa fa-download"></i> Export</a>
                <a class="btn btn-outline-primary theme_button pull-right mr-1" href="javascript:void(0);"  onclick="getFile()"><i class="fa fa fa-upload"></i> Upload</a>
                <form method="post" action={{route('frontend.cards.uploadFile')}} id="upload_file"  enctype="multipart/form-data">
				<input type="file" style="display:none;" onchange="sub(this)" name="upload_recipients" id="upload_recipients">
				<input type="hidden" name="list_id" value="{{$order_detail['listing_id']}}">
				{{ csrf_field() }}
				</form>
			</div></div>
			<br>
        <div class="row"  id="step_8_tooltip" data-value="{{setting('step_8_tooltip_message')}}"  data-pos="right"  data-title="{{setting('step_8_tooltip_title')}}" data-element="step_8_tooltip" data-video_link="{{setting('step_8_video_link')}}">
            <div class="col-12">

                <table class="table table-bordered mb-5">
                    <tbody>
                        <tr><th>Campaign Id</th><td>{{$order_detail['id']}}</td></tr>
                        <tr><th>Order Amount</th><td>{{$order_detail['order_amount']}}</td></tr>
                        <tr><th>Status</th><td>{{status_format($order_detail['status'])}}</td></tr>
                        <tr><th>Uploaded Recipient File</th>
                        @if($order_detail['uploaded_recipient_file'])
                        <td><a class="anchor_class" href="/files/{{$order_detail['uploaded_recipient_file']}}">Download File</a></td>
                        @else
                        <td><a class="anchor_class" href="{{route('frontend.cards.generateFiles',$order_detail['id'])}}">Generate File</a></td>
                        @endif
                        </tr>
                        @php
							$json_decode=json_decode($order_detail['order_json'],1);
						@endphp
                        <tr><th>Campaign_name</th><td>{{$order_detail['campaign_name']}}</td></tr>
                        <tr><th>Campaign Type</th><td>{{$order_detail['campaign_type']}}</td></tr>
                        <!-- <tr><th>Campaign Message</th><td>{!!nl2br($order_detail['campaign_message'])!!}</td></tr> -->
                        <tr><th>Message Preview</th><td align="center">@php if(@$order_detail['campaign_message']&&file_exists(public_path('img/preview/'.@$order_detail['campaign_message']))){ $preview_image=asset('img/preview/'.@$order_detail['campaign_message']); echo("<img width='100px' style='display:inline;background:url(".asset("storage/".$order_detail['inner_design']).") #f8f8f8;background-position:center;background-size:92%;background-repeat:no-repeat;'  class='model_preview' data-url='".$preview_image."' src='".$preview_image."'>"); if(!empty($order_detail['main_design'])){ echo("&nbsp;<img width='100px' class='model_preview' data-url='".asset("storage/".$order_detail['main_design'])."' src='".asset("storage/".$order_detail['main_design'])."'>");} }else{ echo$order_detail['campaign_message']; } @endphp</td></tr>
                        <tr><th>schedule Status</th><td>{{$order_detail['schedule_status']?'Yes':'No'}}</td></tr>
                        <tr><th>Auto Charge</th><td>{{$order_detail['auto_charge']?'Yes':'No'}}</td></tr>
                        <tr><th>Threshold</th><td>{{$order_detail['threshold']}}</td></tr>
                        <tr><th>Batch Created</th><td></td></tr>
                        <tr><th>Repeat Number</th><td>{{$order_detail['repeat_number']}}</td></tr>

                        <tr><th>Final Printing File</th>
                        @if($order_detail['final_printing_file'])
                        <td><a class="anchor_class"  href="{{asset('/files/'.$order_detail['final_printing_file'])}}">Download File</a></td>
                        @else
                        <td><a class="anchor_class" href="{{route('frontend.cards.generateFiles',$order_detail['id'])}}">Generate File</a></td>
                        @endif
                        </tr>
                        <tr><th>Linked List Name</th><td><a class="anchor_class" href="{{route('frontend.cards.contacts',$order_detail['listing_id'])}}">{{$file['name']}}</a></td></tr>
						
                        <tr><th>Linked List Fields</th><td>{{implode(', ',array_keys($json_decode['system_property_1']))}}</td></tr>
                        <tr><th>Created At</th><td>{{$order_detail['created_at']}}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
</section>
<script>
	function getFile() {
  document.getElementById("upload_recipients").click();
}

function sub(obj) {
$("#upload_file").submit();
}
</script>


@endsection