<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $provider->fantasy_name }} - Bancos
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('providers.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <x-forms.buttons.create route="providers.banks.create" :id="$provider->id" />
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
                                <a href="{{ route('providers.banks.show', [$provider->id, $bank->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $bank->name }}</a>
                            </td>
                            <td class="text-center">{{ $bank->agency }}</td>
                            <td class="text-center">{{ $bank->account }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit route="providers.banks.edit" :id="[$provider->id, $bank->id]" />
                                    <x-forms.buttons.destroy route="providers.banks.destroy" :id="[$provider->id, $bank->id]" />
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
