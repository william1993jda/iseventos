<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $budget->name }} - Despesas
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('budgets.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <x-forms.buttons.create route="budgets.expenses.create" :id="$budget->id" />
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">VALOR</th>
                        <th class="text-center whitespace-nowrap">DATA</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('budgets.expenses.show', [$budget->id, $expense->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $expense->name }}</a>
                            </td>
                            <td class="text-center">{{ $expense->price }}</td>
                            <td class="text-center">{{ $expense->date }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit route="budgets.expenses.edit" :id="[$budget->id, $expense->id]" />
                                    <x-forms.buttons.destroy route="budgets.expenses.destroy" :id="[$budget->id, $expense->id]" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $expenses->links('layouts.paginator') }}

    </div>
</x-app-layout>
