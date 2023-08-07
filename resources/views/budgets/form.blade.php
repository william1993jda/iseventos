<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Orçamento
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('budgets.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($budget->id))
                <a href="{{ route('budgets.mount', $budget->id) }}" class="btn btn-primary shadow-md mr-2">Montar</a>
                <a href="{{ route('budgets.expenses.index', $budget->id) }}"
                    class="btn btn-primary shadow-md mr-2">Despesas</a>
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($budget->id))
                {!! Form::open([
                    'route' => 'budgets.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($budget, [
                    'route' => ['budgets.update', $budget->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-4 gap-2">
                    <x-forms.text name="name" label="Nome do Evento" />
                    <x-forms.select name="place_id" label="Local" :options="$places" />
                    <x-forms.text name="public" label="Quantidade de Participantes" />
                    <x-forms.text name="request_date" label="Data da solicitação" class="datepicker form-control w-full"
                        data-single-mode="true" />
                </div>
                <div class="sm:grid grid-cols-5 gap-2 mt-3">
                    <x-forms.text name="budget_days" label="Dias do evento" class="datepicker form-control w-full"
                        data-daterange="true" />
                    <x-forms.time name="start_time" label="Horário de início" class="form-control w-full" />
                    <x-forms.time name="end_time" label="Horário de término" class="form-control w-full" />
                    <x-forms.text name="mount_date" label="Data da Montagem" class="datepicker form-control w-full"
                        data-single-mode="true" />
                    <x-forms.text name="unmount_date" label="Data da Desmontagem" class="datepicker form-control w-full"
                        data-single-mode="true" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.select name="agency_id" label="Agência" :options="$agencies" />
                    <x-forms.select name="customer_id" label="Cliente" :options="$customers" />
                    <x-forms.select name="customer_contact_id" label="Contato" :options="$customerContacts" />
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.textarea name="commercial_conditions" label="Condições Comerciais" />
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.textarea name="payment_conditions" label="Condições de Pagamento"
                        value="{{ isset($settings) ? $settings->payment_conditions : $budget->payment_conditions }}" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$budget" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function(e) {
                const customerId = document.getElementById('customer_id');
                customerId.addEventListener('change', function(e) {
                    getCustomerContacts(e.target.value);
                });
            });

            @if (!empty($budget->customer_id))
                getCustomerContacts('{{ $budget->customer_id }}');
            @endif

            function getCustomerContacts(customer_id) {
                var customer_contact_id = null;

                @if (!empty($budget->customer_contact_id))
                    customer_contact_id = {{ $budget->customer_contact_id }};
                @endif

                fetch("{{ route('budgets.getCustomerContacts') }}", {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            customer_id: customer_id,
                            _token: '{{ csrf_token() }}'
                        })
                    }).then((response) => response.json())
                    .then((data) => {
                        const selectCustomerContactId = document.getElementById('customer_contact_id').tomselect;
                        selectCustomerContactId.clear();
                        selectCustomerContactId.clearOptions();

                        for (let index = 0; index < data.length; index++) {
                            const item = data[index];

                            selectCustomerContactId.addOption({
                                value: item.id,
                                text: item.name
                            });
                        }

                        if (customer_contact_id) {
                            selectCustomerContactId.setValue(customer_contact_id);
                        }
                    });
            }
        </script>
    @endpush
</x-app-layout>
