<div id="modal-orderservice-kit" class="modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Adicionar Kit</h2>
            </div>
            <div class="modal-body">
                <div class="hidden" id="alert-kit-error">
                    <div class="alert alert-danger show flex items-center mb-2" role="alert">
                        <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                    </div>
                </div>

                <div class="sm:grid grid-cols-1 gap-2">
                    <x-forms.select name="group_id" label="Kit" :options="$groups" wire:model="dataGroup.group_id" />
                </div>
                <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                        wire:model="dataGroup.place_room_id" />
                    <x-forms.number name="quantity" label="Quantidade" wire:model="dataGroup.quantity" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                <button type="button" class="btn btn-primary w-20" wire:click="saveKit">Salvar</button>
            </div>
        </div>
    </div>
</div>