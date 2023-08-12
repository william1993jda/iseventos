<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Mão de obra
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('labors.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($labor->id))
                {!! Form::open([
                    'route' => 'labors.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($labor, [
                    'route' => ['labors.update', $labor->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-1">
                    {{-- <x-forms.select name="category_id" label="Categoria" :options="$categories" /> --}}
                    <x-forms.text name="name" label="Nome" />
                    {{-- </div>
                <div class="sm:grid grid-cols-2 gap-2 mt-3"> --}}

                    <x-forms.currency name="price" label="Preço" />
                    <x-forms.checkbox name="active" label="Ativo" :checked="$labor->getActive()" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$labor" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
