<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Relatório de Fornecedores
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <form action="{{ route('reports.providers') }}" method="GET">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.text name="name" label="Nome do Evento" :value="$query['name']" />
                    </div>
                    <div class="flex mt-3">
                        <div><button type="submit" class="btn btn-primary shadow-md">Buscar</button>
                            <a href="{{ route('reports.providers') }}"
                                class="btn btn-secondary shadow-md ml-2">Limpar</a>
                        </div>
                        <div class="hidden md:block mx-auto text-slate-500"></div>
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
                        <th class="text-center whitespace-nowrap">EVENTOS</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($providers as $provider)
                        <tr class="intro-x">
                            <td>
                                {{-- <a href="{{ route('budgets.show', $budget->id) }}"
                                    class="font-medium whitespace-nowrap">{{ $budget->name }}</a> --}}
                                {{ $provider->fantasy_name }}
                            </td>
                            <td class="text-center">{{ $provider->events }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a href="{{ route('reports.providers.detail', $provider->id) }}"
                                        class="btn btn-primary shadow-md">Detalhes</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $providers->links('layouts.paginator') }}

    </div>
</x-app-layout>
