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
                    <div>
                        <label for="street" class="form-label">Logradouro</label>
                        {!! Form::text('street', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'street']) !!}
                    </div>
                    <div>
                        <label for="number" class="form-label">Número</label>
                        {!! Form::text('number', null, ['class' => 'form-control w-full', 'id' => 'number']) !!}
                    </div>
                    <div>
                        <label for="complement" class="form-label">Complemento</label>
                        {!! Form::text('complement', null, ['class' => 'form-control w-full', 'id' => 'complement']) !!}
                    </div>
                </div>
                <div class="sm:grid grid-cols-4 gap-2 mt-3">
                    <div>
                        <label for="district" class="form-label">Bairro</label>
                        {!! Form::text('district', null, [
                            'class' => 'form-control w-full',
                            'required' => 'required',
                            'id' => 'district',
                        ]) !!}
                    </div>
                    <div>
                        <label for="city" class="form-label">Cidade</label>
                        {!! Form::text('city', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'city']) !!}
                    </div>
                    <div>
                        <label for="complement" class="form-label">Estado</label>
                        {!! Form::select('state', $states, null, ['class' => 'tom-select w-full', 'required']) !!}
                    </div>
                    <div>
                        <label for="zipcode" class="form-label">CEP</label>
                        {!! Form::text('zipcode', null, [
                            'class' => 'form-control w-full',
                            'required' => 'required',
                            'id' => 'zipcode',
                        ]) !!}
                    </div>
                </div>
                @if (!isset($showMode))
                    <div class="text-right mt-5">
                        <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Cancelar</button>
                        <button type="submit" class="btn btn-primary w-24">Salvar</button>
                    </div>
                @endif
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
