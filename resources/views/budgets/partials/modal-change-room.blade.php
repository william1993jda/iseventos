<div>
    <div id="modal-budget-change-room" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Seleciona a sala abaixo</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataRoom.place_room_id" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" onclick="saveChangeRoom()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalChangeRoom = null;

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

            function changeRoom() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    modalChangeRoom.show();
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

            function saveChangeRoom() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    @this.saveChangeRoom(products);
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
                modalChangeRoom = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-change-room"));
            });

            window.livewire.on('roomChanged', () => {
                modalChangeRoom.hide();

                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    $('input[class="checkbox_product"]')[i].checked = false;
                }
            });
        </script>
    @endpush
</div>
