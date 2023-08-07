<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Saída / Entrada
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 box px-5 pt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DETALHES</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Orçamento Nº:</span>&nbsp;#{{ $budget->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Versão Nº:</span>&nbsp;#{{ $budget->budget_version }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Nome do Evento:</span>&nbsp;{{ $budget->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Local do Evento:</span>&nbsp;{{ $budget->place->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Endereço do
                                Local:</span>&nbsp;{{ $budget->place->getfullAddress() }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Status:</span>&nbsp;{{ $budget->status->name }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DATAS</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Data da
                                solicitação:</span>&nbsp;{{ $budget->request_date->format('d/m/Y') }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Dias do Evento:</span>&nbsp;{{ $budget->budget_days }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Montagem:</span>&nbsp;{{ $budget->mount_date->format('d/m/Y') }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Desmontagem:</span>&nbsp;{{ $budget->unmount_date->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">CLIENTE</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Nome:</span>&nbsp;{{ $budget->customer->fantasy_name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Contato - Nome:</span>&nbsp;
                            @if (!empty($budget->customerContact))
                                {{ $budget->customerContact->name }}
                            @endif
                        </div>
                        @if (!empty($budget->customerContact) && !empty($budget->customerContact->phone))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Contato - Telefone:</span>&nbsp;
                                {{ $budget->customerContact->phone }}
                            </div>
                        @endif
                        @if (!empty($budget->customerContact) && !empty($budget->customerContact->email))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Contato - E-mail:</span>&nbsp;
                                {{ $budget->customerContact->email }}
                            </div>
                        @endif
                        @if (!empty($budget->agency))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Agência:</span>&nbsp;{{ $budget->agency->fantasy_name }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="intro-x col-span-12">
                <div class="font-medium text-center lg:text-left lg:mt-3">OBSERVAÇÕES</div>
                <div class="my-3">{!! nl2br($budget->observation) !!}</div>
            </div>
        </div>
        <div class="intro-x col-span-12">
            {{-- <h3 class="text-lg font-medium mr-auto">
                TESTE
            </h3> --}}
            <div class="intro-y col-span-12 box px-5 pt-5 my-3">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">EQUIPAMENTO</th>
                                <th class="whitespace-nowrap text-center w-48">SKU</th>
                                <th class="whitespace-nowrap w-10">SAÍDA</th>
                                <th class="whitespace-nowrap w-10">ENTRADA</th>
                                <th class="whitespace-nowrap w-10">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderServiceCheckItems as $orderServiceCheckItem)
                                <tr>
                                    <td class="whitespace-nowrap font-medium">
                                        {{ $orderServiceCheckItem->osProduct->name }}</td>
                                    <td class="whitespace-nowrap">
                                        <x-forms.number name="sku" min="1"
                                            value="{{ $orderServiceCheckItem->sku }}"
                                            wire:change="onChangeSku({{ $orderServiceCheckItem->id }}, $event.target.value)" />
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ $orderServiceCheckItem->checkout_date ? $orderServiceCheckItem->checkout_date->format('d/m/Y') : null }}
                                    </td>
                                    <td class="whitespace-nowrap">&nbsp;</td>
                                    <td class="whitespace-nowrap">&nbsp;</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            window.livewire.on('notificationError', (data) => {
                document.getElementById('error-notification-title').innerHTML = data.title;
                document.getElementById('error-notification-message').innerHTML = data.message;

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
            });
        </script>
    @endpush
</div>
