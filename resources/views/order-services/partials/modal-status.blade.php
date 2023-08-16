<div>
    <div id="modal-orderservice-status" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Alterar status</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-status-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-status-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="status_id" label="Status" :options="$osStatuses"
                            wire:model="dataStatus.status_id" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveStatus">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceStatus = null;
            var alertStatusError = null;
            var alertStatusBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalOrderServiceStatus = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-status"));

                alertStatusError = document.getElementById('alert-status-error');
                alertStatusBodyError = document.getElementById('alert-status-body-error');
            });

            window.livewire.on('editStatus', () => {
                modalOrderServiceStatus.show();
            });

            window.livewire.on('statusUpdated', () => {
                window.location.reload();
            });

            window.livewire.on('statusError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertStatusBodyError.innerHTML = listErros;
                    alertStatusError.classList.remove('hidden');
                } else {
                    alertStatusBodyError.innerHTML = '';
                    alertStatusError.classList.add('hidden');
                }
            });
        </script>
    @endpush
</div>
