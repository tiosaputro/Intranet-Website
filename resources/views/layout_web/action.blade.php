@if(in_array('update', $permission))
<a href="{{ url($route.'/edit/'.$row->id) }}" class="btn btn-sm btn-primary">
    <i data-feather="edit"></i> Edit
</a>
@endif

@if(in_array('delete', $permission))
<a href="javascript:;" class="btn btn-sm btn-danger" onclick="removeData('{{ $row->id }}')">
    <i data-feather="x"></i> Delete
</a>
@endif
