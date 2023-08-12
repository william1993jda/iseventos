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
            @if ($canEdit)
                <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-primary shadow-md mr-2">Editar</a>
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
                                Montagem:</span>&nbsp;{{ $budget->mount_date->format('d/m/Y') }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Desmontagem:</span>&nbsp;{{ $budget->unmount_date->format('d/m/Y') }}
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
            @php
                $total = 0;
            @endphp
            @if (!empty($listProducts['categories']))
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <h2 class="font-medium text-base mr-auto">EQUIPAMENTOS</h2>
                    <div class="hidden md:block mx-auto text-slate-500"></div>
                    @if ($canEdit && !empty($budget->place_id))
                        <button class="btn btn-primary shadow-md mr-2" onclick="applyBvProduct()">
                            Aplicar BV
                        </button>
                        <button class="btn btn-primary shadow-md mr-2" onclick="changeRoomProduct()">
                            Trocar sala
                        </button>
                    @else
                        <button class="btn btn-primary shadow-md mr-2" disabled>Aplicar BV</button>
                        <button class="btn btn-primary shadow-md mr-2" disabled>Trocar sala</button>
                    @endif
                </div>
                <div class="intro-y col-span-12 box px-5 pt-5 my-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">
                                    <input type="checkbox" name="checkbox_product" onclick="checkAllProduct()">
                                </th>
                                <th class="whitespace-nowrap">EQUIPAMENTO</th>
                                @foreach ($listProducts['days'] as $day)
                                    <th class="whitespace-nowrap w-10">{{ $day }}</th>
                                @endforeach
                                <th class="whitespace-nowrap text-center w-10">SALA</th>
                                <th class="whitespace-nowrap text-center w-10">QUANTIDADE</th>
                                <th class="whitespace-nowrap text-center w-10">BV %</th>
                                <th class="whitespace-nowrap text-center w-10">VALOR</th>
                                <th class="whitespace-nowrap text-center w-10">TOTAL</th>
                                <th class="whitespace-nowrap w-10">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listProducts['categories'] as $category)
                                <tr class="bg-red-100">
                                    <td class="whitespace-nowrap">&nbsp;</td>
                                    <td class="whitespace-nowrap font-medium">
                                        {{ $category['name'] }}
                                    </td>
                                    <td class="whitespace-nowrap" colspan="{{ count($listProducts['days']) + 6 }}">
                                        &nbsp;</td>
                                </tr>
                                @foreach ($category['products'] as $product)
                                    @php
                                        $days = count(explode(',', $product['days']));
                                        $total += $product['quantity'] * $product['price'] * $days;
                                    @endphp
                                    <tr>
                                        <td class="whitespace-nowrap w-4">
                                            <input type="checkbox" class="checkbox_product"
                                                value="{{ $product['id'] }}">
                                        </td>
                                        <td class="whitespace">{{ $product['name'] }}</td>
                                        @foreach ($listProducts['days'] as $day)
                                            <td class="whitespace-nowrap">
                                                @if ($canEdit)
                                                    @if (in_array($day, explode(',', $product['days'])))
                                                        <x-forms.checkbox name="active" :checked="true"
                                                            wire:click="checkDayRoom({{ $product['id'] }}, '{{ $day }}')" />
                                                    @else
                                                        <x-forms.checkbox name="active" :checked="false"
                                                            wire:click="checkDayRoom({{ $product['id'] }}, '{{ $day }}')" />
                                                    @endif
                                                @else
                                                    @if (in_array($day, explode(',', $product['days'])))
                                                        <x-forms.checkbox name="active" :checked="true" disabled />
                                                    @else
                                                        <x-forms.checkbox name="active" :checked="false" disabled />
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="whitespace-nowrap w-48">
                                            <select name="place_room_id" class="form-control w-full"
                                                wire:change="onChangeProductRoom({{ $product['id'] }}, $event.target.value)">
                                                <option value="">Selecione</option>
                                                @foreach ($placeRooms as $placeRoomId => $placeRoomName)
                                                    @if ($placeRoomId == $product['place_room_id'])
                                                        <option value="{{ $placeRoomId }}" selected>
                                                            {{ $placeRoomName }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $placeRoomId }}">
                                                            {{ $placeRoomName }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            @if ($canEdit)
                                                <x-forms.number name="quantity_product_{{ $product['id'] }}"
                                                    min="1" :value="$product['quantity']"
                                                    wire:change="onChangeQuantity({{ $product['id'] }}, $event.target.value)" />
                                            @else
                                                <x-forms.number name="quantity_product_{{ $product['id'] }}"
                                                    min="1" :value="$product['quantity']" disabled />
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ number_format($product['bv'], 2, ',', '.') }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ number_format($product['price'], 2, ',', '.') }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ number_format($product['quantity'] * $product['price'] * $days, 2, ',', '.') }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            @if ($canEdit)
                                                <button class="btn btn-sm btn-primary delete-confirmation-button"
                                                    type="button"
                                                    wire:click="confirmProductRemove({{ $product['id'] }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="lucide lucide-trash-2 w-5 h-5">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                        <line x1="10" x2="10" y1="11"
                                                            y2="17" />
                                                        <line x1="14" x2="14" y1="11"
                                                            y2="17" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-primary delete-confirmation-button"
                                                    type="button" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="lucide lucide-trash-2 w-5 h-5">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                        <line x1="10" x2="10" y1="11"
                                                            y2="17" />
                                                        <line x1="14" x2="14" y1="11"
                                                            y2="17" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (!empty($listLabors))
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-10">
                    <h2 class="font-medium text-base mr-auto">MÃO DE OBRA</h2>
                    <div class="hidden md:block mx-auto text-slate-500"></div>
                    @if ($canEdit && !empty($budget->place_id))
                        <button class="btn btn-primary shadow-md mr-2" onclick="applyBvLabor()">
                            Aplicar BV
                        </button>
                        <button class="btn btn-primary shadow-md mr-2" onclick="changeRoomLabor()">
                            Trocar sala
                        </button>
                    @else
                        <button class="btn btn-primary shadow-md mr-2" disabled>Aplicar BV</button>
                        <button class="btn btn-primary shadow-md mr-2" disabled>Trocar sala</button>
                    @endif
                </div>
                <div class="intro-y col-span-12 box px-5 pt-5 my-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">
                                    <input type="checkbox" name="checkbox_labor" onclick="checkAllLabor()">
                                </th>
                                <th class="whitespace-nowrap">MÃO DE OBRA</th>
                                <th class="whitespace-nowrap text-center w-10">SALA</th>
                                <th class="whitespace-nowrap text-center w-10">DIAS</th>
                                <th class="whitespace-nowrap text-center w-10">QUANTIDADE</th>
                                <th class="whitespace-nowrap text-center w-10">BV %</th>
                                <th class="whitespace-nowrap text-center w-10">VALOR</th>
                                <th class="whitespace-nowrap text-center w-10">TOTAL</th>
                                <th class="whitespace-nowrap w-10">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listLabors as $labor)
                                @php
                                    $total += $labor['quantity'] * $labor['price'] * $labor['days'];
                                @endphp
                                <tr>
                                    <td class="whitespace-nowrap w-4">
                                        <input type="checkbox" class="checkbox_labor" value="{{ $labor['id'] }}">
                                    </td>
                                    <td class="whitespace">{{ $labor['name'] }}</td>
                                    <td class="whitespace-nowrap w-48">
                                        <select name="place_room_id" class="form-control w-full"
                                            wire:change="onChangeLaborRoom({{ $labor['id'] }}, $event.target.value)">
                                            <option value="">Selecione</option>
                                            @foreach ($placeRooms as $placeRoomId => $placeRoomName)
                                                @if ($placeRoomId == $labor['place_room_id'])
                                                    <option value="{{ $placeRoomId }}" selected>
                                                        {{ $placeRoomName }}
                                                    </option>
                                                @else
                                                    <option value="{{ $placeRoomId }}">
                                                        {{ $placeRoomName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="whitespace-nowrap w-28">
                                        @if ($canEdit)
                                            <x-forms.number name="days_labor_{{ $labor['id'] }}" min="1"
                                                :value="$labor['days']"
                                                wire:change="onChangeLaborDays({{ $labor['id'] }}, $event.target.value)" />
                                        @else
                                            <x-forms.number name="days_labor_{{ $labor['id'] }}" min="1"
                                                :value="$product['days']" disabled />
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap w-28">
                                        @if ($canEdit)
                                            <x-forms.number name="quantity_labor_{{ $labor['id'] }}" min="1"
                                                :value="$labor['quantity']"
                                                wire:change="onChangeLaborQuantity({{ $labor['id'] }}, $event.target.value)" />
                                        @else
                                            <x-forms.number name="quantity_labor_{{ $labor['id'] }}" min="1"
                                                :value="$product['quantity']" disabled />
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ number_format($labor['bv'], 2, ',', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ number_format($labor['price'], 2, ',', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ number_format($labor['quantity'] * $labor['price'] * $labor['days'], 2, ',', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($canEdit)
                                            <button class="btn btn-sm btn-primary delete-confirmation-button"
                                                type="button" wire:click="confirmLaborRemove({{ $labor['id'] }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-trash-2 w-5 h-5">
                                                    <path d="M3 6h18" />
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    <line x1="10" x2="10" y1="11"
                                                        y2="17" />
                                                    <line x1="14" x2="14" y1="11"
                                                        y2="17" />
                                                </svg>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary delete-confirmation-button"
                                                type="button" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-trash-2 w-5 h-5">
                                                    <path d="M3 6h18" />
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    <line x1="10" x2="10" y1="11"
                                                        y2="17" />
                                                    <line x1="14" x2="14" y1="11"
                                                        y2="17" />
                                                </svg>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="intro-y col-span-12 box px-5 py-5 my-3">
                <div class="text-l font-medium text-right">
                    SUBTOTAL: R$ {{ number_format($total, 2, ',', '.') }}
                </div>

                @php
                    $subtotal = $total;
                    $totalFee = 0;
                    $totalDiscount = 0;
                @endphp

                @if (!empty($budget['fee']))
                    <div>
                        @if ($budget['fee_type'] == 'percent')
                            @php
                                $feePercentage = $budget['fee'];
                                $totalFeePercentage = ($feePercentage / 100) * $total;
                                $totalFee = $totalFeePercentage;
                            @endphp
                            <div class="text-l font-medium text-right">
                                <span class="text-green-500">TAXA DO CARTÃO ({{ $budget['fee'] }}%): R$
                                    {{ number_format($totalFeePercentage, 2, ',', '.') }}</span>
                            </div>
                        @else
                            @php
                                $totalFee = $budget['fee'];
                            @endphp
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
                            @php
                                $discountPercentage = $budget['discount'];
                                $totalDiscountPercentage = ($discountPercentage / 100) * $total;
                                $totalDiscount = $totalDiscountPercentage;
                            @endphp
                            <div class="text-l font-medium text-right">
                                <span class="text-red-500">DESCONTO ({{ $budget['discount'] }}%): R$
                                    {{ number_format($totalDiscountPercentage, 2, ',', '.') }}</span>
                            </div>
                        @else
                            @php
                                $totalDiscount = $budget['discount'];
                            @endphp
                            <div class="text-l font-medium text-right">
                                <span class="text-red-500">DESCONTO (R$
                                    {{ number_format($budget['discount'], 2, ',', '.') }}): R$
                                    {{ number_format($budget['discount'], 2, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                @php
                    $total = $subtotal - $totalDiscount + $totalFee;
                @endphp
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
