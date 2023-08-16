<div>
    <div id="modal-budget-discount" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Aplicar desconto</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-discount-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-discount-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2">
                        <x-forms.select name="discount_type" label="Tipo de Desconto" :options="$feeDiscountTypes"
                            wire:model="dataDiscount.discount_type" />
                        <x-forms.text name="discount" label="Desconto" wire:model="dataDiscount.discount" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveDiscount">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetDiscount = null;
            var alertDiscountError = null;
            var alertDiscountBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                alertDiscountError = document.getElementById('alert-discount-error');
                alertDiscountBodyError = document.getElementById('alert-discount-body-error');

                modalBudgetDiscount = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-discount"));
            });

            window.livewire.on('addDiscount', () => {
                modalBudgetDiscount.show();
            });

            window.livewire.on('discountUpdated', () => {
                modalBudgetDiscount.hide();
            });

            window.livewire.on('discountError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertDiscountBodyError.innerHTML = listErros;
                    alertDiscountError.classList.remove('hidden');
                } else {
                    alertDiscountBodyError.innerHTML = '';
                    alertDiscountError.classList.add('hidden');
                }
            });
        </script>
    @endpush
</div>
