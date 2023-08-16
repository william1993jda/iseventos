<div>
    <div id="modal-orderservice-provider" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Equipamento - Fornecedor</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-provider-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-provider-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="provider_id" label="Fornecedor" :options="$providers"
                            wire:model="dataProvider.provider_id" wire:change="onSelectProvider($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.select name="provider_category_id" label="Categoria" :options="[]"
                            wire:model="dataProvider.category_id"
                            wire:change="onSelectCategoryProvider($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.select name="provider_product_id" label="Equipamento" :options="[]"
                            wire:model="dataProvider.product_id" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="provider_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataProvider.place_room_id" />
                        <x-forms.number name="provider_quantity" label="Quantidade"
                            wire:model="dataProvider.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveProvider">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-provider-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="provider_id_delete" id="provider_id_delete">
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
                        <button type="button" class="btn btn-danger w-24" onclick="removeProvider()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceProvider = null;
            var deleteConfirmationProviderModal = null;
            var selectProviderId = null;
            var selectProviderCategoryId = null;
            var selectProviderProductId = null;
            var selectProviderPlaceRoomId = null;
            var inputProviderQuantity = null;
            var alertProviderError = null;
            var alertProviderBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalOrderServiceProvider = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-provider"));
                deleteConfirmationProviderModal = tailwind.Modal.getInstance(document.querySelector(
                    "#delete-confirmation-provider-modal"));

                selectProviderId = document.getElementById('provider_id').tomselect;
                selectProviderCategoryId = document.getElementById('provider_category_id').tomselect;
                selectProviderProductId = document.getElementById('provider_product_id').tomselect;
                selectProviderPlaceRoomId = document.getElementById('provider_place_room_id').tomselect;
                inputProviderQuantity = document.getElementById('provider_quantity');
                alertProviderError = document.getElementById('alert-provider-error');
                alertProviderBodyError = document.getElementById('alert-provider-body-error');
            });

            function removeProvider() {
                const providerId = document.getElementById('provider_id_delete').value;
                @this.removeProvider(providerId);
                document.getElementById('provider_id_delete').value = '';
                deleteConfirmationProviderModal.hide();
            }

            window.livewire.on('addProvider', () => {
                selectProviderId.clear(true);
                selectProviderCategoryId.clear(true);
                selectProviderProductId.clear(true);
                selectProviderPlaceRoomId.clear(true);
                inputProviderQuantity.value = '';
                modalOrderServiceProvider.show();
            });

            window.livewire.on('providerSaved', () => {
                selectProviderId.clear(true);
                selectProviderCategoryId.clear(true);
                selectProviderProductId.clear(true);
                selectProviderPlaceRoomId.clear(true);
                inputProviderQuantity.value = '';
            });

            window.livewire.on('updateProviderCategoryList', (data) => {
                selectProviderCategoryId.clear();
                selectProviderCategoryId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProviderCategoryId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });

            window.livewire.on('updateProviderProductList', (data) => {
                selectProviderProductId.clear();
                selectProviderProductId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProviderProductId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });

            window.livewire.on('providerError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertProviderBodyError.innerHTML = listErros;
                    alertProviderError.classList.remove('hidden');
                } else {
                    alertProviderBodyError.innerHTML = '';
                    alertProviderError.classList.add('hidden');
                }
            });

            window.livewire.on('confirmProviderRemove', (id) => {
                document.getElementById('provider_id_delete').value = id;
                deleteConfirmationProviderModal.show();
            });
        </script>
    @endpush
</div>
