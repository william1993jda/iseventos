<div>
    <div id="modal-budget-change-room-product" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Seleciona a sala abaixo</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-change-room-product-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-change-room-product-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="product_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataRoomProduct.place_room_id" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20"
                        onclick="saveChangeRoomProduct()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalChangeRoomProduct = null;
            var alertChangeRoomProductError = null;
            var alertChangeRoomProductBodyError = null;

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

            function changeRoomProduct() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    @this.updatePlaceRooms('product');
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

            function saveChangeRoomProduct() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    @this.saveChangeRoomProduct(products);
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
                modalChangeRoomProduct = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-change-room-product"));

                alertChangeRoomProductError = document.getElementById('alert-change-room-product-error');
                alertChangeRoomProductBodyError = document.getElementById('alert-change-room-product-body-error');
            });

            window.livewire.on('openRoomProduct', () => {
                modalChangeRoomProduct.show();
            });

            window.livewire.on('roomChangedProduct', () => {
                modalChangeRoomProduct.hide();

                $('input[name="checkbox_product"]')[0].checked = false;

                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    $('input[class="checkbox_product"]')[i].checked = false;
                }
            });

            window.livewire.on('roomChangeProductError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertChangeRoomProductBodyError.innerHTML = listErros;
                    alertChangeRoomProductError.classList.remove('hidden');
                } else {
                    alertChangeRoomProductBodyError.innerHTML = '';
                    alertChangeRoomProductError.classList.add('hidden');
                }
            });
        </script>
    @endpush
</div>
