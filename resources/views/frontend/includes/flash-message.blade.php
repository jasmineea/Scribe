@auth
<section>
	<div class="container-fluid padding_top_135" style="padding-left: 3648px;">
		<div class="row">
			<div class="col-12">
@endif
@if ($message = Session::get('success'))
<script>
    Alert.success('{{$message}}','Success',{displayDuration: 5000, pos: 'top'})
</script>
@endif

@if ($message = Session::get('error'))
<script>
    Alert.error('{{$message}}','Error',{displayDuration: 5000, pos: 'top'})
</script>
@endif

@if ($message = Session::get('warning'))
<script>
    Alert.warning('{{$message}}','Warning',{displayDuration: 5000, pos: 'top'})
</script>
@endif

@if ($message = Session::get('info'))
<script>
    Alert.info('{{$message}}','Info',{displayDuration: 5000, pos: 'top'})
</script>
@endif

@if ($errors->any())
@foreach ($errors->all() as $item)
<script>
    Alert.error('{{$item}}','Error',{displayDuration: 5000, pos: 'top'})
</script>
@endforeach
@endif
@auth
            </div>
        </div>
    </div>
</section>
@endif
