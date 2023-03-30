<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $provider->fantasy_name }} - Equipamentos
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <form action="{{ route('providers.os-products.index', $provider->id) }}" method="GET" class="flex">
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <input type="text" name="query" class="form-control w-56 box pr-10" placeholder="Buscar..."
                            value="{{ $query }}">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary shadow-md ml-2">Buscar</button>
                <a href="{{ route('providers.os-products.index', $provider->id) }}"
                    class="btn btn-secondary shadow-md ml-2">Limpar</a>
            </form>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <x-forms.buttons.create route="providers.os-products.create" :id="$provider->id" />
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
                    @foreach ($osProducts as $osProduct)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('providers.os-products.show', [$provider->id, $osProduct->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $osProduct->name }}</a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit route="providers.os-products.edit" :id="[$provider->id, $osProduct->id]" />
                                    <x-forms.buttons.destroy route="providers.os-products.destroy" :id="[$provider->id, $osProduct->id]" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $osProducts->links('layouts.paginator') }}

    </div>
</x-app-layout>
