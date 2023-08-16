<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Equipamentos Sublocados
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('subleases.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DETALHES</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Ordem de Serviço
                                Nº:</span>&nbsp;#{{ $sublease->orderService->budget->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Orçamento
                                Nº:</span>&nbsp;#{{ $sublease->orderService->budget->id }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Versão
                                Nº:</span>&nbsp;#{{ $sublease->orderService->os_version }}&nbsp;&nbsp;
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Nome do
                                Evento:</span>&nbsp;{{ $sublease->orderService->budget->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span
                                class="font-semibold">Status:</span>&nbsp;{{ $sublease->orderService->osStatus->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Criado
                                por:</span>&nbsp;{{ $sublease->orderService->user_id ? $sublease->orderService->user->name : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Alterado
                                por:</span>&nbsp;{{ $sublease->orderService->last_user_id ? $sublease->orderService->lastUser->name : null }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">DATAS</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span class="font-semibold">Data da
                                solicitação:</span>&nbsp;{{ $sublease->orderService->budget->request_date->format('d/m/Y') }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Dias do
                                Evento:</span>&nbsp;{{ $sublease->orderService->budget->budget_days }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Montagem:</span>&nbsp;{{ $sublease->orderService->budget->mount_date ? $sublease->orderService->budget->mount_date->format('d/m/Y') : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Data
                                Desmontagem:</span>&nbsp;{{ $sublease->orderService->budget->unmount_date ? $sublease->orderService->budget->unmount_date->format('d/m/Y') : null }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Local do
                                Evento:</span>&nbsp;{{ $sublease->orderService->budget->place->name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Endereço do
                                Local:</span>&nbsp;{{ $sublease->orderService->budget->place->getfullAddress() }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">CLIENTE</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <span
                                class="font-semibold">Nome:</span>&nbsp;{{ $sublease->orderService->budget->customer->fantasy_name }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-1">
                            <span class="font-semibold">Contato - Nome:</span>&nbsp;
                            @if (!empty($sublease->orderService->budget->customerContact))
                                {{ $sublease->orderService->budget->customerContact->name }}
                            @endif
                        </div>
                        @if (
                            !empty($sublease->orderService->budget->customerContact) &&
                                !empty($sublease->orderService->budget->customerContact->phone))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Contato - Telefone:</span>&nbsp;
                                {{ $sublease->orderService->budget->customerContact->phone }}
                            </div>
                        @endif
                        @if (
                            !empty($sublease->orderService->budget->customerContact) &&
                                !empty($sublease->orderService->budget->customerContact->email))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span class="font-semibold">Contato - E-mail:</span>&nbsp;
                                {{ $sublease->orderService->budget->customerContact->email }}
                            </div>
                        @endif
                        @if (!empty($sublease->orderService->budget->agency))
                            <div class="truncate sm:whitespace-normal flex items-center mt-1">
                                <span
                                    class="font-semibold">Agência:</span>&nbsp;{{ $sublease->orderService->budget->agency->fantasy_name }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="intro-x col-span-12">
                <div class="font-medium text-center lg:text-left lg:mt-3">OBSERVAÇÕES</div>
                <div class="my-3">{!! nl2br($sublease->orderService->observation) !!}</div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">EQUIPAMENTO</th>
                        <th class="text-center whitespace-nowrap">QUANTIDADE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sublease->items as $item)
                        <tr class="intro-x">
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $item->osProduct->name }}</span>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

    </div>
</x-app-layout>
