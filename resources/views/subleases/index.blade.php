<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Equipamentos Sublocados
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">EVENTO</th>
                        <th class="text-center whitespace-nowrap">DIAS DO EVENTO</th>
                        <th class="text-center whitespace-nowrap">LOCAL</th>
                        <th class="text-center whitespace-nowrap">EQUIPAMENTOS</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subleases as $subleases)
                        <tr class="intro-x">
                            <td>
                                <span
                                    class="font-medium whitespace-nowrap">{{ $subleases->orderService->budget->name }}</span>
                            </td>
                            <td class="text-center">{{ $subleases->orderService->budget->budget_days }}</td>
                            <td class="text-center">{{ $subleases->orderService->budget->place->name }}</td>
                            <td class="text-center">{{ $subleases->items->count() }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.icon route="subleases.items" :id="$subleases->id" icon="package"
                                        label="Equipamentos" />

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

    </div>
</x-app-layout>
