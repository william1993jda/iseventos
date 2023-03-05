<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $agency->fantasy_name }} - Endereço
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('agencies.addresses.index', $agency->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($address->id))
                {!! Form::open([
                    'route' => ['agencies.addresses.store', $agency->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($address, [
                    'route' => ['agencies.addresses.update', [$agency->id, $address->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-1 gap-2">
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        {!! Form::text('name', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'name']) !!}
                    </div>
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
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$address" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
