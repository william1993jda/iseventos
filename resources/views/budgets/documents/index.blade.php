<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $budget->name }} - Documentos
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <x-forms.buttons.create route="budgets.documents.create" :id="$budget->id" />
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
                    @foreach ($documents as $document)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('budgets.documents.show', [$budget->id, $document->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $document->name }}</a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <x-forms.buttons.download :route="$document->getLink()" />
                                    {{-- <x-forms.buttons.edit route="budgets.documents.edit', [$budget->id, $document->id])" /> --}}
                                    <x-forms.buttons.destroy route="budgets.documents.destroy" :id="[$budget->id, $document->id]" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $documents->links('layouts.paginator') }}

    </div>
</x-app-layout>
