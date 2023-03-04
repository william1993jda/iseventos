<div id="modal-budget-status" class="modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Alterar status</h2>
            </div>
            <div class="modal-body">
                <div class="hidden" id="alert-status-error">
                    <div class="alert alert-danger show flex items-center mb-2" role="alert">
                        <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                    </div>
                </div>

                <div class="sm:grid grid-cols-1 gap-2">
                    <x-forms.select name="status_id" label="Status" :options="$status"
                        wire:model="dataStatus.status_id" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                <button type="button" class="btn btn-primary w-20" wire:click="saveStatus">Salvar</button>
            </div>
        </div>
    </div>
</div>
