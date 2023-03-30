<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Kits - {{ $group->name }}
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('groups.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <x-forms.buttons.create route="groups.products.create" :id="$group->id" />
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">NOME</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="intro-x">
                            <td>
                                <a href="{{ route('groups.products.show', [$group->id, $product->id]) }}"
                                    class="font-medium whitespace-nowrap">{{ $product->product->name }}</a>
                            </td>
                            <td class="table-report__action w-28">
                                <div class="flex justify-center items-center">
                                    {{-- <x-forms.buttons.edit route="groups.products.edit" :id="[$group->id, $product->id]" /> --}}
                                    <x-forms.buttons.destroy route="groups.products.destroy" :id="[$group->id, $product->id]" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

        {{ $products->links('layouts.paginator') }}

    </div>
</x-app-layout>
