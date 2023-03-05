<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Local
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('places.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($place->id))
                <a href="{{ route('places.rooms.index', $place->id) }}" class="btn btn-primary shadow-md mr-2">Salas</a>
                <a href="{{ route('places.documents.index', $place->id) }}"
                    class="btn btn-primary shadow-md mr-2">Documentos</a>
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($place->id))
                {!! Form::open([
                    'route' => ['places.store', $place->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($place, [
                    'route' => ['places.update', $place->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-1 gap-2">
                    <x-forms.text name="name" label="Nome" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="street" label="Logradouro" />
                    <x-forms.text name="number" label="Número" />
                    <x-forms.text name="complement" label="Complemento" />
                </div>
                <div class="sm:grid grid-cols-4 gap-2 mt-3">
                    <x-forms.text name="district" label="Bairro" />
                    <x-forms.text name="city" label="Cidade" />
                    <x-forms.select name="state" label="Estado" :options="$states" />
                    <x-forms.text name="zipcode" label="CEP" mask="'99.999-999'" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$place" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
