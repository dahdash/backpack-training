@if ($crud->hasAccess('update'))
<a href="{{ url($crud->route.'/'.$entry->getKey().'/status') }} " class="btn btn-xs btn-default"
  onclick="return confirm('Are you sure?')">
  <i class="fa fa-check"></i> {{ $entry->enabled == 0 ? 'Enable' : 'Disable' }}
</a>

@endif
