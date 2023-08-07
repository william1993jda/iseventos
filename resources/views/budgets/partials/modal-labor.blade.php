<div>
    <div id="modal-budget-labor" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Mão de obra</h2>
                </div>
                <div class="modal-body">
                    <div class="hidden" id="alert-labor-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-labor-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="labor_id" label="Mão de obra" :options="$labors"
                            wire:model="dataLabor.labor_id" wire:change="onSelectLabor($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-4 gap-2 mt-3">
                        <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataLabor.place_room_id" />
                        <x-forms.text name="labor_price" label="Preço" wire:model="dataLabor.price" />
                        <x-forms.number name="days" label="Diárias" wire:model="dataLabor.days" />
                        <x-forms.number name="labor_quantity" label="Quantidade" wire:model="dataLabor.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveLabor">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetLabor = null;
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

                selectLaborId = document.getElementById('labor_id').tomselect;
                selectLaborPlaceRoomId = document.getElementById('place_room_id').tomselect;
                inputLaborPrice = document.getElementById('labor_price');
                inputLaborDays = document.getElementById('days');
                inputLaborQuantity = document.getElementById('labor_quantity');
                alertLaborError = document.getElementById('alert-labor-error');
                alertLaborBodyError = document.getElementById('alert-labor-body-error');
            });

            window.livewire.on('addLabor', () => {
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
        </script>
    @endpush
</div>
