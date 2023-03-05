@props(['route'])
@can($route)
    <a href="{{ route($route) }}" class="btn btn-primary shadow-md mr-2">Novo</a>
@endcan
