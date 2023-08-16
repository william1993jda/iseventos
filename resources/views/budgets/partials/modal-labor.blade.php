<div>
    <div id="modal-budget-labor" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Mão de obra</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-labor-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-labor-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2" wire:ignore>
                        <x-forms.select name="labor_id" label="Mão de obra" :options="$labors"
                            wire:model="dataLabor.labor_id" wire:change="onSelectLabor($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-4 gap-2 mt-3">
                        <x-forms.select name="labor_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataLabor.place_room_id" />
                        <x-forms.text name="labor_price" label="Preço" wire:model="dataLabor.price" />
                        <x-forms.number name="days" label="Diárias" wire:model="dataLabor.days" />
                        <x-forms.number name="labor_quantity" label="Quantidade" wire:model="dataLabor.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveLabor">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-labor-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="labor_id_delete" id="labor_id_delete">
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
                        <button type="button" class="btn btn-danger w-24" onclick="removeLabor()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetLabor = null;
            var deleteConfirmationLaborModal = null;
            var selectLaborId = null;
            var selectLaborPlaceRoomId = null;
            var inputLaborPrice = null;
            var inputLaborDays = null;
            var inputLaborQuantity = null;
            var alertLaborError = null;
            var alertLaborBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalBudgetLabor = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-labor"));
                deleteConfirmationLaborModal = tailwind.Modal.getInstance(document.querySelector(
                    "#delete-confirmation-labor-modal"));
                selectLaborId = document.getElementById('labor_id').tomselect;
                selectLaborPlaceRoomId = document.getElementById('labor_place_room_id').tomselect;
                inputLaborPrice = document.getElementById('labor_price');
                inputLaborDays = document.getElementById('days');
                inputLaborQuantity = document.getElementById('labor_quantity');
                alertLaborError = document.getElementById('alert-labor-error');
                alertLaborBodyError = document.getElementById('alert-labor-body-error');
            });

            function removeLabor() {
                const laborId = document.getElementById('labor_id_delete').value;
                @this.removeLabor(laborId);
                document.getElementById('labor_id_delete').value = '';
                deleteConfirmationLaborModal.hide();
            }

            window.livewire.on('addLabor', () => {
                selectLaborId.clear(true);
                selectLaborPlaceRoomId.clear(true);
                inputLaborPrice.value = '';
                inputLaborDays.value = '';
                inputLaborQuantity.value = '';
                modalBudgetLabor.show();
            });

            window.livewire.on('updateLaborList', (data) => {
                selectLaborId.clear();
                selectLaborId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectLaborId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });

            window.livewire.on('updateLaborPrice', (data) => {
                inputLaborPrice.value = data;
            });

            window.livewire.on('laborSaved', () => {
                selectLaborId.clear(true);
                selectLaborPlaceRoomId.clear(true);
                inputLaborPrice.value = '';
                inputLaborDays.value = '';
                inputLaborQuantity.value = '';
            });

            window.livewire.on('laborError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertLaborBodyError.innerHTML = listErros;
                    alertLaborError.classList.remove('hidden');
                } else {
                    alertLaborBodyError.innerHTML = '';
                    alertLaborError.classList.add('hidden');
                }
            });

            window.livewire.on('confirmLaborRemove', (id) => {
                document.getElementById('labor_id_delete').value = id;
                deleteConfirmationLaborModal.show();
            });
        </script>
    @endpush
</div>
