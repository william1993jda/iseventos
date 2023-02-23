<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $employee->user->name }} - Bancos
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('employees.banks.create', $employee->id) }}"
                class="btn btn-primary shadow-md mr-2">Novo</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">BANCO</th>
                        <th class="text-center whitespace-nowrap">AGÊNCIA</th>
                        <th class="text-center whitespace-nowrap">CONTA</th>
                        <th class="text-center whitespace-nowrap">AÇOES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banks as $bank)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('employees.banks.show', [$employee->id, $bank->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $bank->name }}</a>
                            </td>
                            <td class="text-center">{{ $bank->agency }}</td>
                            <td class="text-center">{{ $bank->account }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit :route="route('employees.banks.edit', [$employee->id, $bank->id])" />
                                    <x-forms.buttons.delete :route="route('employees.banks.destroy', [$employee->id, $bank->id])" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $banks->links('layouts.paginator') }}

    </div>
</x-app-layout>
