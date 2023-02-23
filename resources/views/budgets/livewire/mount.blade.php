<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Montar orçamento
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('budgets.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <button class="btn btn-primary shadow-md mr-2" wire:click="addStatus">Status</button>
            <a href="{{ route('budgets.print', $budget->id) }}" target="_blank"
                class="btn btn-primary shadow-md mr-2">Imprimir</a>
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5">
            <div class="flex flex-col lg:flex-row border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DETALHES</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Orçamento Nº:</span>&nbsp;#{{ $budget->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Nome do Evento:</span>&nbsp;{{ $budget->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Local do Evento:</span>&nbsp;{{ $budget->place->name }}
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
                            <span class="font-semibold">Contato:</span>&nbsp;
                            @if (!empty($budget->customerContact))
                                {{ $budget->customerContact->name }}
                            @endif
                            @if (!empty($budget->customerContact))
                                @if (!empty($budget->customerContact->phone))
                                    - {{ $budget->customerContact->phone }}
                                @endif
                                @if (!empty($budget->customerContact->email))
                                    - {{ $budget->customerContact->email }}
                                @endif
                            @endif
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span
                                class="font-semibold">Agência:</span>&nbsp;{{ $budget->agency ? $budget->agency->fantasy_name : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2" wire:ignore>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addProduct">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Equipamento
            </button>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addLabor">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Mão de obra
            </button>
        </div>
        @if (count($rooms) > 0)
            @php
                $total = 0;
            @endphp
            <div class="intro-x col-span-12">
                @foreach ($rooms as $index => $room)
                    <h3 class="text-lg font-medium mr-auto">
                        {{ $room['place_room_name'] }}
                    </h3>
                    <div class="intro-y col-span-12 box px-5 pt-5 my-3">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">EQUIPAMENTO</th>
                                        @foreach ($room['days'] as $roomDate)
                                            <th class="whitespace-nowrap w-10">{{ $roomDate }}</th>
                                        @endforeach
                                        <th class="whitespace-nowrap w-10">VALOR</th>
                                        <th class="whitespace-nowrap w-10">QUANTIDADE</th>
                                        <th class="whitespace-nowrap w-10">TOTAL</th>
                                        <th class="whitespace-nowrap w-10">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($room['categories'] as $category)
                                        <tr class="bg-red-100">
                                            <td class="whitespace-nowrap font-medium">{{ $category['name'] }}</td>
                                            <td class="whitespace-nowrap" colspan="{{ count($room['days']) + 4 }}">
                                                &nbsp;</td>
                                        </tr>
                                        @foreach ($category['products'] as $product)
                                            @php
                                                $days = count(explode(',', $product['days']));
                                                $total += $product['quantity'] * $product['price'] * $days;
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">{{ $product['product']['name'] }}</td>
                                                @foreach ($room['days'] as $roomDate)
                                                    <td class="whitespace-nowrap">
                                                        @if (in_array($roomDate, explode(',', $product['days'])))
                                                            <x-forms.checkbox name="active" :checked="true"
                                                                wire:click="checkDayRoom({{ $product['id'] }}, '{{ $roomDate }}')" />
                                                        @else
                                                            <x-forms.checkbox name="active" :checked="false"
                                                                wire:click="checkDayRoom({{ $product['id'] }}, '{{ $roomDate }}')" />
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td class="whitespace-nowrap">
                                                    {{ number_format($product['price'], 2, ',', '.') }}
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    <x-forms.number name="quantity" min="1" :value="$product['quantity']"
                                                        wire:change="onChangeQuantity({{ $product['id'] }}, $event.target.value)" />
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    {{ number_format($product['quantity'] * $product['price'] * $days, 2, ',', '.') }}
                                                </td>
                                                <td class="whitespace-nowrap" wire:ignore>
                                                    <button
                                                        class="btn btn-sm btn-primary mr-1 mb-2 delete-confirmation-button"
                                                        data-action="{{ route('budgets.room.product.destroy', $product['id']) }}"
                                                        data-tw-toggle="modal"
                                                        data-tw-target="#delete-confirmation-modal" type="button">
                                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($category['labors'] as $labor)
                                            @php
                                                $days = $labor['days'];
                                                $total += $labor['quantity'] * $labor['price'] * $days;
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">{{ $labor['labor']['name'] }}</td>
                                                <td class="whitespace-nowrap" colspan="{{ count($room['days']) }}">
                                                    <div class="flex items-center justify-end">
                                                        <x-forms.number name="days" min="1" :value="$labor['days']"
                                                            class="form-control"
                                                            wire:change="onChangeLaborDays({{ $labor['id'] }}, $event.target.value)" />
                                                        &nbsp;&nbsp;diárias
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    {{ number_format($labor['price'], 2, ',', '.') }}
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    <x-forms.number name="quantity" min="1" :value="$labor['quantity']"
                                                        wire:change="onChangeLaborQuantity({{ $labor['id'] }}, $event.target.value)" />
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    {{ number_format($labor['quantity'] * $labor['price'] * $days, 2, ',', '.') }}
                                                </td>
                                                <td class="whitespace-nowrap" wire:ignore>
                                                    <button
                                                        class="btn btn-sm btn-primary mr-1 mb-2 delete-confirmation-button"
                                                        data-action="{{ route('budgets.room.labor.destroy', $labor['id']) }}"
                                                        data-tw-toggle="modal"
                                                        data-tw-target="#delete-confirmation-modal" type="button">
                                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
                <div class="intro-y col-span-12 box px-5 py-5 my-3">
                    <div class="text-lg font-medium text-right">
                        TOTAL: {{ number_format($total, 2, ',', '.') }}
                    </div>
                    @if (!empty($budget['discount']))
                        <div>
                            @if ($budget['discount_type'] == 'percent')
                                @php
                                    $percentage = $budget['discount'];
                                    
                                    $totalPercentage = ($percentage / 100) * $total;
                                @endphp
                                <div class="text-lg font-medium text-right">
                                    TOTAL COM DESCONTO DE: {{ number_format($total - $totalPercentage, 2, ',', '.') }}
                                </div>
                            @else
                                <div class="text-lg font-medium text-right">
                                    TOTAL COM DESCONTO DE:
                                    {{ number_format($total - $budget['discount'], 2, ',', '.') }}
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="flex justify-end mt-3">
                        @if (empty($budget['discount']))
                            <button type="button" class="btn btn-primary shadow-md" wire:click="addDiscount">
                                Aplicar desconto
                            </button>
                        @else
                            <button type="button" class="btn btn-primary shadow-md" wire:click="removeDiscount">
                                Remover desconto
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- BEGIN: Modal Content -->
    <div id="modal-budget-product" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Equipamento</h2>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body">
                    <div class="hidden" id="alert-product-error">
                        <div class="alert alert-danger show flex items-center mb-2" role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2">
                        <x-forms.select name="category_id" label="Categoria" :options="$categories"
                            wire:model="dataProduct.category_id"
                            wire:change="onSelectCategory($event.target.value)" />
                        <x-forms.select name="product_id" label="Equipamento" :options="[]"
                            wire:model="dataProduct.product_id" wire:change="onSelectProduct($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataProduct.place_room_id" />
                        <x-forms.text name="price" label="Preço" wire:model="dataProduct.price" />
                        <x-forms.number name="quantity" label="Quantidade" wire:model="dataProduct.quantity" />
                    </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveProduct">Salvar</button>
                </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div> <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="modal-budget-labor" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Adicionar Mão de obra</h2>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body">
                    <div class="hidden" id="alert-labor-error">
                        <div class="alert alert-danger show flex items-center mb-2" role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2">
                        <x-forms.select name="category_id" label="Categoria" :options="$categories"
                            wire:model="dataLabor.category_id"
                            wire:change="onSelectCategoryLabor($event.target.value)" />
                        <x-forms.select name="labor_id" label="Mão de obra" :options="[]"
                            wire:model="dataLabor.labor_id" wire:change="onSelectLabor($event.target.value)" />
                    </div>
                    <div class="sm:grid grid-cols-4 gap-2 mt-3">
                        <x-forms.select name="place_room_id" label="Sala" :options="$placeRooms"
                            wire:model="dataLabor.place_room_id" />
                        <x-forms.text name="labor_price" label="Preço" wire:model="dataLabor.price" />
                        <x-forms.number name="days" label="Diárias" wire:model="dataLabor.days" />
                        <x-forms.number name="quantity" label="Quantidade" wire:model="dataLabor.quantity" />
                    </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveLabor">Salvar</button>
                </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div> <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="modal-budget-discount" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Aplicar desconto</h2>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body">
                    <div class="hidden" id="alert-discount-error">
                        <div class="alert alert-danger show flex items-center mb-2" role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2">
                        <x-forms.select name="discount_type" label="Tipo de Desconto" :options="$discountTypes"
                            wire:model="dataDiscount.discount_type" />
                        <x-forms.text name="discount" label="Desconto" wire:model="dataDiscount.discount" />
                    </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveDiscount">Salvar</button>
                </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div> <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="modal-budget-status" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Alterar status</h2>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body">
                    <div class="hidden" id="alert-status-error">
                        <div class="alert alert-danger show flex items-center mb-2" role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> Preencha todos os campos abaixo
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.select name="status_id" label="Status" :options="$status"
                            wire:model="dataStatus.status_id" />
                    </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancelar</button>
                    <button type="button" class="btn btn-primary w-20" wire:click="saveStatus">Salvar</button>
                </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div> <!-- END: Modal Content -->

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetProduct = null;
            var modalBudgetLabor = null;
            var modalBudgetDiscount = null;
            var modalBudgetStatus = null;
            var selectProductId = null;
            var selectLaborId = null;
            var inputPrice = null;
            var inputLaborPrice = null;
            var alertProductError = null;
            var alertLaborError = null;
            var alertDiscountError = null;
            var alertStatusError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                selectProductId = document.getElementById('product_id').tomselect;
                selectLaborId = document.getElementById('labor_id').tomselect;
                inputPrice = document.getElementById('price');
                inputLaborPrice = document.getElementById('labor_price');
                alertProductError = document.getElementById('alert-product-error');
                alertLaborError = document.getElementById('alert-labor-error');
                alertDiscountError = document.getElementById('alert-discount-error');
                alertStatusError = document.getElementById('alert-status-error');
                modalBudgetProduct = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-product"));
                modalBudgetLabor = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-labor"));
                modalBudgetDiscount = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-discount"));
                modalBudgetStatus = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-status"));
            });

            window.livewire.on('addProduct', () => {
                modalBudgetProduct.show();
            });

            window.livewire.on('addLabor', () => {
                modalBudgetLabor.show();
            });

            window.livewire.on('addDiscount', () => {
                modalBudgetDiscount.show();
            });

            window.livewire.on('addStatus', () => {
                modalBudgetStatus.show();
            });

            window.livewire.on('updateProductList', (data) => {
                selectProductId.clear();
                selectProductId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProductId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
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

            window.livewire.on('updateProductPrice', (data) => {
                inputPrice.value = data;
            });

            window.livewire.on('updateLaborPrice', (data) => {
                inputLaborPrice.value = data;
            });

            window.livewire.on('saved', () => {
                window.location.reload();
            });

            window.livewire.on('productError', (show) => {
                if (show) {
                    alertProductError.classList.remove('hidden');
                } else {
                    alertProductError.classList.add('hidden');
                }
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
        </script>
    @endpush
</div>
