@if ($crud->hasAccess('update'))
<a href="{{ url($crud->route.'/'.$entry->getKey().'/suppliers') }} " class="btn btn-xs btn-default"><i class="fa fa-industry"></i> Suppliers</a>
@endif
