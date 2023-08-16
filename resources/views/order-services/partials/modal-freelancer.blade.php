<div>
    <div id="modal-orderservice-freelancer" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Freelancer</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="hidden" id="alert-freelancer-error">
                        <div class="text-base font-medium">Verifique os campos abaixo:</div>
                        <div class="alert alert-danger show flex items-center mb-2" role="alert"
                            id="alert-freelancer-body-error">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="freelancer_id" label="Freelancer" :options="$freelancers"
                            wire:model="dataFreelancer.freelancer_id" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="freelancer_place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataFreelancer.place_room_id" />
                        <x-forms.number name="freelancer_days" label="Diárias" wire:model="dataFreelancer.days" />
                        <x-forms.number name="freelancer_quantity" label="Quantidade"
                            wire:model="dataFreelancer.quantity" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveFreelancer">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-freelancer-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="freelancer_id_delete" id="freelancer_id_delete">
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
                        <button type="button" class="btn btn-danger w-24" onclick="removeFreelancer()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceFreelancer = null;
            var deleteConfirmationFreelancerModal = null;
            var selectFreelancerId = null;
            var selectFreelancerPlaceRoomId = null;
            var inputFreelancerDays = null;
            var inputFreelancerQuantity = null;
            var alertFreelancerError = null;
            var alertFreelancerBodyError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                modalOrderServiceFreelancer = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-freelancer"));
                deleteConfirmationFreelancerModal = tailwind.Modal.getInstance(document.querySelector(
                    "#delete-confirmation-freelancer-modal"));

                selectFreelancerId = document.getElementById('freelancer_id')
                    .tomselect;
                selectFreelancerPlaceRoomId = document.getElementById(
                    'freelancer_place_room_id').tomselect;
                inputFreelancerDays = document.getElementById(
                    'freelancer_days');
                inputFreelancerQuantity = document.getElementById(
                    'freelancer_quantity');
                alertFreelancerError = document.getElementById(
                    'alert-freelancer-error');
                alertFreelancerBodyError = document.getElementById(
                    'alert-freelancer-body-error');
            });

            function removeFreelancer() {
                const freelancerId = document.getElementById('freelancer_id_delete').value;
                @this.removeFreelancer(freelancerId);
                document.getElementById('freelancer_id_delete').value = '';
                deleteConfirmationFreelancerModal.hide();
            }

            window.livewire.on('addFreelancer', (data) => {
                selectFreelancerId.clear(true);
                selectFreelancerPlaceRoomId.clear(true);
                inputFreelancerDays.value = '';
                inputFreelancerQuantity.value = '';
                modalOrderServiceFreelancer.show();
            });

            window.livewire.on('freelancerSaved', () => {
                selectFreelancerId.clear(true);
                selectFreelancerPlaceRoomId.clear(true);
                inputFreelancerDays.value = '';
                inputFreelancerQuantity.value = '';
            });

            window.livewire.on('freelancerError', (data) => {
                if (data) {
                    let listErros =
                        '<ul class="list-disc">';

                    Object.keys(data).forEach(function(key) {
                        listErros += '<li>' + data[key] + '</li>';
                    });

                    listErros += '</ul>';

                    alertFreelancerBodyError.innerHTML = listErros;
                    alertFreelancerError.classList.remove('hidden');
                } else {
                    alertFreelancerBodyError.innerHTML = '';
                    alertFreelancerError.classList.add('hidden');
                }
            });

            window.livewire.on('confirmFreelancerRemove', (id) => {
                document.getElementById('freelancer_id_delete').value = id;
                deleteConfirmationFreelancerModal.show();
            });
        </script>
    @endpush
</div>
