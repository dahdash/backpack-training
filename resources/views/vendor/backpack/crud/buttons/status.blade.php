
@if ($crud->hasAccess('update'))
<a href="{{ url($crud->route.'/'.$entry->getKey().'/status') }} " class="btn btn-xs btn-default"
  onclick="return confirm('Are you sure?')" >
  @if($entry->enabled == 0)
    <i class="fa fa-check"></i>
  @endif
  @if($entry->enabled == 1)
    <i class="fa fa-ban"></i>
  @endif
  {{ $entry->enabled == 0 ? 'Enable' : 'Disable' }}
</a>
@endif
