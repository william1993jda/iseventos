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
            <div class="intro-y col-span-12 box px-5 pt-5 my-3">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">EQUIPAMENTO</th>
                                <th class="whitespace-nowrap text-center w-48">SKU</th>
                                <th class="whitespace-nowrap text-center w-10">SAÍDA</th>
                                <th class="whitespace-nowrap text-center w-10">ENTRADA</th>
                                <th class="whitespace-nowrap text-center w-24">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderServiceCheckItems as $orderServiceCheckItem)
                                <tr>
                                    <td class="whitespace-nowrap font-medium">
                                        {{ $orderServiceCheckItem['name'] }}</td>
                                    <td class="whitespace-nowrap">
                                        <x-forms.number name="sku" min="1"
                                            value="{{ $orderServiceCheckItem['sku'] }}"
                                            wire:change="onChangeSku({{ $orderServiceCheckItem['id'] }}, $event.target.value)" />
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ $orderServiceCheckItem['checkout_date'] }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ $orderServiceCheckItem['checkin_date'] }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <div class="flex justify-center items-center">
                                            @switch($orderServiceCheckItem['status'])
                                                @case(2)
                                                    <button class="btn btn-sm btn-success text-white mx-2" type="button"
                                                        title="Confirmar entrada"
                                                        wire:click="confirmCheckin({{ $orderServiceCheckItem['id'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-check-circle-2">
                                                            <path
                                                                d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                                            <path d="m9 12 2 2 4-4" />
                                                        </svg>
                                                    </button>
                                                    <button class="btn btn-sm btn-primary mx-2" type="button"
                                                        title="Informar problema"
                                                        wire:click="informProblem({{ $orderServiceCheckItem['id'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-info">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path d="M12 16v-4" />
                                                            <path d="M12 8h.01" />
                                                        </svg>
                                                    </button>
                                                @break

                                                @case(3)
                                                    <button class="btn btn-sm btn-warning text-white mx-2" type="button"
                                                        title="Cancelar saída"
                                                        wire:click="cancelCheckout({{ $orderServiceCheckItem['id'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-x-circle">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path d="m15 9-6 6" />
                                                            <path d="m9 9 6 6" />
                                                        </svg>
                                                    </button>
                                                @break

                                                @case(4)
                                                    <button class="btn btn-sm btn-primary text-white mx-2" type="button"
                                                        title="Cancelar problema"
                                                        wire:click="cancelProblem({{ $orderServiceCheckItem['id'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-ban">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path d="m4.9 4.9 14.2 14.2" />
                                                        </svg>
                                                    </button>
                                                @break

                                                @default
                                            @endswitch
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($orderServiceCheckItemGroups as $orderServiceCheckItemGroup)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <div class="font-medium">
                                            {{ $orderServiceCheckItemGroup['name'] }}
                                        </div>
                                        <ul>
                                            @foreach ($orderServiceCheckItemGroup['products'] as $product)
                                                <li class="h-10 flex items-center">{{ $product['name'] }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <div class="h-5">&nbsp</div>
                                        @foreach ($orderServiceCheckItemGroup['products'] as $product)
                                            <div class="h-10 flex items-center">
                                                <x-forms.number name="sku" min="1"
                                                    value="{{ $product['sku'] }}"
                                                    wire:change="onChangeSku({{ $product['id'] }}, $event.target.value)" />
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <div class="h-5">&nbsp</div>
                                        @foreach ($orderServiceCheckItemGroup['products'] as $product)
                                            <div class="h-10 flex items-center">
                                                {{ $product['checkout_date'] }}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <div class="h-5">&nbsp</div>
                                        @foreach ($orderServiceCheckItemGroup['products'] as $product)
                                            <div class="h-10 flex items-center">
                                                {{ $product['checkin_date'] }}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <div class="h-2">&nbsp</div>
                                        @foreach ($orderServiceCheckItemGroup['products'] as $product)
                                            <div class="flex justify-center items-center">
                                                @switch($product['status'])
                                                    @case(2)
                                                        <button class="btn btn-sm btn-success text-white mx-2" type="button"
                                                            title="Confirmar entrada"
                                                            wire:click="confirmCheckin({{ $product['id'] }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" class="lucide lucide-check-circle-2">
                                                                <path
                                                                    d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                                                <path d="m9 12 2 2 4-4" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-sm btn-primary mx-2" type="button"
                                                            title="Informar problema"
                                                            wire:click="informProblem({{ $product['id'] }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" class="lucide lucide-info">
                                                                <circle cx="12" cy="12" r="10" />
                                                                <path d="M12 16v-4" />
                                                                <path d="M12 8h.01" />
                                                            </svg>
                                                        </button>
                                                    @break

                                                    @case(3)
                                                        <button class="btn btn-sm btn-warning text-white mx-2" type="button"
                                                            title="Cancelar saída"
                                                            wire:click="cancelCheckout({{ $product['id'] }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" class="lucide lucide-x-circle">
                                                                <circle cx="12" cy="12" r="10" />
                                                                <path d="m15 9-6 6" />
                                                                <path d="m9 9 6 6" />
                                                            </svg>
                                                        </button>
                                                    @break

                                                    @case(4)
                                                        <button class="btn btn-sm btn-primary text-white mx-2" type="button"
                                                            title="Cancelar problema"
                                                            wire:click="cancelProblem({{ $product['id'] }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" class="lucide lucide-ban">
                                                                <circle cx="12" cy="12" r="10" />
                                                                <path d="m4.9 4.9 14.2 14.2" />
                                                            </svg>
                                                        </button>
                                                    @break

                                                    @default
                                                        <div class="h-12">&nbsp;</div>
                                                @endswitch
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @component('order-services.partials.modal-check-observation')
    @endcomponent

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
