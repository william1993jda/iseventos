<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Orçamentos
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <form action="{{ route('budgets.index') }}" method="GET">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="sm:grid grid-cols-5 gap-2">
                        <x-forms.text name="name" label="Nome do Evento" :value="$query['name']" />
                        <x-forms.text name="budget_days" label="Dias do evento" class="datepicker form-control w-full"
                            data-daterange="true" :value="$query['budget_days']" />
                        <x-forms.select name="place_id" label="Local" :options="$places" :selected="$query['place_id']" />
                        <x-forms.select name="customer_id" label="Cliente" :options="$customers" :selected="$query['customer_id']" />
                        <x-forms.select name="status_id" label="Status" :options="$statuses" :selected="$query['status_id']" />
                    </div>
                    <div class="flex mt-3">
                        <div><button type="submit" class="btn btn-primary shadow-md">Buscar</button>
                            <a href="{{ route('budgets.index') }}" class="btn btn-secondary shadow-md ml-2">Limpar</a>
                        </div>
                        <div class="hidden md:block mx-auto text-slate-500"></div>
                        <a href="{{ route('budgets.create') }}" class="btn btn-primary shadow-md">Novo</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">DIAS DO EVENTO</th>
                        <th class="text-center whitespace-nowrap">LOCAL</th>
                        <th class="text-center whitespace-nowrap">CLIENTE</th>
                        <th class="text-center whitespace-nowrap">ALTERADO POR</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budgets as $budget)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('budgets.show', $budget->id) }}"
                                    class="font-medium whitespace-nowrap">{{ $budget->name }}</a>
                            </td>
                            <td class="text-center">{{ $budget->budget_days }}</td>
                            <td class="text-center">{{ $budget->place_id ? $budget->place->name : null }}</td>
                            <td class="text-center">{{ $budget->customer->fantasy_name }}</td>
                            <td class="text-center">{{ $budget->last_user_id ? $budget->lastUser->name : null }}</td>
                            <td class="text-center">{{ $budget->status->name }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.icon route="budgets.mount" :id="$budget->id" icon="clipboard-check"
                                        label="Montar" />
                                    <x-forms.buttons.icon route="budgets.expenses.index" :id="$budget->id"
                                        icon="dollar-sign" label="Despesas" />
                                    <x-forms.buttons.edit route="budgets.edit" :id="$budget->id" />
                                    <x-forms.buttons.destroy route="budgets.destroy" :id="$budget->id" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $budgets->links('layouts.paginator') }}

    </div>
</x-app-layout>
