@props(['route', 'id'])
@can($route)
    <button class="flex items-center text-danger delete-confirmation-button" data-action="{{ route($route, $id) }}"
        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" type="button">
        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Remover
    </button>
@endcan
