<div>
    <div id="modal-orderservice-product" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Equipamento</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-product-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-product-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="os_category_id" label="Categoria" :options="$osCategories"
                            wire:model="dataProduct.os_category_id"
                            wire:change="onSelectOsCategory($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.select name="product_id" label="Equipamento" :options="[]"
                            wire:model="dataProduct.product_id" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataProduct.place_room_id" />
                        <x-forms.number name="product_quantity" label="Quantidade" wire:model="dataProduct.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveProduct">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-product-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="product_id_delete" id="product_id_delete">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Deseja remover?</div>
                        <div class="text-slate-500 mt-2">
                            Tem certeza que deseja remover esse item?
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Cancelar</button>
                        <button type="button" class="btn btn-danger w-24" onclick="removeProduct()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceProduct = null;
            var deleteConfirmationProductModal = null;
            var selectOsCategoryId = null;
            var selectProductId = null;
            var selectPlaceRoomId = null;
            var inputQuantity = null;
            var alertProductError = null;
            var alertProductBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalOrderServiceProduct = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-product"));
                deleteConfirmationProductModal = tailwind.Modal.getInstance(document.querySelector(
                    "#delete-confirmation-product-modal"));

                selectOsCategoryId = document.getElementById('os_category_id').tomselect;
                selectProductId = document.getElementById('product_id').tomselect;
                selectPlaceRoomId = document.getElementById('place_room_id').tomselect;
                inputQuantity = document.getElementById('product_quantity');
                alertProductError = document.getElementById('alert-product-error');
                alertProductBodyError = document.getElementById('alert-product-body-error');
            });

            function removeProduct() {
                const productId = document.getElementById('product_id_delete').value;
                @this.removeProduct(productId);
                document.getElementById('product_id_delete').value = '';
                deleteConfirmationProductModal.hide();
            }

            window.livewire.on('addProduct', () => {
                selectOsCategoryId.clear(true);
                selectProductId.clear(true);
                selectProductId.clearOptions();
                selectPlaceRoomId.clear(true);
                inputQuantity.value = '';
                modalOrderServiceProduct.show();
            });

            window.livewire.on('updateProductList', (data) => {
                selectProductId.clear();
                selectProductId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProductId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });

            window.livewire.on('productSaved', () => {
                selectOsCategoryId.clear(true);
                selectProductId.clear(true);
                selectProductId.clearOptions();
                selectPlaceRoomId.clear(true);
                inputQuantity.value = '';
            });

            window.livewire.on('productError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertProductBodyError.innerHTML = listErros;
                    alertProductError.classList.remove('hidden');
                } else {
                    alertProductBodyError.innerHTML = '';
                    alertProductError.classList.add('hidden');
                }
            });

            window.livewire.on('confirmProductRemove', (id) => {
                document.getElementById('product_id_delete').value = id;
                deleteConfirmationProductModal.show();
            });
        </script>
    @endpush
</div>
