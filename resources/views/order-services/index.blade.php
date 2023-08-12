<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Ordem de Serviço
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <form action="{{ route('orderServices.index') }}" method="GET">
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
                            <a href="{{ route('orderServices.index') }}"
                                class="btn btn-secondary shadow-md ml-2">Limpar</a>
                        </div>
                        <div class="hidden md:block mx-auto text-slate-500"></div>
                    </div>
                </div>
            </form>
        </div>

        @if (count($budgets) > 0)
            <h3 class="intro-y col-span-12 text-base font-medium mt-10">
                Orçamentos sem Ordem de Serviço
            </h3>

            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">NOME</th>
                            <th class="text-center whitespace-nowrap">DIAS DO EVENTO</th>
                            <th class="text-center whitespace-nowrap">LOCAL</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
                            <th class="text-center whitespace-nowrap">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budgets as $budget)
                            <tr class="intro-x">
                                <td>{{ $budget->name }}</td>
                                <td class="text-center">{{ $budget->budget_days }}</td>
                                <td class="text-center">{{ $budget->place->name }}</td>
                                <td class="text-center">{{ $budget->status->name }}</td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a href="{{ route('orderServices.create.budget', $budget->id) }}"
                                            class="btn btn-primary shadow-md">GERAR OS</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->

            {{ $budgets->links('layouts.paginator') }}
        @endif

        <h3 class="intro-y col-span-12 text-base font-medium mt-10">
            Ordem de Serviço
        </h3>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">DIAS DO EVENTO</th>
                        <th class="text-center whitespace-nowrap">LOCAL</th>
                        <th class="text-center whitespace-nowrap">OS N°</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">VERSÃO</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderServices as $orderService)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('orderServices.show', $orderService->id) }}"
                                    class="font-medium whitespace-nowrap">{{ $orderService->budget->name }}</a>
                            </td>
                            <td class="text-center">{{ $orderService->budget->budget_days }}</td>
                            <td class="text-center">{{ $orderService->budget->place->name }}</td>
                            <td class="text-center">{{ $orderService->os_number }}</td>
                            <td class="text-center">{{ $orderService->osStatus->name }}</td>
                            <td class="text-center">
                                @if ($orderService->budget->budget_version == $orderService->budget_version)
                                    <span class="bg-green-300 p-1 rounded text-xs font-medium">
                                        ATUALIZADA
                                    </span>
                                @else
                                    <span class="bg-red-300 p-1 rounded text-xs font-medium">
                                        DESATUALIZADA
                                    </span>
                                @endif
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.icon route="orderServices.mount" :id="$orderService->id"
                                        icon="clipboard-check" label="Montar" />
                                    <x-forms.buttons.icon route="orderServices.expenses.index" :id="$orderService->id"
                                        icon="dollar-sign" label="Despesas" />
                                    <x-forms.buttons.destroy route="orderServices.destroy" :id="$orderService->id" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $orderServices->links('layouts.paginator') }}

    </div>
    @push('custom-scripts')
        @if (session('warning'))
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(e) {
                    document.getElementById('error-notification-title').innerHTML = "Atenção!";
                    document.getElementById('error-notification-message').innerHTML = "{{ session('warning') }}";

                    Toastify({
                        node: $("#error-notification").clone().removeClass("hidden")[0],
                        duration: 5000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "transparent",
                        stopOnFocus: true,
                    }).showToast();
                });
            </script>
        @endif
    @endpush
</x-app-layout>
