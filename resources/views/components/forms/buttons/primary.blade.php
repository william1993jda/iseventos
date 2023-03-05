@props(['route', 'label', 'id' => null])
@can($route)
    <a href="{{ route($route, $id) }}" class="btn btn-primary shadow-md mr-2">{{ $label }}</a>
@endcan
