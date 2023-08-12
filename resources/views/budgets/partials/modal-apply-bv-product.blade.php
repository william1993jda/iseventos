<div>
    <div id="modal-budget-apply-bv-product" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Informe a porcentagem BV para ser aplicado aos itens
                        selecionado.</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.number name="bv_product" label="Porcentagem" min="1"
                            wire:model="dataBvProduct.amount" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" onclick="saveApplyBvProduct()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalApplyBvProduct = null;
            var inputBvProduct = null;

            function checkAllProduct() {
                if ($('input[name="checkbox_product"]').is(':checked')) {
                    for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                        $('input[class="checkbox_product"]')[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                        $('input[class="checkbox_product"]')[i].checked = false;
                    }
                }
            }

            function applyBvProduct() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    modalApplyBvProduct.show();
                } else {
                    document.getElementById('error-notification-title').innerHTML = "Atenção!";
                    document.getElementById('error-notification-message').innerHTML = "Selecione pelo menos um equipamento!";

                    Toastify({
                        node: $("#error-notification").clone().removeClass("hidden")[0],
                        duration: 5000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "transparent",
                        stopOnFocus: true,
                    }).showToast();
                }
            }

            function saveApplyBvProduct() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    @this.saveApplyBvProduct(products);
                } else {
                    document.getElementById('error-notification-title').innerHTML = "Atenção!";
                    document.getElementById('error-notification-message').innerHTML = "Selecione pelo menos um equipamento!";

                    Toastify({
                        node: $("#error-notification").clone().removeClass("hidden")[0],
                        duration: 5000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "transparent",
                        stopOnFocus: true,
                    }).showToast();
                }
            }

            document.addEventListener("DOMContentLoaded", function(e) {
                modalApplyBvProduct = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-apply-bv-product"));

                inputBvProduct = document.getElementById('bv_product');
            });

            window.livewire.on('openBvProduct', () => {
                modalApplyBvProduct.show();
            });

            window.livewire.on('bvAppliedProduct', () => {
                modalApplyBvProduct.hide();
                inputBvProduct.value = '';

                $('input[name="checkbox_product"]')[0].checked = false;

                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    $('input[class="checkbox_product"]')[i].checked = false;
                }
            });
        </script>
    @endpush
</div>
