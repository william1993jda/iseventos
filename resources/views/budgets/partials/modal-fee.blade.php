<div id="modal-budget-fee" class="modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Aplicar taxa</h2>
            </div>
            <div class="modal-body">
                <div class="hidden" id="alert-fee-error">
                    <div class="alert alert-danger show flex items-center mb-2" role="alert">
                        <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                    </div>
                </div>

                <div class="sm:grid grid-cols-2 gap-2">
                    <x-forms.select name="fee_type" label="Tipo de Taxa" :options="$feeDiscountTypes"
                        wire:model="dataFee.fee_type" />
                    <x-forms.text name="fee" label="Taxa" wire:model="dataFee.fee" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                <button type="button" class="btn btn-primary w-20" wire:click="saveFee">Salvar</button>
            </div>
        </div>
    </div>
</div>
