<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Equipamentos - Estoque - {{ $osProduct->name }}
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('os-products.stocks.index', $osProduct->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($stock->id))
                {!! Form::open([
                    'route' => ['os-products.stocks.store', $osProduct->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($stock, [
                    'route' => ['os-products.stocks.update', [$osProduct->id, $stock->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-3 gap-2">
                    <x-forms.text name="sku" label="SKU" />
                    <x-forms.currency name="price" label="Preço" />
                    <x-forms.select name="status" label="Status" :options="$statuses" />
                </div>
                <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <x-forms.text name="purchase_date" label="Data da compra" class="datepicker form-control w-full"
                        data-single-mode="true" />
                    <x-forms.text name="life_date" label="Validade" class="datepicker form-control w-full"
                        data-single-mode="true" />
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.text name="accessories" label="Acessórios" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$stock" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
