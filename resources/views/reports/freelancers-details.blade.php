<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Relatório de Freelancers - {{ $freelancer->name }}
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">

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
                        <th class="text-center whitespace-nowrap">VERSÃO</th>
                        <th class="text-center whitespace-nowrap">TOTAL</th>
                        {{-- <th class="text-center whitespace-nowrap">AÇÕES</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderServices as $orderService)
                        <tr class="intro-x">
                            <td>
                                {{-- <a href="{{ route('budgets.show', $budget->id) }}"
                                    class="font-medium whitespace-nowrap">{{ $budget->name }}</a> --}}
                                {{ $orderService->budget->name }}
                            </td>
                            <td class="text-center">{{ $orderService->budget->budget_days }}</td>
                            <td class="text-center">
                                {{ $orderService->budget->place_id ? $orderService->budget->place->name : null }}</td>
                            <td class="text-center">{{ $orderService->budget->customer->fantasy_name }}</td>
                            <td class="text-center">{{ $orderService->budget->budget_version }}</td>
                            <td class="text-center">R$ {{ number_format($orderService->total, 2, ',', '.') }}</td>
                            {{-- <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a href="{{ route('reports.providers.detail', $provider->id) }}"
                                        class="btn btn-primary shadow-md">Detalhes</a>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $orderServices->links('layouts.paginator') }}

    </div>
</x-app-layout>
