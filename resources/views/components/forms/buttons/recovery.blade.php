@props(['route', 'id', 'module'])
@can($route)
    <button class="flex items-center text-danger recovery-confirmation-button" data-action="{{ route($route, $id) }}"
        data-module="{{ $module }}" data-tw-toggle="modal" data-tw-target="#recovery-confirmation-modal" type="button">
        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Recuperar
    </button>
@endcan
