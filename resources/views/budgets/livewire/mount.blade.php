<div>
    <style>
        .table th,
        .table td {
            padding: 0.75rem;
        }
    </style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Montar orçamento
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('budgets.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-primary shadow-md mr-2">Editar</a>
            @if ($canEdit)
                <button class="btn btn-primary shadow-md mr-2" wire:click="editObservation">Observações</button>
                <button class="btn btn-primary shadow-md mr-2" wire:click="editStatus">Status</button>
            @else
                <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal"
                    data-tw-target="#budget-new-version-modal" type="button">Nova versão</button>
                <button class="btn btn-primary shadow-md mr-2" disabled>Observações</button>
                <button class="btn btn-primary shadow-md mr-2" disabled>Status</button>
            @endif
            <x-forms.buttons.primary route="budgets.documents.index" :id="$budget->id" label="Documentos" />
            <a href="{{ route('budgets.print', $budget->id) }}" target="_blank"
                class="btn btn-primary shadow-md">Imprimir</a>
        </div>
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
                            <span class="font-semibold">Status:</span>&nbsp;{{ $budget->status->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Criado
                                por:</span>&nbsp;{{ $budget->user_id ? $budget->user->name : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Alterado
                                por:</span>&nbsp;{{ $budget->last_user_id ? $budget->lastUser->name : null }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DATAS E LOCAL</div>
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
                                Montagem:</span>&nbsp;{{ $budget->mount_date ? $budget->mount_date->format('d/m/Y') : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Desmontagem:</span>&nbsp;{{ $budget->unmount_date ? $budget->unmount_date->format('d/m/Y') : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">
                                Local do Evento:</span>&nbsp;{{ $budget->place_id ? $budget->place->name : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">
                                Endereço do
                                Local:</span>&nbsp;{{ $budget->place_id ? $budget->place->getfullAddress() : null }}
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
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @if ($canEdit)
                <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addProduct">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus-square w-4 h-4 text-white mr-2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M8 12h8" />
                        <path d="M12 8v8" />
                    </svg>
                    Equipamento
                </button>
                <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addLabor">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus-square w-4 h-4 text-white mr-2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M8 12h8" />
                        <path d="M12 8v8" />
                    </svg>
                    Mão de obra
                </button>
            @else
                <button type="button" class="btn btn-primary shadow-md mr-2" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus-square w-4 h-4 text-white mr-2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M8 12h8" />
                        <path d="M12 8v8" />
                    </svg>
                    Equipamento
                </button>
                <button type="button" class="btn btn-primary shadow-md mr-2" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus-square w-4 h-4 text-white mr-2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M8 12h8" />
                        <path d="M12 8v8" />
                    </svg>
                    Mão de obra
                </button>
            @endif
        </div>

        <div class="intro-x col-span-12">
            @component('budgets.partials.table-product', [
                'budget' => $budget,
                'listProducts' => $listProducts,
                'placeRooms' => $placeRooms,
                'total' => $total,
                'canEdit' => $canEdit,
            ])
            @endcomponent

            @component('budgets.partials.table-labor', [
                'budget' => $budget,
                'listLabors' => $listLabors,
                'placeRooms' => $placeRooms,
                'total' => $total,
                'canEdit' => $canEdit,
            ])
            @endcomponent


            <div class="intro-y col-span-12 box px-5 py-5 my-3">
                <div class="text-l font-medium text-right">
                    SUBTOTAL: R$ {{ number_format($subtotal, 2, ',', '.') }}
                </div>

                @if (!empty($budget['fee']))
                    <div>
                        @if ($budget['fee_type'] == 'percent')
                            <div class="text-l font-medium text-right">
                                <span class="text-green-500">TAXA DO CARTÃO ({{ $budget['fee'] }}%): R$
                                    {{ number_format($totalFeePercentage, 2, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="text-l font-medium text-right">
                                <span class="text-green-500">TAXA DO CARTÃO (R$
                                    {{ number_format($budget['fee'], 2, ',', '.') }}): R$
                                    {{ number_format($budget['fee'], 2, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                @endif
                @if (!empty($budget['discount']))
                    <div>
                        @if ($budget['discount_type'] == 'percent')
                            <div class="text-l font-medium text-right">
                                <span class="text-red-500">DESCONTO ({{ $budget['discount'] }}%): R$
                                    {{ number_format($totalDiscountPercentage, 2, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="text-l font-medium text-right">
                                <span class="text-red-500">DESCONTO (R$
                                    {{ number_format($budget['discount'], 2, ',', '.') }}): R$
                                    {{ number_format($budget['discount'], 2, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <hr class="my-2">
                <div class="text-lg font-medium text-right">
                    <span>TOTAL: R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-end mt-3">
                    @if ($canEdit)
                        @if (empty($budget['fee']))
                            <button type="button" class="btn btn-primary shadow-md" wire:click="addFee">
                                Aplicar taxa do cartão
                            </button>
                        @else
                            <button type="button" class="btn btn-primary shadow-md" wire:click="removeFee">
                                Remover taxa do cartão
                            </button>
                        @endif
                        @if (empty($budget['discount']))
                            <button type="button" class="btn btn-primary shadow-md ml-2" wire:click="addDiscount">
                                Aplicar desconto
                            </button>
                        @else
                            <button type="button" class="btn btn-primary shadow-md ml-2"
                                wire:click="removeDiscount">
                                Remover desconto
                            </button>
                        @endif
                    @else
                        @if (empty($budget['fee']))
                            <button type="button" class="btn btn-primary shadow-md" disabled>
                                Aplicar taxa do cartão
                            </button>
                        @else
                            <button type="button" class="btn btn-primary shadow-md" disabled>
                                Remover taxa do cartão
                            </button>
                        @endif
                        @if (empty($budget['discount']))
                            <button type="button" class="btn btn-primary shadow-md ml-2" disabled>
                                Aplicar desconto
                            </button>
                        @else
                            <button type="button" class="btn btn-primary shadow-md ml-2" disabled>
                                Remover desconto
                            </button>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>

    @component('budgets.partials.modal-observation')
    @endcomponent
    @component('budgets.partials.modal-new-version')
    @endcomponent
    @component('budgets.partials.modal-status', ['status' => $status])
    @endcomponent
    @component('budgets.partials.modal-product', ['categories' => $categories, 'placeRooms' => $placeRooms])
    @endcomponent
    @component('budgets.partials.modal-labor', ['labors' => $labors, 'placeRooms' => $placeRooms])
    @endcomponent
    @component('budgets.partials.modal-change-room-product', ['placeRooms' => $placeRooms])
    @endcomponent
    @component('budgets.partials.modal-change-room-labor', ['placeRooms' => $placeRooms])
    @endcomponent
    @component('budgets.partials.modal-apply-bv-product')
    @endcomponent
    @component('budgets.partials.modal-apply-bv-labor')
    @endcomponent
    @component('budgets.partials.modal-fee', ['feeDiscountTypes' => $feeDiscountTypes])
    @endcomponent
    @component('budgets.partials.modal-discount', ['feeDiscountTypes' => $feeDiscountTypes])
    @endcomponent
</div>
