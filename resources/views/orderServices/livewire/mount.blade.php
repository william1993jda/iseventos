<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Montar Ordem de Serviço
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('orderServies.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <button class="btn btn-primary shadow-md mr-2" wire:click="editObservation">Observações</button>
            <button class="btn btn-primary shadow-md mr-2" wire:click="addStatus">Status</button>
            <a href="{{ route('orderServie.print', $orderServie->id) }}" target="_blank"
                class="btn btn-primary shadow-md mr-2">Imprimir</a>
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DETALHES</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Status Nº:</span>&nbsp;#{{ $os_statuses->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Orçamento:</span>&nbsp;{{ $budgets->name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-x col-span-12">
                <div class="font-medium text-center lg:text-left lg:mt-3">OBSERVAÇÕES</div>
                <div class="my-3">{!! nl2br($orderService->observation) !!}</div>
            </div>
        </div>
    </div>

    @include('budgets.partials.modal-product')
    @include('budgets.partials.modal-labor')
    @include('budgets.partials.modal-fee')
    @include('budgets.partials.modal-discount')
    @include('budgets.partials.modal-status')
    @include('budgets.partials.modal-observation')

    @push('custom-scripts')
        <script type="text/javascript">
            var modalBudgetProduct = null;
            var modalBudgetLabor = null;
            var modalBudgetFee = null;
            var modalBudgetDiscount = null;
            var modalBudgetStatus = null;
            var modalBudgetObservation = null;
            var selectProductId = null;
            var selectLaborId = null;
            var inputPrice = null;
            var inputLaborPrice = null;
            var alertProductError = null;
            var alertLaborError = null;
            var alertFeeError = null;
            var alertDiscountError = null;
            var alertStatusError = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                selectProductId = document.getElementById('product_id').tomselect;
                selectLaborId = document.getElementById('labor_id').tomselect;
                inputPrice = document.getElementById('price');
                inputLaborPrice = document.getElementById('labor_price');
                alertProductError = document.getElementById('alert-product-error');
                alertLaborError = document.getElementById('alert-labor-error');
                alertFeeError = document.getElementById('alert-fee-error');
                alertDiscountError = document.getElementById('alert-discount-error');
                alertStatusError = document.getElementById('alert-status-error');
                modalBudgetProduct = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-product"));
                modalBudgetLabor = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-labor"));
                modalBudgetFee = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-fee"));
                modalBudgetDiscount = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-discount"));
                modalBudgetStatus = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-status"));
                modalBudgetObservation = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-budget-observation"));
            });

            window.livewire.on('addProduct', () => {
                modalBudgetProduct.show();
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
