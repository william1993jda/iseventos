<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Equipamentos - Estoque
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('os-products.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($osProduct->id))
                <a href="{{ route('os-products.stocks.index', $osProduct->id) }}"
                    class="btn btn-primary shadow-md mr-2">Estoque</a>
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($osProduct->id))
                {!! Form::open([
                    'route' => 'os-products.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($osProduct, [
                    'route' => ['os-products.update', $osProduct->id],
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
                    <x-forms.checkbox name="active" label="Ativo" :checked="$osProduct->getActive()" />
                </div>
                {{-- <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <x-forms.checkbox name="customization" label="Customizar" :options="$osProduct->getCustomization()" />
                </div> --}}
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$osProduct" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
