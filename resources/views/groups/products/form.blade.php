<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Kits - Produtos
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('groups.products.index', $group->id) }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            {{-- @if (!empty($group->id))
                <x-forms.buttons.primary route="groups.products.index" :id="$group->id" label="Produtos" />
            @endif --}}
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
                <div class="sm:grid grid-cols-2 gap-2">
                    <x-forms.select name="os_product_id" label="Os Produtos" :options="$products" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$product" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>

</x-app-layout>
