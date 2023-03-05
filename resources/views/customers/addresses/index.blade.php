<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $customer->fantasy_name }} - Endereços
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <a href="{{ route('customers.addresses.create', $customer->id) }}"
                class="btn btn-primary shadow-md mr-2">Novo</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">CIDADE</th>
                        <th class="text-center whitespace-nowrap">ESTADO</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($addresses as $address)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('customers.addresses.show', [$customer->id, $address->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $address->name }}</a>
                            </td>
                            <td class="text-center">{{ $address->city }}</td>
                            <td class="text-center">{{ $address->state }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit :route="route('customers.addresses.edit', [$customer->id, $address->id])" />
                                    <x-forms.buttons.delete :route="route('customers.addresses.destroy', [$customer->id, $address->id])" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $addresses->links('layouts.paginator') }}

    </div>
</x-app-layout>
