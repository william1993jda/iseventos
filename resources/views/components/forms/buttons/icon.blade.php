@props(['route', 'label', 'icon', 'id' => null])
@can($route)
    <a class="flex items-center mr-3" href="{{ route($route, $id) }}">
        <i data-lucide="{{ $icon }}" class="w-4 h-4 mr-1"></i> {{ $label }}
    </a>
@endcan
