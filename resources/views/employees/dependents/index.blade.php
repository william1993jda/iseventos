<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $employee->user->name }} - Dependentes
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('employees.dependents.create', $employee->id) }}"
                class="btn btn-primary shadow-md mr-2">Novo</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">DATA DE NASCIMENTO</th>
                        <th class="text-center whitespace-nowrap">PARENTESCO</th>
                        <th class="text-center whitespace-nowrap">CPF</th>
                        <th class="text-center whitespace-nowrap">AÇOES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dependents as $dependent)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('employees.dependents.show', [$employee->id, $dependent->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $dependent->name }}</a>
                            </td>
                            <td class="text-center">{{ $dependent->birthday }}</td>
                            <td class="text-center">{{ $dependent->identification }}</td>
                            <td class="text-center">{{ $dependent->social_security }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit :route="route('employees.dependents.edit', [$employee->id, $dependent->id])" />
                                    <x-forms.buttons.delete :route="route('employees.dependents.destroy', [$employee->id, $dependent->id])" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $dependents->links('layouts.paginator') }}

    </div>
</x-app-layout>
