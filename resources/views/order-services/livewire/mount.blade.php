<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Montar ordem de serviço
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('orderServices.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if ($orderService->budget->budget_version != $orderService->budget_version)
                <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal"
                    data-tw-target="#modal-orderservice-update-version" type="button">Atualizar Versão</button>
            @endif
            <button class="btn btn-primary shadow-md mr-2" wire:click="editObservation">Observações</button>
            <button class="btn btn-primary shadow-md mr-2" wire:click="editStatus">Status</button>
            <x-forms.buttons.primary route="orderServices.documents.index" :id="$orderService->id" label="Documentos" />
            <a href="{{ route('orderServices.print', $orderService->id) }}" target="_blank"
                class="btn btn-primary shadow-md mr-2">Imprimir</a>
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DETALHES</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Ordem de Serviço
                                Nº:</span>&nbsp;#{{ $orderService->budget->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Orçamento Nº:</span>&nbsp;#{{ $orderService->budget->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Versão
                                Nº:</span>&nbsp;#{{ $orderService->os_version }}&nbsp;&nbsp;
                            @if ($orderService->budget->budget_version == $orderService->budget_version)
                                <span class="bg-green-300 p-1 rounded text-xs font-medium">
                                    ATUALIZADA
                                </span>
                            @else
                                <span class="bg-red-300 p-1 rounded text-xs font-medium">
                                    DESATUALIZADA
                                </span>
                            @endif
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Nome do Evento:</span>&nbsp;{{ $orderService->budget->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Status:</span>&nbsp;{{ $orderService->osStatus->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Criado
                                por:</span>&nbsp;{{ $orderService->user_id ? $orderService->user->name : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Alterado
                                por:</span>&nbsp;{{ $orderService->last_user_id ? $orderService->lastUser->name : null }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DATAS</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Data da
                                solicitação:</span>&nbsp;{{ $orderService->budget->request_date->format('d/m/Y') }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Dias do
                                Evento:</span>&nbsp;{{ $orderService->budget->budget_days }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Montagem:</span>&nbsp;{{ $orderService->budget->mount_date ? $orderService->budget->mount_date->format('d/m/Y') : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Desmontagem:</span>&nbsp;{{ $orderService->budget->unmount_date ? $orderService->budget->unmount_date->format('d/m/Y') : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Local do
                                Evento:</span>&nbsp;{{ $orderService->budget->place->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Endereço do
                                Local:</span>&nbsp;{{ $orderService->budget->place->getfullAddress() }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">CLIENTE</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span
                                class="font-semibold">Nome:</span>&nbsp;{{ $orderService->budget->customer->fantasy_name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Contato - Nome:</span>&nbsp;
                            @if (!empty($orderService->budget->customerContact))
                                {{ $orderService->budget->customerContact->name }}
                            @endif
                        </div>
                        @if (!empty($orderService->budget->customerContact) && !empty($orderService->budget->customerContact->phone))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Contato - Telefone:</span>&nbsp;
                                {{ $orderService->budget->customerContact->phone }}
                            </div>
                        @endif
                        @if (!empty($orderService->budget->customerContact) && !empty($orderService->budget->customerContact->email))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Contato - E-mail:</span>&nbsp;
                                {{ $orderService->budget->customerContact->email }}
                            </div>
                        @endif
                        @if (!empty($orderService->budget->agency))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span
                                    class="font-semibold">Agência:</span>&nbsp;{{ $orderService->budget->agency->fantasy_name }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="intro-x col-span-12">
                <div class="font-medium text-center lg:text-left lg:mt-3">OBSERVAÇÕES</div>
                <div class="my-3">{!! nl2br($orderService->observation) !!}</div>
            </div>
        </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2" wire:ignore>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addProduct">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Equipamento
            </button>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addGroup">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Kit
            </button>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addProvider">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Fornecedor
            </button>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addFreelancer">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Freelancer
            </button>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if ($orderService->osStatus->slug == 'aprovado')
                <x-forms.buttons.primary route="orderServices.checks.index" :id="$orderService->id" label="Saída / Entrada" />
            @else
                <button type="button" class="btn btn-primary shadow-md mr-2" disabled>Saída / Entrada</button>
            @endif
        </div>

        <div class="intro-x col-span-12">

            @component('order-services.partials.table-product', [
                'orderService' => $orderService,
                'listProducts' => $listProducts,
                'placeRooms' => $placeRooms,
            ])
            @endcomponent

            @component('order-services.partials.table-group', [
                'orderService' => $orderService,
                'listGroups' => $listGroups,
                'placeRooms' => $placeRooms,
            ])
            @endcomponent

            @component('order-services.partials.table-provider', [
                'orderService' => $orderService,
                'listProviders' => $listProviders,
                'placeRooms' => $placeRooms,
            ])
            @endcomponent

            @component('order-services.partials.table-freelancer', [
                'orderService' => $orderService,
                'listFreelancers' => $listFreelancers,
                'placeRooms' => $placeRooms,
            ])
            @endcomponent
        </div>

        @component('order-services.partials.modal-product', [
            'osCategories' => $osCategories,
            'placeRooms' => $placeRooms,
        ])
        @endcomponent

        @component('order-services.partials.modal-group', [
            'groups' => $groups,
            'placeRooms' => $placeRooms,
        ])
        @endcomponent

        @component('order-services.partials.modal-freelancer', [
            'freelancers' => $freelancers,
            'placeRooms' => $placeRooms,
        ])
        @endcomponent

        @component('order-services.partials.modal-provider', [
            'providers' => $providers,
            'placeRooms' => $placeRooms,
        ])
        @endcomponent

        @component('order-services.partials.modal-status', [
            'osStatuses' => $osStatuses,
        ])
        @endcomponent

        @component('order-services.partials.modal-observation')
        @endcomponent

        @push('custom-scripts')
            <script type="text/javascript">
                window.livewire.on('subleaseError', () => {
                    document.getElementById('error-notification-title').innerHTML = "Atenção!";
                    document.getElementById('error-notification-message').innerHTML =
                        "Quantidade de equipamentos não disponível, a diferença foi adicionada a lista de sublocação!";

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
