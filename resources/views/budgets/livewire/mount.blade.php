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
                <button class="btn btn-primary shadow-md mr-2" wire:click="editObservation">Observações</button>
                <button class="btn btn-primary shadow-md mr-2" wire:click="addStatus">Status</button>
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
                    @if ($canEdit)
                        <button class="btn btn-primary shadow-md mr-2" onclick="changeRoom()">Trocar sala</button>
                    @else
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
                                    <td class="whitespace-nowrap" colspan="{{ count($listProducts['days']) + 5 }}">
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
                                        <td class="whitespace">{{ $product['product']['name'] }}</td>
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
                                                wire:change="onChangeRoom({{ $product['id'] }}, $event.target.value)">
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
        </div>

    </div>

    <div id="modal-budget-change-room" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Seleciona a sala abaixo</h2>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataRoom.place_room_id" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" onclick="saveChangeRoom()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Budget New Version Modal -->
    <div id="budget-new-version-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="copy-plus" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Gerar nova versão?</div>
                        <div class="text-slate-500 mt-2">
                            Tem certeza que gerar uma nova versão desse orçamento?
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Não</button>
                        <button type="submit" class="btn btn-primary w-24"
                            wire:click="generateNewVersion">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Budget New Version Modal -->

    @component('budgets.partials.modal-product', ['categories' => $categories, 'placeRooms' => $placeRooms])
    @endcomponent

    {{-- @include('budgets.partials.modal-product')
    @include('budgets.partials.modal-labor')
    @include('budgets.partials.modal-fee')
    @include('budgets.partials.modal-discount')
    @include('budgets.partials.modal-status')
    @include('budgets.partials.modal-observation') --}}

    @push('custom-scripts')
        <script type="text/javascript">
            var modalChangeRoom = null;
            var modalBudgetLabor = null;
            var modalBudgetFee = null;
            var modalBudgetDiscount = null;
            var modalBudgetStatus = null;
            var modalBudgetObservation = null;
            var selectLaborId = null;
            var inputLaborPrice = null;
            var alertLaborError = null;
            var alertFeeError = null;
            var alertDiscountError = null;
            var alertStatusError = null;

            function checkAllProduct() {
                if ($('input[name="checkbox_product"]').is(':checked')) {
                    for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                        $('input[class="checkbox_product"]')[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                        $('input[class="checkbox_product"]')[i].checked = false;
                    }
                }
            }

            function changeRoom() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    modalChangeRoom.show();
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

            function saveChangeRoom() {
                var products = [];
                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    if ($('input[class="checkbox_product"]')[i].checked) {
                        products.push($('input[class="checkbox_product"]')[i].value);
                    }
                }
                if (products.length > 0) {
                    @this.saveChangeRoom(products);
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
                modalChangeRoom = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-change-room"));


                // selectLaborId = document.getElementById('labor_id').tomselect;
                // inputLaborPrice = document.getElementById('labor_price');

                // alertLaborError = document.getElementById('alert-labor-error');
                // alertFeeError = document.getElementById('alert-fee-error');
                // alertDiscountError = document.getElementById('alert-discount-error');
                // alertStatusError = document.getElementById('alert-status-error');

                // modalBudgetLabor = tailwind.Modal.getInstance(document.querySelector(
                //     "#modal-budget-labor"));
                // modalBudgetFee = tailwind.Modal.getInstance(document.querySelector(
                //     "#modal-budget-fee"));
                // modalBudgetDiscount = tailwind.Modal.getInstance(document.querySelector(
                //     "#modal-budget-discount"));
                // modalBudgetStatus = tailwind.Modal.getInstance(document.querySelector(
                //     "#modal-budget-status"));
                // modalBudgetObservation = tailwind.Modal.getInstance(document.querySelector(
                //     "#modal-budget-observation"));
            });

            window.livewire.on('addLabor', () => {
                modalBudgetLabor.show();
            });

            window.livewire.on('addFee', () => {
                modalBudgetFee.show();
            });

            window.livewire.on('addDiscount', () => {
                modalBudgetDiscount.show();
            });

            window.livewire.on('addStatus', () => {
                modalBudgetStatus.show();
            });

            window.livewire.on('editObservation', () => {
                modalBudgetObservation.toggle();
            });

            window.livewire.on('updateLaborList', (data) => {
                selectLaborId.clear();
                selectLaborId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectLaborId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });

            window.livewire.on('updateLaborPrice', (data) => {
                inputLaborPrice.value = data;
            });

            window.livewire.on('laborError', (show) => {
                if (show) {
                    alertLaborError.classList.remove('hidden');
                } else {
                    alertLaborError.classList.add('hidden');
                }
            });

            window.livewire.on('discountError', (show) => {
                if (show) {
                    alertDiscountError.classList.remove('hidden');
                } else {
                    alertDiscountError.classList.add('hidden');
                }
            });

            window.livewire.on('statusError', (show) => {
                if (show) {
                    alertStatusError.classList.remove('hidden');
                } else {
                    alertStatusError.classList.add('hidden');
                }
            });

            window.livewire.on('roomChanged', () => {
                modalChangeRoom.hide();

                for (var i = 0; i < $('input[class="checkbox_product"]').length; i++) {
                    $('input[class="checkbox_product"]')[i].checked = false;
                }
            });
        </script>
    @endpush
</div>
