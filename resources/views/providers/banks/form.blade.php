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
                    <x-forms.text name="name" label="Banco" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="number" label="Número do Banco" />
                    <x-forms.text name="agency" label="Agência" />
                    <x-forms.text name="account" label="Número da Conta" />
                </div>
                <div class="sm:grid grid-cols-4 gap-2 mt-3">
                    <x-forms.select name="type" label="Tipo" :options="$types" />
                    <x-forms.text name="holder" label="Nome do titular da conta" />
                    <x-forms.text name="document_number" label="CPF ou CNPJ do titular" mask="'99.999-999'" />
                    <x-forms.text name="observation" label="Observação" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$bank" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
