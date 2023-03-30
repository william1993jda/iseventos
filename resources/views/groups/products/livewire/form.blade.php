<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Kits - Produtos
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('groups.products.index', $group->id) }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($product->id))
                {!! Form::open([
                    'route' => ['groups.products.store', [$group->id, $product->id]],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($product, [
                    'route' => ['groups.products.update', [$group->id, $product->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2" wire:ignore>
                    <x-forms.select name="os_category_id" label="Categoria" :options="$osCategories"
                        wire:model="dataGroup.os_category_id" wire:change="onSelectCategory($event.target.value)" />
                    <x-forms.select name="os_product_id" label="Produto" :options="$osProducts"
                        wire:model="dataGroup.os_product_id" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$product" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            var selectProductId = null;

            document.addEventListener("DOMContentLoaded", function(e) {
                selectProductId = document.getElementById('os_product_id').tomselect;
            });

            window.livewire.on('updateProductGroupList', (data) => {
                selectProductId.clear();
                selectProductId.clearOptions();
                Object.keys(data).forEach(function(key) {
                    selectProductId.addOption({
                        value: key,
                        text: data[key]
                    });
                });
            });
        </script>
    @endpush
</div>
