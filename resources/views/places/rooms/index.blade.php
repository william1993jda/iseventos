<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $place->name }} - Salas
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('places.edit', $place->id) }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <x-forms.buttons.create route="places.rooms.create" :id="$place->id" />
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                        <th class="text-center whitespace-nowrap">ATIVO</th>
                        <th class="text-center whitespace-nowrap">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('places.rooms.show', [$place->id, $room->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $room->name }}</a>
                            </td>
                            <td class="text-center">{{ $room->active ? 'SIM' : 'NÃO' }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.edit route="places.rooms.edit" :id="[$place->id, $room->id]" />
                                    <x-forms.buttons.destroy route="places.rooms.destroy" :id="[$place->id, $room->id]" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $rooms->links('layouts.paginator') }}

    </div>
</x-app-layout>
