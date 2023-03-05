<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $agency->fantasy_name }} - Contatos
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('agencies.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <a href="{{ route('agencies.contacts.create', $agency->id) }}" class="btn btn-primary shadow-md mr-2">Novo</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">E-MAIL</th>
                        <th class="text-center whitespace-nowrap">TELEFONE</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('agencies.contacts.show', [$agency->id, $contact->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $contact->name }}</a>
                            </td>
                            <td class="text-center">{{ $contact->email }}</td>
                            <td class="text-center">{{ $contact->phone }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit
                                        route="agencies.contacts.edit', [$agency->id, $contact->id])" />
                                    <x-forms.buttons.destroy
                                        route="agencies.contacts.destroy', [$agency->id, $contact->id])" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $contacts->links('layouts.paginator') }}

    </div>
</x-app-layout>
