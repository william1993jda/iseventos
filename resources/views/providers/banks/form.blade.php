<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $provider->fantasy_name }} - Banco
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('providers.banks.index', $provider->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($bank->id))
                {!! Form::open([
                    'route' => ['providers.banks.store', $provider->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($bank, [
                    'route' => ['providers.banks.update', [$provider->id, $bank->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-1 gap-2">
                    <div>
                        <label for="name" class="form-label">Banco</label>
                        {!! Form::text('name', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'name']) !!}
                    </div>
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <div>
                        <label for="number" class="form-label">Número do Banco</label>
                        {!! Form::text('number', null, ['class' => 'form-control w-full', 'id' => 'number']) !!}
                    </div>
                    <div>
                        <label for="agency" class="form-label">Agência</label>
                        {!! Form::text('agency', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'agency']) !!}
                    </div>
                    <div>
                        <label for="account" class="form-label">Número da Conta</label>
                        {!! Form::text('account', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'account']) !!}
                    </div>
                </div>
                <div class="sm:grid grid-cols-4 gap-2 mt-3">
                    <div>
                        <label for="type" class="form-label">Tipo</label>
                        {!! Form::select('type', $types, null, ['class' => 'tom-select w-full', 'required' => 'required']) !!}
                    </div>
                    <div>
                        <label for="holder" class="form-label">Nome do titular da conta</label>
                        {!! Form::text('holder', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'holder']) !!}
                    </div>
                    <div>
                        <label for="document_number" class="form-label">CPF ou CNPJ do titular</label>
                        {!! Form::text('document_number', null, [
                            'class' => 'form-control w-full',
                            'required' => 'required',
                            'id' => 'document_number',
                        ]) !!}
                    </div>
                    <div>
                        <label for="observation" class="form-label">Observação</label>
                        {!! Form::text('observation', null, [
                            'class' => 'form-control w-full',
                            'id' => 'observation',
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
