<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Cliente
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($customer->id))
                <x-forms.buttons.primary route="customers.contacts.index" :id="$customer->id" label="Contatos" />
                <x-forms.buttons.primary route="customers.addresses.index" :id="$customer->id" label="Endereços" />
                <x-forms.buttons.primary route="customers.documents.index" :id="$customer->id" label="Documentos" />
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($customer->id))
                {!! Form::open([
                    'route' => 'customers.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($customer, [
                    'route' => ['customers.update', $customer->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-3 gap-2">
                    <x-forms.text name="fantasy_name" label="Nome Fantasia" />
                    <x-forms.text name="corporate_name" label="Razão Social" />
                    <x-forms.text name="ein" label="CNPJ" mask="'99.999.999/9999-99'" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="payment_term" label="Prazo de Pagamento" mask="'99/99/9999'" />
                    <x-forms.email name="email" label="E-mail" />
                    <x-forms.text name="phone" label="Telefone" mask="'(99) 99999-9999'" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$customer" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
