<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $provider->fantasy_name }} - Equipamentos
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('providers.os-products.index', $provider->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($product->id))
                {!! Form::open([
                    'route' => ['providers.os-products.store', $provider->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($product, [
                    'route' => ['providers.os-products.update', [$provider->id, $product->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-3 gap-2">
                    <x-forms.select name="os_category_id" label="Categoria" :options="$osCategories" />
                    <x-forms.text name="name" label="Nome" />
                    <x-forms.currency name="price" label="Preço" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="brand" label="Marca" />
                    <x-forms.text name="model" label="Modelo" />
                    <x-forms.text name="serie" label="Série" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="dimensions" label="Medidas" />
                    <x-forms.text name="weight" label="Peso" />
                    <x-forms.checkbox name="active" label="Ativo" :checked="$product->getActive()" />
                </div>
                {{-- <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <x-forms.checkbox name="customization" label="Customizar" :options="$product->getCustomization()" />
                </div> --}}
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$product" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
