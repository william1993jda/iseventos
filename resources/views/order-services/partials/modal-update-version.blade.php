<div>
    <div id="modal-orderservice-update-version" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0" wire:ignore>
                    <div class="p-5 text-center">
                        <i data-lucide="copy-plus" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Atualizar versão?</div>
                        <div class="text-slate-500 mt-2">
                            Você confirma que já verificou todas as alterações do Orçamento e deseja informar que essa
                            Ordem de Serviço está atualizada?
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Não</button>
                        <button type="submit" class="btn btn-primary w-24" wire:click="updateVersion">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            window.livewire.on('versionUpdated', () => {
                window.location.reload();
            });
        </script>
    @endpush
</div>
