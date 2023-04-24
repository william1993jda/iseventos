<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Recuperar Dados
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <form action="{{ route('recoveries.index') }}" method="GET" class="flex">
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        {!! Form::select('query', $modules, $query, ['class' => 'tom-select form-control w-full']) !!}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary shadow-md ml-2">Buscar</button>
                <a href="{{ route('recoveries.index') }}" class="btn btn-secondary shadow-md ml-2">Limpar</a>
            </form>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr class="intro-x">
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $record['name'] }}</span>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.recovery route="recoveries.recovery" :id="$record['id']"
                                        :module="$record['module']" />
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
