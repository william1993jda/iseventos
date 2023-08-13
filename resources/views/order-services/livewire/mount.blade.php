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
            <x-forms.buttons.primary route="orderServices.checks.index" :id="$orderService->id" label="Saída / Entrada" />
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
                            <span class="font-semibold">Local do
                                Evento:</span>&nbsp;{{ $orderService->budget->place->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Endereço do
                                Local:</span>&nbsp;{{ $orderService->budget->place->getfullAddress() }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Status:</span>&nbsp;{{ $orderService->osStatus->name }}
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
                                Montagem:</span>&nbsp;{{ $orderService->budget->mount_date->format('d/m/Y') }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Desmontagem:</span>&nbsp;{{ $orderService->budget->unmount_date->format('d/m/Y') }}
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
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addKit">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Kit
            </button>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addFreelancer">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Freelancer
            </button>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="addProvider">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Fornecedor
            </button>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <button type="button" class="btn btn-primary shadow-md mr-2" wire:click="listPrintProviders">
                <i class="w-4 h-4 text-white mr-2" data-lucide="plus-square"></i>Pedidos Fornecedor
            </button>
        </div>

        <div class="intro-x col-span-12">

            @component('order-services.partials.table-product', [
                'orderService' => $orderService,
                'listProducts' => $listProducts,
                'placeRooms' => $placeRooms,
            ])
            @endcomponent

            @if (count($rooms) > 0)
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
                                        <th class="whitespace-nowrap w-10">QUANTIDADE</th>
                                        <th class="whitespace-nowrap w-10">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($room['categories'] as $category)
                                        <tr class="bg-red-100">
                                            <td class="whitespace-nowrap font-medium">{{ $category['name'] }}</td>
                                            <td class="whitespace-nowrap" colspan="{{ count($room['days']) + 2 }}">
                                                &nbsp;</td>
                                        </tr>
                                        @foreach ($category['products'] as $product)
                                            @php
                                                $days = count(explode(',', $product['days']));
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">{{ $product['os_product']['name'] }}
                                                </td>
                                                @foreach ($room['days'] as $roomDate)
                                                    <td class="whitespace-nowrap">
                                                        @if (in_array($roomDate, explode(',', $product['days'])))
                                                            <x-forms.checkbox name="active" :checked="true"
                                                                wire:click="checkDayRoomProduct({{ $product['id'] }}, '{{ $roomDate }}')" />
                                                        @else
                                                            <x-forms.checkbox name="active" :checked="false"
                                                                wire:click="checkDayRoomProduct({{ $product['id'] }}, '{{ $roomDate }}')" />
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td class="whitespace-nowrap">
                                                    <x-forms.number name="quantity" min="1" :value="$product['quantity']"
                                                        wire:change="onChangeQuantityProduct({{ $product['id'] }}, $event.target.value)" />
                                                </td>
                                                <td class="whitespace-nowrap" wire:ignore>
                                                    <button
                                                        class="btn btn-sm btn-primary mr-1 mb-2 delete-confirmation-button"
                                                        data-action="{{ route('orderServices.room.product.destroy', $product['id']) }}"
                                                        data-tw-toggle="modal"
                                                        data-tw-target="#delete-confirmation-modal" type="button">
                                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($category['providers'] as $provider)
                                            @php
                                                $days = count(explode(',', $provider['days']));
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">
                                                    <div class="font-medium">
                                                        {{ $provider['os_product']['provider']['fantasy_name'] }}
                                                    </div>
                                                    {{ $provider['os_product']['name'] }}
                                                </td>
                                                @foreach ($room['days'] as $roomDate)
                                                    <td class="whitespace-nowrap">
                                                        @if (in_array($roomDate, explode(',', $provider['days'])))
                                                            <x-forms.checkbox name="active" :checked="true"
                                                                wire:click="checkDayRoomProvider({{ $provider['id'] }}, '{{ $roomDate }}')" />
                                                        @else
                                                            <x-forms.checkbox name="active" :checked="false"
                                                                wire:click="checkDayRoomProvider({{ $provider['id'] }}, '{{ $roomDate }}')" />
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td class="whitespace-nowrap">
                                                    <x-forms.number name="quantity" min="1" :value="$provider['quantity']"
                                                        wire:change="onChangeQuantityProvider({{ $provider['id'] }}, $event.target.value)" />
                                                </td>
                                                <td class="whitespace-nowrap" wire:ignore>
                                                    <button
                                                        class="btn btn-sm btn-primary mr-1 mb-2 delete-confirmation-button"
                                                        data-action="{{ route('orderServices.room.provider.destroy', $provider['id']) }}"
                                                        data-tw-toggle="modal"
                                                        data-tw-target="#delete-confirmation-modal" type="button">
                                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($category['groups'] as $group)
                                            @php
                                                $days = count(explode(',', $group['days']));
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">
                                                    <div class="font-medium">
                                                        {{ $group['group']['name'] }}
                                                    </div>
                                                    <ul>
                                                        @foreach ($group['group']['products'] as $product)
                                                            <li>{{ $product['name'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                @foreach ($room['days'] as $roomDate)
                                                    <td class="whitespace-nowrap">
                                                        @if (in_array($roomDate, explode(',', $group['days'])))
                                                            <x-forms.checkbox name="active" :checked="true"
                                                                wire:click="checkDayRoomGroup({{ $group['id'] }}, '{{ $roomDate }}')" />
                                                        @else
                                                            <x-forms.checkbox name="active" :checked="false"
                                                                wire:click="checkDayRoomGroup({{ $group['id'] }}, '{{ $roomDate }}')" />
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td class="whitespace-nowrap">
                                                    <x-forms.number name="quantity" min="1" :value="$group['quantity']"
                                                        wire:change="onChangeQuantityGroup({{ $group['id'] }}, $event.target.value)" />
                                                </td>
                                                <td class="whitespace-nowrap" wire:ignore>
                                                    <button
                                                        class="btn btn-sm btn-primary mr-1 mb-2 delete-confirmation-button"
                                                        data-action="{{ route('orderServices.room.provider.destroy', $group['id']) }}"
                                                        data-tw-toggle="modal"
                                                        data-tw-target="#delete-confirmation-modal" type="button">
                                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($category['freelancers'] as $freelancer)
                                            @php
                                                $days = count(explode(',', $freelancer['days']));
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">
                                                    <div class="font-medium">
                                                        {{ $freelancer['freelancer']['name'] }}
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap" colspan="{{ count($room['days']) }}">
                                                    <div class="flex items-center justify-end">
                                                        <x-forms.number name="days" min="1"
                                                            :value="$freelancer['days']" class="form-control"
                                                            wire:change="onChangeFreelancerDays({{ $freelancer['id'] }}, $event.target.value)" />
                                                        &nbsp;&nbsp;diárias
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    <x-forms.number name="quantity" min="1" :value="$freelancer['quantity']"
                                                        wire:change="onChangeFreelancerQuantity({{ $freelancer['id'] }}, $event.target.value)" />
                                                </td>
                                                <td class="whitespace-nowrap" wire:ignore>
                                                    <button
                                                        class="btn btn-sm btn-primary mr-1 mb-2 delete-confirmation-button"
                                                        data-action="{{ route('orderServices.room.freelancer.destroy', $freelancer['id']) }}"
                                                        data-tw-toggle="modal"
                                                        data-tw-target="#delete-confirmation-modal" type="button">
                                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- @foreach ($category['labors'] as $labor)
                                            @php
                                                $days = $labor['days'];
                                                $total += $labor['quantity'] * $labor['price'] * $days;
                                            @endphp
                                            <tr>
                                                <td class="whitespace-nowrap">{{ $labor['labor']['name'] }}</td>
                                                <td class="whitespace-nowrap" colspan="{{ count($room['days']) }}">
                                                    <div class="flex items-center justify-end">
                                                        <x-forms.number name="days" min="1"
                                                            :value="$labor['days']" class="form-control"
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
                                        @endforeach --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
        </div>
        @endif

    </div>

    @component('order-services.partials.modal-product', [
        'osCategories' => $osCategories,
        'placeRooms' => $placeRooms,
    ])
    @endcomponent

    @component('order-services.partials.modal-kit', [
        'groups' => $groups,
        'placeRooms' => $placeRooms,
    ])
    @endcomponent

    {{-- @include('order-services.partials.modal-product')
    @include('order-services.partials.modal-labor')
    @include('order-services.partials.modal-freelancer')
    @include('order-services.partials.modal-provider')
    @include('order-services.partials.modal-kit')
    @include('order-services.partials.modal-status')
    @include('order-services.partials.modal-observation')
    @include('order-services.partials.modal-print-provider')
    @include('order-services.partials.modal-update-version')

    @push('custom-scripts')
        <script type="text/javascript">
            var modalOrderServiceProduct = null;
            var modalOrderServiceLabor = null;
            var modalOrderServiceFreelancer = null;
            var modalOrderServiceProvider = null;
            var modalOrderServiceKit = null;
            var modalOrderServiceStatus = null;
            var modalOrderServiceObservation = null;
            var modalOrderServicePrintProvider = null;
            var selectOsCategoryId = null;
            var selectCategoryId = null;
            var selectProductId = null;
            var selectLaborId = null;
            var selectFreelancerId = null;
            var selectProviderId = null;
            var selectProviderCategoryId = null;
            var selectProviderProductId = null;
            var selectGroupId = null;
            var alertProductError = null;
            var alertLaborError = null;
            var alertFreelancerError = null;
            var alertProviderError = null;
            var alertKitError = null;
            var alertStatusError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                selectOsCategoryId = document.getElementById('os_category_id').tomselect;
                selectCategoryId = document.getElementById('category_id').tomselect;
                selectProductId = document.getElementById('product_id').tomselect;
                selectLaborId = document.getElementById('labor_id').tomselect;
                selectFreelancerId = document.getElementById('freelancer_id').tomselect;
                selectProviderId = document.getElementById('provider_id').tomselect;
                selectProviderCategoryId = document.getElementById('provider_category_id').tomselect;
                selectProviderProductId = document.getElementById('provider_product_id').tomselect;
                selectGroupId = document.getElementById('group_id').tomselect;
                alertProductError = document.getElementById('alert-product-error');
                alertLaborError = document.getElementById('alert-labor-error');
                alertFreelancerError = document.getElementById('alert-freelancer-error');
                alertProviderError = document.getElementById('alert-provider-error');
                alertKitError = document.getElementById('alert-kit-error');
                alertStatusError = document.getElementById('alert-status-error');
                modalOrderServiceProduct = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-product"));
                modalOrderServiceLabor = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-labor"));
                modalOrderServiceFreelancer = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-freelancer"));
                modalOrderServiceProvider = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-provider"));
                modalOrderServiceKit = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-kit"));
                modalOrderServiceStatus = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-status"));
                modalOrderServiceObservation = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-observation"));
                modalOrderServicePrintProvider = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-orderservice-print-provider"));
            });

            window.livewire.on('addProduct', (data) => {
                selectOsCategoryId.clear();
                selectOsCategoryId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectOsCategoryId.addOption({
                        value: key,
                        text: data[key]
                    });
                });

                modalOrderServiceProduct.show();
            });

            window.livewire.on('addLabor', (data) => {
                selectCategoryId.clear();
                selectCategoryId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectCategoryId.addOption({
                        value: key,
                        text: data[key]
                    });
                });

                modalOrderServiceLabor.show();
            });

            window.livewire.on('addFreelancer', (data) => {
                selectFreelancerId.clear();
                selectFreelancerId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectFreelancerId.addOption({
                        value: key,
                        text: data[key]
                    });
                });

                modalOrderServiceFreelancer.show();
            });

            window.livewire.on('addProvider', (data) => {
                selectProviderId.clear();
                selectProviderId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProviderId.addOption({
                        value: key,
                        text: data[key]
                    });
                });

                modalOrderServiceProvider.show();
            });

            window.livewire.on('addKit', (data) => {
                selectGroupId.clear();
                selectGroupId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectGroupId.addOption({
                        value: key,
                        text: data[key]
                    });
                });

                modalOrderServiceKit.show();
            });

            window.livewire.on('editStatus', () => {
                modalOrderServiceStatus.show();
            });

            window.livewire.on('editObservation', () => {
                modalOrderServiceObservation.toggle();
            });

            window.livewire.on('showPrintProviders', () => {
                modalOrderServicePrintProvider.toggle();
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

            window.livewire.on('updateProviderCategoryList', (data) => {
                selectProviderCategoryId.clear();
                selectProviderCategoryId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProviderCategoryId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });

            window.livewire.on('updateProviderProductList', (data) => {
                selectProviderProductId.clear();
                selectProviderProductId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProviderProductId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
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

            window.livewire.on('providerError', (show) => {
                if (show) {
                    alertProviderError.classList.remove('hidden');
                } else {
                    alertProviderError.classList.add('hidden');
                }
            });

            window.livewire.on('groupError', (show) => {
                if (show) {
                    alertKitError.classList.remove('hidden');
                } else {
                    alertKitError.classList.add('hidden');
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
    @endpush --}}
</div>
