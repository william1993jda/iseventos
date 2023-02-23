<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Funcionário
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($employee->id))
                <a href="{{ route('employees.contacts.index', $employee->id) }}"
                    class="btn btn-primary shadow-md mr-2">Contatos</a>
                <a href="{{ route('employees.addresses.index', $employee->id) }}"
                    class="btn btn-primary shadow-md mr-2">Endereços</a>
                <a href="{{ route('employees.banks.index', $employee->id) }}"
                    class="btn btn-primary shadow-md mr-2">Banco</a>
                <a href="{{ route('employees.dependents.index', $employee->id) }}"
                    class="btn btn-primary shadow-md mr-2">Dependentes</a>
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($employee->id))
                {!! Form::open([
                    'route' => 'employees.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($employee, [
                    'route' => ['employees.update', $employee->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <x-forms.text name="name" label="Nome" />
                    <x-forms.email name="email" label="E-mail" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="birthday" label="Data de Nascimento" class="datepicker form-control w-full"
                        data-single-mode="true" />
                    <x-forms.text name="identification" label="RG" />
                    <x-forms.text name="social_security" label="CPF" mask="'999.999.999-99'" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="admission_date" label="Data de Admissão" class="datepicker form-control w-full"
                        data-single-mode="true" />
                    <x-forms.text name="phone" label="Telefone" />
                    <x-forms.text name="cellphone" label="Telefone Celular" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="emergency_name" label="Contato de Emergência" />
                    <x-forms.text name="emergency_phone" label="Telefone de Emergência" />
                    <x-forms.text name="occupation_area" label="Área de ocupação" />
                </div>
                <div class="sm:grid grid-cols-4 gap-2 mt-3">
                    <x-forms.text name="corporate_name" label="Razão Social" />
                    <x-forms.text name="fantasy_name" label="Nome Fantasia" />
                    <x-forms.text name="ein" label="CNPJ" />
                    <x-forms.text name="cnai" label="CNAI" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="work_card" label="Carteira de Trabalho" />
                    <x-forms.text name="reservist" label="Certificado Reservista" />
                    <x-forms.text name="voter_registration" label="Título de Eleitor" />
                </div>
                <div class="sm:grid grid-cols-4 gap-2 mt-3">
                    <x-forms.text name="spouse_name" label="Nome do Conjugê" />
                    <x-forms.text name="spouse_birth_date" label="Data de Nascimento Conjugê" />
                    <x-forms.text name="spouse_identification" label="RG Conjugê" />
                    <x-forms.text name="spouse_social_security" label="CPF Conjugê" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="tshirt" label="Tamanho Camiseta" />
                    <x-forms.text name="trousers" label="Tamanho Calça" />
                    <x-forms.text name="shoe" label="Tamanho Sapato" />
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.textarea name="contract" label="Contrato" />
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.textarea name="observation" label="Observação" />
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
