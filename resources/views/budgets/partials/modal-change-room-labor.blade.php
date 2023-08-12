<div>
    <div id="modal-budget-change-room-labor" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Seleciona a sala abaixo</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-change-room-labor-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-change-room-labor-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="labor_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataRoomLabor.place_room_id" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" onclick="saveChangeRoomLabor()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalChangeRoomLabor = null;
            var alertChangeRoomLaborError = null;
            var alertChangeRoomLaborBodyError = null;

            function checkAllLabor() {
                if ($('input[name="checkbox_labor"]').is(':checked')) {
                    for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                        $('input[class="checkbox_labor"]')[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                        $('input[class="checkbox_labor"]')[i].checked = false;
                    }
                }
            }

            function changeRoomLabor() {
                var labors = [];
                for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                    if ($('input[class="checkbox_labor"]')[i].checked) {
                        labors.push($('input[class="checkbox_labor"]')[i].value);
                    }
                }
                if (labors.length > 0) {
                    @this.updatePlaceRooms('labor');
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

            function saveChangeRoomLabor() {
                var labors = [];
                for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                    if ($('input[class="checkbox_labor"]')[i].checked) {
                        labors.push($('input[class="checkbox_labor"]')[i].value);
                    }
                }
                if (labors.length > 0) {
                    @this.saveChangeRoomLabor(labors);
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
                modalChangeRoomLabor = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-change-room-labor"));

                alertChangeRoomLaborError = document.getElementById('alert-change-room-labor-error');
                alertChangeRoomLaborBodyError = document.getElementById('alert-change-room-labor-body-error');
            });

            window.livewire.on('openRoomLabor', () => {
                modalChangeRoomLabor.show();
            });

            window.livewire.on('roomChangedLabor', () => {
                modalChangeRoomLabor.hide();

                $('input[name="checkbox_labor"]')[0].checked = false;

                for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                    $('input[class="checkbox_labor"]')[i].checked = false;
                }
            });

            window.livewire.on('roomChangeLaborError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertChangeRoomLaborBodyError.innerHTML = listErros;
                    alertChangeRoomLaborError.classList.remove('hidden');
                } else {
                    alertChangeRoomLaborBodyError.innerHTML = '';
                    alertChangeRoomLaborError.classList.add('hidden');
                }
            });
        </script>
    @endpush
</div>
