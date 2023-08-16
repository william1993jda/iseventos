<div>
    <div id="modal-budget-observation" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Observações</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.textarea name="observation" wire:model="dataBudget.observation" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveObservation">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetObservation = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalBudgetObservation = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-observation"));
            });

            window.livewire.on('editObservation', () => {
                modalBudgetObservation.show();
            });

            window.livewire.on('observationUpdated', () => {
                modalBudgetObservation.hide();
            });
        </script>
    @endpush
</div>
