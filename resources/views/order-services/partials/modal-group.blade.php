<div>
    <div id="modal-orderservice-group" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Kit</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-group-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-group-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="group_id" label="Kit" :options="$groups"
                            wire:model="dataGroup.group_id" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="group_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataGroup.place_room_id" />
                        <x-forms.number name="group_quantity" label="Quantidade" wire:model="dataGroup.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveGroup">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-group-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="group_id_delete" id="group_id_delete">
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
                        <button type="button" class="btn btn-danger w-24" onclick="removeGroup()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceGroup = null;
            var deleteConfirmationGroupModal = null;
            var selectGroupId = null;
            var selectPlaceRoomIdGroup = null;
            var inputQuantityGroup = null;
            var alertGroupError = null;
            var alertGroupBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalOrderServiceGroup = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-group"));
                deleteConfirmationGroupModal = tailwind.Modal.getInstance(document.querySelector(
                    "#delete-confirmation-group-modal"));

                selectGroupId = document.getElementById('group_id').tomselect;
                selectPlaceRoomIdGroup = document.getElementById('group_place_room_id').tomselect;
                inputQuantityGroup = document.getElementById('group_quantity');
                alertGroupError = document.getElementById('alert-group-error');
                alertGroupBodyError = document.getElementById('alert-group-body-error');
            });

            function removeGroup() {
                const groupId = document.getElementById('group_id_delete').value;
                @this.removeGroup(groupId);
                document.getElementById('group_id_delete').value = '';
                deleteConfirmationGroupModal.hide();
            }

            window.livewire.on('addGroup', () => {
                selectGroupId.clear(true);
                selectPlaceRoomIdGroup.clear(true);
                inputQuantityGroup.value = '';
                modalOrderServiceGroup.show();
            });

            window.livewire.on('groupSaved', () => {
                selectGroupId.clear(true);
                selectPlaceRoomIdGroup.clear(true);
                inputQuantityGroup.value = '';
            });

            window.livewire.on('groupError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertGroupBodyError.innerHTML = listErros;
                    alertGroupError.classList.remove('hidden');
                } else {
                    alertGroupBodyError.innerHTML = '';
                    alertGroupError.classList.add('hidden');
                }
            });

            window.livewire.on('confirmGroupRemove', (id) => {
                document.getElementById('group_id_delete').value = id;
                deleteConfirmationGroupModal.show();
            });
        </script>
    @endpush
</div>
