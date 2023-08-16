<div>
    <div id="modal-budget-fee" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Aplicar Taxa do Cartão</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-fee-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-fee-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2">
                        <x-forms.select name="fee_type" label="Tipo de Taxa do Cartão" :options="$feeDiscountTypes"
                            wire:model="dataFee.fee_type" />
                        <x-forms.text name="fee" label="Taxa do Cartão" wire:model="dataFee.fee" />
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

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetFee = null;
            var alertFeeError = null;
            var alertFeeBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                alertFeeError = document.getElementById('alert-fee-error');
                alertFeeBodyError = document.getElementById('alert-fee-body-error');

                modalBudgetFee = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-fee"));
            });

            window.livewire.on('addFee', () => {
                modalBudgetFee.show();
            });

            window.livewire.on('feeUpdated', () => {
                modalBudgetFee.hide();
            });

            window.livewire.on('feeError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertFeeBodyError.innerHTML = listErros;
                    alertFeeError.classList.remove('hidden');
                } else {
                    alertFeeBodyError.innerHTML = '';
                    alertFeeError.classList.add('hidden');
                }
            });
        </script>
    @endpush
</div>
