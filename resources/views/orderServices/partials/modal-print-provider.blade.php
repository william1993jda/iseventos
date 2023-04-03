<div id="modal-orderservice-print-provider" class="modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Pedidos Fornecedor</h2>
            </div>
            <div class="modal-body bg-slate-100">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">NOME</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($printProviders as $printProvider)
                            <tr class="intro-x">
                                <td>
                                    {{ $printProvider->fantasy_name }}
                                </td>
                                <td class="table-report__action w-28">
                                    <div class="flex justify-center items-center">
                                        <a target="_blank" class="flex items-center"
                                            href="{{ route('orderServices.print.provider', [$orderService->id, $printProvider->id]) }}">Imprimir
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
            </div>
        </div>
    </div>
</div>
