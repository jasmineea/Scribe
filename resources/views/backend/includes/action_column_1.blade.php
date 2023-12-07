<div class="text-end">
    <x-buttons.show route='{!!route("backend.$module_name.show", $data)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
    <a href="{{route('backend.listings.delete',['id'=>$data])}}" class="btn btn-danger btn-sm mt-1" data-toggle="tooltip" title="Delete List"><i class="fas fa-trash"></i></a>
</div>
