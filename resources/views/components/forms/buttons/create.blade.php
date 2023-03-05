@props(['route', 'id' => null])
@can($route)
    <a href="{{ route($route, $id) }}" class="btn btn-primary shadow-md mr-2">Novo</a>
@endcan
