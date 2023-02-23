@props(['route', 'label', 'icon'])
<a class="flex items-center mr-3" href="{{ $route }}">
    <i data-lucide="{{ $icon }}" class="w-4 h-4 mr-1"></i> {{ $label }}
</a>
