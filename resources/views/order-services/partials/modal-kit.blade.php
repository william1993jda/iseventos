<div>
    <div id="modal-orderservice-kit" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Kit</h2>
                </div>
                <div class="modal-body">
                    <div class="hidden" id="alert-kit-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-kit-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="group_id" label="Kit" :options="$groups"
                            wire:model="dataGroup.group_id" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="kit_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataGroup.place_room_id" />
                        <x-forms.number name="kit_quantity" label="Quantidade" wire:model="dataGroup.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveKit">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-kit-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="kit_id_delete" id="kit_id_delete">
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
                        <button type="button" class="btn btn-danger w-24" onclick="removeKit()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceKit = null;
            var deleteConfirmationKitModal = null;
            var selectGroupId = null;
            var selectPlaceRoomIdKit = null;
            var inputQuantityKit = null;
            var alertKitError = null;
            var alertKitBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalOrderServiceKit = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-kit"));
                deleteConfirmationKitModal = tailwind.Modal.getInstance(document.querySelector(
                    "#delete-confirmation-kit-modal"));

                selectGroupId = document.getElementById('group_id').tomselect;
                selectPlaceRoomIdKit = document.getElementById('kit_place_room_id').tomselect;
                inputQuantityKit = document.getElementById('kit_quantity');
                alertKitError = document.getElementById('alert-kit-error');
                alertKitBodyError = document.getElementById('alert-kit-body-error');
            });

            function removeKit() {
                const kitId = document.getElementById('kit_id_delete').value;
                @this.removeKit(kitId);
                document.getElementById('kit_id_delete').value = '';
                deleteConfirmationKitModal.hide();
            }

            window.livewire.on('addKit', () => {
                selectGroupId.clear(true);
                selectPlaceRoomIdKit.clear(true);
                inputQuantityKit.value = '';
                modalOrderServiceKit.show();
            });

            window.livewire.on('kitSaved', () => {
                selectGroupId.clear(true);
                selectPlaceRoomIdKit.clear(true);
                inputQuantityKit.value = '';
            });

            window.livewire.on('kitError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertKitBodyError.innerHTML = listErros;
                    alertKitError.classList.remove('hidden');
                } else {
                    alertKitBodyError.innerHTML = '';
                    alertKitError.classList.add('hidden');
                }
            });

            window.livewire.on('confirmKitRemove', (id) => {
                document.getElementById('kit_id_delete').value = id;
                deleteConfirmationKitModal.show();
            });
        </script>
    @endpush
</div>
