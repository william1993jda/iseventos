<div>
    <div id="modal-budget-apply-bv-labor" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Informe a porcentagem BV para ser aplicado aos itens
                        selecionado.</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.number name="bv_labor" label="Porcentagem" min="1"
                            wire:model="dataBvLabor.amount" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" onclick="saveApplyBvLabor()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalApplyBvLabor = null;
            var inputBvLabor = null;

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

            function applyBvLabor() {
                var labors = [];
                for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                    if ($('input[class="checkbox_labor"]')[i].checked) {
                        labors.push($('input[class="checkbox_labor"]')[i].value);
                    }
                }
                if (labors.length > 0) {
                    modalApplyBvLabor.show();
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

            function saveApplyBvLabor() {
                var labors = [];
                for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                    if ($('input[class="checkbox_labor"]')[i].checked) {
                        labors.push($('input[class="checkbox_labor"]')[i].value);
                    }
                }
                if (labors.length > 0) {
                    @this.saveApplyBvLabor(labors);
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
                modalApplyBvLabor = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-apply-bv-labor"));

                inputBvLabor = document.getElementById('bv_labor');
            });

            window.livewire.on('openBvLabor', () => {
                modalApplyBvLabor.show();
            });

            window.livewire.on('bvAppliedLabor', () => {
                modalApplyBvLabor.hide();
                inputBvLabor.value = '';

                $('input[name="checkbox_labor"]')[0].checked = false;

                for (var i = 0; i < $('input[class="checkbox_labor"]').length; i++) {
                    $('input[class="checkbox_labor"]')[i].checked = false;
                }
            });
        </script>
    @endpush
</div>
